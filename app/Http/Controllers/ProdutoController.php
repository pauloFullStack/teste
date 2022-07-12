<?php

namespace App\Http\Controllers;

use App\Service\CadastrarProduto;
use App\Service\CarregarTodosProduto;
use App\Service\ListaCidades;
use App\Service\UpdateProduto;
use App\Service\ValidacaoCampos;
use App\Service\DeletarProduto;
use App\Service\FiltraPorCidadeProduto;
use App\Service\FiltrarPorValorProduto;
use App\Service\FormataMensagem;
use Illuminate\Http\Request;


class ProdutoController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function carregaProdutos()
    {
        $obj_todos_produtos = new CarregarTodosProduto();
        return response()->json([
            'dados' => $obj_todos_produtos->getCarregaProdutos()
        ]);
    }

    public function store(Request $request)
    {

        $result_validacao = new ValidacaoCampos($request, 'store');
        $result = response()->json($result_validacao->getValidacaoCampos());
        $obj_formata_mensagem = new FormataMensagem();
        if (isset($result->original['status'])) {
            $result_add_produto = new CadastrarProduto($request);
            if ($result_add_produto->getStatus() == 'Adicionado com sucesso!') {
                $obj_formata_mensagem->padraoMensagem($result_add_produto->getStatus(), 0, 0, 0, 0, false);
                return response()->json($obj_formata_mensagem->getFormataMensagem());
            } else {
                $obj_formata_mensagem->padraoMensagem($result_add_produto->getStatus(), 1, 1, 1, 0, 'nome');
                return response()->json($obj_formata_mensagem->getFormataMensagem());
            }
        } else {
            $obj_formata_mensagem->padraoMensagem($result_validacao->setStatusStore($result->original), 1, 1, 1, 0, $result_validacao->setStatusStore1($result->original));
            return response()->json($obj_formata_mensagem->getFormataMensagem());
        }
    }

    public function listaCidades()
    {
        $result_list_cidades = new ListaCidades();
        return response()->json([
            'status' => $result_list_cidades->getListaCidades()
        ]);
    }

    public function update(Request $request)
    {

        $result_validacao = new ValidacaoCampos($request, 'update');
        $result = response()->json($result_validacao->getValidacaoCampos());
        $obj_formata_mensagem = new FormataMensagem();
        if (isset($result->original['status'])) {
            $result_update_produto = new UpdateProduto($request);
            if ($result_update_produto->getUpdateProdutos() == 'Atualizado com sucesso!') {
                $obj_formata_mensagem->padraoMensagem($result_update_produto->getUpdateProdutos(), 0, 0, 0, 1, false);
                return response()->json($obj_formata_mensagem->getFormataMensagem());
            } else {
                $obj_formata_mensagem->padraoMensagem($result_update_produto->getUpdateProdutos(), 1, 1, 1, 1, 'update_nome');
                return response()->json($obj_formata_mensagem->getFormataMensagem());
            }
        } else {
            $obj_formata_mensagem->padraoMensagem($result_validacao->setStatusUpdate($result->original), 1, 1, 1, 1, $result_validacao->setStatusUpdate1($result->original));
            return response()->json($obj_formata_mensagem->getFormataMensagem());
        }
    }

    //FAZER OS TESTE UNIDADE, E ARRUMAR O FRONT E AS NOTIFICAÇÕES DE ERRO E SUCESSO! E FECHAR OS MODAL QUANDO FAZER ALGUMA AÇÃO...
    public function destroy($id)
    {
        $result_del_produto = new DeletarProduto($id);
        return response()->json([
            'status' => $result_del_produto->getDeletarProduto()
        ]);
    }

    public function filtraPorCidade($nome_produto)
    {
        $result_filtra_por_cidade = new FiltraPorCidadeProduto($nome_produto);
        return response()->json([
            'dados' => $result_filtra_por_cidade->getFiltraPorCidade()
        ]);
    }

    public function filtraPorValor($valor_inicial, $valor_final)
    {
        $result_filtra_por_valor = new FiltrarPorValorProduto($valor_inicial, $valor_final);
        return response()->json([
            'dados' => $result_filtra_por_valor->getFiltrarPorValorProduto()
        ]);
    }
}
