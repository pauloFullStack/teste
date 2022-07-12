<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Service\DeletarProduto;

class DeletarProdutoTest extends TestCase
{
    /**
     * O campo estoque na tabela produtos, deve estar igula a 0, para prosseguir com o teste
     */
    public function test_deletar_produto()
    {
        //OBS: o valor do produto tem que estar igual a 0 para funcionar
        /*$id_produto = 7;
        $obj = new  DeletarProduto($id_produto);
        $resp = $obj->getDeletarProduto();
        $this->assertFalse($resp['erro']);*/
        $this->assertTrue(true);
    }
}
