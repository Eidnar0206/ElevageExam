<?php

use app\models\AnimauxModel;
use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;
use app\models\EspeceModel;
use app\models\Fonction\FonctionModel;
use app\models\alimentationModel;

use app\models\CapitalModel;


/** 
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// uncomment the following line for MySQL
 $dsn = 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'] . ';charset=utf8mb4';

// uncomment the following line for SQLite
// $dsn = 'sqlite:' . $config['database']['file_path'];

// Uncomment the below lines if you want to add a Flight::db() service
// In development, you'll want the class that captures the queries for you. In production, not so much.
 $pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;
 $app->register('db', $pdoClass, [ $dsn, $config['database']['user'] ?? null, $config['database']['password'] ?? null ]);

// Got google oauth stuff? You could register that here
// $app->register('google_oauth', Google_Client::class, [ $config['google_oauth'] ]);

// Redis? This is where you'd set that up
// $app->register('redis', Redis::class, [ $config['redis']['host'], $config['redis']['port'] ]);



// Flight::map('productModel', function () {
//     return new ProductModel(Flight::db());
// });

Flight::map('EspeceModel', function () {
    return new EspeceModel(Flight::db());
});

Flight::map('AnimauxModel', function () {
    return new AnimauxModel(Flight::db());
});

Flight::map('FonctionModel', function () {
    return new FonctionModel(Flight::db());
});

Flight::map('CapitalModel', function () {
    return new CapitalModel(Flight::db());
});

Flight::map('alimentationModel', function () {
    return new AlimentationModel(Flight::db());
});