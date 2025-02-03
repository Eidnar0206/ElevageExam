<?php

namespace app\models;

class EspeceModel 
{

    private $idEspece;
    public $nomEspece;
    public $poidsMin;
    public $poidsMax;
    public $prixVenteKg;
    public $joursSansManger;
    public $pertePoidsJour;

    protected $db;

    public function __construct($db = null, $nomEspece = null, $poidsMin = null, $poidsMax = null,
    $prixVenteKg = null, $joursSansManger = null, $pertePoidsJour = null) {
        $this->db = $db;
        $this->nomEspece = $nomEspece;
        $this->poidsMin = $poidsMin;
        $this->poidsMax = $poidsMax;
        $this->prixVenteKg = $prixVenteKg;
        $this->joursSansManger = $joursSansManger;
        $this->pertePoidsJour = $pertePoidsJour;
    }

    public function getLabels() {
        return [
            'nomEspece' => 'Nom de l\'espèce',
            'poidsMin' => 'Poids Minimum',
            'poidsMax' => 'Poids Maximum',
            'prixVenteKg' => 'Prix de vente au Kg',
            'joursSansManger' => 'Le nombre de jour sans manger avant de mourir',
            'pertePoidsJour' => 'Le % de perte de poids par jour sans manger'
        ];
    }

}