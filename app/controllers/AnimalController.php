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
        $errorMessage = null; 
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idAnimal = $_POST['idAnimal'];
            $dateVente = $_POST['dateVente'];
            $conditionVente = Flight::AnimauxModel()->conditionVente($idAnimal, $dateVente);
    
            if ($conditionVente) {
                $poidsActu = Flight::SituationModel()->getPoidsActuel($idAnimal, $dateVente);
                $idEspece = Flight::SituationModel()->getIdEspeceAnimal($idAnimal);
                $prixVenteKg = Flight::SituationModel()->getPrixVenteKgParEspece($idEspece);
                $prix = $poidsActu * $prixVenteKg;
    
                Flight::AnimauxModel()->insertVenteAnimal($idAnimal, $poidsActu, $prix, $dateVente);
                Flight::CapitalModel()->insertTransaction($prix, 'entree', 'Vente d\'un Animal', $dateVente);
            } else {
                $errorMessage = "Les conditions de vente ne sont pas remplies pour cet animal.";
            }
        }
    
        $animals = Flight::AnimauxModel()->getAllAnimals();
        Flight::render('navbarFooter', [
            'page' => 'Animal/listeAnimauxVente',
            'animals' => $animals,
            'errorMessage' => $errorMessage 
        ]);
    }
    

}