<?php
    //VERIFICAR NIVEL DE ACESSO
if($_SESSION["funcionalBusca"]['situacao']['nome'] == 'ATIVO'){
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
    if($prmfrequencia['listar']=='1'){
        $idModal = 'InicioFim';
    }else{
        $idModal = 'Inicio';
    }
}else{
    foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
        if (($valor['pasta'] == 'funcional') AND ($valor['arquivo'] == 'frequencia'AND ($valor['menuN1'] == 'Frequência') AND $valor['buscar'] == '1')){ 
             $prmfrequencia["buscar"] = 1;
              break;
        }
    }
    //$prmfrequencia["buscar"] = 1;
}
?>
<div class="tab-pane <?= tabId('frequencia', $respGet['tab']) ?>" id="frequencia">
    <!-- Post -->
    <div class="post clearfix">
        <?php modalInicio('macacoesInicio', 'Marcações', 'print', 'info', 'macacoesInicio', '', 'funcional', 'perfil', 'frequencia') ?>
        <?php modalInicoFim('macacoesInicioFim', 'Marcações', 'print', 'info', 'macacoesInicioFim', '', 'funcional', 'perfil', 'frequencia') ?>
        <?php modalEnviaSetorInicio('modalEnviaSetorInicio', 'Folha de Ponto', 'print', 'info', 'folhapontoInicio', 'funcional', 'perfil', 'frequencia')?>
        <?php modalEnviaSetorInicioFim('modalEnviaSetorInicioFim', 'Folha de Ponto', 'print', 'info', 'folhapontoInicioFim', 'funcional', 'perfil', 'frequencia')?>
        <!-- /.box -->
        <!-- /.post -->        
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <button type="button <?=permissaoAcesso($prmfrequencia['buscar'],'hide')?>" class="btn btn-info" data-toggle="modal" data-target="<?='#modalEnviaSetor'.$idModal?>">
                            <i class="fa fa-calendar"></i> <b>Folha de Ponto</b>
                        </button>
                        <button type="button <?=permissaoAcesso($prmfrequencia['buscar'],'hide')?>" class="btn btn-info" data-toggle="modal" data-target="<?='#macacoes'.$idModal?>">
                            <i class="fa fa-print"></i> <b>Marcações</b>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOLHA de PONTO -->

        <div class="box box-info collapsed-box">
<!--            <div class="box-header with-border">
                <h3 class="box-title">Folha de Ponto</h3>

                <div class="box-tools pull-right">
                    <button onclick="exibeFolhaDePonto()" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>-->
            <!-- /.box-header -->
            <div class="box-body" style="">
                <!-- Carregamento -->
                 <div id="idCarregamentoFolhaDePonto" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                 </div>
                <!-- Fim Carregamento -->
                <!-- Inicio COnteudo Folha -->
                <div id="idConteudoFolhaDePonto" class="table-responsive collapse">
                    <!-- AQUI O JAVASCRIPT CRIA A FOLHA DE PONTO DINAMICAMENTE -->
                </div>
                <!-- Fim conteudo Folha-->
            </div>
            <!-- /.box-body -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div>
                    <div class="box-body">
                        <form class="<?=permissaoAcesso($prmfrequencia['incluir'],'hide')?> form-horizontal" method="<?=$method?>" action="index.php">
                            <?php require_once 'lancaOcorrencia.php'; ?>
                            <input type="hidden" name="tab" value="frequencia">
                            <input type="hidden" name="acao" value="lancarOco">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success pull-right  btn-sm"><i class="fa fa-edit"></i> Lançar</button>
                            </div>
                        </form>
                     </div>
                    </div>
                </div>
            </div>
        <!-- Folha de Ponto -->
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Buscar e Analisar as Ocorrências lançadas</h3>
            </div>
            <div class="box-body">
                <form class="<?=permissaoAcesso($prmfrequencia["buscar"],'hide')?> form-horizontal" method="<?=$method?>" action="index.php"> 
                    <div class="col-sm-6">
                        <label>Tipo de Ocorrência</label>
                        <select class="form-control select2"  name='idOcorrencia' style="width: 100%;">
                            <option selected='selected'></option>
                            <?php foreach ($_SESSION["funcionalPerfil"]["ocorrenciaDesc"] as $ArrEsp) { ?>ocorrenciaDesc
                                <option value="<?= $ArrEsp['idOcorrencia'] ?>"><?= $ArrEsp['nome'] ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="form-horizontal col-sm-5">
                        <label>Período</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="periodoOco" class="form-control pull-right" id="reservation">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class=" col-sm-12">
                        <br>
                    </div>
                    <div class=" col-sm-12">
                        <input type="hidden" name="tab" value="frequencia">
                        <input type="hidden" name="acao" value="buscarOcorrencia">
                        <input type="hidden" name="pst" value="<?= $pst ?>">
                        <input type="hidden" name="arq" value="<?= $arq ?>">
                        <button type="submit" class="btn btn-primary pull-right  btn-sm"><i class="fa fa-search"></i> Buscar</button>
                        
                    </div>
                </form>
            </div>
            
            <div class="box">
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
                                <form method="<?=$method?>" action="index.php">
                                    <input type="hidden" name="pst" value="print"/>
                                    <input type="hidden" name="arq" value="info"/>
                                    <input type="hidden" name="varq" value="perfil"/>
                                    <input type="hidden" name="vpst" value="funcional"/>
                                    <input type="hidden" name="vtab" value="frequencia">
                                    <input type="hidden" name="relat" value="OcorrenciasPorPeriodo"/>
                                    <input type="hidden" name="acao" value="OcorrenciasPorPeriodo"/>
                                    <input type="hidden" name="idOcorrencia" value="<?=$respGet['idOcorrencia']?>"/>
                                    <input type="hidden" name="inicio" value="<?=$bucaOcoInicio?>"/>
                                    <input type="hidden" name="fim" value="<?=$bucaOcoFim?>"/>
                                    <input type="hidden" name="matricula" value="<?=$_SESSION["funcionalBusca"]['matricula']?>"/>
                                    <button type="submit" class="btn btn-info"><i class="fa fa-book"></i> Gerar Relatório</button> 
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
                                                            <form action="index.php" method="<?=$method?>" name="formTemplate" class="<?=permissaoAcesso($prmfrequencia["excluir"],'hide')?>">
                                                                 <button class="btn btn-danger pull-right espaco-direita">
                                                                     <i class="fa fa-trash"></i>
                                                                 </button>
                                                                 <input type='hidden' name='id' value='<?=$ArrEsp['id']?>'>
                                                                 <input type='hidden' name='cpf' value='<?=$ArrEsp['cpf']?>'>
                                                                 <input type='hidden' name='tab' value='frequencia'>
                                                                 <input type='hidden' name='acao' value='excluirOcorrencia'>
                                                                 <input type="hidden" name="pst" value="<?=$pst?>">
                                                                 <input type="hidden" name="arq" value="<?=$arq?>">
                                                                 <input type="hidden" name="pg" value="1">
                                                             </form>
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
        </div>
    </div>
</div>
