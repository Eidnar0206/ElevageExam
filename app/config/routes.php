<?php

use app\controllers\AnimalController;
use app\controllers\EspeceController;
use app\controllers\HomeController;
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
$homeController = new HomeController();


$router->get('/', [$homeController, 'goAccueil']);
$router->post('/ajoutEspece', [$especeController, 'ajoutEspece']);
$router->get('/ajoutEspece', [$especeController, 'ajoutEspece']);

Flight::route('POST /ajoutEspece', array('app\controllers\EspeceController', 'ajoutEspece'));
Flight::route('/espece/edit/@id', ['app\controllers\EspeceController', 'editEspece']);
Flight::route('POST /espece/update', ['app\controllers\EspeceController', 'updateEspece']);

$router->get('/ajoutAnimal', [$animalController, 'goAjoutAnimal']);

$router->post('/ajoutAnimal', [$animalController, 'ajoutAnimal']);
$router->get('/template', [$animalController, 'goTemplate']);



