<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Service\CarregarTodosProduto;

class CarregarTodosProdutoTest extends TestCase
{
    /**
     * O teste verifica se existe o nome do produto, teste verifica se esta trazendo os dados da tabela produtos
     * @return void
     */
    public function test_carregar_todos_produto()
    {
        $obj = new CarregarTodosProduto();
        $dados = $obj->getCarregaProdutos();
        $this->assertEquals($dados[0]['nome'], 't2');
    }
}
