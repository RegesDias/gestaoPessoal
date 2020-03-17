<script type="text/javascript">
//CAPTURA ELEMENTOS DE TELA

    var selectLotSubAvaliacao = document.querySelector('#idLotSubAvaliacao');
    var btnAvaliar = document.querySelector('#idBtnAvaliar');
    var btnImprimir = document.querySelector('#idBtnImprimir');
    var btnAnular = document.querySelector('#idBtnAnular');
    var labelNota = document.querySelector('#idLabelNota');
    var inputIdNota = document.querySelector('#idInputIdNota');
    

    function marcaRadios(lista, apaga) {

        var parametrosNota = [
            'Adaptacao',
            'Comprometimento',
            'Conhecimento',
            'Iniciativa',
            'Qualidade',
            'Relacionamentos',
            'Resolucao',
            'Responsabilidade'
        ];

        var camposNota = [
            'adaptacao',
            'comprometimento',
            'conhecimento',
            'iniciativa',
            'qualidade',
            'relacionamentos',
            'resolucao',
            'responsabilidade'
        ];

        for (i = 0; i < parametrosNota.length; i++) {
            for (j = 1; j < 6; j++) {
                strIdElem = "id" + parametrosNota[i] + j;
                idElem = '#' + strIdElem;
                let objRadio = document.querySelector(idElem);
                if(!apaga){
                  if (lista[0][camposNota[i]] === j) {
                        objRadio.checked = true;
                    } else {
                        objRadio.checked = false;
                    }  
                  objRadio.disabled = true;
                }else{
                    objRadio.checked = false;
                    objRadio.disabled = false;
                }
                    
            }
        }
    }

    function recebeAvaliacoes(lista) {
        nota = lista[0]['nota'];

        btnAvaliar.classList.add("hidden");
        btnImprimir.classList.add("hidden");
        btnAnular.classList.add("hidden");
        
        

        //Verifica se o cara tem ou nao avaliacao
        if (nota < 0) {
            inputIdNota.value = "0";
            
            btnAvaliar.classList.remove("hidden");
            
            
            labelNota.innerHTML = "(Não avaliado)";
            marcaRadios(lista,true);//apaga tudo
        } else {
            //atribui o id nota no input
            inputIdNota.value = lista[0]['id'];
            
            btnImprimir.classList.remove("hidden");
            btnAnular.classList.remove("hidden");
            
            labelNota.innerHTML = nota;
            marcaRadios(lista,false);//marca de acordo com as notas
        }
    }


    //Se mudar a setor
    $('#idLotSubAvaliacao').on('change', function () {
        let idHistFunc = "<?= $_SESSION[funcionalBusca][id] ?>";
        let idLotSub = selectLotSubAvaliacao.value;
        let argumentos = idHistFunc + "/" + idLotSub;
        getAJAX(<?= "'" . $ajurl . "'"; ?>, 'avaliacao/getAvaliacaoIdhistFuncPeriodo/', argumentos, recebeAvaliacoes);
    });
    
    function carregaAvaliacao(){
        //if (existeElementoPorId('idLotSubAvaliacao')) {
        let idHistFunc = "<?= $_SESSION[funcionalBusca][id] ?>";
        
        let idLotSub = selectLotSubAvaliacao.options[0].value;
        let argumentos = idHistFunc + "/" + idLotSub;

        getAJAX(<?= "'" . $ajurl . "'"; ?>, 'avaliacao/getAvaliacaoIdhistFuncPeriodo/', argumentos, recebeAvaliacoes);
        //}
    }


    //EXECUTA AO CARREGAR A PAGINA
    $(document).ready(function () {
        carregaAvaliacao();
    });
</script>