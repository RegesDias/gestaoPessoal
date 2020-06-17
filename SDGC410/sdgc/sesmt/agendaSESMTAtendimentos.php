<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $listaMedicos = getRest('requerimento/getListarMedicoComVagasAbertas');
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?> 
<div class="box box-primary">
  <div class="box-header with-border">
    <div class="col-sm-12">
        <h3 class="box-title"><i class="fa fa-calendar"></i> Agenda</h3>
    </div>
   </div>
    <div class="col-sm-12">
        <div class="col-sm-6">
            <label for="exampleInputEmail1">Intervalo</label>
            <div class="form-group">
                <div class="form-group">
                    <input type='date'  class="form-control" name='mes' id='inicio' style="width: 100%;">
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <input type='date'  class="form-control" name='mes' id='fim' style="width: 100%;">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <label>Médico</label>
            <select id='idMedico' class="form-control select2" style="width: 100%;">
                <option></option>
                <?php foreach ($listaMedicos as $value) {
                    echo "<option value='$value[idRequerimentoMedico]'>$value[nomeMedico]</option>";
                }?>
            </select>
        </div>
    </div>
    <div class="col-sm-12"><br></div>
    <div class="modal-footer">
        <button class="btn btn-info " onclick="agendaSESMTAgendaEditar('Agenda Alterar',$('#inicio').val(),$('#fim').val(),$('#idMedico').val())" type="button">
            <i class="fa fa-folder-open-o"></i> Abrir
        </button>
        <button class="btn btn-primary" onclick="buscaAtendimentos('buscaAtendimento',$('#inicio').val(),$('#fim').val(),$('#idMedico').val())" type="button">
            <i class="fa fa-search"></i> Buscar
        </button>
    </div>
    <!-- /.box-tools -->
  </div>
  <!-- /.box-header -->
  <div id="abrirAgenda">
  </div>
 
<script>
    configuraTela(); 
</script>
<script>
    window.onload = limparResult('limpar');
</script>