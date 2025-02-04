<?php

namespace app\controllers;
use app\models\EspeceModel;
use app\models\AnimauxModel;
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
    
        // Insert animal and handle the response
        $result = Flight::AnimauxModel()->insertAnimalWithPhoto($idEspece, $prixAchat, $poidsInitial, $dateAchat, $files);
    
        if ($result === true) {
            $message = "Animal added successfully!";
            $messageType = "success";
        } else {
            // If there's an error, set the error message
            $message = $result; // Error message from insertAnimal
            $messageType = "error";
        }
    
        // Fetch species for the form
        $esp = Flight::EspeceModel()->getAllEspecesIdNom();
    
        // Render the view with the message
        Flight::render('navbarFooter', [
            'page' => 'Animal/ajoutAnimal',
            'especes' => $esp,
            'message' => $message,
            'messageType' => $messageType
        ]);
    }
    
    public function goVenteAnimaux() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idAnimal = $_POST['idAnimal'];
            $dateVente = $_POST['dateVente'];
        }
        $animals = Flight::AnimauxModel()->getAllAnimals();
        Flight::render('navbarFooter', [
            'page' => 'Animal/listeAnimauxVente',
            'animals' => $animals
        ]);
    }

    public static function getAnimauxValides() {
        $date = $_GET['dateSituation'];

        if (!$date) {
            Flight::json(["error" => "Date requise"], 400);
            return;
        }

        $animalModel = new AnimalModel();
        $animaux = $animalModel->getAnimauxValide($date);

        $resultats = [];
        foreach ($animaux as $animal) {
            $image = $animalModel->getImages($animal['idAnimal']);
            $resultats[] = [
                "idAnimal" => $animal['idAnimal'],
                "espece" => $animal['nomEspece'],
                "image" => $image
            ];
        }

        Flight::json($resultats);
    }
}