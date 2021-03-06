<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    if($respGet[acao] == 'agendarServidor'){
        $ag = array('idLinha' => $respGet[idLinha],'idRequerimentoFuncional' => $respGet[idRequerimentoFuncional],'idLinhaOrigem' =>  $respGet[idLinhaOrigem]);
        $agendar = array($ag);
        $executar = postRest('requerimento/postMarcarServidor',$agendar);
        $respGet[acao] = 'buscaAtendimento'; 
        $msnTexto = "ao agendar Servidor. ".$executar['msn'].'.';
    }
    if($respGet[acao] == 'criarVaga'){
        $ag = array('idFolha' => $respGet[idFolha]);
        $agendar = array($ag);
        $executar = postRest('requerimento/postCriarVaga',$agendar);
        $respGet[acao] = 'buscaAtendimento';
        $msnTexto = "ao criar vaga. ".$executar['msn'].'.';
    }
    if($respGet[acao] == 'agendar'){
        $ag = array('idLinha' => $respGet[idLinha],'idRequerimentoFuncional' => $respGet[idRequerimentoFuncional],'idLinhaOrigem' => $respGet[idLinhaOrigem]);
        $agendar = array($ag);
        $executar = postRest('requerimento/postAgendar',$agendar);
        $l = array('idLinha' =>$respGet[idLinha]);
        $listadata =  getRest('requerimento/getDataFolhaPorIdLinha',$l);
        $respGet[acao] = 'buscaAtendimento';
        $msnTexto = "ao agendar. ".$executar['msn'].'.';
    }
    if($respGet[acao] == 'remarcar'){
        $linhaDestino = array('idLinha' => $respGet[idLinha],$linhaDestino);
        $idFolhaDestino = getRest('requerimento/getFolhaPorIdLinha',$linhaDestino);
        $respGet[idFolhaDestino] = $idFolhaDestino[0][idFolha];
        $ag = array('idFolhaOrigem' => $respGet[idFolhaOrigem],'idFolhaDestino' => $respGet[idFolhaDestino]);
        $agendar = array($ag);
        $executar = postRest('requerimento/postRemarcarAgenda',$agendar);
        $l = array('idLinha' =>$respGet[idLinha]);
        $listadata =  getRest('requerimento/getDataFolhaPorIdLinha',$l);
        $respGet[acao] = 'buscaAtendimento';
        $msnTexto = "ao agendar. ".$executar['msn'].'.';
    }
    if($respGet[acao] == 'alterarStatusRequerimento'){
        $ag = array('id' => $respGet[idRequerimento],'idStatus' => $respGet[status],'idLinha' => $respGet[idLinha]);
        $agendar = array($ag);
        $executar = postRest('requerimento/postAlterarStatusRequerimento',$agendar);
        $msnTexto = "ao alterar status. ".$executar['msn'].'.';
        $respGet[acao] = 'buscaAtendimento';
    }
    if($respGet[acao] == 'buscaAtendimento'){
        if (isset($listadata)){
            $listadata[0][data] = substr($listadata[0][data], 0, -6);
            $respGet[inicio] = $listadata[0][data];
            $respGet[fim] = $listadata[0][data];
        }
        $lAtend = array('dataInicio' => $respGet[inicio],'dataFim' => $respGet[fim],'idRequerimentoMedico' => $respGet[medico]);
        $listaFolha = getRest('requerimento/getListarFolhaPorPeriodoEMedico',$lAtend);
    }
    $listaMedicos = getRest('requerimento/getListarMedicoComVagasAbertas');
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
    if((count($listaFolha) and $respGet[acao] == 'buscaAtendimento')){ ?>
  <div class="box-body no-padding">
    <div class="mailbox-controls">
        <?php require_once '../sesmt/dadosMedico.php'; ?>
    </div>
    <div class="table-responsive mailbox-messages">
        <a href='#'>Atendimentos de <?=dataBr($respGet[inicio])." até ".dataBr($respGet[fim])?></a>
            <div class="box">
                <div class="box box-solid box-primary">
                  <div class="panel"><?php 
                    if(count($listaFolha) <= 2){
                          $in = 'in';
                    }
                    foreach ($listaFolha as $folha) {
                        if($folha[periodo] == 'manha'){$folha[periodo] = 'Manhã';}
                        if($folha[periodo] == 'tarde'){$folha[periodo] = 'Tarde';}
                        $folha[data] = dataHorabr($folha[data]);
                        $folha[data] = substr($folha[data], 0, -5);
                        $dataHoje = date("d/m/Y");?>
                                <?php if($dataAtual != $folha[data]){?>
                                        <div class="box-header with-border">
                                          <h4 class="box-title box-primary">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$folha[idFolha]?>">
                                                <i class="fa fa-medkit"></i> <?=$folha[data]?>
                                            </a>
                                          </h4>
                                        </div>
                                        <div class="box-header with-border">
                                          <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" class='link-button-menu-left' href="#collapse<?=$folha[idFolha]?>">
                                                <?=$folha[periodo]?> total de <?=$folha[vagas]?> atendimento(s)
                                            </a>
                                          </h4>
                                        </div>
                                        <?php 

                                }else{ ?>
                                        <div class="box-header with-border">
                                          <h4 class="box-title box-primary">
                                            <a data-toggle="collapse" data-parent="#accordion" class='link-button-menu-left' href="#collapse<?=$folha[idFolha]?>">
                                                <?=$folha[periodo]?> total de <?=$folha[vagas]?> atendimento(s)
                                            </a>
                                          </h4>
                                        </div>                                
                                <?php }?>
                                <div id="collapse<?=$folha[idFolha]?>" class="panel-collapse collapse <?=$in?>">
                                  <div class="box-body">
                                    <div class="box-body no-padding">
                                      <table class="table table-condensed"><?php
                                          $ll = array('folha' => $folha[idFolha]);
                                          $llinha = getRest('requerimento/getListarLinhasPorIdFolha',$ll);
                                          foreach ($llinha as $value) {
                                                if($value[reAgenda] == 1){
                                                    $btnStatus = '';
                                                }else{
                                                    $btnStatus = 'disabled';
                                                }
                                                if($value[matriculaServidor] == 'VAGO'){
                                                  $ArrEsp = $value['idLinha'];
                                                  if($value[vagaExtra] == 'true'){
                                                      $vaga = 'Vaga Extra';
                                                      $btn = 'btn-danger';
                                                  }else{
                                                      $vaga = 'Vaga';
                                                      $btn = 'btn-warning';
                                                  }
                                                  if($toDay > $dataAgenda){
                                                      echo estatosAnterior;
                                                  }
                                                  ?>
                                                  <tr>
                                                      <td colspan="3">
                                                          <a href="#" <?=$btnStatus?> ><center><span class="badge <?=$btn?>"> <?=$vaga?> </span></center></a>
                                                      </td>
                                                      <td>
                                                           <?php if($folha[data] >= date('d-m-Y')){?>
                                                                <div class="pull-right">
                                                                      <button <?=$btnStatus?> title = 'Agendar' class="btn <?=$btn?> btn-small" data-toggle="modal" data-target="#agendaServidor<?=$ArrEsp?>" >
                                                                          <i class="fa fa-calendar-check-o"></i>
                                                                      </button>
                                                                </div>
                                                           <?php }?>
                                                      </td>
                                                  </tr><?php        
                                              }else{
                                                  $ArrEsp = $value['idRequerimentoFuncional'];?>
                                                  <tr>
                                                      <td class="mailbox-name">
                                                          <?=$value[matriculaServidor]." - ".$value[nomeServidor]?>
                                                      </td>
                                                      <td class="mailbox-date">
                                                           <?=$value[requerimentoSolicitacao]?>
                                                      </td>
                                                      <td class="mailbox-date">
                                                          <span class="text-muted pull-right label label-primary"><i class="fa fa-hourglass-2"></i> <?=$value[nomeStatus]?></span>
                                                      </td>
                                                        <td>
                                                            <div class="pull-right">
                                                                <?php if(($value[idStatus] == 4) AND ($toDay <= $dataAgenda)){?>
                                                                    <button class="btn btn-primary" title="Atendimento" onclick="agendaSESMTAtendimentosFichaMedica('Agenda Alterar','<?=$value[id]?>','<?=$value[cpfServidor]?>')" >
                                                                        <i class="fa fa-heartbeat"></i>
                                                                    </button><?php 
                                                                
                                                                }
                                                                 if($value[idStatus] < 90){?>
                                                                    <button  class="btn btn-small" data-toggle="modal" data-target="#alterarStatus<?=$ArrEsp?>" >
                                                                        <i class="fa fa-thumbs-o-down"></i>
                                                                    </button>
                                                                  <?php }?>
                                                                  <div class="modal fade" id="alterarStatus<?=$ArrEsp?>" role="dialog">
                                                                      <div class="modal-dialog modal-md">
                                                                          <div class="modal-content">
                                                                              <div class="modal-body">
                                                                                  <div class="col-sm-12">
                                                                                      <label>Servidor</label>
                                                                                      <select name="idStatus" size="1"  class="form-control select2" id='idStatus<?=$value[idLinha]?>' style="width: 100%;">
                                                                                            <option selected></option>
                                                                                            <option value="97">Paciente não compareceu</option>
                                                                                            <option value="94">Paciente Requisitou Remarcação</option>
                                                                                            <option value="95">Médico Indisponível</option>
                                                                                            <option value="93">Médico Requisitou Remarcação</option>
                                                                                      </select>
                                                                                  </div>
                                                                                  <div class="col-sm-12"><br></div>
                                                                              </div>
                                                                              <div class="modal-footer">
                                                                                  <button data-dismiss="modal" class="btn btn-primary" onclick="alterarStatusRequerimentoModal('alterarStatusRequerimento','<?=$respGet[inicio]?>','<?=$respGet[fim]?>','<?=$respGet[medico]?>','<?=$value[idRequerimento]?>',$('#idStatus<?=$value[idLinha]?>').val(),'<?=$value[idLinha]?>')" type="button">
                                                                                      Confirmar
                                                                                  </button>
                                                                                  <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <a href="#" class="btn btn-success btn-small" onclick="agendaSESMTAtendimentosResult('ler','<?=$value[cpfServidor]?>')">
                                                                      <i class="fa fa-user"></i>
                                                                  </a>
                                                                <?php if( $btnStatus != 'disabled'){?>
                                                                  <button <?=$btnStatus?> class="btn btn-info btn-small" data-toggle="modal" data-target="#agenda<?=$ArrEsp?>" >
                                                                      <i class="fa fa-calendar-check-o"></i>
                                                                  </button>
                                                                <?php }?>
                                                            </div>
                                                        </td>
                                                  </tr><?php 
                                              }
                                              require '../sesmt/modalAgendar.php';
                                          }?>
                                      </table>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="pull-right">
                                            <?php if($folha[data] >= date('d-m-Y')){?>
                                            <button class="btn btn-primary" onclick="criarVaga('criarVaga','<?=$folha[idFolha]?>','<?=$respGet[inicio]?>','<?=$respGet[fim]?>','<?=$respGet[medico]?>')" type="button">
                                                    <i class="fa fa-plus"></i> Criar Vaga
                                            </button>
                                            <?php }?>
                                            <button class="btn btn-warning btn-small" data-toggle="modal" data-target="#agenda<?="folha".$folha[idFolha]?>" >
                                                    <i class="fa fa-calendar-check-o"></i> Remarcar Todos
                                            </button>
                                        </div>
                                    </div>

                          </div>
                        </div><?php
                        //remarcar todos
                        $remarcar = true;
                        $ArrEsp = "folha".$folha[idFolha];
                        require '../sesmt/modalAgendar.php';
                        //atualiza data atual
                        $dataAtual = $folha[data];
                    }?>
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-info" onclick="fecharEmSecretaria('fecharVariavelSecretaria','<?=$ArrEsp[idVariavelDesc]?>','<?=$ArrEsp[variaveisDesc]?>')" type="button">
          <i class="fa fa-print"></i> Imprimir
        </button>
    </div>
<?php }?>

<?php if (!count($listaFolha) and ($respGet[acao] == 'buscaAtendimento')){ ?>
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Vazio</h3>

              <p>Nenhum Atendimento Encontrado</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="#" class="small-box-footer">
                <br>
            </a>
          </div>
        </div>
<?php } ?>
<script>
    configuraTela(); 
</script>