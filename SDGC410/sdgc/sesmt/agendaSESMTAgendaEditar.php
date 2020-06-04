<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    if($respGet[acao] == 'AbrirAgenda'){
        $statusAlterar = array('dataInicio' => $respGet[inicio],'dataFim' => $respGet[fim],'idRequerimentoMedico' => $respGet[idMedico], 'periodo' => $respGet[periodo]);
        $sa = array($statusAlterar);
        $executar = postRest('requerimento/postAbrirAgenda',$sa);
        print_p($executar);
    }
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
    $listaMedico = getRest('requerimento/getListarRequerimentoMedicoAtivos');
?>
 <div class="tab-pane active" id="abrirAgenda">
    <div class="box-header with-border">
        <h3 class="box-title">Abrir Agenda</h3>
    </div>
    <div class="box-body">
        <label for="exampleInputEmail1">Médico</label>
        <select id='idMedico' class="form-control select2" style="width: 100%;">
            <option></option>
            <?php foreach ($listaMedico as $value) {
                echo "<option value='$value[idRequerimentoMedico]'>$value[nomeMedico]</option>";
            }?>
        </select>
        <label for="exampleInputEmail1">Período</label>
            <select name="select" class="form-control select2" id="periodo">
              <option value=""></option>
              <option value="manha">Manhã</option> 
              <option value="tarde">Tarde</option>
            </select>
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
    <div class="box-footer">
        <button type="submit" id='enviarChamado' class="pull-right btn btn-primary" onclick="agendaSESMTAgendaSalvar('AbrirAgenda', $('#inicio').val(), $('#fim').val(), $('#idMedico').val(),$('#periodo').val())">
            <i class="fa fa-envelope-o"></i> Liberar
        </button>
        <button type="reset" class="btn btn-default" onclick="agendaSESMTAgendaEditar('limpar')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
</div>
<script>
    configuraTela(); 
</script>

