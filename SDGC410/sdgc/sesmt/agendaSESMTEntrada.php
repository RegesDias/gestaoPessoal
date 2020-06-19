<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $_SESSION[listaMedicos] = getRest('requerimento/getListarMedicoComVagasAbertas');
?> 
<div class="box box-primary">
  <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-ambulance"></i> Entrada</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body no-padding">
    <!-- /.mail-box-messages -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer no-padding">
    <div class="mailbox-controls">
    </div>
  </div>
</div>

<script>
    window.onload = agendaSESMTEntradaListar('limpar');
</script>