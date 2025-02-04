<?php

namespace app\models;
use app\models\CapitalModel;
use Flight;

class AnimauxModel 
{
    protected $db;

    public $idAnimal;
    public $idEspece;
    public $prixAchat;
    public $poidsInitial;
    public $dateAchat;
    public $dayWithoutFood;
    public function __construct($db = null, $idAnimal = null, $idEspece = null, $prix = null, $poidsInitial = null, $dateAchat = null) {
        $this->db = $db;
        $this->idAnimal = $idAnimal;
        $this->idEspece = $idEspece;
        $this->prixAchat = $prix;
        $this->poidsInitial = $poidsInitial;
        $this->dateAchat = $dateAchat;
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
            $this->insertPhoto($files);
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
    public function getAnimalsBoughtOnDate($date) {
        $query = "SELECT * FROM elevage_animals WHERE dateAchat = :date";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':date' => $date]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }

    public function groupAnimalsByEspece($date) {
        // Fetch all species (we only need the idEspece)
        $especes = Flight::EspeceModel()->getEspeceNamesAndIds();
        $especeIds = [];
        foreach ($especes as $espece) {
            $especeIds[] = $espece['idEspece']; // Only storing species idEspece
        }
        // Fetch all animals bought on the specified date
        $results = $this->getAnimalsBoughtOnDate($date);
    
        // Group animals by species id (idEspece)
        $groupedAnimals = [];
        foreach ($especeIds as $idEspece) {
            // Initialize each species group with an empty array
            $groupedAnimals[$idEspece] = [];
        }
    
        // Add animals to the appropriate species groups
        foreach ($results as $animal) {
            $idEspece = $animal['idEspece'];
    
            // Create animal object
            $animalObj = new self(
                $this->db,
                $animal['idAnimal'],
                $idEspece,
                $animal['prixAchat'],
                $animal['poidsInitial'],
                $animal['dateAchat']
            );
            // Add the animal object to the appropriate species group
            $groupedAnimals[$idEspece][] = $animalObj;
        }
        return $groupedAnimals;
    }
    
    
}