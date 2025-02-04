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

    // public static function getAnimauxValides() {
    //     $date = Flight::request()->query['dateSituation'] ?? null;

    //     if (!$date) {
    //         Flight::json(["error" => "Date requise"], 400);
    //         return;
    //     }

    //     $animalModel = new AnimalModel();
    //     $animaux = $animalModel->getAnimauxValide($date);

    //     $resultats = [];
    //     foreach ($animaux as $animal) {
    //         $image = $animalModel->getImages($animal['idAnimal']);
    //         $resultats[] = [
    //             "idAnimal" => $animal['idAnimal'],
    //             "espece" => $animal['nomEspece'],
    //             "image" => $image
    //         ];
    //     }

    //     Flight::json($resultats);
    // }

    public static function getAnimauxValides() {
        error_log("Méthode getAnimauxValides appelée");
    error_log("Toutes les données reçues: " . print_r(Flight::request(), true));
    $date = Flight::request()->query['dateSituation'] ?? null;
    error_log("Date reçue: " . $date);
        // Récupération et logging de la date
        $date = Flight::request()->query['dateSituation'] ?? null;
        error_log("Date reçue dans getAnimauxValides: " . $date);

        // Validation de la date
        if (!$date) {
            error_log("Erreur: Aucune date fournie");
            Flight::json(["error" => "Date requise"], 400);
            return;
        }

        try {
            // Instanciation du modèle
            $animalModel = new AnimauxModel(Flight::db());
            
            // Récupération des animaux
            $animaux = $animalModel->getAnimauxValide($date);
            error_log("Animaux trouvés: " . print_r($animaux, true));

            // Vérification si des animaux ont été trouvés
            if (empty($animaux)) {
                error_log("Aucun animal trouvé pour la date: " . $date);
                Flight::json([]);
                return;
            }

            // Construction du résultat
            $resultats = [];
            foreach ($animaux as $animal) {
                $image = $animalModel->getImages($animal['idAnimal']);
                //error_log("Image trouvée pour animal " . $animal['idAnimal'] . ": " . $image);
                
                $resultats[] = [
                    "idAnimal" => $animal['idAnimal'],
                    "espece" => $animal['nomEspece']
                ];
            }

            error_log("Résultats finaux: " . print_r($resultats, true));
            Flight::json($resultats);
            
        } catch (\Exception $e) {
            error_log("Erreur dans getAnimauxValides: " . $e->getMessage());
            Flight::json(["error" => "Erreur serveur: " . $e->getMessage()], 500);
        }
    }
}