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
        Flight::render('navbarFooter', [
            'page' => 'Espece\ajoutEspece',
        ]);
    }
    

    public function listEspece() {
        $allEspeces = Flight::EspeceModel()->getAllEspeces();
        $data = [
            'especes' => $allEspeces
        ];
        Flight::render('Espece/listEspeces', $data);
    }

    public static function update() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Ajouter un log pour voir les données reçues
        error_log('Données reçues : ' . print_r($data, true));
        
        if (!$data) {
            error_log('Aucune donnée reçue');
            Flight::json(["error" => "Aucune donnée reçue"], 400);
            return;
        }
        
        $result = Flight::EspeceModel()->updateEspeces($data);
        error_log('Résultat : ' . print_r($result, true));
        Flight::json($result);
    }
    
    
}