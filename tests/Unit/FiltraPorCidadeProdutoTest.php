<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Service\FiltraPorCidadeProduto;

class FiltraPorCidadeProdutoTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_filtrar_por_cidade_produto()
    {
        $obj = new FiltraPorCidadeProduto('cidade5');
        $dados = $obj->getFiltraPorCidade();
        $this->assertEquals($dados[0]['nome'], 'produto5');
    }
}
