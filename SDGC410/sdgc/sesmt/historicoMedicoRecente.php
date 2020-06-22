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
                                    if($value[idStatus] > 3){ ?>
                                       <button class="btn btn-success" title="Médico" onclick="buscaAtendimentos('buscaAtendimento','<?=$dataAgenda?>','<?=$dataAgenda?>','<?=$dataNew[0][idMedico]?>')" type="button">
                                            <i class="fa fa-stethoscope"></i>
                                        </button><?php    
                                    }?>
                                </div>
                            </td>
                        </tr>
<?php                    }?>
                </tbody>
            </table>
        </div>
    </div>
</div>