<?php

namespace App\Service;

use App\Models\Produto;
use App\Models\Marca;
use App\Models\Cidade;

/**
 * Carrega todos os produtos da tabela produto
 * @var array $dados retorna os dados
 */
class CarregarTodosProduto extends SelectProduto
{


    private array $dados;

    public function __construct()
    {
        $obj = new  SelectProduto(Produto::orderBy("id", "desc")->get());
        $this->dados = $obj->getSelectProduto();
    }


    public function getCarregaProdutos()
    {
        return $this->dados;
    }
}
