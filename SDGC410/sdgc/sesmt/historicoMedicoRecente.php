<?php
    $histR = array($respGet[cpf]);
    $listaHist = getRest('requerimento/getListaRequerimentoPorFuncionalTodos',$histR);
?>
<h3>Histórico Médico Recente</h3>
<div class="box-footer box-comments">
      <?php foreach ($listaHist as $value) {
          print_p($value);
          $ArrEsp = $value[id];
          ?>
        <div class="box-comment">
            <div class="comment-text">
                  <span class="username">
                    <?=$value[id]." - ".$value[solicitacao]?>
                    <span class="text-muted pull-right btn-success"><?=$value[status]?></span>
                  </span><!-- /.username -->
                  <b>Protocolo:</b> <?=$value[protocolo]?>
            </div>
            <div class="modal-footer">
                <?php if($value[idStatus] == 4){?>
                    <button class="btn btn-danger" onclick="alterarStatusRequerimento('alterarStatusRequerimento',<?=$value[id]?>,'<?=$respGet[cpf]?>','99')" >
                       <i class="fa fa-calendar-times-o"></i> Cancelar
                   </button>
                    <button class="btn btn-warning" onclick="alterarStatusRequerimento('alterarStatusRequerimento',<?=$value[id]?>,'<?=$respGet[cpf]?>','97')">
                       <i class="fa fa-calendar-times-o"></i> Não compareceu
                   </button>
                    <button class="btn btn-success" onclick="agendaSESMTAtendimentosFichaMedica('Agenda Alterar','<?=$value[id]?>','<?=$respGet[cpf]?>')" >
                        <i class="fa fa-stethoscope"></i> Ficha Médica
                    </button>
                <?php }?>
                <?php if($value[reAgenda] == true){?>
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#agenda<?=$ArrEsp?>" >
                        <i class="fa fa-calendar-check-o"></i> Agendar
                    </button>
                <?php }?>
            </div>
          </div>
        <?php require '../sesmt/modalAgendar.php'; ?>
      <?php }?>
</div>