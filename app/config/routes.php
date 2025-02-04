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

Flight::route('POST /ajoutEspece', array('app\controllers\EspeceController', 'ajoutEspece'));
Flight::route('POST /achatAnimal', array('app\controllers\AnimalController', 'achatAnimal'));

$router->get('/ajoutAnimal', [$animalController, 'goAjoutAnimal']);

$router->post('/ajoutAnimal', [$animalController, 'ajoutAnimal']);
$router->get('/template', [$animalController, 'goTemplate']);



$alimentationController = new alimentationController();
$router->get('/ajoutAlimentation', [$alimentationController, 'afficherFormulaireAjout']);
$router->post('/ajoutAlimentation', [$alimentationController, 'ajoutAlimentation']);
$router->get('/achatAlimentation', [$alimentationController, 'afficherFormulaireAchat']);
$router->post('/achatAlimentation', [$alimentationController, 'achatAlimentation']);

$DataController = new DataController();
$router->post('/reset', [$DataController, 'reset']);




