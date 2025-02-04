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
            'Especes' => $Especes,
            'page' => 'Alimentation/ajoutAlimentation'
        ];
        Flight::render('navbarFooter', $data);
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
            'Especes' => $Especes,
            'page' => 'Alimentation/ajoutAlimentation'
        ];

        Flight::render('navbarFooter', $data);
    }

    public function afficherFormulaireAchat(){
        $model = new alimentationModel(Flight::db());
        $alimentations = $model->getAll();
        $data = [
            'alimentations' => $alimentations, 
            'page' => 'Alimentation/achatAlimentation'
        ];
        Flight::render('navbarFooter', $data);        
    }

    public function achatAlimentation(){
        $model = new alimentationModel(Flight::db());
        $idAlimentation = $_POST['idAlimentation'];
        $quantite = $_POST['quantite'];
        $prixTotal = $_POST['prixTotal'];
        $dateAchat = $_POST['dateAchat'];

        $alimentations = $model->getAll();

        $verif = $model->verifSolde($dateAchat, $prixTotal);
        if($verif){
            $data = [
                'alimentations' => $alimentations,
                'page' => 'Alimentation/achatAlimentation'
            ];

            $model->achatAlimentation($idAlimentation, $quantite, $prixTotal, $dateAchat);
    
            Flight::render('navbarFooter', $data);        
        }
        else{
            $data = [
                'alimentations' => $alimentations,
                'insuf' => 'dfghjkl',
                'page' => 'Alimentation/achatAlimentation'
            ];

            Flight::render('navbarFooter', $data);        
        }
    }

    public function stockAlimentation(){ 
        
    }
}