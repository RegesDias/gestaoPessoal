<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <label>Secretaria</label>
            <select onchange="getAJAX(<?= "'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', this.value, selectSingleSetorAjax)" name="idSecretaria" size="1"  class="form-control select2" id='secretariaID' style="width: 100%;">

            </select>
        </div>
    </div>
    <div class="row">
        <div id="identificadorDeNecessidadeDeCarregamentoDosSetoresTendoAsSecretariasEmUmSelect">
            <div class="col-md-12">
                <label>Setor</label>
                <select name="idSetor" size="1" class="form-control select2" id="setorID" style="width: 100%;">
                </select>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../javascript/fBoxSecretariaSetor.php';
?>
<script>
carregaBoxSecretariaSetor();
</script>
