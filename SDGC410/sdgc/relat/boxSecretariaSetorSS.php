<!-- ************************************************* -->
<!-- RADIO SECRETARIA SETOR|| MANIPULADOR POR JAVASCRIPT-->
<!-- ************************************************* -->

<div class="box-body " id="idBoxRadio">
    <div class="col-md-12">
        <label>Tipo:</label>
        <div class="form-group">
            <label>
                <input id="idRadioSecretariaFOn" type="radio" name="orby" value ='setor' class="flat-red">
                Secretaria
            </label>
            <label>
                <input id="idRadioSetorFOn" type="radio" name="orby" value ='secretaria' class="flat-red" checked>
                Setor
            </label>
        </div>                        
    </div>
</div>
<script>
    var boxSelectSecretaria = document.querySelector('#idBoxSecretaria');
    var boxSelectSetor = document.querySelector('#idBoxSetor');
    var inputSecretaria = document.querySelector('#idInputIdSecretaria');
    var inputSetor = document.querySelector('#idInputIdSetor');
    var selectSecretaria = document.querySelector('#secretariaID');
    var selectSetor = document.querySelector('#setorID');
    
    //ao carregar pagina
    $(document).ready(function () {
        
        inputSecretaria.value = selectSecretaria.value;
        inputSetor.value = selectSetor.value;
    });
    
    $('#secretariaID').on('change', function () {
       inputSecretaria.value = selectSecretaria.value;
    });
   
    //ao mudar setor, altera o input setor
    $('#setorID').on('change', function () {
        inputSetor.value = selectSetor.value;
    });
    //Exibe ou oculta o select Setor
    $('#idRadioSecretariaFOn').on('ifChecked', function () {
        boxSelectSetor.classList.add("hidden");
        inputSecretaria.value = "semSetor";
    });

    $('#idRadioSetorFOn').on('ifChecked', function () {
        boxSelectSetor.classList.remove("hidden");
        inputSetor.value = selectSetor.value;
    });
</script>
<!-- ************************* -->
<!-- FIM BOX SECRETARIA SETOR -->
<!-- ************************* -->
<div class="box-body">
    <div class="row">
        
        <div class="col-md-12" id="idBoxSecretaria">
            <label>Secretaria</label>
            <input type="hidden" id="idInputIdSecretaria" value="0">
            <select onchange="getAJAX(<?= "'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', this.value, selectSingleSetorAjax)" name="idSecretaria" size="1"  class="form-control select2" id='secretariaID' style="width: 100%;">

            </select>
        </div>
    </div>
    <div class="row">
            <div class="col-md-12" id="idBoxSetor">
                <label>Setor</label>
                <input type="hidden" id="idInputIdSetor" value="0">
                <select name="idSetor" size="1" class="form-control select2" id="setorID" style="width: 100%;">
                </select>
            </div>
    </div>
</div>
<?php
require_once '../javascript/fBoxSecretariaSetor.php';
?>
<script>
    carregaBoxSecretariaSetor();
</script>
