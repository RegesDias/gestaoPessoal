<script type="text/javascript">
    //FUNCOES DE DATA
    function diasNoMes(mes, ano) {
        var data = new Date(ano, mes, 0);
        return data.getDate();
    }
    
    function devolveDiaDaSemana(dia, mes, ano){
        let dataAtual = new Date(ano, mes, dia);
        let numDiaDaSemana = dataAtual.getDay();
        let strDiaDaSemana = '';
        switch(numDiaDaSemana) {
            case 0:
                strDiaDaSemana = 'Domingo';
                break;
            case 1:
                strDiaDaSemana = 'Segunda';
                break;
            case 2:
                strDiaDaSemana = 'Terça';
                break;
            case 3:
                strDiaDaSemana = 'Quarta';
                break;    
            case 4:
                strDiaDaSemana = 'Quinta';
                break;  
            case 5:
                strDiaDaSemana = 'Sexta';
                break; 
            case 6:
                strDiaDaSemana = 'Sábado';
                break;  
            default:
                strDiaDaSemana = '';
        }
        return strDiaDaSemana;
    }
    //FIM FUNCOES DE DATA
    //FIM FUNCOES DE EXIBICAO DE FOLHA  
    
    //Função usada na pagina de Lançamento em Lotes para carregar a lista de servidor por setor
    function setSlcListaServidorPorIdSetor(lista){
            var listaMapeada = lista.map(item => [item.nome, item.idFuncional, item.matricula]);
            let arrayColumn = (arr, n) => arr.map(x => x[n]);
            listaNomeFuncional = arrayColumn(listaMapeada,0);
            listaIdFuncional = arrayColumn(listaMapeada,1);
            listaMatriculaFuncional = arrayColumn(listaMapeada,2);
            document.formTemplate.servidor.options.length = listaNomeFuncional.length;
            for (i=0; i<listaNomeFuncional.length; i++) {
                    document.formTemplate.servidor.options[i] = new Option(listaMatriculaFuncional[i] + ' - ' + listaNomeFuncional[i]);
                    document.formTemplate.servidor.options[i].value=listaIdFuncional[i];
            }
    }
    //Fim função usada na pagina de Lançamento em Lotes para carregar a lista de servidor por setor
    
    // FUNCOES DO MODAL PARA SETAR TEMPLATE E SETOR
    //JQuery para setar o tamanho máximo dos multiselects
    $(document).ready(function () {
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
        if (document.getElementById('identificadorDeNecessidadeDeCarregamentoDasSecretariasEmUmSelect') !== null){
            if (document.getElementById('identificadorDeNecessidadeDeCarregamentoDasSecretariasEmUmSelect') !== null){
                console.log("Aqui 2");
                getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', document.formTemplate.idSecretaria.options[0].value, selectSingleSetorAjax);
            }
        }
        if (document.getElementById('CarregamentoDasSecretariasEmUmSelectOcorrencia') !== null){
            if (document.getElementById('CarregamentoDasSecretariasEmUmSelectOcorrencia') !== null){
                console.log("Aqui 3");           
                getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', document.formTemplate.idSecretaria.options[0].value, selectSingleSetorAjax);
            }
        }
        
    });
    
    function selectTemplateAjax(lista){
           var listaMapeada = lista.map(item => [item.dataHora, item.id, item.login, item.nome]);
           let arrayColumn = (arr, n) => arr.map(x => x[n]);
           listaNomeTemplate = arrayColumn(listaMapeada,3);
           listaIdTemplate = arrayColumn(listaMapeada,1);
           document.formTemplate.idTemplate.options.length = listaNomeTemplate.length;
           document.formTemplate.idTemplate.options[0] = new Option('');
           for (i=0; i<listaNomeTemplate.length; i++) {
                    document.formTemplate.idTemplate.options[i+1] = new Option(listaNomeTemplate[i]);
                    document.formTemplate.idTemplate.options[i+1].value = listaIdTemplate[i];
            }

    }
    
    //funcao usada no filtro de relatorios e no modal
    function selectSecretariasAjax(lista){
        let listaMapeada = lista.map(item => [item.ativo, item.atual, item.controle, item.id, item.max, item.nome]);
        let arrayColumn = (arr, n) => arr.map(x => x[n]);
        let listaNomeSecretaria = [];
        listaNomeSecretaria = arrayColumn(listaMapeada,5);
        let listaIdSecretaria = [];
        listaIdSecretaria = arrayColumn(listaMapeada,3);
        document.formTemplate.idSecretaria.options.length = listaNomeSecretaria.length;
        for (i=0; i<listaNomeSecretaria.length; i++) {
            document.formTemplate.idSecretaria.options[i] = new Option(listaNomeSecretaria[i]);
            document.formTemplate.idSecretaria.options[i].value = listaIdSecretaria[i];
        }
        //Executa se estiver na página de emissão de relatórios de funcionarios por setor
        if (document.getElementById('identificadorDeNecessidadeDeCarregamentoDasSecretariasEmUmSelect') !== null){
            if (document.getElementById('identificadorDeNecessidadeDeCarregamentoDasSecretariasEmUmSelect') !== null){
                console.log("Aqui 2");
                getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', document.formTemplate.idSecretaria.options[0].value, selectSingleSetorAjax);
            }
        }
        if (document.getElementById('CarregamentoDasSecretariasEmUmSelectOcorrencia') !== null){
            if (document.getElementById('CarregamentoDasSecretariasEmUmSelectOcorrencia') !== null){
                console.log("Aqui 3");           
                getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', document.formTemplate.idSecretaria.options[0].value, selectSingleSetorAjax);
            }
        }
    }
    
    //funcao usada no filtro de relatorios e no modal
    function selectMultipleSecretariasAjax(lista){
        let listaMapeada = lista.map(item => [item.ativo, item.atual, item.controle, item.id, item.max, item.nome]);
        let arrayColumn = (arr, n) => arr.map(x => x[n]);
        let listaNomeSecretaria = [];
        listaNomeSecretaria = arrayColumn(listaMapeada,5);
        let listaIdSecretaria = [];
        listaIdSecretaria = arrayColumn(listaMapeada,3);
        document.formTemplate.idSecretaria.options.length = listaNomeSecretaria.length;
        for (i=0; i<listaNomeSecretaria.length; i++) {
            document.formTemplate.idSecretaria.options[i] = new Option(listaNomeSecretaria[i]);
            document.formTemplate.idSecretaria.options[i].value = listaIdSecretaria[i];
        }
        document.formTemplate.idSecretaria.options[i] = new Option('TODAS SECRETARIAS');
        document.formTemplate.idSecretaria.options[i].value = 'todasSecretarias';
        var campoIdSetor = document.getElementById('secretariaID');
        campoIdSetor.setAttribute('name','idSecretaria[]');
    }
    
    //função usada no modalCadUser para carregar todos os setores por secretarias
    //Permitindo a multiseleção das secretarias
    function selectMultipleSetorAjax(lista){
        console.log(lista);
        var listaMapeada = lista.map(item => [item.ativo, item.idSetor, item.nome]);
        console.log(listaMapeada);
        let arrayColumn = (arr, n) => arr.map(x => x[n]);
        listaNomeSetor = arrayColumn(listaMapeada,2);
        listaIdSetor = arrayColumn(listaMapeada,1);
        document.formTemplate.idSetor.options.length = listaNomeSetor.length;
        for (i=0; i<listaNomeSetor.length; i++) {
            document.formTemplate.idSetor.options[i] = new Option(listaNomeSetor[i]);
            document.formTemplate.idSetor.options[i].value = listaIdSetor[i];
        }
        var campoIdSetor = document.getElementById('setorID');
        campoIdSetor.setAttribute('name','idSetor[]');
    }
    
    //função usada no boxSecretariaSetor para carregar todos os setores por secretarias
    //Não permitindo a multiseleção das secretarias
    function selectSingleSetorAjax(lista){
        var listaMapeada = lista.map(item => [item.ativo, item.id, item.nome]);
         let arrayColumn = (arr, n) => arr.map(x => x[n]);
         listaNomeSetor = arrayColumn(listaMapeada,2);
         listaIdSetor = arrayColumn(listaMapeada,1);
         document.formTemplate.idSetor.options.length = listaNomeSetor.length;
         for (i=0; i<listaNomeSetor.length; i++) {
            document.formTemplate.idSetor.options[i] = new Option(listaNomeSetor[i]);
            document.formTemplate.idSetor.options[i].value = listaIdSetor[i];
         } 
         //se estiver na pagina de lançamento em lote:
        if (document.getElementById('identificadorDeNecessidadeDeCarregamentoDeServidores') !== null){      
           let selectSetor = document.getElementById('setorID');      
           getAJAX(<?="'" . $ajurl . "'"; ?>, 'funcionalws/getListaFuncionalPorIdSetor/', selectSetor.value, setSlcListaServidorPorIdSetor);
        }
    }
    
    function selectUsuariosAjax(lista){
        var listaMapeada = lista.map(item => [item.cpf, item.id, item.login, item.nomeCompleto, item.status]);
        let arrayColumn = (arr, n) => arr.map(x => x[n]);
        listaNomeUsuario = arrayColumn(listaMapeada,3);
        listaIdUsuario = arrayColumn(listaMapeada,1);
        document.formTemplate.idUsuario.options.length = listaNomeUsuario.length;
        document.formTemplate.idUsuario.options[0] = new Option(''); 
        for (i=0; i<listaNomeUsuario.length; i++) {
            document.formTemplate.idUsuario.options[i+1] = new Option(listaNomeUsuario[i]);
            document.formTemplate.idUsuario.options[i+1].value = listaIdUsuario[i];
         }
    }
    
    
    function selectListaReferenciaNsd(lista){
        console.log(lista);

        listaReferenciaDistinct = lista;
 
        let mes;
        let ano;
        let selectCompetencia = document.getElementById('idCompetencia'+idModal);
        selectCompetencia.options.length = listaReferenciaDistinct.length;
        for (i=0; i<listaReferenciaDistinct.length; i++) {
            ano = listaReferenciaDistinct[i].split('-')[0];
            mes = listaReferenciaDistinct[i].split('-')[1];
            selectCompetencia.options[i] = new Option(mes+"/"+ano);
            selectCompetencia.options[i].value = listaReferenciaDistinct[i];
         }
        
        //TRATAMENTO DaPARTE VISUAL
        
        //pega elementos
        let figLoader = document.getElementById('idVoltinhaCarregar'+idModal);
        let lblDefinir = document.getElementById('idLblDefinir'+idModal);
        let idDivCompetencia = document.getElementById('idDivCompetencia2'+idModal);
        
        figLoader.classList.add('hide');
        lblDefinir.classList.remove('collapse');
        idDivCompetencia.classList.remove('collapse');
        
    }
    
    var idModal;
    function definirCompetencia(id){
        //pega data inicial
        idModal = id;
        let dataInicio = document.getElementById('idMesAnoInicial'+idModal).value;
        let anoInicio = dataInicio.split('-')[0];
        let mesInicio = dataInicio.split('-')[1];
        //pega data final
        let dataFim = document.getElementById('idMesAnoFinal'+idModal).value;
        let anoFim = dataFim.split('-')[0];
        let mesFim = dataFim.split('-')[1];
        let parametroBusca = mesInicio + '%2F' + anoInicio + '/' + mesFim + '%2F' + anoFim;
        getAJAX(<?="'" . $ajurl . "'"; ?>, 'nsdWs/getListaReferenciaNsd/', parametroBusca, selectListaReferenciaNsd);
        //TRATAMENTO DaPARTE VISUAL
        
        //pega elementos
        let figLoader = document.getElementById('idVoltinhaCarregar'+idModal);
        let lblDefinir = document.getElementById('idLblDefinir'+idModal);
        let idDivCompetencia = document.getElementById('idVoltinhaCarregar'+idModal);
        
        figLoader.classList.remove('hide');
        lblDefinir.classList.add('collapse');

    }

    function atualizarUltimoLoginAjax(obj) {
        let spanUltimoLogin = document.getElementById('txtUltimoLogin');
        
        let data = obj[0].split('T')[0];
        let hora = obj[0].split('T')[1];
        
        let data2 = data.split('-');
        
        let ano = data2[0];
        let mes = data2[1];
        let dia = data2[2];
        
        let datahora = dia+"/"+mes+"/"+ano+" "+hora;
        
        spanUltimoLogin.innerHTML = datahora;
    }
    
 //----------------------------------------------
 //---------------INÍCIO-------------------------
 //----------------------------------------------
    function getAJAX(vgurl, vservico, parametro, callback){
        
        var xhr = new XMLHttpRequest();
        var linkPedido = vgurl + vservico + parametro;
        //console.log("LINK: ");
        //console.log(linkPedido);
        xhr.open('GET', linkPedido, true);
        xhr.timeout = 1000;
        xhr.addEventListener('load', function(){
            var objJSON = JSON.parse(xhr.responseText);
            callback(objJSON);
        });
        xhr.addEventListener('error', function(e){
          console.warn("Houve algum problema com a requisição AJAX.");
        });
        
        //Adicinando Header antes de enviar
        xhr.setRequestHeader('chave', '<?php echo $_SESSION["user"]["chave"]; ?>');
        xhr.setRequestHeader('appv', '<?php echo $gappv; ?>');
        
        xhr.send(null);
        
    }

 //----------------------------------------------
 //---------------FIM AJAX-----------------------
 //----------------------------------------------
 
 //-----------------------------------------------------
 //FUNÇÕES QUE EXECUTAM DEPOIS DO CARRWGAMENTO DA PÁGINA
 //-----------------------------------------------------
 $(document).ready(function () {
        //Executa se estiver na página de emissão de relatórios de funcionarios por setor
        if (document.getElementById('identificadorDeNecessidadeDeCarregamentoDasSecretariasEmUmSelect') !== null){
            //console.log("aqui 0");
            getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoUsuario', '', selectSecretariasAjax);
           
        }
        if (document.getElementById('CarregamentoDasSecretariasEmUmSelectOcorrencia') !== null){
            //console.log("aqui 1");       
            getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoUsuarioOcorrencia', '', selectSecretariasAjax);

        }
        if (document.getElementById('identificadorDeNecessidadeDeCarregamentoDosUsuariosEmUmSelect') !== null){
           getAJAX(<?="'" . $ajurl . "'"; ?>, 'userloginws/getListaUserLogin', '', selectUsuariosAjax);
        }
        if (document.getElementById('identificadorDeNecessidadeDeCarregamentoDoUltimoLogin') !== null){
            var caller = setInterval(function(){
                getAJAX(<?="'" . $ajurl . "'"; ?>, 'userloginws/getDataHoraUltimoLog/', idUsuario, atualizarUltimoLoginAjax);
            },1000);  
        }
        
    });
 //-------------------------------------------------------------
 //FIM DAS FUNÇÕES QUE EXECUTAM DEPOIS DO CARRWGAMENTO DA PÁGINA
 //-------------------------------------------------------------
</script>
