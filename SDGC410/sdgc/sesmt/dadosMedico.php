<div class="table-responsive mailbox-messages">
    <div class="box">
        <div class="box-header with-border">
            <div class="user-block">
              <span class="pull-right"><h3><?=$listaFolha[0][CRM]?></h3></span>
              <img class="img-circle" src="<?=exibeFoto($listaFolha[0][cpfMedico])?>" alt="User Image">
              <span class="username"><a href="#"><?=$listaFolha[0][nomeMedico]?></a></span>
              <span class="description">MEDICO ESPECIALISTA</span>
            </div>
        </div>
        <div class="box-header">
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" id="ocultar" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
            <button type="submit" class="btn btn-primary" onclick="conferirAgenda('verCalendario', '<?=substr($listaFolha[0][data], 0, -9)?>', '<?=$listaFolha[0][idMedico]?>')">
                <i class="fa fa-calendar"></i> Ver Agenda
            </button>
            <div class="espaco-esquerda"></div>
            <div id="calendarioMedico">
            </div>
        </div>
    </div>
</div>

<script>
    $("#ocultar").click(function () {
        $("#calendarioMedico").addClass('hidden');
    });
</script>