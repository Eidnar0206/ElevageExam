<?php

namespace app\controllers;
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