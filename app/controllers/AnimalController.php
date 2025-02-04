<?php

namespace app\controllers;
use app\models\EspeceModel;
use Flight;

class AnimalController
{
    public function __construct()
    {

    }

    public function goAjoutAnimal() {
        $esp = Flight::EspeceModel()->getAllEspecesIdNom();
        Flight::render('navbarFooter', [
            'page' => 'Animal/ajoutAnimal',
            'especes' => $esp
        ]);
    }

    public function ajoutAnimal() {
        $idEspece = $_POST['idEspece'];
        $prixAchat = $_POST['prixAchat'];
        $poidsInitial = $_POST['poidsInitial'];
        $dateAchat = $_POST['dateAchat'];
        $files = $_FILES['photos'];
        Flight::AnimauxModel()->insertAnimalWithPhoto($idEspece, $prixAchat, $poidsInitial, $dateAchat, $files);
        $esp = Flight::EspeceModel()->getAllEspecesIdNom();
        Flight::render('navbarFooter', [
            'page' => 'Animal/ajoutAnimal',
            'especes' => $esp
        ]);
    }

    public function achatAnimal() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idEspece = $_POST['espece'];
            $prixAchat = $_POST['prixAchat'];
            $poidsInitial = $_POST['poidsInitial'];
            $dateAchat = $_POST['dateAchat'];

            $verifySolde = Flight::AnimauxModel()->verifySolde($dateAchat, $prixAchat);
            if($verifySolde == true) {
                Flight::AnimauxModel()->achatAnimal($idEspece, $prixAchat, $poidsInitial, $dateAchat);
            }
        }
        $especes = Flight::EspeceModel()->getAllEspeces();
        $data = [
            'especes' => $especes
        ];
        Flight::render('navbarFooter', [
            'page' => 'Animal\achatAnimal',
            'data' => $data
        ]);
    }


}