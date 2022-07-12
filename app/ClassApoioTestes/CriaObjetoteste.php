<?php

namespace App\ClassApoioTestes;

class CriaObjetoteste
{

    public $nome;
    public $marca;
    public $fabricante;
    public $cidade;
    public $valor;
    public $estoque;
    public $id;

    public function __construct()
    {

        $this->nome = 'produto1';
        $this->marca = 'marca1';
        $this->fabricante = 'fabricante1';
        $this->cidade = 'cidade1';
        $this->valor = 200;
        $this->estoque = 6;
        $this->id = 1;
    }
}

