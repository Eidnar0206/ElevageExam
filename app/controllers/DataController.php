<?php

namespace app\controllers;
use app\models\Fonction\FonctionModel;
use app\models\EspeceModel;
use Flight;

class DataController
{
    public function __construct()
    {

    }

    public function reset(){
        $model = new FonctionModel(Flight::db());
        $model->resetData();
        Flight::redirect('/');
    }
}