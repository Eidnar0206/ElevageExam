<?php

use app\controllers\AnimalController;
use app\controllers\EspeceController;
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

$router->post('/ajoutEspece', [$especeController, 'ajoutEspece']);
$router->get('/ajoutEspece', [$especeController, 'ajoutEspece']);
$router->get('/listEspece', [$especeController, 'listEspece']);


Flight::route('POST /ajoutEspece', array('app\controllers\EspeceController', 'ajoutEspece'));


$router->get('/ajoutAnimal', [$animalController, 'goAjoutAnimal']);

$router->post('/ajoutAnimal', [$animalController, 'ajoutAnimal']);



