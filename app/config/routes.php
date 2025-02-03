<?php

use app\controllers\AnimalController;
use app\controllers\EspeceController;
use flight\Engine;
use flight\net\Route;
use flight\net\Router;
// use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$especeController = new EspeceController();
$animalController = new AnimalController();

$router->get('/', [$especeController, 'goAjoutEspece']);
$router->post('/ajoutEspece', [$especeController, 'ajoutEspece']);
$router->get('/ajoutEspece', [$especeController, 'ajoutEspece']);

Flight::route('POST /ajoutEspece', array('app\controllers\EspeceController', 'ajoutEspece'));
Flight::route('/espece/edit/@id', ['app\controllers\EspeceController', 'editEspece']);
Flight::route('POST /espece/update', ['app\controllers\EspeceController', 'updateEspece']);

$router->get('/ajoutAnimal', [$animalController, 'goAjoutAnimal']);

$router->post('/ajoutAnimal', [$animalController, 'ajoutAnimal']);



