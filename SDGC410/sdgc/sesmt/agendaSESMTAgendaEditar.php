<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    if($respGet[acao] == 'AbrirAgenda'){
        $statusAlterar = array('dataInicio' => $respGet[inicio],'dataFim' => $respGet[fim],'idRequerimentoMedico' => $respGet[idMedico], 'periodo' => $respGet[periodo]);
        $sa = array($statusAlterar);
        $executar = postRest('requerimento/postAbrirAgenda',$sa);
        $msnTexto = "ao abrir agenda. ".$executar['msn'];
    }
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <div class="tab-pane active" id="abrirAgenda">
           <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-calendar"></i> Agenda Abrir </h3>
           </div>
           <div class="box-body">
               <label for="exampleInputEmail1">Período</label>
                   <select name="select" class="form-control select2" id="periodo">
                     <option value=""></option>
                     <option value="manha">Manhã</option> 
                     <option value="tarde">Tarde</option>
                   </select>
           </div>
           <div class="box-footer">
               <button type="submit" class="pull-right btn btn-primary" onclick="conferirAgendaAbrir('CarregarCalendario', '<?=$respGet[inicio]?>','<?=$respGet[fim]?>','<?=$respGet[idMedico]?>',$('#periodo').val())">
                   <i class="fa fa-envelope-o"></i> Verificar
               </button>
           </div>
           <div id="calendarioMedico">
           </div>
       </div>
    </div>          
</div>
<script>
    configuraTela(); 
</script>

