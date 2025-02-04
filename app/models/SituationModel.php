<?php

namespace app\models;
use app\models\AnimauxModel;
use app\models\EspeceModel;
use Flight;

class SituationModel 
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Animaux vivants-morts (avec poids pdt cette date la)
    public function getAnimalVivant($date) {
        $query = "SELECT a.*
        FROM elevage_animaux a
        WHERE NOT EXISTS (
        SELECT 1 
        FROM elevage_morts m 
        WHERE m.idAnimal = a.idAnimal 
        AND m.dateMort <= :date_reference
        )
        AND a.dateAchat <= :date_reference";
        $stmt = $this->db->query($query);
        $stmt->execute([
            ':date_reference' => $date
        ]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAnimalMort($date) {
        $query = "SELECT a.*, m.dateMort
        FROM elevage_animaux a
        INNER JOIN elevage_morts m ON a.idAnimal = m.idAnimal
        WHERE m.dateMort <= :date_reference";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':date_reference' => $date
        ]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getIdEspeceAnimal($idAnimal) {
        $query = "SELECT idEspece AS id FROM elevage_animaux
        WHERE idAnimal=:id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':id' => $idAnimal
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            return 0; 
        }
        
        return $result['id'];
    }

    public function getPrixVenteKgParEspece($idEspece) {
        $query = "SELECT prixVenteKg as pv FROM elevage_espece
        WHERE idEspece = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':id' => $idEspece
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            return 0; 
        }
        
        return $result['pv'];
    }

    // ca depend encr du poids
    public function getPrixVenteParAnimal($idAnimal, $date, $poidsActuel) {
        $idEspece = $this->getIdEspeceAnimal($idAnimal);
        $pvParKg = $this->getPrixVenteKgParEspece($idEspece);
        $prix = $poidsActuel * $pvParKg;
        return $prix;
    }

    public function pourcentagePertePoids($idEspece) {
        $query = "SELECT pertePoidsJour FROM elevage_espece WHERE idEspece=:id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':id' => $idEspece
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            return 0; 
        }
        return $result['pertePoidsJour'];
    }

    public function pourcentageGainPoids($idEspece) {
        $query = "SELECT gainPoids FROM elevage_alimentation WHERE idEspece=:id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':id' => $idEspece
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            return 0; 
        }
        return $result['gainPoids'];
    }

    public function getPoidsActuel($idAnimal, $date) {
        $theAnimal = Flight::AnimauxModel()->getAnimalById($idAnimal);
        $poids = $theAnimal['poidsInitial'];
        $idEspece = $this->getIdEspeceAnimal($idAnimal);
        $pertePoids = $this->pourcentagePertePoids($idEspece);
        $gainPoids = $this->pourcentageGainPoids($idEspece);
        $qteParJour = Flight::EspeceModel()->getQuantiteNourritureJour($idEspece);

        $dateAchatAnimal = Flight::AnimauxModel()->getDateAchat($idAnimal);

        while($dateAchatAnimal != $date) {
            $stockCeJourLa = Flight::EspeceModel()->getStockByEspece($dateAchatAnimal);
            if($stockCeJourLa[$idEspece] >= $qteParJour) {
                $poids = $poids + ($poids * ($gainPoids/100) );
            } else {
                $poids = $poids - ($poids * ($pertePoids/100));
            }

            $dateAchatAnimal->modify('+1 day');
            // var_dump($stockCeJourLa);
        }

        return $poids;
    }

    public function calculatePoidsOnDate($targetDate) {
        try {
            $targetDate =  Flight::FonctionModel()->ensureDateTime($targetDate);
            $currentDate = Flight::CapitalModel()->getDateDebut();
            
            if (!$currentDate) {
                throw new \RuntimeException("Could not determine start date");
            }
            
            if ($currentDate > $targetDate) {
                throw new \InvalidArgumentException("Target date cannot be before start date");
            }

            $stockLevels = [];
            $animals = [];
            
            // Initialize tracking arrays
            while ($currentDate <= $targetDate) {
                $dateString = $currentDate->format('Y-m-d');
                
                // Add new stock for the day
                $newStock =  Flight::EspeceModel()->getStockByEspece($currentDate);
                foreach ($newStock as $speciesId => $quantity) {
                    $stockLevels[$speciesId] = ($stockLevels[$speciesId] ?? 0) + $quantity;
                }
                
                 // Add new animals for the day
                 $newAnimals = Flight::AnimauxModel()->getAnimalsByDate($currentDate);
                 foreach ($newAnimals as $animal) {
                     if (!isset($animals[$animal['idEspece']])) {
                         $animals[$animal['idEspece']] = [];
                     }
                     $animals[$animal['idEspece']][] = [
                         'idAnimal' => $animal['idAnimal'],
                         'idEspece' => $animal['idEspece'],
                         'prixAchat' => $animal['prixAchat'],
                         'poidsInitial' => $animal['poidsInitial'],
                         'dateAchat' => $animal['dateAchat'],
                         'quantiteNourritureJour' => $animal['quantiteNourritureJour'],
                         'joursSansManger' => $animal['joursSansManger'],
                         'daysWithoutFood' => 0
                     ];
                 }
                 
                
                // Process feeding and mortality
                foreach ($animals as $speciesId => $speciesAnimals) {
                    $especeDetails = Flight::EspeceModel()->getEspeceDetails($speciesId);
                    $dailyFoodNeeded = $especeDetails['quantiteNourritureJour'];
                    
                    foreach ($speciesAnimals as $key => &$animal) {
                        if ($stockLevels[$speciesId] >= $dailyFoodNeeded) {
                            $stockLevels[$speciesId] -= $dailyFoodNeeded;
                            $animal['daysWithoutFood'] = 0;
                        } else {
                            $animal['daysWithoutFood']++;
                            if ($animal['daysWithoutFood'] >= $especeDetails['joursSansManger']) {
                                unset($speciesAnimals[$key]);
                            }
                        }
                    }
                }
                $currentDate->modify('+1 day');
            }
            
            return [
                'stock' => $stockLevels,
                'animals' => $animals
            ];
            
        } catch (\Exception $e) {
            // Log the error if you have a logging system
            throw new \RuntimeException("Error calculating stock: " . $e->getMessage());
        }
    }
    
}