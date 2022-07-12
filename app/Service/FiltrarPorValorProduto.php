<?php

namespace App\Service;

use App\Models\Produto;
/**
 * Busca produtos pelo intervalo de valor
 * 
*/
class FiltrarPorValorProduto extends SelectProduto
{
    private $dados;

    public function __construct($valor_inicia, $valor_final)
    {


        $obj = new  SelectProduto(Produto::select("*")
            ->where("valor", "<=", $valor_final)
            ->where("valor", ">=", $valor_inicia)
            ->get());
        $this->dados = $obj->getSelectProduto();
    }

    public function getFiltrarPorValorProduto()
    {
        return $this->dados;
    }
}
