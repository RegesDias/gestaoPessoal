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
        $ag = array('id' => $respGet[idRequerimento],'idStatus' => $respGet[status]);
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
        $lAtend = array('dataInicio' => $respGet[inicio],'dataFim' => $respGet[fim]);
        $listaFolha = getRest('requerimento/getListarFolhaPorPeriodoEMedico',$lAtend);
    }
    $listaReqEntrada = getRest('requerimento/getRequerimentoEntrada');
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?> 
  <div id="abrirAgenda">
  </div>
  <?php if((count($listaFolha) and $respGet[acao] == 'buscaAtendimento')){ ?>
  <div class="box-body no-padding">
    <div class="table-responsive mailbox-messages">
        <a href='#'>Atendimentos de <?=dataBr($respGet[inicio])." até ".dataBr($respGet[fim])?></a>
            <div class="box">
                <div class="box box-solid box-primary">
                 <table class="table table-condensed">
                  <div class="panel"><?php 
                    foreach ($listaFolha as $folha) {
                        if($folha[periodo] == 'manha'){$folha[periodo] = 'Manhã';}
                        if($folha[periodo] == 'tarde'){$folha[periodo] = 'Tarde';}
                        $folha[data] = dataHorabr($folha[data]);
                        $folha[data] = substr($folha[data], 0, -5);
                        $dataHoje = date("d/m/Y");?>
                                     <?php
                                          $ll = array('folha' => $folha[idFolha], 'notNull'=> 1);
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
                                                  }                                                
                                                  if($value[reAgenda] == 1){
                                                        $btnStatus = '';
                                                    }else{
                                                        $btnStatus = 'disabled';
                                                    }   
                                              }else{
                                                  $ArrEsp = $value['idRequerimentoFuncional'];?>
                                                  <tr>
                                                      <td class="mailbox-name">
                                                          <?=$folha[data]?>
                                                      </td>
                                                      <td class="mailbox-date">
                                                           <?=$folha[periodo]?>
                                                      </td>
                                                      <td class="mailbox-name">
                                                          <?=$value[matriculaServidor]." - ".$value[nomeServidor]?>
                                                      </td>
                                                      <td class="mailbox-date">
                                                           <?=$folha[nomeMedico]?>
                                                      </td>
                                                        <td>
                                                            <div class="pull-right">
                                                                  <a href="#" class="btn btn-success btn-small" onclick="agendaSESMTAtendimentosResult('ler','<?=$value[cpfServidor]?>')">
                                                                      <i class="fa fa-user"></i>
                                                                  </a>
                                                            </div>
                                                        </td>
                                                  </tr><?php 
                                              }
                                              require '../sesmt/modalAgendar.php';
                                          }
                        //remarcar todos
                        $remarcar = true;
                        $ArrEsp = "folha".$folha[idFolha];
                        require '../sesmt/modalAgendar.php';
                        //atualiza data atual
                        $dataAtual = $folha[data];
                    }?>
                      </table>
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