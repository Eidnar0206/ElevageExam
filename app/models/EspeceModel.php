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
    
    public function getStockByEspece($date) {
        // Query to get total quantities of food purchased per species (idEspece) on a specific date
        $query = "
            SELECT a.idEspece, SUM(aa.quantite) AS totalQuantite
            FROM elevage_achatAlimentation aa
            JOIN elevage_alimentation a ON aa.idAlimentation = a.idAlimentation
            WHERE aa.dateAchat = '2024-01-03'
            GROUP BY a.idEspece
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':date' => $date]);
        
        // Fetch the results
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Initialize an empty array to store the total food quantity for each species
        $foodQuantities = [];
        
        // Loop through the results and populate the array with idEspece as the key and total quantity as the value
        foreach ($results as $row) {
            $foodQuantities[$row['idEspece']] = $row['totalQuantite'];
        }
    
        return $foodQuantities;
    }
    
    public function getQuantiteNourritureJour($idEspece) {
        // SQL query to get the quantiteNourritureJour based on idEspece
        $query = "SELECT quantiteNourritureJour FROM elevage_espece WHERE idEspece = :idEspece";
    
        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->execute([':idEspece' => $idEspece]);
    
        // Fetch the result
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        // Return the quantiteNourritureJour or null if no result
        return $result ? $result['quantiteNourritureJour'] : null;
    }

    public function getJoursSansManger($idEspece) {
        // SQL query to get the quantiteNourritureJour based on idEspece
        $query = "SELECT joursSansManger FROM elevage_espece WHERE idEspece = :idEspece";
    
        // Prepare and execute the query
        $stmt = $this->db->prepare($query);
        $stmt->execute([':idEspece' => $idEspece]);
    
        // Fetch the result
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        // Return the quantiteNourritureJour or null if no result
        return $result ? $result['quantiteNourritureJour'] : null;
    }
    
}