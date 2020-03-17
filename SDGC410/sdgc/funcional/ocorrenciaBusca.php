 <?php
    session_start();
    require_once '../func/fPhp.php';
    foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
        if (($valor['pasta'] == 'funcional') AND ($valor['arquivo'] == 'frequencia'AND ($valor['menuN1'] == 'Frequência'))){ 
             $prmfrequencia = $valor;
              break;
        }
    }
    foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
        if (($valor['pasta'] == 'funcional') AND ($valor['arquivo'] == 'frequencia'AND ($valor['menuN1'] == 'ConsultarUsuario'))){ 
             $prmConsultaUsuario = $valor;
              break;
        }
    }
    if ($respGet[acao] == 'buscarOcorrencia'){
        $dataTotal = $respGet['reservation'];
        $dataTotal = str_ireplace("/", "-", $dataTotal);
        $inicioFim = explode(" até ", $dataTotal);
        $inicioData = date("Y-m-d",strtotime($inicioFim[0]));
        $fimData = date("Y-m-d",strtotime($inicioFim[1]));
        $buscaOco = array('idFuncional' => $_SESSION["funcionalBusca"]['id'], 'inicio' => $inicioData, 'fim' => $fimData,'idOcoDesc' => $respGet['idOcorrenciaBusca']);
        $_SESSION["dadosBuscaOcorrencia"] = $buscaOco;
        $_SESSION["dadosBuscaOcorrencia"]['matricula'] = $_SESSION['funcionalBusca']['matricula'];
        $_SESSION["dadosBuscaOcorrencia"]['cpf'] = $_SESSION['funcionalBusca']['pessoa']['cpf'];
        $buscaOcorrencia = getRest('OcorrenciaWs/getListaOcorrenciaPorIdData',$buscaOco);
        $msnTexto = "! Ocorrencias não encontradas no período de ".$inicioFim[0]." até ".$inicioFim[1].".";
        $totalBusca = count($buscaOcorrencia);
            if ($totalBusca == 0) {
                $executar['info'] = 400;
            }else{
                $executar['info'] = 200;
            }
        $_SESSION["ocorrenciaPerfil"] = $buscaOcorrencia;
    }
    //EXCLUIR OCORRENCIA
    if ($respGet['acao'] == "excluirOcorrencia") {
            $excluirOco = array(      
                            'idOcorrencia' => $respGet['id']
                            );
        $excluirOco = array($excluirOco);
        $executar = postRest('OcorrenciaWs/postExcluirOcorrencia',$excluirOco);
        $msnTexto = "ao excluir ocorrência.";
        $periodoOcoBusca = str_replace("/", "-", $periodoMes);
        $inicioData = date("Y-m-d",strtotime($periodoOcoBusca[0]));
        $fimData = date("Y-m-d",strtotime($periodoOcoBusca[1]));
        $oPerfil = array('idFuncional' => $_SESSION["funcionalBusca"]['id'], 'inicio' => $inicioData, 'fim' => $fimData,'idOcoDesc' => '');
        $buscaOcorrencia = getRest('OcorrenciaWs/getListaOcorrenciaPorIdData',$oPerfil);
        $_SESSION["ocorrenciaPerfil"] = $buscaOcorrencia;
    }
 ?>
<div class="box">
            <div class="overlay hidden" id="idSpinLoaderImprimeOcorrencia">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
                <div class="box-body ">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                                if(count($_SESSION['dadosBuscaOcorrencia']['inicio'])>0){
                                     $bucaOcoInicio = $_SESSION['dadosBuscaOcorrencia']['inicio'];
                                 }else{
                                     $bucaOcoInicio = dataBanco($periodoMes[0]); 
                                 }
                                 if(count($_SESSION['dadosBuscaOcorrencia']['fim'])>0){
                                     $bucaOcoFim = $_SESSION['dadosBuscaOcorrencia']['fim'];
                                 }else{
                                     $bucaOcoFim =  dataBanco($periodoMes[1]); 
                                 }
                            ?>
                            <?php if(count($_SESSION["ocorrenciaPerfil"])>0){?>
                                <form>
                                    
                                    <button class="btn btn-danger" onclick="relatorioEmBuscarOcorrencia('OcorrenciasPorPeriodo','<?=$_SESSION["funcionalBusca"]['matricula']?>','<?=$bucaOcoInicio?>', '<?=$bucaOcoFim?>', '<?=$respGet['idOcorrencia']?>',false)" type="button">
                                          <i class="fa fa-print"></i> Imprimir                         
                                    </button>
                                    

                                </form>
                            <?php }?>
                            <div class="box box-solid">
                                <!-- /.box-header -->
                                <div class="box-body">
                                    
                                    <div class="box-group" id="ocorrencia">
                                        
                                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                        <?php
                                        $totalDias = 0;
                                        foreach ($_SESSION["ocorrenciaPerfil"] as $ArrEsp) {
                                            $numeroDias = $ArrEsp['numeroDias'];
                                            $entradaOco = dataHoraBr($ArrEsp['entrada']);
                                            $saidaOco = dataHoraBr($ArrEsp['saida']);
                                            //hora
                                            $horaEntradaOco = substr($entradaOco, -8);
                                            $horaSaidaOco = substr($saidaOco, -8);
                                            //data
                                            $dataEntradaOco = substr($entradaOco, 0, -8);
                                            $dataSaidaOco = substr($saidaOco, 0, -8);
                                            if ($ArrEsp['numeroDias'] != 0){
                                                $diasTotal= $ArrEsp['numeroDias']-1;
                                                if (($dataEntradaOco != $dataSaidaOco) AND ($ArrEsp['numeroDias'] > 0)){
                                                   $diasTotal= $ArrEsp['numeroDias']-2;
                                                }
                                                if (($dataEntradaOco != $dataSaidaOco) AND ($ArrEsp['numeroDias'] == 1)){
                                                   $diasTotal= $ArrEsp['numeroDias']-1;
                                                }
                                                $ArrEsp['numeroDias'] = $diasTotal;
                                            }
                                            $dataSaidaOco = date('d/m/Y', strtotime($ArrEsp['numeroDias'].' days', strtotime($ArrEsp['saida'])));
                                            if($entradaOco == $saidaOco){
                                                $msnPeriodo= "<b>Período: </b><i> Dia ".$dataEntradaOco.' as '.$horaEntradaOco.'</i>';
                                            }else{
                                                $msnPeriodo= "<b>Período: </b><i> A partir do dia ".$dataEntradaOco." até ".$dataSaidaOco.", entre as ".$horaEntradaOco." e as ".$horaSaidaOco.'</i>';
                                            }
                                            $LancadoOco = dataHoraBr($ArrEsp['dataLancamento']);
                                            $totalDias = $totalDias+$numeroDias;
                                            //echo $totalDias;
                                            //teste
                                            $d1=substr(trim($dataEntradaOco),3);
                                            $d2=substr(trim($periodoMes[0]),3);
                                            ?>                                
                                            <div class="panel box box-success">
                                                <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                        <a data-toggle="collapse" data-parent="#ocorrencia" href="#<?= $ArrEsp['id'] ?>">
                                                            <i class="fa fa-sort-down"></i> <?= $ArrEsp['id'] . ' - ' . $ArrEsp['ocorrenciaNome'] ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="<?= $ArrEsp['id'] ?>" class="panel-collapse collapse">
                                                     <div class="box-body">
                                                        <?php if($d1 == $d2){?>
                                                            <button class="<?=permissaoAcesso($prmfrequencia["excluir"],'hide')?> btn btn-danger pull-right espaco-direita" onclick="postApagarOcorrencia(<?=$ArrEsp['id']?>,<?=$ArrEsp['cpf']?>,'excluirOcorrencia')" type="button">
                                                                  <i class="fa fa-trash"></i>
                                                            </button>
                                                        <?php }?> 
                                                        <?php if($prmConsultaUsuario['buscar']=='1'){?>
                                                             <form action="index.php" method="<?=$method?>"name="formTemplate">
                                                                 <button class="btn btn-info pull-right espaco-direita">
                                                                     <i class="fa fa-user"></i>
                                                                 </button>
                                                                 <input type='hidden' name='cpf' value='<?=$ArrEsp['cpf']?>'>
                                                                 <input type='hidden' name='acao' value='buscar'>
                                                                 <input type="hidden" name="pst" value="usuario">
                                                                 <input type="hidden" name="arq" value="perfil">
                                                                 <input type="hidden" name="pg" value="1">
                                                             </form>
                                                         <?php }?>
                                                     </div>
                                                    <div class="box-body">
                                                        <b><?=$ArrEsp['nomeLotacao']?></b><br>
                                                        <?=$msnPeriodo?><br>
                                                        <?php if($numeroDias>0){?>
                                                            <b>Total de dias: </b><i><?= $numeroDias ?>
                                                            </i><br>
                                                        <?php }?>
                                                        <b>Lançado em: </b><i><?= $LancadoOco ?>
                                                            <?=$ArrEsp['login']?>
                                                        </i><br>
                                                        <b>Observação: </b>
                                                        <div class="box-body">
                                                            <?=$ArrEsp['obs']?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                        <?php } ?>
 <?php
                                    if(($respGet['idOcorrencia']!='') and ($totalDias>0)){
                                        $msnPeriodo= "Analisando partir do dia ".dataBr($inicioData)." até ".dataBr($fimData);
                                        ?>
                                            <div class="panel box box-success">
                                                <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                        <a data-toggle="collapse" data-parent="#ocorrencia" href="#analizar">
                                                            <i class="fa fa-sort-down"></i> <?='Analisador - ' . $ArrEsp['ocorrenciaNome'] ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="analizar" class="panel-collapse collapse">                                                 
                                                    <div class="box-body">
                                                        <b>Total de dias Gozados: </b><i><?= $totalDias ?>
                                                        </i><br>
                                                        <b>Período: </b><i><?=$msnPeriodo?></i><br>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php }
                                ?>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                               
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
<?php

    $be = array('idSpinLoaderImprimeOcorrencia','removeClass','hidden');
    $s1 = array('idBoxImprimir','addClass','hidden');
    $s2 = array('idSpinLoaderLancaOcorrencia','addClass','hidden');
    $beforeSend= array ($be);
    $success = array ($s1, $s2);
    $funcao = array('postBuscarOcorrencia');
    $dados = array('id','cpf','acao');
    postRestAjax('postApagarOcorrencia','ocorrenciaBusca','funcional/ocorrenciaBusca.php',$dados, $beforeSend, $success, $funcao);
    
    $be = array('idSpinLoaderImprimeOcorrencia','removeClass','hidden');
    $s1 = array('idBoxImprimir','addClass','hidden');
    $s2 = array('idSpinLoaderLancaOcorrencia','addClass','hidden');
    $beforeSend= array ($be);
    $success = array ($s1, $s2);
    $funcao = array('postBuscarOcorrencia');
    $dados = array('acao','matricula','inicio','fim' ,'idOcorrencia' );
    postRestAjax('relatorioEmBuscarOcorrencia','imprimir','print/info.php',$dados, $beforeSend, $success, $funcao);
    
?>