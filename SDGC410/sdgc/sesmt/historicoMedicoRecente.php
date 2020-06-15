<?php
    $histR = array($respGet[cpf]);
    $listaHist = getRest('requerimento/getListaRequerimentoPorFuncionalTodos',$histR);
?>
<div class="box box-info">
   <div class="box-header with-border">
        <h3 class="box-title">Histórico Médico Recente</h3>
        <div class="box-tools pull-right">
        </div>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
            <thead>
                <tr>
                    <th>Protocolo</th>
                    <th>Item</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
                <tbody><?php 
                    foreach ($listaHist as $value) {
                        $ArrEsp = $value[id];
                        $value['protocolo'] = protocolo($value['protocolo']);
                        $toDay = date("Y-m-d");
                        $d = array('idRequerimentoFuncional' => $value[idRequerimentoFuncional]);
                        $dataNew = getRest('requerimento/getFolhaPorIdReqFunc',$d);
                        //data
                        $dataAgenda = $dataNew[0][data];
                        $dataAgenda = substr($dataAgenda, 0, -6);
                        $agendaBr = dataBr($dataAgenda);
                        //nome Médico
                        $nomeMedico = $dataNew[0][nomeMedico]; 
                        
                        
                        ?>
                        <tr>
                            <td><?=$value[protocolo]?></td>
                            <td><a title='<?="$nomeMedico Atendimento em $agendaBr"?>' href="#"><?=$value[solicitacao]?></a></td>
                            <td><span class="label label-primary"><?=$value[status]?></span></td>
                            <td>
                                <div  class="pull-right">
                                    <?php 
                                    if(($value[idStatus] == 4) AND ($toDay <= $dataAgenda)){?>
                                        <button class="btn btn-primary" title="Atendimento" onclick="agendaSESMTAtendimentosFichaMedica('Agenda Alterar','<?=$value[id]?>','<?=$respGet[cpf]?>')" >
                                            <i class="fa fa-heartbeat"></i>
                                        </button><?php 
                                    } 
                                    if($value[idStatus] > 3){
                                        if($value[idStatus] < 90){?>
                                            <button <?=$btnStatus?> class="btn btn-small" title="Consulta não realizada" data-toggle="modal" data-target="#alterarStatus<?=$ArrEsp?>" >
                                                <i class="fa fa-thumbs-o-down"></i>
                                            </button><?php
                                        } ?>
                                       <button class="btn btn-success" title="Médico" onclick="buscaAtendimentos('buscaAtendimento','<?=$dataAgenda?>','<?=$dataAgenda?>','<?=$dataNew[0][idMedico]?>')" type="button">
                                            <i class="fa fa-stethoscope"></i>
                                        </button><?php    
                                    }
                                    if($value[reAgenda] == true){?>
                                        <button class="btn btn-info btn-small" title="Agendar" data-toggle="modal" data-target="#agenda<?=$ArrEsp?>" >
                                            <i class="fa fa-calendar-check-o"></i>
                                        </button><?php 
                                    }
                                    if($value[idStatus] < 90){?>
                                        <button class="btn btn-danger btn-small" title="Cancelar" onclick="alterarStatusRequerimento('alterarStatusRequerimento',<?=$value[id]?>,'<?=$respGet[cpf]?>','99')" >
                                           <i class="fa fa-times"></i>
                                        </button><?php 
                                    }?>
                                </div>
                            </td>
                        </tr>
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
                        <?php require '../sesmt/modalAgendar.php'; 
                    }?>
                </tbody>
            </table>
        </div>
    </div>
</div>