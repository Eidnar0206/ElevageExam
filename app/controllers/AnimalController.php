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
        Flight::render("Animal/ajoutAnimal", ["especes" => $esp]);
    }

    public function ajoutAnimal() {
    
        $idEspece = $_POST['idEspece'];
        $prixAchat = $_POST['prixAchat'];
        $poidsInitial = $_POST['poidsInitial'];
        $dateAchat = $_POST['dateAchat'];
        $files = $_FILES['photos'];
        Flight::AnimauxModel()->insertAnimalWithPhoto($idEspece, $prixAchat, $poidsInitial, $dateAchat, $files);
        $esp = Flight::EspeceModel()->getAllEspecesIdNom();
        Flight::render("Animal/ajoutAnimal", ["especes" => $esp]);
    }

    public function achatAnimal() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
        $especes = Flight::EspeceModel()->getAllEspeces();
        $data = [
            'especes' => $especes
        ];
        Flight::render('Animal/achatAnimal', $data);
    }


}