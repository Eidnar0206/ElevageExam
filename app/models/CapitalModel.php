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
        WHERE typeTransaction='entree' and dateTransaction <= ?";
        $stmt = $this->db->query($query);
        $stmt->execute([
            $date
        ]);
        return $stmt['s'];
    }

    public function getSortie($date) {
        $query = "SELECT SUM(montant) as s FROM elevage_capitalTransactions 
        WHERE typeTransaction='sortie' and dateTransaction <= ?";
        $stmt = $this->db->query($query);
        $stmt->execute([
            $date
        ]);
        return $stmt['s'];
    }

    public function getMontantInitial() {
        $query = "SELECT montant as m FROM elevage_capital";
        $stmt = $this->db->query($query);
        $stmt->execute();
        return $stmt['m'];
    }

    public function getMontantActuelle($date) {
        $entree = $this->getEntree($date);
        $sortie = $this->getSortie($date);
        $montantInitial = $this->getMontantInitial();

        $capital = ($entree - $sortie) + $montantInitial;
        return $capital;
    }

}
