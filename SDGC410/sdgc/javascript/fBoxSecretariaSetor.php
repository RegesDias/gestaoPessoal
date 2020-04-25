<script type="text/javascript">
//console.log("ChamouFBoxSecretariaSetor");
//funcao usada no filtro de relatorios e no modal
function selectSecretariasAjax(lista){
    let listaMapeada = lista.map(item => [item.ativo, item.atual, item.controle, item.id, item.max, item.nome]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNomeSecretaria = arrayColumn(listaMapeada,5);
    listaIdSecretaria = arrayColumn(listaMapeada,3);
    let selectSecretaria = pegaElementoPorId('secretariaID');
    preencheSelect(selectSecretaria, listaNomeSecretaria, listaIdSecretaria);
    if (existeElementoPorId('carregaLot')){
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', selectSecretaria.options[0].value, selectSingleSetorAjax);
    }
    if (existeElementoPorId('carregaLot-ocorrencia')){         
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', selectSecretaria.options[0].value, selectSingleSetorAjax);
    }
    if (existeElementoPorId('carregaLot-variaveis')){ 
        getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', selectSecretaria.options[0].value, selectSingleSetorAjax);
    
    }
    if (existeElementoPorId('carregaLot-previafalta')){         
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', selectSecretaria.options[0].value, selectSingleSetorAjax);
    }
    //mantem selecionada determinada secretaria
    if(existeElementoPorId('idTituloValidar')){
        selecionaOptionPorValor(selectSecretaria, "<?=$_SESSION[idLotacao]?>");
    }
    if(existeElementoPorId('idTituloCarregarVariaveis')){
        selecionaOptionPorValor(selectSecretaria, "<?=$_SESSION[idLotacao]?>");
    }
}
//funcao usada no filtro de relatorios e no modal
function selectMultipleSecretariasAjax(lista){
    let listaMapeada = lista.map(item => [item.ativo, item.atual, item.controle, item.id, item.max, item.nome]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNomeSecretaria = arrayColumn(listaMapeada,5);
    listaIdSecretaria = arrayColumn(listaMapeada,3);
    listaNomeSecretaria.push('TODAS SECRETARIAS');
    listaIdSecretaria.push('todasSecretarias');
    let selectSecretaria = pegaElementoPorId('secretariaID');
    preencheSelect(selectSecretaria, listaNomeSecretaria, listaIdSecretaria);
    selectSecretaria.setAttribute('name','idSecretaria[]');
}
//função usada no boxSecretariaSetor para carregar todos os setores por secretarias
//Não permitindo a multiseleção das secretarias
function selectSingleSetorAjax(lista){
    var listaMapeada = lista.map(item => [item.ativo, item.id, item.nome]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNomeSetor = arrayColumn(listaMapeada,2);
    listaIdSetor = arrayColumn(listaMapeada,1);
    let selectSetor = pegaElementoPorId('setorID');
    preencheSelect(selectSetor, listaNomeSetor, listaIdSetor);
    if (existeElementoPorId('carregaFuncional')){          
      getAJAX(<?="'" . $ajurl . "'"; ?>, 'funcionalws/getListaFuncionalPorIdSetor/', selectSetor.value, selectServidoresPorSetor);
    }
}
//função usada no modalCadUser para carregar todos os setores por secretarias
//Permitindo a multiseleção das secretarias
function selectMultipleSetorAjax(lista){
    var listaMapeada = lista.map(item => [item.ativo, item.idSetor, item.nome]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNomeSetor = arrayColumn(listaMapeada,2);
    listaIdSetor = arrayColumn(listaMapeada,1);
    let selectSetor = pegaElementoPorId('setorID');
    preencheSelect(selectSetor, listaNomeSetor, listaIdSetor);
    selectSetor.setAttribute('name','idSetor[]');
}
//Função usada na pagina de Lançamento em Lotes para carregar a lista de servidor por setor
function selectServidoresPorSetor(lista){
    var listaMapeada = lista.map(item => [item.nome, item.idFuncional, item.matricula]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    let listaNomeFuncional = arrayColumn(listaMapeada,0);
    let listaIdFuncional = arrayColumn(listaMapeada,1);
    let listaMatriculaFuncional = arrayColumn(listaMapeada,2);
    let selectServidores = pegaElementoPorId('multiselect');
    let listaMatriculaNomeFunciona = listaNomeFuncional.map(function(elem, index){
        return listaMatriculaFuncional[index] + ' - ' + elem;
    });
    preencheSelect(selectServidores, listaMatriculaNomeFunciona, listaIdFuncional);
}
//Fim função usada na pagina de Lançamento em Lotes para carregar a lista de servidor por setor
function selectTemplateAjax(lista){
    var listaMapeada = lista.map(item => [item.dataHora, item.id, item.login, item.nome]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNomeTemplate = arrayColumn(listaMapeada,3);
    listaIdTemplate = arrayColumn(listaMapeada,1);
    let selectTemplate = pegaElementoPorId('templateID');
    preencheSelect(selectTemplate, listaNomeTemplate, listaIdTemplate);
}

function selectUsuariosAjax(lista){
    var listaMapeada = lista.map(item => [item.cpf, item.id, item.login, item.nomeCompleto, item.status]);
    let arrayColumn = (arr, n) => arr.map(x => x[n]);
    listaNomeUsuario = arrayColumn(listaMapeada,3);
    listaIdUsuario = arrayColumn(listaMapeada,1);
    document.formTemplate.idUsuario.options.length = listaNomeUsuario.length;
    document.formTemplate.idUsuario.options[0] = new Option(''); 
    let selectUsuario = pegaElementoPorId('usuarioID');
    preencheSelect(selectUsuario, listaNomeUsuario, listaIdUsuario,1);
}

function atualizarUltimoLoginAjax(obj) {
    let spanUltimoLogin = pegaElementoPorId('txtUltimoLogin');
    let data = obj[0].split('T')[0];
    let hora = obj[0].split('T')[1];
    let data2 = data.split('-');
    let ano = data2[0];
    let mes = data2[1];
    let dia = data2[2];
    let datahora = dia+"/"+mes+"/"+ano+" "+hora;
    spanUltimoLogin.innerHTML = datahora;
}


function carregaBoxSecretariaSetor(){
//Executa para configurar permissões do modal
    if (document.getElementById('appVersaoID') !== null){
       $("#appVersaoID").select2({
            maximumSelectionLength: 1
       });
       $("#templateID").select2({
            maximumSelectionLength: 1
       });
       $("#secretariaID").select2({

       });
       document.formTemplate.idSecretaria.options[i] = new Option("Todas Scretarias");
       document.formTemplate.idSecretaria.options[i].value = "todasSecretarias";
    }
    
    //executa se estiver na tela de relatorios por setor
    //Executa se estiver na página de emissão de relatórios de funcionarios por setor
    if (existeElementoPorId('carregaLot')){
       
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoUsuario', '', selectSecretariasAjax);
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', document.formTemplate.idSecretaria.options[0].value, selectSingleSetorAjax);
    }
    
    if (existeElementoPorId('carregaLot-previafalta')){
       
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoUsuarioPreviaFalta', '', selectSecretariasAjax);
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuarioPreviaFalta/', document.formTemplate.idSecretaria.options[0].value, selectSingleSetorAjax);
    }
    if (existeElementoPorId('carregaLot-ocorrencia')){ 
      
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoUsuarioOcorrencia', '', selectSecretariasAjax);

       //getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', document.formTemplate.idSecretaria.options[0].value, selectSingleSetorAjax);  
    }
    
    if (existeElementoPorId('carregaLot-variaveis')){ 
       
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoUsuarioVariaveis', '', selectSecretariasAjax);
       
       //getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', document.formTemplate.idSecretaria.options[0].value, selectSingleSetorAjax);  
    }
    
    if (existeElementoPorId('carregaLot-variaveis-validar')){ 
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoUsuarioVariaveis', '', selectSecretariasAjax);
       
    }
    if (existeElementoPorId('carregaUsuarios')){
       getAJAX(<?="'" . $ajurl . "'"; ?>, 'userloginws/getListaUserLogin', '', selectUsuariosAjax);
    }
    
    if (existeElementoPorId('carregaUltimoLogin')){
        var caller = setInterval(function(){
            getAJAX(<?="'" . $ajurl . "'"; ?>, 'userloginws/getDataHoraUltimoLog/', idUsuario, atualizarUltimoLoginAjax);
        },1000);  
    }
}


//EXECUTA DEPOIS QUE CARREGA A PAGINA
$(document).ready(function () {
    carregaBoxSecretariaSetor();
});


 //-------------------------------------------------------------
 //FIM DAS FUNÇÕES QUE EXECUTAM DEPOIS DO CARRWGAMENTO DA PÁGINA
 //-------------------------------------------------------------
</script>
