<?php
    $histR = array($respGet[cpf]);
    $listaHist = getRest('requerimento/getListaRequerimentoPorFuncionalTodos',$histR);
?>
<h3>Histórico Médico Recente</h3>
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
                <?php if($value[idStatus] > 3){?>
                    <button <?=$btnStatus?> class="btn btn-small" data-toggle="modal" data-target="#alterarStatus<?=$ArrEsp?>" >
                        <i class="fa fa-thumbs-o-down"></i>
                    </button>

                <?php }?>
                   <button class="btn btn-success" onclick="buscaAtendimentos('buscaAtendimento','<?=$dataAgenda?>','<?=$dataAgenda?>','<?=$dataNew[0][idMedico]?>')" type="button">
                        <i class="fa fa-stethoscope"></i>
                    </button>
                <?php if($value[reAgenda] == true){?>
                    <button class="btn btn-info btn-small" title="Agendar" data-toggle="modal" data-target="#agenda<?=$ArrEsp?>" >
                        <i class="fa fa-calendar-check-o"></i>
                    </button>
                <?php }?>
                    <button class="btn btn-danger btn-small" title="Cancelar" onclick="alterarStatusRequerimento('alterarStatusRequerimento',<?=$value[id]?>,'<?=$respGet[cpf]?>','99')" >
                       <i class="fa fa-times"></i>
                   </button>

            </div>
          </div>
            <div class="modal fade" id="alterarStatus<?=$ArrEsp?>" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="col-sm-12">
                                <label>Ações</label>
                                <select name="idStatus" size="1"  class="form-control select2" id='idStatus' style="width: 100%;">
                                    <option></option>
                                    <option value="97">Paciente não compareceu</option> 
                                    <option value="95">Médico Indisponivel</option>
                                </select>
                            </div>
                            <div class="col-sm-12"><br></div>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-primary" onclick="alterarStatusRequerimento('alterarStatusRequerimento','<?=$value[id]?>','<?=$respGet[cpf]?>',$('#idStatus').val())" type="button">
                                Confirmar
                            </button>
                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php require '../sesmt/modalAgendar.php'; ?>
      <?php }?>