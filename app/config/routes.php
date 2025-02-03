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

$router->get('/ajoutAnimal', [$animalController, 'goAjoutAnimal']);

$router->post('/ajoutAnimal', [$animalController, 'ajoutAnimal']);



