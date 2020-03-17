<script type="text/javascript">
//Pega Objetos em Tela
    var selectSecretaria = document.querySelector('#idSecretaria');
    var selectSetor = document.querySelector('#idSetor');
    var radioSecretaria = document.querySelector('#idRadioSecretaria');
    var radioSetor = document.querySelector('#idRadioSetor');
    var boxRadio = document.querySelector('#idBoxRadio');
    var boxSelectSecretaria = document.querySelector('#idBoxSelectSecretaria');
    var boxSelectSetor = document.querySelector('#idBoxSelectSetor');
    var boxRadioOrdenar = document.querySelector('#idBoxRadioOrdenar');
    var boxradioFiltrar = document.querySelector('#idBoxRadioFiltrar');
    var spinLoader = document.querySelector('#idSpinLoaderRelat');
    var inputIdSetor = document.querySelector('#idInputIdSetor');

//Outras variaveis globais
    var menuN3 = "<?= $_SESSION["relatorio"]['menuN3'] ?>";
    var menuN4 = "<?= $_SESSION["relatorio"]['menuN4'] ?>";

//console.log("ChamouFBoxSecretariaSetor");
//funcao usada no filtro de relatorios e no modal
    function selectSecretariasAjax(lista) {
        let listaMapeada = lista.map(item => [item.ativo, item.atual, item.controle, item.id, item.max, item.nome]);
        let arrayColumn = (arr, n) => arr.map(x => x[n]);
        listaNomeSecretaria = arrayColumn(listaMapeada, 5);
        listaIdSecretaria = arrayColumn(listaMapeada, 3);
        preencheSelect(selectSecretaria, listaNomeSecretaria, listaIdSecretaria);
        let parametros = menuN3 + "/" + selectSecretaria.options[0].value;
        spinLoader.classList.add("hidden");
        if (radioSetor.checked) {
            spinLoader.classList.remove("hidden");
            getAJAX(<?= "'" . $ajurl . "'"; ?>, 'userMenu/getAcessoRelatorio/', parametros, selectSetorAjax);
        }
        
    }

//função usada no boxSecretariaSetor para carregar todos os setores por secretarias
//Não permitindo a multiseleção das secretarias
    function selectSetorAjax(lista) {
        var listaMapeada = lista.map(item => [item.ativo, item.id, item.nome]);
        let arrayColumn = (arr, n) => arr.map(x => x[n]);
        listaNomeSetor = arrayColumn(listaMapeada, 2);
        listaIdSetor = arrayColumn(listaMapeada, 1);
        preencheSelect(selectSetor, listaNomeSetor, listaIdSetor);
        if(radioSetor.checked){
            inputIdSetor.value = selectSetor.value;
        }
        spinLoader.classList.add("hidden");
    }

//Oculta ou nao os radiobutons.
    function exibeRadioButons(lista) {
        //console.log(lista);
        if (lista.length > 1) {
            boxRadio.classList.remove("hidden");
            //selectSetor.name = "idSetor";
        } else {
            boxRadio.classList.add("hidden");
            //selectSetor.name = "";
        }
        spinLoader.classList.add("hidden");
    }

//Exibe elementos (radio) (secretaria) (setor)
    function exibeElementos() {
        //verificacao do nivel de acesso se é por secretaria ou setor
        boxRadio.classList.add("hidden");
        boxSelectSecretaria.classList.add("hidden");
        boxSelectSetor.classList.add("hidden");
        boxRadioOrdenar.classList.add("hidden");
        boxradioFiltrar.classList.add("hidden");
        
        //Verifica os itens a serem exibidos em tela
        
        let niveis = menuN4.split("-");
        
        if(niveis.find(elemento => elemento === 'radio')){
            spinLoader.classList.remove("hidden");
            getAJAX(<?= "'" . $ajurl . "'"; ?>, 'userMenu/getAcessoRelatoriosUnificados/', menuN3, exibeRadioButons);
        }
        
        if(niveis.find(elemento => elemento === 'secretaria')){
            boxSelectSecretaria.classList.remove("hidden");
        }
        
        if(niveis.find(elemento => elemento === 'setor')){
            
            boxSelectSetor.classList.remove("hidden");
        }
        
        if(niveis.find(elemento => elemento === 'ordenar')){
            boxRadioOrdenar.classList.remove("hidden");
        }
        
        if(niveis.find(elemento => elemento === 'filtro')){
            boxradioFiltrar.classList.remove("hidden");
        }
        
        //console.log(niveis);
    }

//EXECUTA AO OCORRER MUDANÇAS
////Se mudar a secretaria
    $('#idSecretaria').on('change', function () {
        limpaSelect(selectSetor);
        parametros = menuN3 + "/" + selectSecretaria.value;
        
        getAJAX(<?= "'" . $ajurl . "'"; ?>, 'userMenu/getAcessoRelatorio/', parametros, selectSetorAjax);
        
    });
    
    $('#idSetor').on('change', function () {
        inputIdSetor.value = selectSetor.value;
    });

//Exibe ou oculta o select Setor
    $('#idRadioSecretaria').on('ifChecked', function () {
        boxSelectSetor.classList.add("hidden");
        inputIdSetor.value = "semSetor";
    });

    $('#idRadioSetor').on('ifChecked', function () {
        boxSelectSetor.classList.remove("hidden");
        inputIdSetor.value = selectSetor.value;
    });
    
    function carregaRelat(){

        spinLoader.classList.remove("hidden");

        getAJAX(<?= "'" . $ajurl . "'"; ?>, 'userMenu/getAcessoRelatorio/', menuN3, selectSecretariasAjax);
        //exibe eleemtos em funcao do menuN4
        exibeElementos();
    }


//EXECUTA DEPOIS QUE CARREGA A PAGINA
    $(document).ready(function () {
        carregaRelat();
    });
    //-------------------------------------------------------------
    //FIM DAS FUNÇÕES QUE EXECUTAM DEPOIS DO CARRWGAMENTO DA PÁGINA
    //-------------------------------------------------------------
    
</script>
