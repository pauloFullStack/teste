@extends('layouts.main')

@section('title', 'Bem-vindo')

@section('content')


    <div style="padding: 20px 20px 40px 20px;text-align: center;color:#7F3FBF">
        <h1>Gerenciador de produtos</h1>
    </div>

    <div class="padding-b-30">
        <div class="row">
            <div onclick="alterardiv('div-table-produtos', 'div-formualrio-add-produto');styleAlternarDiv( 'menu-cadastrar','menu-produtos')"
                class="col padding-30">
                <div id="menu-cadastrar" class="menu">
                    <h4>Cadastar Produto</h4>
                </div>
            </div>
            <div onclick="alterardiv('div-formualrio-add-produto', 'div-table-produtos');styleAlternarDiv('menu-produtos', 'menu-cadastrar')"
                class="col padding-30">
                <div id="menu-produtos" class="menu">
                    <h4>Produtos</h4>
                </div>
            </div>
        </div>
    </div>


    <div id="div-formualrio-add-produto" class="mx-auto div-padrao">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                <div class="padding-20 b-white">
                    <div class="padding-10">
                        <h3>Cadastrar Produto</h3>
                    </div>
                    <div id="notificacao" class="padding-10">
                        <input type="text" onkeyup="limpaMensagem('nome')" id="nome" name="nome"
                            class="form-control" placeholder="Nome produto">
                    </div>
                    <div class="padding-10">
                        <input type="text" id="valor" onkeyup="formataValor(this);limpaMensagem('valor')"
                            name="valor" class="form-control" placeholder="Valor">
                    </div>
                    <div class="padding-10">
                        <input type="text" onkeyup="limpaMensagem('marca')" id="marca" name="marca"
                            class="form-control" placeholder="Marca">
                    </div>
                    <div class="padding-10">
                        <input type="text" onkeyup="limpaMensagem('fabricante')" id="fabricante" name="fabricante"
                            class="form-control" placeholder="Fabricante">
                    </div>
                    <div class="padding-10">
                        <input type="number" onkeyup="limpaMensagem('estoque')" onkeypress="return event.charCode >= 1"
                            min="1" id="estoque" name="estoque" class="form-control" placeholder="Estoque">
                    </div>
                    <div class="padding-10">
                        <input type="text" onkeyup="limpaMensagem('cidade')" id="cidade" name="cidade"
                            class="form-control" placeholder="Cidade">
                    </div>
                    <div style="text-align: center" class="padding-perso">
                        <button style="text-align: center" type="submit" class="btn btn-outline-success"
                            onclick="event.preventDefault();cadastrarProduto()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="div-table-produtos" class="container div-padrao">
        <div class="row">
            <div class="col-lg-3 padding-b-30 mx-auto">
                <div class="btn-perso">
                    Total Produtos
                    <div class="padding-t-10">
                        <h4 id="valor-soma"></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 padding-b-10 mx-auto">
                <div class="btn-perso">
                    Média Produtos
                    <div class="padding-t-10">
                        <h4 id="media-valor"></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div style="text-align: center" class="col-lg-6 mx-auto">
                <div class="padding-trbl-20">
                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button"
                        aria-expanded="false" aria-controls="collapseExample">
                        Filtrar &nbsp;&nbsp; <i class="fa-solid fa-filter"></i>
                    </a>
                </div>
                <div class="padding-trbl-20">
                    <div class="collapse mx-auto" id="collapseExample">
                        <div class="card card-body">
                            <select id="select-filtro" class="form-select" aria-label="Default select example">
                                <option selected>Selecione o filtro</option>
                                <option value="por_cidade">Por cidade</option>
                                <option value="intervalor_valores">Intervalo de valores</option>
                            </select>
                            <div id="div-select-cidades" class="padding-tb-20">
                                <select id="select-filtro-cidades" class="form-select"
                                    aria-label="Default select example">

                                </select>
                            </div>
                            <div id="div-select-valor-aleatorio" class="padding-tb-20">
                                <label for="filtrar-por-valor">Valor Inicial <span id="valor-inicial"></span></label>
                                <input type="range" oninput="valorInicial(this.value)"
                                    onchange="valorInicial(this.value)" class="form-range" min="1" max="1000"
                                    value="0" step="1" id="filtrar-por-valor">
                                <label for="filtrar-por-valor">Valor Final <span id="valor-final"></span></label>
                                <input type="range" oninput="valorFinal(this.value)" onchange="valorFinal(this.value)"
                                    class="form-range" min="1" max="1000" value="0" step="1"
                                    id="filtrar-por-valor">
                                <div class="padding-t-10">
                                    <button type="button" onclick="filtrarPorValor()"
                                        class="btn btn-outline-success">Buscar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive tabela-produtos">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Estoque</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Fabricante</th>
                    </tr>
                </thead>
                <tbody id="table-carrega-produtos">

                </tbody>
            </table>
            <div style="text-align: center">
                <h2 class="tabela-produtos-h2" id="mensagem-vazio-tabela"></h2>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="update-modal" class="modal-body">
                    <div id="notificacao-update" style="padding: 15px;">
                        <input type="hidden" id="id_produto">
                        <div class="padding-5">
                            <div class="padding-5">
                                <label for="update_nome"><b>Nome</b></label>
                            </div>
                            <input type="text" class="form-control" id="update_nome">
                        </div>
                        <div class="padding-5">
                            <div class="padding-5">
                                <label for="update_valor"><b>Valor</b></label>
                            </div>
                            <input type="text" onkeyup="formataValor(this)" class="form-control" id="update_valor">
                        </div>
                        <div class="padding-5">
                            <div class="padding-5">
                                <label for="update_marca"><b>Marca</b></label>
                            </div>
                            <input type="text" class="form-control" id="update_marca">
                        </div>
                        <div class="padding-5">
                            <div class="padding-5">
                                <label for="update_fabricante"><b>Fabricante</b></label>
                            </div>
                            <input type="text" class="form-control" id="update_fabricante">
                        </div>
                        <div class="padding-5">
                            <div class="padding-5">
                                <label for="update_estoque"><b>Estoque</b></label>
                            </div>
                            <input type="number" onkeypress="return event.charCode >= 1" min="0"
                                class="form-control" id="update_estoque">
                        </div>
                        <div class="padding-5">
                            <div class="padding-5">
                                <label for="update_cidade"><b>Cidade</b></label>
                            </div>
                            <input type="text" class="form-control" id="update_cidade">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button onclick="event.preventDefault();updateProduto()" class="btn btn-success"
                            type="submit">Salvar</button>
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            type="button">Cancelar</button>
                    </div>
                </div>
                <div id="delete-modal" class="modal-body">
                    <div class="d-grid gap-2">
                        <button onclick="event.preventDefault();deleteProduto()" class="btn btn-danger"
                            type="submit">Sim</button>
                        <button class="btn btn-outline-dark" data-bs-dismiss="modal" type="button">Não</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
