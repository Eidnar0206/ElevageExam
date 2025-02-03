<?php

namespace app\controllers;
use Flight;

class TheController
{
    public function __construct()
    {

    }
    
    public function goAjoutThe() {
        $values = range(1, 4);
        $names = ["Alice", "Bob", "Charlie", "David"];

        $form = Flight::FrontModel()->generateForm(Flight::TheModel(), 'ajoutThe');
        $select = Flight::FrontModel()->setSelectOptions(Flight::TheModel(), $form, "occupation", $names, $values);
        flight::render("ajoutThe", ['form' => $select]);
    }
    public function ajoutThe() {
        $lastId = Flight::QueryModel()->insertObject(Flight::TheModel(), 'tea');
        $form = Flight::FrontModel()->generateForm(Flight::TheModel(), 'ajoutThe');
        flight::render("ajoutThe", ['form' => $form]);
    }

}