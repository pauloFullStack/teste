<?php

namespace App\Service;

use App\Models\Cidade;

/**
 * Lista as cidades
 * 
*/
class ListaCidades
{


    private array $dados;

    public function __construct()
    {
        $pega_cidades = Cidade::select('nome')->get();
        foreach ($pega_cidades as $values) {
            $this->dados[] = $values;
        }
    }


    public function getListaCidades()
    {
        return array_unique($this->dados);
    }
}
