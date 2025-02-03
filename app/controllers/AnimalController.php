<?php

namespace app\controllers;
use Flight;

class AnimalController
{
    public function __construct()
    {

    }

    public function goAjoutAnimal() {
        $esp = Flight::EspeceModel()->getAllEspecesIdNom();
        Flight::render("ajoutAnimal", ["especes" => $esp]);
    }

    public function ajoutAnimal() {
    
        $idEspece = $_POST['idEspece'];
        $prixAchat = $_POST['prixAchat'];
        $poidsInitial = $_POST['poidsInitial'];
        $dateAchat = $_POST['dateAchat'];
        $files = $_FILES['photos'];
        Flight::AnimauxModel()->insertAnimalWithPhoto($idEspece, $prixAchat, $poidsInitial, $dateAchat, $files);
        $esp = Flight::EspeceModel()->getAllEspecesIdNom();
        Flight::render("ajoutAnimal", ["especes" => $esp]);
    }
}