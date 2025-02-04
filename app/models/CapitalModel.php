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
        $stmt->execute([
            ':dt' => $date
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC); 
        return $result['s'];
    }
    

    public function getSortie($date) {
        $query = "SELECT SUM(montant) as s FROM elevage_capitalTransactions 
        WHERE typeTransaction='sortie' and dateTransaction <= :dt";
        $stmt = $this->db->prepare($query); 
        $stmt->execute([
            ':dt' => $date
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC); 
        return $result['s'];
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

}
