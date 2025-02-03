<?php

namespace app\controllers;
use app\models\EspeceModel;
use app\models\FrontModel;
use Flight;

class EspeceController
{
    public function __construct()
    {

    }

    public function goAjoutEspece() {
        $form = Flight::FrontModel()->generateForm(Flight::EspeceModel(), 'ajoutEspece');
        Flight::render("ajoutEspece", ['form' => $form]);
    }

    public function ajoutEspece() {
        $lastId = Flight::FrontModel()->insertObject(Flight::EspeceModel(), 'elevage_espece');
        $form = Flight::FrontModel()->generateForm(Flight::EspeceModel(), 'ajoutEspece');
        Flight::render("ajoutEspece", ['form' => $form]);
    }
}