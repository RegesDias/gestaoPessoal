<script type="text/javascript">
//CAPTURA ELEMENTOS DE TELA
var campoCep = document.querySelector('#idCep');
var campoEstado = document.querySelector('#idEstado');
var campoCidade = document.querySelector('#idCidade');
var campoBairro = document.querySelector('#idBairro');
var campoLogradouro = document.querySelector('#idLogradouro');

//CAPTURA EVENTOS DE TELA
//DIGITACAO CEP
if(existeElementoPorId('idCep')){
    campoCep.addEventListener('keyup', function(el){
        let qtDigitosStart = el.srcElement.selectionStart;
        //SO executa se for digitado o utimo digito do CPF
        if(qtDigitosStart >= 9){
            let cep = el.srcElement.value;
            cep = cep.substring(0,5) + cep.substring(6,9);
            limpaSelect(campoEstado);
            limpaSelect(campoCidade);
            limpaSelect(campoBairro);
            campoLogradouro.value = '';
            getAJAX(<?="'" . $aeurl . "'"; ?>,'logradouro/getListaLogradouroPorCEP/', cep, preencheCamposPorCepAjax);
        }
        //SE FOR MENOR QUE UM, RECARREGA TODOS OS CAMPOS
        if(qtDigitosStart < 1){
           getAJAX(<?="'" . $aeurl . "'"; ?>,'estados/getListaEstadosWs', '', selectEstadoAjax);
           getAJAX(<?="'" . $aeurl . "'"; ?>,'cidades/getListaCidadesPorEstado/', '2', selectCidadeAjax);
           getAJAX(<?="'" . $aeurl . "'"; ?>,'bairros/getListaBairrosPorCidadeWs/', '1096', selectBairroAjax);
           campoLogradouro.value = '';
        }
    });
}

//SELECTAO ESTADO
if(existeElementoPorId('idEstado')){
    $('#idEstado').on('change', function() {
        limpaSelect(campoCidade);
        limpaSelect(campoBairro);
        getAJAX(<?="'" . $aeurl . "'"; ?>,'cidades/getListaCidadesPorEstado/', this.value, selectCidadeAjax);
        
    });
}

//SELECTAO CIDADE
if(existeElementoPorId('idCidade')){
    $('#idCidade').on('change', function() {
        limpaSelect(campoBairro);
        getAJAX(<?="'" . $aeurl . "'"; ?>,'bairros/getListaBairrosPorCidadeWs/', this.value, selectBairroAjax);
    });
}

function preencheCamposPorCepAjax(obj){

    console.log(obj);

    let listaUfEstado = [];
    let listaIdEstado = [];
    let listaNomeCidade = [];
    let listaIdCidade = [];
    let listaNomeBairro = [];
    let listaIdBairro = [];

    listaUfEstado[0] = obj[0].estado;
    listaIdEstado[0] = obj[0].idEstado;
    
    listaNomeCidade[0] = obj[0].cidade;
    listaIdCidade[0] = obj[0].idCidade;
    
    listaNomeBairro[0] = obj[0].bairro;
    listaIdBairro[0] = obj[0].idBairro;
    
    limpaSelect(campoEstado);
    limpaSelect(campoCidade);
    limpaSelect(campoBairro);
    
    preencheSelect(campoEstado, listaUfEstado, listaIdEstado);
    preencheSelect(campoCidade, listaNomeCidade, listaIdCidade);
    preencheSelect(campoBairro, listaNomeBairro, listaIdBairro);
    
    campoLogradouro.value = obj[0].logradouro;

}

function selectEstadoAjax(lista){
    var listaMapeada = lista.map(item => [item.id, item.nome, item.uf]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaUf = arrayColumn(listaMapeada,2);
    listaId = arrayColumn(listaMapeada,0);
    limpaSelect(campoEstado);
    preencheSelect(campoEstado, listaUf, listaId);
    //FAZ O ESTADO DO RIO SER SELECIONADO
    campoEstado.options[1].selected = 'selected';
}

function selectCidadeAjax(lista){
    var listaMapeada = lista.map(item => [item.id, item.nome, item.uf]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNome = arrayColumn(listaMapeada,1);
    listaId = arrayColumn(listaMapeada,0);
    limpaSelect(campoCidade);
    preencheSelect(campoCidade, listaNome, listaId);
    //A CIDADE SER MACAÉ
    campoCidade.options[138].selected = 'selected';
}

function selectBairroAjax(lista){
    var listaMapeada = lista.map(item => [item.id, item.nome]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNome = arrayColumn(listaMapeada,1);
    listaId = arrayColumn(listaMapeada,0);
    limpaSelect(campoBairro);
    preencheSelect(campoBairro, listaNome, listaId);
}


//EXECUTA AO CARREGAR A PAGINA
window.onload = function() {
    if (existeElementoPorId('idEstado')){
        //INICIA CARREGANDO TODOS OS ESTADOS
        getAJAX(<?="'" . $aeurl . "'"; ?>,'estados/getListaEstadosWs', '', selectEstadoAjax);
    }
    if(existeElementoPorId('idCidade')){
        //INICIA CARREGANDO COM TODAS CIDADES DO RJ
        getAJAX(<?="'" . $aeurl . "'"; ?>,'cidades/getListaCidadesPorEstado/', '2', selectCidadeAjax);
    }
    if(existeElementoPorId('idBairro')){
        getAJAX(<?="'" . $aeurl . "'"; ?>,'bairros/getListaBairrosPorCidadeWs/', '1096', selectBairroAjax);
    }
};
</script>
