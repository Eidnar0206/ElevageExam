<?php

namespace app\models;
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
        $stmt = $this->db->query($query);
        $stmt->execute([
            ':date_reference' => $date
        ]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getIdEspeceAnimal($idAnimal) {
        $query = "SELECT idEspece AS id FROM elevage_animaux
        WHERE idAnimal=:id";
        $stmt = $this->db->query($query);
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
        $stmt = $this->db->query($query);
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
    public function getPrixVenteParAnimal($idAnimal, $date) {
        $idEspece = $this->getIdEspeceAnimal($idAnimal);
        $pvParKg = $this->getPrixVenteKgParEspece($idEspece);
        $poidsActuel = 
        $prix = $poidsActuel * $pvParKg;
    }
    
}