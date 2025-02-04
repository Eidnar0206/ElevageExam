<?php

namespace app\models;
use app\models\CapitalModel;
use Flight;

class AnimauxModel 
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function insertAnimal($idEspece, $prixAchat, $poidsInitial, $dateAchat) {
        try {
            if ($this->verifySolde($dateAchat, $prixAchat)) {
                $sql = "INSERT INTO elevage_animaux (idEspece, prixAchat, poidsInitial, dateAchat) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$idEspece, $prixAchat, $poidsInitial, $dateAchat]);
                Flight::CapitalModel()->insertTransaction($prixAchat, "sortie", "Achat d'un animal", $dateAchat);
                return true; // Success
            } else {
                return "Insufficient funds on the specified date."; // Error message
            }
        } catch (\PDOException $e) {
            return "Database error: " . $e->getMessage(); // Database error
        }
    }
    function getLastId() {
        try{
            $sql="select max(idAnimal) as idAnimal from elevage_animaux";
            $stmt=$this->db->prepare($sql);
            $stmt->execute();
            $result=$stmt->fetchAll();
            foreach ($result as $r) {
                return $r['idAnimal'];
            }
        }
        catch (\Exception $e){
            throw $e;
        }
        
    }
    function insertPhoto($files) {
        try {
            $sql = "INSERT INTO elevage_imagesAnimaux (idAnimal, nomImage) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
    
            foreach ($files['name'] as $index => $name) {
                // Build the single file array
                $file = [
                    'name' => $files['name'][$index],
                    'type' => $files['type'][$index],
                    'tmp_name' => $files['tmp_name'][$index],
                    'error' => $files['error'][$index],
                    'size' => $files['size'][$index],
                ];
                // Upload the file and get the saved file path
                $uploadedFilePath = Flight::FonctionModel()->upload($file, "animaux");
                // Insert into the database
                $stmt->execute([$this->getLastId(), $uploadedFilePath]);
            }
        } catch (\Exception $th) {
            throw $th; // Handle exceptions
        }
    }
    public function insertAnimalWithPhoto($idEspece, $prixAchat, $poidsInitial, $dateAchat, $files) {
        try {
            $this->insertAnimal($idEspece, $prixAchat, $poidsInitial, $dateAchat);
            //$this->insertPhoto($files);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function verifySolde($date, $prix) {
        $solde = Flight::CapitalModel()->getMontantActuelle($date);
        if($solde >= $prix) {
            return true;
        }
        return false;
    }

    // Conditions de vente de l'animal 
    // . Mbola tsy novarotana
    // . Mbola tsy mort
    // . Poids minimal de vente
    
    public function notSoldYet($idAnimal) {
        $query = "SELECT NOT EXISTS (
                    SELECT 1 FROM elevage_Ventes WHERE idAnimal = :idAnimal
                  ) AS notSold"; 
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':idAnimal' => $idAnimal]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return (bool) $result['notSold']; // Retourne true si pas encore vendu, false sinon
    }
    
    public function notDeadYet($idAnimal) {
        $query = "SELECT NOT EXISTS (
            SELECT 1 FROM elevage_morts WHERE idAnimal = :idAnimal
          ) AS notDead"; 

        $stmt = $this->db->prepare($query);
        $stmt->execute([':idAnimal' => $idAnimal]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (bool) $result['notDead'];       
    }



}