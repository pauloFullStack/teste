<?php

namespace App\Service;

use App\Models\Marca;
use App\Models\Cidade;

/**
 * Traz todos os produtos
 * 
 */
class SelectProduto
{


    private array $dados;
    private  $contador = 0;
    private float $soma = 0;

    public function __construct($dados)
    {

        if (sizeof($dados) > 0) {
            foreach ($dados as $values) {
                $this->dados[$this->contador]['marca'] = Marca::select('nome', 'fabricante')->where('id', $values->marca)->get();
                $this->dados[$this->contador]['cidade'] = Cidade::select('nome')->where('id', $values->cidade)->get()[0]['nome'];
                $this->dados[$this->contador]['nome'] = $values->nome;
                $this->dados[$this->contador]['valor'] = $values->valor;
                $this->dados[$this->contador]['estoque'] = $values->estoque;
                $this->dados[$this->contador]['id'] = $values->id;
                $this->soma = $this->soma +  $values->valor;
                $this->contador++;
            }
            $this->dados[$this->contador]['soma_produtos'] = $this->soma;
            $this->dados[$this->contador]['media_valor_produtos'] = $this->soma / $this->contador;
        } else {
            $this->dados[] = 'vazio';
        }
    }


    public function getSelectProduto()
    {
        return $this->dados;
    }
}
