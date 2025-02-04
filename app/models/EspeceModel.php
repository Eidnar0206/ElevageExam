<?php

namespace app\models;
use Flight;
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

    public function getEspeceNames() {
        $query = "SELECT nomEspece FROM elevage_espece";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
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
    
    public function updateEspeces($data) {

        foreach ($data as $espece) {
            $query = "UPDATE elevage_espece 
                                  SET nomEspece = ?, poidsMin = ?, poidsMax = ?, prixVenteKg = ?, 
                                      joursSansManger = ?, pertePoidsJour = ?, quantiteNourritureJour = ? 
                                  WHERE idEspece = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                $espece['nomEspece'],
                $espece['poidsMin'],
                $espece['poidsMax'],
                $espece['prixVenteKg'],
                $espece['joursSansManger'],
                $espece['pertePoidsJour'],
                $espece['quantiteNourritureJour'],
                $espece['idEspece']
            ]);
        }

        return ["message" => "Mise à jour réussie"];
    }
    public function getAllEspecesIdNom() {
        try {
            $sql = "SELECT idEspece, nomEspece FROM elevage_espece";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getStockByEspece(\DateTime $date) {

        $dateObj = Flight::FonctionModel()->ensureDateTime($date);
        $query = "
            SELECT a.idEspece, COALESCE(SUM(aa.quantite), 0) AS totalQuantite
            FROM elevage_espece e
            LEFT JOIN elevage_alimentation a ON e.idEspece = a.idEspece
            LEFT JOIN elevage_achatAlimentation aa ON aa.idAlimentation = a.idAlimentation 
                AND aa.dateAchat = :date
            GROUP BY a.idEspece
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':date' => $date->format('Y-m-d')]);
        
        $foodQuantities = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $foodQuantities[$row['idEspece']] = (float)$row['totalQuantite'];
        }
        return $foodQuantities;
    }

    public function getEspeceDetails($idEspece) {
        $query = "
            SELECT quantiteNourritureJour, joursSansManger, pertePoidsJour, poidsMax, poidsMin, gainPoids 
            FROM elevage_espece
            JOIN elevage_alimentation ON elevage_espece.idEspece = elevage_alimentation.idEspece 
            WHERE elevage_espece.idEspece = :idEspece
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':idEspece' => $idEspece]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [
            'quantiteNourritureJour' => 0,
            'joursSansManger' => 0,
            'pertePoidsJour' => 0,
            'poidsMax' => 0,
            'poidsMin' => 0
        ];
    }

    
}