<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $listaMedico = getRest('requerimento/getListarRequerimentoMedicoAtivos');
    if($respGet[acao] == 'buscaAtendimento'){
        $lAtend = array('dataInicio' => $respGet[inicio],'dataFim' => $respGet[fim],'idRequerimentoMedico' => $respGet[medico]);
        $listaFolha = getRest('requerimento/getListarFolhaPorPeriodoEMedico',$lAtend);
    }
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
        foreach ($listaFolha as $value) {
            if($value[periodo] == 'manha'){$value[periodo] = 'Manhã';}
            if($value[periodo] == 'tarde'){$value[periodo] = 'Tarde';}
            $value[data] = dataHorabr($value[data]);
            $value[data] = substr($value[data], 0, -5);
            if($dataAtual != $value[data]){?>
                <div class="box box-primary">
                  <div class="box-header">
                    <center><h3 class="box-title"><i class="fa fa-medkit"></i>  <?=$value[data]?></h3></center>
                  </div>
                <div><?php 
                
            }?>
            <div class="box">
              <div class="box-header">
                <h3 class="box-title"> <?=$value[periodo]?> total de <?=$value[vagas]?> atendimento(s)</h3>
              </div>
              <div class="box-body no-padding">
                <table class="table table-condensed"><?php
                    $ll = array('folha' => $value[idFolha]);
                    $llinha = getRest('requerimento/getListarLinhasPorIdFolha',$ll);
                    foreach ($llinha as $value2) {
                        if($value2[matriculaServidor] == 'VAGO'){ ?>
                            <tr>
                                <td colspan="2">
                                    <center><span class="badge bg-yellow"> Vago </span></center>
                                </td>
                                <td>                  
                                    <div class="pull-right">
                                        <button class="btn btn-warning btn-small" data-toggle="modal" data-target="#agenda<?=$ArrEsp[idVariavelDesc]?>" >
                                            <i class="fa fa-calendar-check-o"></i>
                                        </button>
                                        <?php require_once '../sesmt/modalAgendar.php'; ?>
                                    </div>
                                </td>
                            </tr><?php        
                        }else{ ?>
                            <tr>
                                <td class="mailbox-name">
                                    <?=$value2[matriculaServidor]." - ".$value2[nomeServidor]?>
                                </td>
                                <td class="mailbox-date">
                                     <?=$value2[requerimentoSolicitacao]?>
                                </td>
                                  <td class="mailbox-date">
                                        <a href="#" class="btn btn-info btn-small" onclick="agendaSESMTAtendimentosResult('ler','<?=$v[id]?>')">
                                            <i class="fa fa-search"></i>
                                        </a>
                                          <button class="btn btn-info btn-small" data-toggle="modal" data-target="#agenda<?=$ArrEsp[idVariavelDesc]?>" >
                                              <i class="fa fa-calendar-check-o"></i>
                                          </button>
                                          <?php require_once '../sesmt/modalAgendar.php'; ?>
                                  </td>
                            </tr><?php 
                        }
                    }?>

                </table>
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
        <button class="btn btn-warning" onclick="fecharEmSecretaria('fecharVariavelSecretaria','<?=$ArrEsp[idVariavelDesc]?>','<?=$ArrEsp[variaveisDesc]?>')" type="button">
          <i class="fa fa-minus"></i> Remarcar Todos
        </button>
        <button class="btn btn-success" onclick="fecharEmSecretaria('fecharVariavelSecretaria','<?=$ArrEsp[idVariavelDesc]?>','<?=$ArrEsp[variaveisDesc]?>')" type="button">
          <i class="fa fa-plus"></i> Criar Vaga
        </button>
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
<?php }  
        //Agendar
        $dados = array('acao','agendaMedico','agendaDia','agendaPeriodo','idPaciente');
        $funcao = array('fecharModal');
        postRestAjax('agendaSESMTAgendar','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados,'','',$funcao);
?>
<script>
    configuraTela(); 
</script>