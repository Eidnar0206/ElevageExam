<?php

namespace app\models;
use Flight;

class CapitalModel 
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }
    // Vente: entree
    // Achat: sortie
    public function getEntree($date) {
        $query = "SELECT SUM(montant) as s FROM elevage_capitalTransactions 
                  WHERE typeTransaction='entree' and dateTransaction <= :dt";
        $stmt = $this->db->prepare($query); 
        $stmt->execute([':dt' => $date]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC); 
        return $result['s'] ?? 0;
    }
    
    public function getSortie($date) {
        $query = "SELECT SUM(montant) as s FROM elevage_capitalTransactions 
        WHERE typeTransaction='sortie' and dateTransaction <= :dt";
        $stmt = $this->db->prepare($query); 
        $stmt->execute([
            ':dt' => $date
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC); 
        return $result['s'] ?? 0;
    }
    public function getMontantInitial() {
        $query = "SELECT montant FROM elevage_capital";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($result === false) {
            return 0; 
        }
        
        return $result['montant'];
    }  

    public function getMontantActuelle($date) {
        $entree = $this->getEntree($date);
        $sortie = $this->getSortie($date);
        $montantInitial = $this->getMontantInitial();

        $capital = ($entree - $sortie) + $montantInitial;
        return $capital;
    }
    public function insertMontantInitial($montant) {
        $query = "INSERT INTO elevage_capital(montant) VALUES (:montant)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':montant' => $montant
        ]);
    }
    public function insertTransaction($montant, $typeTransaction, $desc, $dateTransaction) {
        $query = "INSERT INTO elevage_capitalTransactions(montant, typeTransaction, description, dateTransaction) VALUES
        (:montant, :type, :desc, :dateT)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':montant' => $montant,
            ':type' => $typeTransaction,
            ':desc' => $desc,
            ':dateT' => $dateTransaction
        ]);
    }
    public function getDateDebut() {
        // Query to get the dateDebut from the elevage_capital table
        $query = "SELECT dateDebut FROM elevage_capital LIMIT 1"; // Assuming there's only one row or you want the first one
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        // Fetch the result
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        // Return the dateDebut or null if no result is found
        return $result ? $result['dateDebut'] : null;
    }
    

}
