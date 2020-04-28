
<script type="text/javascript">
//console.log("Chamou o fLancaVariaveis");
//CAPTURA ELEMENTOS DE TELA
var campoSecretaria = document.querySelector('#idSecretariaVL');
var divSecretaria = document.querySelector('#idDivSecretaria');
var campoSetor = document.querySelector('#idSetorVL');
var campoVariavel = document.querySelector('#idVariaveisDescVL');
var campoQuantidade = document.querySelector('#idQuantidadeVL');
var divQuantidade = document.querySelector('#idDivQuantidadeVL');
var campoValor = document.querySelector('#idValorVL');
var divValor = document.querySelector('#idDivValorVL');
var campoServidores = document.querySelector('#multiselect');
var campoServidoresLancar = document.querySelector('#multiselect_to');
var vetParametrosVariavel = [];

var estaEmLote;

console.log("Está em lote?");
console.log(existeElementoPorId('idEstaEmLote'));

function selectSecretariasAjax(lista){
    let listaMapeada = lista.map(item => [item.ativo, item.atual, item.controle, item.id, item.max, item.nome]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNomeSecretaria = arrayColumn(listaMapeada,5);
    listaIdSecretaria = arrayColumn(listaMapeada,3);
    preencheSelect(campoSecretaria, listaNomeSecretaria, listaIdSecretaria);
    
    if(existeElementoPorId('idEstaEmLote')){
       //Carrega todos os setores que o usuário tem acesso
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuarioVariaveis/', campoSecretaria.options[0].value, selectSetorAjax);
    }else{
       //carrega os setor que o servidor buscado está ativo
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'funcionalws/getListaSetorAtivoPorId/', <?php echo "\"".$_SESSION["funcionalBusca"]['id']."\""; ?>, selectSetorAjax);
    }
}

function selectSetorAjax(lista){
    if(existeElementoPorId('idEstaEmLote')){
        var listaMapeada = lista.map(item => [item.ativo, item.id, item.nome]);
    }else{
        var listaMapeada = lista.map(item => [item.nome, item.idSetor, item.nome]);
    }

    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNomeSetor = arrayColumn(listaMapeada,2);
    listaIdSetor = arrayColumn(listaMapeada,1);
    
    //console.log(listaIdSetor);
    
    preencheSelect(campoSetor, listaNomeSetor, listaIdSetor);
    
    if(existeElementoPorId('idEstaEmLote')){
        //Carrega o nome de todos os servidores do setor no lançamento em lote
        getAJAX(<?="'" . $ajurl . "'"; ?>, 'variaveis/getListaVariaveisDescAbertasPorSetor/', campoSetor.options[0].value, selectVariaveisDesc);
    }else{
        getAJAX(<?="'" . $ajurl . "'"; ?>, 'variaveis/getListaVariaveisSetorHistFunc/', campoSetor.value + "/<?=$_SESSION["funcionalBusca"]['id']?>", selectVariaveisDesc);
    }
    
    
}

function selectServidoresPorSetor(lista){
    console.log(lista);
    var listaMapeada = lista.map(item => [item.nome, item.idFuncional, item.matricula]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    let listaNomeFuncional = arrayColumn(listaMapeada,0);
    let listaIdFuncional = arrayColumn(listaMapeada,1);
    let listaMatriculaFuncional = arrayColumn(listaMapeada,2);
    let listaMatriculaNomeFunciona = listaNomeFuncional.map(function(elem, index){
        return listaMatriculaFuncional[index] + ' - ' + elem;
    });
    preencheSelect(campoServidores, listaMatriculaNomeFunciona, listaIdFuncional);
}

function selectVariaveisDesc(lista){
    var listaMapeada = lista.map(item => [item.id, item.nome, item.maximo, item.minimo, item.valor, item.quantidade, item.padrao]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    let listaId = arrayColumn(listaMapeada,0);
    let listaNome = arrayColumn(listaMapeada,1);
    campoVariavel.options.length = listaId.length;
    campoVariavel.options[0] = new Option('Selecione uma variável');
    preencheSelect(campoVariavel, listaNome, listaId, 1);
    //guarda os parametros para manipular os campos valor ou quantidade
    let listaMaximo = arrayColumn(listaMapeada,2);
    let listaMinimo = arrayColumn(listaMapeada,3);
    let listaValor = arrayColumn(listaMapeada,4);
    let listaQuantidade = arrayColumn(listaMapeada,5);
    let listaPadrao = arrayColumn(listaMapeada,6);
    for (i = 0; i < listaId.length; i++) {
        let parametrosVariavel = {
            id: listaId[i],
            maximo: listaMaximo[i],
            minimo: listaMinimo[i],
            valor: listaValor[i],
            quantidade: listaQuantidade[i],
            padrao: listaPadrao[i]
                };
        vetParametrosVariavel[i] = parametrosVariavel;
    }
}

//EXECUTA AO OCORRER MUDANÇAS
////Se mudar a secretaria
$('#idSecretariaVL').on('change', function() {
    limpaSelect(campoVariavel);
    limpaSelect(campoServidores);
    limpaSelect(campoServidoresLancar);
    getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuarioVariaveis/', campoSecretaria.value, selectSetorAjax);
});

////Se mudar a setor
$('#idSetorVL').on('change', function() {
    limpaSelect(campoVariavel);
    if(existeElementoPorId('idEstaEmLote')){
        limpaSelect(campoServidores);
        limpaSelect(campoServidoresLancar);
    }
    if(existeElementoPorId('idEstaEmLote')){
        //carrega todos os servidores de um determinado setor no lançamento em lote
        getAJAX(<?="'" . $ajurl . "'"; ?>, 'variaveis/getListaVariaveisDescAbertasPorSetor/', campoSetor.value, selectVariaveisDesc);
    }else{
        getAJAX(<?="'" . $ajurl . "'"; ?>, 'variaveis/getListaVariaveisSetorHistFunc/', campoSetor.value + "/<?=$_SESSION["funcionalBusca"]['id']?>", selectVariaveisDesc);
    }
    
});

////Se mudar a variavel, manipula a tela
$('#idVariaveisDescVL').on('change', function() {
    divValor.classList.add("hidden");
    divQuantidade.classList.add("hidden");
    
    let parametrosVariavelSelecionada = vetParametrosVariavel.find( obj => obj.id == campoVariavel.value );
    
    //Se a variavelDesc nao tiver padra, mostra o campo quantidade ou valor, caso contrário, nao mostra nada
    if(!parametrosVariavelSelecionada['padrao']){
        //se exite valor, exibe o campo valor
        if(parametrosVariavelSelecionada['valor']){
            divValor.classList.remove("hidden");
            campoValor.min = parametrosVariavelSelecionada['minimo'];
            campoValor.max = parametrosVariavelSelecionada['maximo'];
            let placeh = parametrosVariavelSelecionada['minimo'] + " à " + parametrosVariavelSelecionada['maximo'];
            campoValor.placeholder = placeh;
        }

        //se exite quantidade, exibe o campo quantidade
        if(parametrosVariavelSelecionada['quantidade']){
           divQuantidade.classList.remove("hidden");
           campoQuantidade.min = parametrosVariavelSelecionada['minimo'];
           campoQuantidade.max = parametrosVariavelSelecionada['maximo'];
           let placeh = parametrosVariavelSelecionada['minimo'] + " à " + parametrosVariavelSelecionada['maximo'];
           campoQuantidade.placeholder = placeh;
        }
    }
        
    
    if(existeElementoPorId('idEstaEmLote')){
        limpaSelect(campoServidores);
        limpaSelect(campoServidoresLancar);
        getAJAX(<?="'" . $ajurl . "'"; ?>, 'variaveis/getListaFuncionalVariaveisSetor/', campoSetor.value + "/" + campoVariavel.value, selectServidoresPorSetor);
    }
    
    
});

function carregaLancaVariaveis(){
//console.log(campoSetor);
    if (existeElementoPorId('idSecretariaVL')){
        //Inicia carregando as secretarias que o usuario tem acesso
        getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoUsuarioVariaveis', '', selectSecretariasAjax);
    }
    
    if (!existeElementoPorId('idEstaEmLote')){
        divSecretaria.classList.add("hidden");
    }
    
    $('#idValorVL').mask('#.##0,00', {reverse: true});

}

//EXECUTA AO CARREGAR A PAGINA
$(document).ready(function(){
    carregaLancaVariaveis();    
});

</script>
