<?php
//configuração
    $pst = 'funcional';
    $arq = 'consolidarPlanejamento';
    $diaPlan = getRest('planejamento/getListaPlanejamentoData');
//buscar
    if ($respGet['acao'] == "consolidar") {
        $diaHoje = date('d');
        foreach ($diaPlan as $diaBanco) {
            if ($diaBanco == $diaHoje){
                $cont++;
                $execConsolidar = array('cpf' => $_SESSION['consolidaPlanejamento']['foto'], 'idLotacaoSub' => $respGet['idSetor']);
                $aConsolidar = array($execConsolidar);
                $executar = postRest('planejamento/postIncluirPlanejamentoConsolidado',$aConsolidar);
                //aqui
                $execConsolidar = array('idLotacaoSub' => $respGet['idSetor']);
                $executar = postRest('planejamento/postRevalidarPlanejamentoAuxiliar',$execConsolidar);
                //aqui
                $msnTexto = "ao consolidar.";
                break;
            }else{
                $executar['info'] = 400;
                $msnTexto = "! Está fora do prazo de Consolidação.";
            }
        }
    }
    if ($respGet['acao'] == "buscar") {
        $cBusc = array($respGet['login'],$respGet['cpf'],$respGet['nome']);
        $lista = getRest('userloginws/getListaUserLoginMult',$cBusc);
        $_SESSION['consolidaPlanejamento']['nome']= $lista['0']['nome'];
        $_SESSION['consolidaPlanejamento']['login'] = $lista['0']['login'];
        $_SESSION['consolidaPlanejamento']['foto'] = $lista['0']['cpf'];
    }else{
        $_SESSION['consolidaPlanejamento']['nome']= $_SESSION['user']['nome'];
        $_SESSION['consolidaPlanejamento']['login'] = $_SESSION['user']['login'];
        $_SESSION['consolidaPlanejamento']['foto'] = $_SESSION['user']['cpf'];
    }
//lista consolidados
   $lConsolidado = array($_SESSION['consolidaPlanejamento']['foto']);
   $consolidados=getRest('planejamento/getListaPlanejamentoConsolidado',$lConsolidado);
//MSN  
   exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
//TESTE
//   echo "<pre>";
//   print_r($_SESSION['$executar']);
//   echo "</pre>";
?>
<h1>
    Consolidar
    <small>Planejamento</small>
    <br>

</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li class="active">Validar Planejamento</li>
</ol>
<div class="row">
      <div class="col-md-4">
      <small>
      <div class="row">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Dias de Consolidação:</span><br>
                <?php
                    foreach ($diaPlan as $diaBanco) {
                        if ($diaBanco == date('d')){
                           $btnConsolida = true; 
                        }
                       ?><span class="badge bg-light-blue"><?=$diaBanco." "?></span> <?php
                    }
                ?>
            </div>
        </div>
      
        </div>
      </small>
    </div>
    <div class="col-md-8">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-aqua">
              <div class="widget-user-image">
                <img class="img-bordered-sm" src="<?=exibeFoto($_SESSION['consolidaPlanejamento']['foto'])?>" alt="User Avatar"><br>
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$_SESSION['consolidaPlanejamento']['nome']?></h3>
              <h5 class="widget-user-desc"><?=$_SESSION['consolidaPlanejamento']['login']?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                  <?php foreach ($consolidados as $valor) {?>
                  <li><a href="#"><div class="fa fa-calendar"></div> <?=dataHoraBr($valor['data'])?> <div class="fa fa-mail-forward"></div> <?=$valor['nomeSetor']?><span class="pull-right badge bg-blue">Consolidado</span></a></li>
                  <?php }
                  if(count($consolidados) == 0){
                      echo '<br><b>&nbsp; Não possui planejamento consolidado</b>';
                  }
                  ?>
              </ul>
              <br>
              <div class="box-footer no-padding col-md-1"></div>
                    <?php 
                    if ($respGet['acao'] != "buscar") {
                        if($btnConsolida == true){?>
                            <div class="box-footer no-padding col-md-9">
                                <form action="index.php" method="<?=$method?>" name="formTemplate">
                                    <?php require_once 'relat/boxSecretariaSetor.php'; ?>
                                    <br>
                                    <input type="submit" class='btn btn-primary' name="Consolidar" value="Consolidar">
                                    <input type='hidden' name='acao' value='consolidar'>
                                    <input type="hidden" name="pst" value="<?=$pst?>">
                                    <input type="hidden" name="arq" value="<?=$arq?>">
                                </form><br><br>
                             </div><?php
                        }else{?>
                            <div class="box-footer no-padding col-md-9">
                                <form action="index.php" method="<?=$method?>" name="formTemplate">
                                    <input type="submit" disabled="disable" class='btn btn-primary' name="Consolidar" value="Consolidar">
                                    <input type='hidden' name='acao' value='consolidar'>
                                    <input type="hidden" name="pst" value="<?=$pst?>">
                                    <input type="hidden" name="arq" value="<?=$arq?>">
                                </form><br><br>
                             </div><?php
                        }
                        }else{ ?>
                        <div class="box-footer no-padding col-md-12">
                            <form action="index.php" method="<?=$method?>"name="formTemplate">
                                <button class='btn btn-primary' value="Voltar">
                                    <i class="fa fa-rotate-left"></i> Voltar
                                </button>
                                <input type='hidden' name='cpf' value='<?=$_SESSION['consolidaPlanejamento']['foto']?>'>
                                <input type='hidden' name='acao' value='buscar'>
                                <input type="hidden" name="pst" value="usuario">
                                <input type="hidden" name="arq" value="perfil"> 
                                <input type="hidden" name="rightmenu" value="1">  
                                <input type="hidden" name="leftmenu" value="1">  
                            </form><br><br>
                        </div>
                    <?php }?>
                <br><br>

            </div>
          </div>
          <!-- /.widget-user -->
       
          <!-- /.widget-user -->
        <!-- /.col -->
      </div>
      <!-- /.row -->

     </div>
