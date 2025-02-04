<?php

namespace app\controllers;
use Flight;

class HomeController
{
    public function __construct()
    {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function goAjoutCapitalInitial() {
        Flight::render('Capital/initialCapital');
    }
    public function ajoutCapitalInitial() {
        $montant = $_POST['montant'];
        Flight::CapitalModel()->insertMontantInitial($montant);
        $_SESSION['capital'] = $montant;
        Flight::render('navbarFooter.php');
    }
}