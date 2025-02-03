<?php

namespace app\controllers;
use Flight;

class HomeController
{
    public function __construct()
    {

    }

    public function goAccueil() {
        $esp = Flight::EspeceModel()->getAllEspecesIdNom();
        Flight::render('navbarFooter');
    }


}