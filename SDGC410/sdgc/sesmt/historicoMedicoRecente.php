<?php
    $histR = array($respGet[cpf]);
    $listaHist = getRest('requerimento/getListaRequerimentoPorFuncionalTodos',$histR);
?>
<h3>Histórico Médico Recente</h3>
<div class="box-footer box-comments">
      <?php foreach ($listaHist as $value) {
          $ArrEsp = $value[id];
          $value['protocolo'] = protocolo($value['protocolo']);
            $toDay = date("Y-m-d");
            $d = array('idRequerimentoFuncional' => $value[idRequerimentoFuncional]);
            $dataNew = getRest('requerimento/getFolhaPorIdReqFunc',$d);
            //data
            $dataAgenda = $dataNew[0][data];
            $dataAgenda = substr($dataAgenda, 0, -6);
            //nome Médico
            $nomeMedico = $dataNew[0][nomeMedico]; 

          ?>
        <div class="box-comment">
            <div class="comment-text">
                  <span class="username">
                    <?=$value[id]." - ".$value[solicitacao]?>
                    <span class="text-muted pull-right label label-primary"><i class="fa fa-hourglass-2"></i> <?=$value[status]?></span>
                    
                  </span><!-- /.username -->
                  <b>Protocolo:</b> <?=$value[protocolo]?><br>
                  <b>Médico:</b> <?=$nomeMedico?><br>
                  <b>Agendado Para:</b> <?=databr($dataAgenda)?>
            </div>
            <div class="modal-footer">
                <?php if($value[idStatus] == 4){?>

               <?php if($toDay <= $dataAgenda){ ?>
                    <button class="btn btn-success" onclick="agendaSESMTAtendimentosFichaMedica('Agenda Alterar','<?=$value[id]?>','<?=$respGet[cpf]?>')" >
                        <i class="fa fa-stethoscope"></i> Ficha Médica
                    </button><?php 
                    }
                }?>
                <?php if($value[reAgenda] == true){?>
                    <button class="btn btn-info btn-sm" title="Agendar" data-toggle="modal" data-target="#agenda<?=$ArrEsp?>" >
                        <i class="fa fa-calendar-check-o"></i>
                    </button>
                <?php }?>
                <?php if($value[idStatus] > 3){?>
                    <button class="btn btn-info btn-sm" title="Paciente não compareceu" onclick="alterarStatusRequerimento('alterarStatusRequerimento',<?=$value[id]?>,'<?=$respGet[cpf]?>','97')">
                       <i class="fa fa-user-times"></i> 
                   </button>
                    <button class="btn btn-info btn-sm" title="Médico Indisponível" onclick="alterarStatusRequerimento('alterarStatusRequerimento',<?=$value[id]?>,'<?=$respGet[cpf]?>','95')">
                       <i class="fa  fa-user-md"></i>
                   </button>
                <?php }?>
                    <button class="btn btn-danger btn-sm" title="Cancelar" onclick="alterarStatusRequerimento('alterarStatusRequerimento',<?=$value[id]?>,'<?=$respGet[cpf]?>','99')" >
                       <i class="fa fa-times"></i>
                   </button>
            </div>
          </div>
        <?php require '../sesmt/modalAgendar.php'; ?>
      <?php }?>
</div>