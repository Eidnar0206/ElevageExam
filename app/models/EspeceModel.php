<?php

namespace app\models;

class EspeceModel 
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ajoutEspece($nomEspece, $poidsMin, $poidsMax, $prixVenteKg, 
    $joursSansManger, $pertePoidsJour, $quantiteNourritureJour) {
        $query = "INSERT INTO elevage_espece(nomEspece, poidsMin, poidsMax, prixVenteKg, 
        joursSansManger, pertePoidsJour, quantiteNourritureJour) VALUES (:nom, :pMin, :pMax, 
        :pv, :nbJour, :perte, :qte)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':nom' => $nomEspece,
            ':pMin' => $poidsMin,
            ':pMax' => $poidsMax,
            ':pv' => $prixVenteKg,
            ':nbJour' => $joursSansManger,
            ':perte' => $pertePoidsJour,
            ':qte' => $quantiteNourritureJour
        ]);
    }

    public function supprimerEspece($idEspece) {
        $sql = "DELETE FROM elevage_espece WHERE idEspece=$idEspece";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function getAllEspeces() {
        $sql = "SELECT * FROM elevage_espece";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getEspeceById($idEspece) {
        $query = "SELECT * FROM elevage_espece WHERE idEspece = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $idEspece]);
        return $stmt->fetch();
    }
    
    public function updateEspece($idEspece, $data) {
        $query = "UPDATE elevage_espece SET 
            nomEspece = :nom,
            poidsMin = :pMin,
            poidsMax = :pMax,
            prixVenteKg = :pv,
            joursSansManger = :nbJour,
            pertePoidsJour = :perte,
            quantiteNourritureJour = :qte
            WHERE idEspece = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':id' => $idEspece,
            ':nom' => $data['nomEspece'],
            ':pMin' => $data['poidsMin'],
            ':pMax' => $data['poidsMax'],
            ':pv' => $data['prixVenteKg'],
            ':nbJour' => $data['joursSansManger'],
            ':perte' => $data['pertePoidsJour'],
            ':qte' => $data['quantiteNourritureJour']
        ]);
    }
    
}