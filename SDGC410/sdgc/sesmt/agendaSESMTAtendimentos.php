<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    if($respGet[acao] == 'agendarServidor'){
        $ag = array('idLinha' => $respGet[idLinha],'idRequerimentoFuncional' => $respGet[idRequerimentoFuncional]);
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
        $ag = array('idLinha' => $respGet[idLinha],'idRequerimentoFuncional' => $respGet[idRequerimentoFuncional]);
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
        print_p();
        $ag = array('id' => $respGet[idRequerimento],'idStatus' => $respGet[status]);
        print_p($ag);
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
    $listaReqEntrada = getRest('requerimento/getRequerimentoEntrada');
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?> 
<div class="box box-primary">
  <div class="box-header with-border">
    <div class="col-sm-12">
        <h3 class="box-title">Atendimentos</h3>
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
        <button class="btn btn-primary" onclick="buscaAtendimentos('buscaAtendimento',$('#inicio').val(),$('#fim').val(),$('#idMedico').val())" type="button">
            <i class="fa fa-search"></i> Buscar
        </button>
    </div>
    <!-- /.box-tools -->
  </div>
  <!-- /.box-header -->
  <?php if((count($listaFolha) and $respGet[acao] == 'buscaAtendimento')){ ?>
  <div class="box-body no-padding">
    <div class="mailbox-controls">
        <?php require_once '../sesmt/dadosMedico.php'; ?>
    </div>
    <div class="table-responsive mailbox-messages">
        <h3>Atendimentos</h3><?php 
        foreach ($listaFolha as $folha) {
            if($folha[periodo] == 'manha'){$folha[periodo] = 'Manhã';}
            if($folha[periodo] == 'tarde'){$folha[periodo] = 'Tarde';}
            $folha[data] = dataHorabr($folha[data]);
            $folha[data] = substr($folha[data], 0, -5);
            $dataHoje = date("d/m/Y");
            if($folha[data] <= $dataHoje){
                $btnStatus = 'disabled';
            }else{
                $btnStatus = '';
            }
            if($dataAtual != $folha[data]){?>
                <div class="box box-primary">
                  <div class="box-header">
                    <center><h3 class="box-title"><i class="fa fa-medkit"></i>  <?=$folha[data]?></h3></center>
                  </div>
                <div><?php 
                
            }?>
            <div class="box">
              <div class="box-header">
                <h3 class="box-title"> <?=$folha[periodo]?> total de <?=$folha[vagas]?> atendimento(s)</h3>
              </div>
              <div class="box-body no-padding">
                <table class="table table-condensed"><?php
                    $ll = array('folha' => $folha[idFolha]);
                    $llinha = getRest('requerimento/getListarLinhasPorIdFolha',$ll);
                    foreach ($llinha as $value) {
                        if($value[matriculaServidor] == 'VAGO'){
                            $ArrEsp = $value['idLinha'];
                            if($value[vagaExtra] == 'true'){
                                $vaga = 'Vaga Extra';
                                $btn = 'btn-danger';
                            }else{
                                $vaga = 'Vaga';
                                $btn = 'btn-warning';
                            }?>
                            <tr>
                                <td colspan="2">
                                    <a href="#" <?=$btnStatus?> ><center><span class="badge <?=$btn?>"> <?=$vaga?> </span></center></a>
                                </td>
                                <td>                  
                                    <div class="pull-right">
                                        <button <?=$btnStatus?> class="btn <?=$btn?> btn-small" data-toggle="modal" data-target="#agendaServidor<?=$ArrEsp?>" >
                                            <i class="fa fa-calendar-check-o"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr><?php        
                        }else{
                            $ArrEsp = $value['idRequerimentoFuncional'];
                            ?>
                            <tr>
                                <td class="mailbox-name">
                                    <?=$value[matriculaServidor]." - ".$value[nomeServidor]?>
                                </td>
                                <td class="mailbox-date">
                                     <?=$value[requerimentoSolicitacao]?>
                                </td>
                                  <td>
                                      <div class="pull-right">
                                            <button <?=$btnStatus?> class="btn btn-info btn-small" data-toggle="modal" data-target="#alterarStatus<?=$ArrEsp?>" >
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                            <div class="modal fade" id="alterarStatus<?=$ArrEsp?>" role="dialog">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="col-sm-12">
                                                                <label>Servidor</label>
                                                                <select name="idStatus" size="1"  class="form-control select2" id='idStatus' style="width: 100%;">
                                                                        <option value="97">Paciente não compareceu</option> 
                                                                        <option value="95" selected>Médico Indisponivel</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-12"><br></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button data-dismiss="modal" class="btn btn-primary" onclick="alterarStatusRequerimentoModal('alterarStatusRequerimento','<?=$respGet[inicio]?>','<?=$respGet[fim]?>','<?=$respGet[medico]?>','<?=$value[idRequerimento]?>',$('#idStatus').val())" type="button">
                                                                Confirmar
                                                            </button>
                                                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-success btn-small" onclick="agendaSESMTAtendimentosResult('ler','<?=$value[cpfServidor]?>')">
                                                <i class="fa fa-heartbeat"></i>
                                            </a>
                                            <button <?=$btnStatus?> class="btn btn-info btn-small" data-toggle="modal" data-target="#agenda<?=$ArrEsp?>" >
                                                <i class="fa fa-calendar-check-o"></i>
                                            </button>
                                      </div>
                                  </td>
                            </tr>
                               
                        <?php }
                          require '../sesmt/modalAgendar.php';
                    }?>

                </table>
              </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button <?=$btnStatus?> class="btn btn-primary" onclick="criarVaga('criarVaga','<?=$folha[idFolha]?>','<?=$respGet[inicio]?>','<?=$respGet[fim]?>','<?=$respGet[medico]?>')" type="button">
                                <i class="fa fa-plus"></i> Criar Vaga
                        </button>
                        <button class="btn btn-warning btn-small" data-toggle="modal" data-target="#agenda<?="folha".$folha[idFolha]?>" >
                                <i class="fa fa-calendar-check-o"></i> Remarcar Todos
                        </button>
                    </div>
                </div>
            </div><?php
            //remarcar todos
            $remarcar = true;
            $ArrEsp = "folha".$folha[idFolha];
            require '../sesmt/modalAgendar.php';
            //atualiza data atual
            $dataAtual = $value[data];
            
        }?>
    <!-- /.box-body -->
    <div class="box-footer no-padding">
      <div class="mailbox-controls">
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