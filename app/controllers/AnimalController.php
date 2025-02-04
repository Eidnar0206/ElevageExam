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
    
        // Insert animal and handle the response
        $result = Flight::AnimauxModel()->insertAnimal($idEspece, $prixAchat, $poidsInitial, $dateAchat);
    
        if ($result === true) {
            // If insertion is successful, proceed with photo upload
            Flight::AnimauxModel()->insertAnimalWithPhoto($idEspece, $prixAchat, $poidsInitial, $dateAchat, $files);
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
    


}