<?php

namespace App\Service;

use App\Models\Produto;
use App\Models\Cidade;
use App\Models\Marca;

/**
 * Deleta o produto 
 *  @var array $status
 */
class DeletarProduto
{


    private array $status;

    public function __construct($id)
    {

        $dados = Produto::findOrFail($id);
        if ($dados->estoque == 0) {
            Produto::findOrFail($id)->delete();
            Cidade::findOrFail($dados->cidade)->delete();
            Marca::findOrFail($dados->marca)->delete();
            $this->status = [
                'erro' => false,
                'mensagem' => 'Produto excluido com sucesso!'
            ];
        } else {
            $this->status = [
                'erro' => true,
                'mensagem' => 'ERRO: Ainda existe produto no estoque!'
            ];
        }
    }

    public function getDeletarProduto()
    {
        return $this->status;
    }
}
