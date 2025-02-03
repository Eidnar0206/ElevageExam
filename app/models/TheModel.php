<?php

namespace app\models;

class TheModel
{
    public $varieteDeThe;
    public $occupation;
    public $rendementParPied;
    protected $db;
    public function __construct($db = null, $varieteDeThe = null, $occupation = null, $rendementParPied = null)
    {
        $this->db = $db;
        $this->varieteDeThe = $varieteDeThe;
        $this->occupation = $occupation;
        $this->rendementParPied = $rendementParPied;
    }
    public function getLabels() {
        return [
            'varieteDeThe' => 'Variete de Thé',
            'occupation' => 'Occupation',
            'rendementParPied' => 'Rendement Par Pied',
        ];
    }
}