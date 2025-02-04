<?php

namespace app\controllers;
use app\models\AnimauxModel;
use Flight;

class SituationController 
{
    public function __construct()
    {

    }

    public function goSituation() {
        Flight::render('navbarFooter', [
            'page' => 'Situation\tableauDeBord',
        ]);
    }
}