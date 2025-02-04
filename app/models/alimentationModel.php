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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['total_achete'] ?? 0;
    }

    function getTotalConsommationAlimentation($idAlimentation, $date) {
        $pdo = $this->db;
        $sql = "SELECT SUM(DATEDIFF(? , ea.dateAchat) * ee.quantiteNourritureJour) AS total_consommee
                FROM elevage_animaux ea
                JOIN elevage_espece ee ON ea.idEspece = ee.idEspece
                JOIN elevage_alimentation al ON ee.idEspece = al.idEspece
                WHERE al.idAlimentation = ? AND ea.dateAchat <= ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$date, $idAlimentation, $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['total_consommee'] ?? 0;
    }
    
    function getStockAlimentation($idAlimentation, $date) {
        $totalAchats = getTotalAchatsAlimentation($idAlimentation, $date);
        $totalConsommation = getTotalConsommationAlimentation($idAlimentation, $date);
    
        return $totalAchats - $totalConsommation;
    }   

    function getStockOnDate($date) {
        $dateActu = Flight::CapitalModel()->getDateDebut();
        $stockActu = Flight::EspeceModel()->getStockByEspece($dateActu);
        $animauxActu = Flight::AnimauxModel()->getAnimalsBoughtOnDate($dateActu);
        while($dateActu != $date) {
            foreach ($animauxActu as $idEspece => $animals) {
                echo "Species ID: $idEspece\n";
                $quantite = Flight::EspeceModel()->getQuantiteNourritureJour($idEspece);
                $joursSansManger = Flight::EspeceModel()->getJoursSansManger($idEspece);
                // Loop through each animal for that species
                foreach ($animals as $index => $animal) {
                    if($stockActu[$idEspece] < $quantite) {
                        $animal->dayWithoutFood++;
                        if($animal->dayWithoutFood >= $joursSansManger) {
                            // Remove the animal from the array when it reaches the limit
                            unset($animals[$index]);
                        }
                        continue;
                    } else {
                        $animal->dayWithoutFood = 0;
                        $stockActu[$idEspece] = $stockActu[$idEspece] - $quantite;
                    }
                }
            }
            $dateActu->modify('+1 day');
        }
    }
}