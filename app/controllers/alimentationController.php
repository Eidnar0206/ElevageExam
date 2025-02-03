<?php

namespace app\controllers;
use app\models\alimentationModel;
use app\models\EspeceModel;
use Flight;

class alimentationController
{
    public function __construct()
    {

    }

    public function afficherFormulaireAjout(){
        $model = new EspeceModel(Flight::db());
        $Especes = $model->getAllEspeces();
        $data = [
            'Especes' => $Especes
        ];
        Flight::render('Alimentation/ajoutAlimentation', $data);
    }

    public function ajoutAlimentation() {
        $model = new alimentationModel(Flight::db());
        $nomAlimentation = $_POST['nom'];
        $idEspece = $_POST['idEspece'];
        $gainPoids = $_POST['gainPoids'];
        $model->ajoutAlimentation($nomAlimentation, $idEspece, $gainPoids);

        $espmodel = new EspeceModel(Flight::db());
        $Especes = $espmodel->getAllEspeces();
        $data = [
            'Especes' => $Especes
        ];

        Flight::render('Alimentation/ajoutAlimentation', $data);
    }

    public function afficherFormulaireAchat(){
        $model = new alimentationModel(Flight::db());
        $alimentations = $model->getAll();
        $data = [
            'alimentations' => $alimentations
        ];
        Flight::render('Alimentation/achatAlimentation', $data);        
    }

    public function achatAlimentation(){
        $model = new alimentationModel(Flight::db());
        $idAlimentation = $_POST['idAlimentation'];
        $quantite = $_POST['quantite'];
        $prixTotal = $_POST['prixTotal'];
        $dateAchat = $_POST['dateAchat'];

        $model->achatAlimentation($idAlimentation, $quantite, $prixTotal, $dateAchat);

        $alimentations = $model->getAll();
        $data = [
            'alimentations' => $alimentations
        ];

        Flight::render('Alimentation/achatAlimentation', $data);        
    }
}