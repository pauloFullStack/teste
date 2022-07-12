<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Service\ListaCidades;

class ListaCidadesTest extends TestCase
{
    /**
     * O campo estoque na tabela produtos, deve estar igula a 0, para prosseguir com o teste
     */
    public function test_lista_cidades()
    {
        $obj = new ListaCidades();
        $dados = $obj->getListaCidades();
        $this->assertEquals($dados[0]['nome'], 'cidade5');
    }
}
