<?php

use app\controllers\TheController;
use flight\Engine;
use flight\net\Route;
use flight\net\Router;
// use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$theController = new TheController();
$router->get('/', [$theController, 'goAjoutThe']);
$router->post('/ajoutThe', [$theController, 'ajoutThe']);

