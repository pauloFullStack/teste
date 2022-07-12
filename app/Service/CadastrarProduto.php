<?php

namespace App\Service;

use App\Models\Marca;
use App\Models\Cidade;
use App\Models\Produto;

/**
 * Cadastra produtos
 * @var string $status retorna o status da requisição post do endpoint /cadastrar-produto
 * @var object $obj_marca salva os dados na tabela Marca
 * @var object $obj_cidade salva os dados na tabela Cidade
 * @var object $obj_produto salva os dados na tabela Produto 
 * @method string getStatus
 */

class CadastrarProduto
{
   
    private string $status;
    private object $obj_marca;
    private object $obj_cidade;
    private object $obj_produto;

    public function __construct($request)
    {
        $verifica_array_vazio = sizeof(Produto::select('nome')
            ->where('nome', $request->nome)
            ->get());

        //verifica se o array veio vazio
        if ($verifica_array_vazio == 0) {
            $this->obj_marca = new Marca;
            $this->obj_marca->nome = $request->marca;
            $this->obj_marca->fabricante = $request->fabricante;
            $this->obj_marca->save();

            $this->obj_cidade = new Cidade;
            $this->obj_cidade->nome = $request->cidade;
            $this->obj_cidade->save();

            $this->obj_produto = new Produto;
            $this->obj_produto->nome = $request->nome;
            $this->obj_produto->valor = $request->valor;
            $this->obj_produto->marca = $this->obj_marca->id;
            $this->obj_produto->estoque = $request->estoque;
            $this->obj_produto->cidade = $this->obj_cidade->id;
            $this->obj_produto->save();
            $this->status = 'Adicionado com sucesso!';
        } else if ($verifica_array_vazio == 1) {
            $this->status = 'Esse produto já existe!';
        }
    }

    public function getStatus()
    {
        return $this->status;
    }
}
