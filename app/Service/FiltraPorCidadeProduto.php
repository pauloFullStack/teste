<?php

namespace App\Service;

use App\Models\Produto;
use App\Models\Cidade;
use App\Service\SelectProduto;


/**
 * Filtra produto por cidade
 * @param string $nome_cidade traz o nome da ciade
 * @var array $array_id traz os ids
 * @var array $dados  
*/
class FiltraPorCidadeProduto extends SelectProduto
{
    private array $dados;

    public function __construct($nome_cidade)
    {
        $ids = Cidade::whereIn('nome', [$nome_cidade])->get('id');
        foreach ($ids as $value) {
            $array_id[] = $value->id;
        }

        $obj = new  SelectProduto(Produto::whereIn('cidade', $array_id)->get());
        $this->dados = $obj->getSelectProduto();
    }


    public function getFiltraPorCidade()
    {
        return $this->dados;
    }
}
