<?php

namespace app\models;
use app\models\CapitalModel;
use Flight;
class alimentationModel 
{
    protected $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function ajoutAlimentation($nomAlimentation, $idEspece, $pct){
        $query = "INSERT INTO elevage_alimentation (nomAlimentation, idEspece, gainPoids)
                    VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nomAlimentation, $idEspece, $pct]);
    }
    public function verifSolde($dateAchat, $prix){
        $model = new CapitalModel($this->db);
        $montant = $model->getMontantActuelle($dateAchat);
        if($prix>$montant){
            return false;
        }

        $model->insertTransaction($prix, 'sortie', 'achat alimentation', $dateAchat);
        return true;
    }
    public function achatAlimentation($idAlimentation, $quantite, $prixTotal, $dateAchat){
        $query = "INSERT INTO elevage_achatAlimentation (idAlimentation, quantite, prixTotal, dateAchat)
        VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idAlimentation, $quantite, $prixTotal, $dateAchat]);
    }
    public function getAll(){
        $sql = "SELECT * FROM elevage_alimentation";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    function getTotalAchatsAlimentation($idAlimentation, $date) {
        $pdo = $this->db;
        $sql = "SELECT SUM(quantite) AS total_achete
                FROM elevage_achatAlimentation
                WHERE idAlimentation = ? AND dateAchat <= ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idAlimentation, $date]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        return $result['total_achete'] ?? 0;
    }
    public function calculateStockOnDate($targetDate) {
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
                foreach ($animals as $speciesId => &$speciesAnimals) {
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