<?php

use app\controllers\AnimalController;
use app\controllers\EspeceController;
use app\controllers\HomeController;
use app\controllers\alimentationController;
use app\controllers\SituationController;
use app\controllers\DataController;
use flight\Engine;
use flight\net\Route;
use flight\net\Router;

Flight::route('POST /especes/update', ['app\controllers\EspeceController', 'update']);
// Flight::route('POST /animaux-valides', ['app\controllers\AnimalController', 'getAnimauxValides']);

// use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$especeController = new EspeceController();
$animalController = new AnimalController();
$homeController = new HomeController();
$situationController = new SituationController();

$router->get('/', [$homeController, 'goAjoutCapitalInitial']);
$router->post('/ajoutCapitalInitial', [$homeController, 'ajoutCapitalInitial']);
$router->post('/ajoutEspece', [$especeController, 'ajoutEspece']);
$router->get('/ajoutEspece', [$especeController, 'ajoutEspece']);
$router->get('/listEspece', [$especeController, 'listEspece']);
$router->get('/achatAnimal', [$animalController, 'achatAnimal']);
$router->get('/tableauBord', [$situationController, 'goSituation']);
$router->get('/goVenteAnimaux', [$animalController, 'goVenteAnimaux']);


Flight::route('POST /ajoutEspece', array('app\controllers\EspeceController', 'ajoutEspece'));
Flight::route('POST /achatAnimal', array('app\controllers\AnimalController', 'achatAnimal'));
Flight::route('POST /goVenteAnimaux', array('app\controllers\AnimalController', 'goVenteAnimaux'));
Flight::route('GET /animaux-valides', function() {
    $date = Flight::request()->query['date'] ?? null;

    if (!$date) {
        Flight::json(['error' => 'Date invalide ou manquante'], 400);
        return;
    }

    // Retourne les animaux valides pour cette date
    Flight::json(['message' => "Animaux trouvés pour la date $date"]); 
});

$router->get('/ajoutAnimal', [$animalController, 'goAjoutAnimal']);

$router->post('/ajoutAnimal', [$animalController, 'ajoutAnimal']);
$router->get('/template', [$animalController, 'goTemplate']);



$alimentationController = new alimentationController();
$router->get('/ajoutAlimentation', [$alimentationController, 'afficherFormulaireAjout']);
$router->post('/ajoutAlimentation', [$alimentationController, 'ajoutAlimentation']);
$router->get('/achatAlimentation', [$alimentationController, 'afficherFormulaireAchat']);
$router->post('/achatAlimentation', [$alimentationController, 'achatAlimentation']);

$router->get('/goAlimentation', [$alimentationController, 'goStockAlimentation']);
$router->post('/goAlimentation', [$alimentationController, 'stockAlimentation']);
$DataController = new DataController();
$router->post('/reset', [$DataController, 'reset']);

// Flight::route('GET /animaux-valides', [$animalController, 'getAnimauxValides']);


