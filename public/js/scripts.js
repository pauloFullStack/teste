//carregamento
$(document).ready(function () {
    alterardiv('div-table-produtos', 'div-formualrio-add-produto');
    alterardiv('delete-modal', 'update-modal');
    styleAlternarDiv('menu-cadastrar', 'menu-produtos');
    document.getElementById('div-select-cidades').style.display = 'none';
    document.getElementById('div-select-valor-aleatorio').style.display = 'none';
    ajaxTemplate('http://localhost:8000/carrega-produtos', 'get', { tipo_requicao: 'get' }, 'tabelaProdutos');
});

//seta cor ao clicar no botão 'cadastrar produto' ou 'produtos'
function styleAlternarDiv(style_on, style_off) {
    var div_on = document.getElementById(style_on);
    var div_off = document.getElementById(style_off);
    div_on.classList.add('add_style');
    div_off.classList.remove('add_style');
}

// pega os valores digitado no formulario envia para o endpoint 'rota' do tipo POST
function cadastrarProduto() {

    var nome = document.querySelector('#nome').value;
    var valor = document.querySelector('#valor').value;
    var marca = document.querySelector('#marca').value;
    var fabricante = document.querySelector('#fabricante').value;
    var estoque = document.querySelector('#estoque').value;
    var cidade = document.querySelector('#cidade').value;


    ajaxTemplate('http://localhost:8000/cadastrar-produto', 'post', {
        nome: nome,
        valor: valor.replace(/[^0-9,]*/g, '').replace(',', '.'),
        fabricante: fabricante,
        marca: marca,
        estoque: estoque,
        cidade: cidade
    }, 'statusCadastro');


}

// alterna as divs
function alterardiv(fechar, abrir) {
    document.getElementById(fechar).style.display = 'none';
    document.getElementById(abrir).style.display = 'block';
    if (abrir == 'div-table-produtos') {
        ajaxTemplate('http://localhost:8000/carrega-produtos', 'get', { tipo_requicao: 'get' }, 'tabelaProdutos');
    }
}

// pega os eventos do select do filtro
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('select-filtro').addEventListener('change', function () {
        var select_filtro = document.querySelector('#select-filtro').value;
        if (select_filtro == 'por_cidade') {
            document.getElementById('div-select-valor-aleatorio').style.display = 'none';
            ajaxTemplate('http://localhost:8000/lista-cidades', 'get', { tipo_requisicao: 'get' }, 'listaCidades');
        } else if (select_filtro == 'intervalor_valores') {
            document.getElementById('div-select-valor-aleatorio').style.display = 'block';
            document.getElementById('div-select-cidades').style.display = 'none';
        }
    });

    document.getElementById('select-filtro-cidades').addEventListener('change', function () {
        var select_filtro = document.querySelector('#select-filtro-cidades').value;
        ajaxTemplate('http://localhost:8000/filtro-por-cidade/' + select_filtro, 'get', { tipo_de_metodo: 'get' }, 'tabelaProdutos');
    });
});

// função estilo um template para criações de requisição POST GET DELETE PUT...
function ajaxTemplate(endpoint, verbo, dados, metodo_js) {

    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

    $.ajax({
        type: verbo,
        url: endpoint,
        data: JSON.stringify(dados),
        //objeto com propriedades e o token necesseario para a requisição POST em LARAVEL
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            //segurança
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        },
        dataType: 'json'

    }).done(function (result) {
        if (metodo_js != null) {
            window[metodo_js](result);
        }
    });

}

//carrega a tabela de produtos
function tabelaProdutos(result) {
    console.log(result);

    if (result.dados[0] != 'vazio') {
        document.getElementById('mensagem-vazio-tabela').innerHTML = ''
        document.getElementById("table-carrega-produtos").innerHTML = '&nbsp;';
        var ultima_ps = result.dados.length;
        --ultima_ps;
        document.getElementById("valor-soma").innerHTML = 'R$ ' + result.dados[ultima_ps].soma_produtos.toFixed(2);
        document.getElementById("media-valor").innerHTML = 'R$ ' + result.dados[ultima_ps].media_valor_produtos.toFixed(2);

        for (var i = 0; i < ultima_ps; i++) {
            var table = document.getElementById("table-carrega-produtos");

            var row = table.insertRow(i);

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);

            cell1.innerHTML = result.dados[i].nome;
            cell2.innerHTML = result.dados[i].valor;
            cell3.innerHTML = result.dados[i].marca[0].nome;
            cell4.innerHTML = result.dados[i].estoque;
            cell5.innerHTML = result.dados[i].cidade;
            cell6.innerHTML = '<div class="icone-edit"><i onclick="setModalUpdateProduto(\'' + result.dados[i].id + '\', \'' + result.dados[i].nome + '\', \'' + result.dados[i].valor + '\',\'' + result.dados[i].marca[0].nome + '\',\'' + result.dados[i].estoque + '\',\'' + result.dados[i].cidade + '\',\'' + result.dados[i].marca[0].fabricante + '\')" style="color:#3F3FBF" class="fa-solid fa-file-pen"></i>&nbsp;&nbsp;<i onclick="deletarProduto(\'' + result.dados[i].id + '\', \'' + result.dados[i].nome + '\')" style="color:#BF3F3F" class="fa-solid fa-trash"></i></div>';
            cell7.innerHTML = result.dados[i].marca[0].fabricante;
        }
    } else {
        document.getElementById("valor-soma").innerHTML = 'R$ 0,00';
        document.getElementById("media-valor").innerHTML = 'R$ 0,00';
        document.getElementById("table-carrega-produtos").innerHTML = '&nbsp;';
        document.getElementById('mensagem-vazio-tabela').innerHTML = 'Nenhum produto encontrado!'
    }
}

//imprimi os status da criação do produto
function statusCadastro(result) {
    console.log(result);
    notificacao('beforebegin', '<span id="msg_erro" style="padding:10px" ><div class="alert alert-' + result.tipo_alerta + ' d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="' + result.tipo_alert_2 + ':"><use xlink:href="' + result.icone + '"/></svg><div>' + result.status + '</div></div></span>', result.campo, result.div_notificacao);

    if (result.tipo_alerta == 'success') {
        var posicaoes_form = ['nome', 'valor', 'marca', 'fabricante', 'estoque', 'cidade'];
        for (var i = 0; i < posicaoes_form.length; i++) {
            document.querySelector('#' + posicaoes_form[i]).value = '';
        }
    }

}

//lista todas as cadedes e cria um select
function listaCidades(dados) {

    var result = Object.values(dados.status);
    console.log(result);
    let select = document.querySelector('#select-filtro-cidades');
    if (result.length >= 0) {
        document.getElementById('select-filtro-cidades').innerHTML = '&nbsp;';
        for (var i = 0; i < result.length; i++) {
            select.options[select.options.length] = new Option(result[i].nome, result[i].nome);
        }
        select.options[select.options.length] = new Option('Selecione a cidade', 'selecione', false, true);
        document.getElementById('div-select-cidades').style.display = 'block';

    } else {
        select.options[select.options.length] = new Option('Nenhumca cidade', 'selecione_cidad', false, true);
        document.getElementById('div-select-cidades').style.display = 'block';
    }

}

//formata o valor em moeda
function numberToReal2(numero) {
    var numero = numero.split('.');
    numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
    return numero.join(',');
}

//seta os valores no formulario de atualizacao
function setModalUpdateProduto(id, nome, valor, marca, estoque, cidade, fabricante) {

    document.getElementById('exampleModalLabel').innerHTML = nome;
    document.querySelector('#id_produto').value = id;
    document.querySelector('#update_nome').value = nome;
    document.querySelector('#update_valor').value = numberToReal2(parseFloat(valor).toFixed(2));
    document.querySelector('#update_marca').value = marca;
    document.querySelector('#update_estoque').value = estoque;
    document.querySelector('#update_cidade').value = cidade;
    document.querySelector('#update_fabricante').value = fabricante;
    alterardiv('delete-modal', 'update-modal');
    abrirModal();

}

//confirmacao de exclusao do produto e deleta produto
function deletarProduto(id, nome_produto) {
    document.getElementById('exampleModalLabel').innerHTML = 'Daseja deletar o poduto ' + nome_produto + ' ?';
    document.querySelector('#id_produto').value = id;
    alterardiv('update-modal', 'delete-modal');
    abrirModal();
}

//requesição para o ajax para deletetar o produto, pelo id
function deleteProduto() {
    ajaxTemplate('http://localhost:8000/produto/' + document.querySelector('#id_produto').value, 'delete', { tipo_requicao: 'delete' }, 'respDeleteProduto');
}

//resposta da requisição DELETE , carrega a tabela novamente, apos a exclusao
function respDeleteProduto(result) {
    alert(result.status.mensagem);
    if (result.status.mensagem == 'Produto excluido com sucesso!') {
        ajaxTemplate('http://localhost:8000/carrega-produtos', 'get', { tipo_requicao: 'get' }, 'tabelaProdutos');
    }
}

//atualiza produto PUT
function updateProduto() {
    var id = document.querySelector('#id_produto').value;
    var nome = document.querySelector('#update_nome').value;
    var valor = document.querySelector('#update_valor').value;
    var marca = document.querySelector('#update_marca').value;
    var estoque = document.querySelector('#update_estoque').value;
    var cidade = document.querySelector('#update_cidade').value;
    var fabricante = document.querySelector('#update_fabricante').value;

    ajaxTemplate('http://localhost:8000/produto-update', 'put', {
        id: id,
        nome: nome,
        valor: valor.replace(/[^0-9,]*/g, '').replace(',', '.'),
        marca: marca,
        estoque: estoque,
        cidade: cidade,
        fabricante: fabricante
    }, 'statusUpdate');

}

//resposta a requisição update
function statusUpdate(result) {
    console.log(result);
    notificacao('beforebegin', '<span id="msg_erro" style="padding:10px" ><div class="alert alert-' + result.tipo_alerta + ' d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="' + result.tipo_alert_2 + ':"><use xlink:href="' + result.icone + '"/></svg><div>' + result.status + '</div></div></span>', result.campo, result.div_notificacao);

    if (result.tipo_alerta == 'success') {
        ajaxTemplate('http://localhost:8000/carrega-produtos', 'get', { tipo_requicao: 'get' }, 'tabelaProdutos');
    }

}

//pega o valor inicial
function valorInicial(valor) {
    document.getElementById('valor-inicial').innerHTML = 'R$ ' + valor;
    document.querySelector('#valor-inicial').value = valor;
}

//pega o valor final
function valorFinal(valor) {
    document.getElementById('valor-final').innerHTML = 'R$ ' + valor;
    document.querySelector('#valor-final').value = valor;
}

//pega os valores do filtro e envia requisição GET
function filtrarPorValor() {
    var valor_incial = document.querySelector('#valor-inicial').value;
    var valor_final = document.querySelector('#valor-final').value;
    if (parseFloat(valor_final) > parseFloat(valor_incial)) {
        ajaxTemplate('http://localhost:8000/filtro-por-valor/' + parseFloat(valor_incial) + '/' + parseFloat(valor_final), 'get', { tipo_de_metodo: 'get' }, 'tabelaProdutos')
    } else {
        console.log('erro');
        notificacao('beforebegin', '<span id="msg_erro" style="padding:10px" ><div class="alert alert-danger d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg><div> O valor inicial deve ser maior que o valor final!</div></div></span>', false, 'div-select-valor-aleatorio');
    }
}

//remove mensagem apos usuario digitar no campo
function limpaMensagem(id_erro) {
    var msg_erro_login = document.querySelector('#msg_erro');
    if (msg_erro_login) {
        msg_erro_login.remove();
        document.getElementById(id_erro).style.borderColor = '#ced4da';
    }
}

//cria notifica para o usuario, referente as requisições solicitadas
function notificacao(posica_alert, html_imprimir, id_erro, div_id_aparece_erro) {

    if (posica_alert == 'padrao') {
        posica_alert = 'afterbegin';
    }

    var msg_erro_login = document.querySelector('#msg_erro');
    if (!msg_erro_login) {
        let div = document.querySelector('#' + div_id_aparece_erro);
        div.insertAdjacentHTML(posica_alert, html_imprimir);
        if (id_erro != false) {
            document.getElementById(id_erro).style.borderColor = '#FB0825';
        }
        setTimeout(function () {
            let remove_element = document.querySelector('#msg_erro');
            if (remove_element) {
                remove_element.remove();
            }
            if (id_erro != false) {
                document.getElementById(id_erro).style.borderColor = '#ced4da';
            }
        }, 5000);
    }

}

//formata valor em moeda
function formataValor(i) {
    var v = i.value.replace(/\D/g, '');
    v = (v / 100).toFixed(2) + '';
    v = v.replace(".", ",");
    v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
    v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
    return i.value = v;
}

//abre o modal
function abrirModal() {
    $('#exampleModal').modal('show');
}