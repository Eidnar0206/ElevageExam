<?php

namespace app\controllers;
use app\models\EspeceModel;
use Flight;

class EspeceController
{
    public function __construct()
    {

    }

    public function ajoutEspece() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nomEspece'];
            $poidsMin = $_POST['poidsMin'];
            $poidsMax = $_POST['poidsMax'];
            $pv = $_POST['prixVenteKg'];
            $nbJour = $_POST['nbJour'];
            $pertePoids = $_POST['pertePoids'];
            $qte = $_POST['qte'];

            Flight::EspeceModel()->ajoutEspece($nom, $poidsMin, $poidsMax, 
            $pv, $nbJour, $pertePoids, $qte);
        }
        Flight::render('Espece\ajoutEspece');
    }

    public function listEspece() {
        $allEspeces = Flight::EspeceModel()->getAllEspeces();
        $data = [
            'especes' => $allEspeces
        ];
        Flight::render('listEspeces', $data);
    }

    public function editEspece($idEspece) {
        $espece = Flight::EspeceModel()->getEspeceById($idEspece);
        Flight::render('Espece/editEspece', ['espece' => $espece]);
    }
    
    public function updateEspece() {
        $idEspece = Flight::request()->data->idEspece;
        $data = [
            'nomEspece' => Flight::request()->data->nomEspece,
            'poidsMin' => Flight::request()->data->poidsMin,
            'poidsMax' => Flight::request()->data->poidsMax,
            'prixVenteKg' => Flight::request()->data->prixVenteKg,
            'joursSansManger' => Flight::request()->data->joursSansManger,
            'pertePoidsJour' => Flight::request()->data->pertePoidsJour,
            'quantiteNourritureJour' => Flight::request()->data->quantiteNourritureJour
        ];
    
        $model = new EspeceModel(Flight::db());
        $model->updateEspece($idEspece, $data);
    
        Flight::redirect('/especes');
    }
    

}