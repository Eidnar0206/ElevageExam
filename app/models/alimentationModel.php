<?php

namespace app\models;

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

    public function getAchatAlimentation($idAlimentation, $dateDebut, $dateFin) {
        try {
            $sql = "SELECT * FROM elevage_achatAlimentation 
                    WHERE idAlimentation = ? 
                    AND dateAchat BETWEEN ? AND ?";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$idAlimentation, $dateDebut, $dateFin]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}