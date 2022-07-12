<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Service\FiltrarPorValorProduto;

class FiltrarPorValorProdutoTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_filtrar_por_valor_produto()
    {
        $obj = new FiltrarPorValorProduto(10, 52);
        $dados = $obj->getFiltrarPorValorProduto();
        $this->assertEquals($dados[0]['nome'], 'produto3');
    }
}
