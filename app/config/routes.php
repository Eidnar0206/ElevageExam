<?php

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
$router->get('/', [$especeController, 'goAjoutEspece']);
$router->post('/ajoutEspece', [$especeController, 'ajoutEspece']);


