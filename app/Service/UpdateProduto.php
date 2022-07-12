<?php

namespace App\Service;

use App\Models\Produto;
use App\Models\Cidade;
use App\Models\Marca;

/**
 * Atuliza dados de um produto
 * 
 */

class UpdateProduto
{
    private $dados;

    public function __construct($request)
    {
        $verifica_array_vazio = sizeof(Produto::select('nome')
            ->where('nome', $request->nome)
            ->where('id', '<>', $request->id)
            ->get());
        if ($verifica_array_vazio == 0) {
            $get_campos = Produto::find($request->id);
            Cidade::where('id', $get_campos->cidade)->update(['nome' => $request->cidade]);
            Marca::where('id', $get_campos->marca)->update(['nome' => $request->marca, 'fabricante' => $request->fabricante]);
            Produto::where('id', $request->id)
                ->update([
                    'nome' => $request->nome,
                    'valor' => $request->valor,
                    'estoque' => $request->estoque
                ]);
            $this->dados = 'Atualizado com sucesso!';
        } else {
            $this->dados = 'Esse produto já existe!';
        }
    }


    public function getUpdateProdutos()
    {
        return $this->dados;
    }
}
