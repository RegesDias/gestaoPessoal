<script>
    var boxSecretaria = document.querySelector('#idBoxSecretaria');
    var boxSetor = document.querySelector('#idBoxSetor');
    var inputSecretaria = document.querySelector('#idInputSecretaria');
    var inputSetor = document.querySelector('#idInputSetor');
    var selectSecretaria = document.querySelector('#idSecretaria');
    var selectSetor = document.querySelector('#idSetor');
    var radioSecretaria = document.querySelector('#idRadioSecretaria');
    var radioSetor = document.querySelector('#idRadioSetor');

    function selectSecretariasAjax(lista) {
        let listaMapeada = lista.map(item => [item.ativo, item.atual, item.controle, item.id, item.max, item.nome]);
        let arrayColumn = (arr, n) => arr.map(x => x[n]);
        listaNomeSecretaria = arrayColumn(listaMapeada, 5);
        listaIdSecretaria = arrayColumn(listaMapeada, 3);
        preencheSelect(selectSecretaria, listaNomeSecretaria, listaIdSecretaria);
        inputSecretaria.value = selectSecretaria.value;

        if (radioSetor.checked) {
            getAJAX(<?= "'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', selectSecretaria.options[0].value, selectSingleSetorAjax);

        }


    }

    function selectSingleSetorAjax(lista) {
        var listaMapeada = lista.map(item => [item.ativo, item.id, item.nome]);
        let arrayColumn = (arr, n) => arr.map(x => x[n]);
        listaNomeSetor = arrayColumn(listaMapeada, 2);
        listaIdSetor = arrayColumn(listaMapeada, 1);
        preencheSelect(selectSetor, listaNomeSetor, listaIdSetor);
        //só preenche setor se nao tiver escondido
        if (radioSetor.checked) {
            inputSetor.value = selectSetor.value;
        }
    }

    $('#idSecretaria').on('change', function () {
        inputSecretaria.value = selectSecretaria.value;
        inputSetor.value = "semSetor";

    });

    //ao mudar setor, altera o input setor
    $('#idSetor').on('change', function () {
        inputSetor.value = selectSetor.value;

    });

    //Exibe ou oculta o select Setor
    $('#idRadioSecretaria').on('ifChecked', function () {
        //esconde o select setor
        boxSetor.classList.add("hidden");
        //faz o input seto ser nulo pra nao mandar nada
        inputSetor.value = "semSetor";
    });

    $('#idRadioSetor').on('ifChecked', function () {
        //mostra o select setor
        boxSetor.classList.remove("hidden");
        //atribui ao input setor o valor selecionado do setor
        inputSetor.value = selectSetor.value;
    });

    //ao carregar pagina
    $(document).ready(function () {
        getAJAX(<?= "'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoUsuario', '', selectSecretariasAjax);
    });
</script>
<!-- ************************************************* -->
<!-- RADIO SECRETARIA SETOR|| MANIPULADOR POR JAVASCRIPT-->
<!-- ************************************************* -->
<div class="box-body " id="idBoxRadio">
    <div class="col-md-12">
        <label>Tipo:</label>
        <div class="form-group">
            <label>
                <input id="idRadioSecretaria" type="radio" name="orby" value ='setor' class="flat-red">
                Secretaria
            </label>
            <label>
                <input id="idRadioSetor" type="radio" name="orby" value ='secretaria' class="flat-red" checked>
                Setor
            </label>
        </div>                        
    </div>
</div>
<!-- ************************* -->
<!-- FIM BOX SECRETARIA SETOR -->
<!-- ************************* -->
<div class="box-body">
    <div class="row">
        <div class="col-md-12" id="idBoxSecretaria">
            <label>Secretaria</label>
            <input type="hidden" id="idInputSecretaria" value="0">
            <select onchange="getAJAX(<?= "'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', this.value, selectSingleSetorAjax)" size="1"  class="form-control select2" id='idSecretaria' style="width: 100%;">

            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="idBoxSetor">
            <label>Setor</label>
            <input type="hidden" id="idInputSetor" value="0">
            <select size="1" class="form-control select2" id="idSetor" style="width: 100%;">
            </select>
        </div>
    </div>
</div>
