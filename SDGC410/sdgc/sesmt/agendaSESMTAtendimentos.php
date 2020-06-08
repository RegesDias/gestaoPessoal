<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $listaMedico = getRest('requerimento/getListarRequerimentoMedicoAtivos');
    if($respGet[acao] == 'criarVaga'){
        $respGet[acao] = 'buscaAtendimento';  
    }
    if($respGet[acao] == 'agendar'){
        $ag = array('idLinha' => $respGet[idLinha],'idRequerimentoFuncional' => $respGet[idRequerimentoFuncional]);
        $agendar = array($ag);
        $executar = postRest('requerimento/postAgendar',$agendar);
        $l = array('idLinha' =>$respGet[idLinha]);
        $listadata =  getRest('requerimento/getDataFolhaPorIdLinha',$l);
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
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
    print_p();
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
                <?php foreach ($listaMedico as $value) {
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
                        $ArrEsp = $value['idRequerimentoFuncional'];
                        if($value[matriculaServidor] == 'VAGO'){ ?>
                            <tr>
                                <td colspan="2">
                                    <center><span class="badge bg-yellow"> Vago </span></center>
                                </td>
                                <td>                  
                                    <div class="pull-right">
                                        <button class="btn btn-warning btn-small" data-toggle="modal" data-target="#agenda<?=$ArrEsp?>" >
                                            <i class="fa fa-calendar-check-o"></i>
                                        </button>
                                        <?php require_once '../sesmt/modalAgendar.php'; ?>
                                    </div>
                                </td>
                            </tr><?php        
                        }else{ ?>
                            <tr>
                                <td class="mailbox-name">
                                    <?=$value[matriculaServidor]." - ".$value[nomeServidor]?>
                                </td>
                                <td class="mailbox-date">
                                     <?=$value[requerimentoSolicitacao]?>
                                </td>
                                  <td>
                                      <div class="pull-right">
                                            <a href="#" class="btn btn-info btn-small" onclick="agendaSESMTAtendimentosResult('ler','<?=$v[id]?>')">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <button class="btn btn-info btn-small" data-toggle="modal" data-target="#agenda<?=$value[idRequerimentoFuncional]?>" >
                                                <i class="fa fa-calendar-check-o"></i>
                                            </button>
                                            <?php require_once '../sesmt/modalAgendar.php'; ?>
                                      </div>
                                  </td>
                            </tr><?php 
                        }
                    }?>

                </table>
              </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button class="btn btn-primary" onclick="criarVaga('criarVaga','<?=$value[[idFolha]]?>','<?=$respGet[inicio]?>','<?=$respGet[fim]?>','<?=$respGet[medico]?>')" type="button">
                                <i class="fa fa-plus"></i> Criar Vaga
                        </button>
                        <button class="btn btn-warning btn-small" data-toggle="modal" data-target="#criar<?=$value[idFolha]?>" >
                                <i class="fa fa-calendar-check-o"></i> Remarcar Todos
                        </button>
                        <div class="modal fade" id="criar<?=$value[idFolha]?>" role="dialog">
                          <div class="modal-dialog modal-md">

                            <div class="modal-content">
                              <div class="modal-body">
                                    <div class="col-sm-12">
                                      <label>Servidor</label>
                                      <select id="agendaDia" class="form-control select2" style="width: 100%;">
                                          <option value=""></option>
                                          <option>2222-joao</option>
                                          <option>2223-Reges</option>
                                          <option>2224-Amauri</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12"><br></div>
                              </div>
                              <div class="modal-footer">
                                    <button class="btn btn-primary" onclick="buscaAtendimentos('agendar',$('#agendaMedico').val(),$('#agendaDia').val())" type="button">
                                        Confirmar
                                    </button>
                                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div><?php  
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