<?php
    session_start();
    require_once '../func/fPhp.php';
    foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
        if (($valor['pasta'] == 'funcional') AND ($valor['arquivo'] == 'planejamento')){ 
             $prmPlanejamento = $valor;
              break;
        }
    }
    //CADASTRAR PLANEJAMNETO
if ($respGet['acao'] == "lancarPlanejamento") {
    $lancarPlan = array(      
                    'idTpPlan' => $respGet['tipoPlan'],
                    'idFunc' => $_SESSION["funcionalBusca"]["id"],
                    'diaSemana' => $respGet['diaSemana'],
                    'hInicial' => $respGet['hInicial'],
                    'hFinal' => $respGet['hFinal'],
                    'setorPlan' => $respGet['setorPlan'],
                    'feriado' => $respGet['feriado'],
                    'pontoFacult' => $respGet['pontoFacult']
                        );
    $arquivoPlan = array($lancarPlan);
    $executar = postRest('planejamento/postIncluirPlanejamento',$arquivoPlan);
    $msnTexto = 'ao Lançar Planejamento. '.$executar['msn'].'.';
    $respGet['acao'] = 'buscarPlanejamento';
}

//REMOVER PLANEJAMENTO
if ($respGet['acao'] == "excluirPlanejamento") {
        $excluirPlan = array('idPlanejamentoAuxiliar'=>$respGet['idPlanejamentoAuxiliar']);
        $excluirP = array($excluirPlan);
        $executar = postRest('planejamento/postRemoverPlanejamentoAuxiliar',$excluirP);
        $msnTexto = "ao excluir Planejamento.";
        $respGet['acao'] = 'buscarPlanejamento';
}

//BUSCAR PLANEJAMENTO
if ($respGet['acao'] == "buscarPlanejamento") {
        $buscaPlan = array('idFuncional'=>$_SESSION["funcionalBusca"]['id']);
        $buscaPlanejamento = getRest('planejamento/getListaPlanejamento',$buscaPlan);
        $_SESSION["planLancados"] = $buscaPlanejamento;
}
exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?>
<div class="<?=permissaoAcesso($prmPlanejamento["buscar"],'hide')?> box box-primary">

    <div class="box-header">
      <h3 class="box-title">Planejamento Consolidado</h3>
    </div>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box box-solid">
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="box-group" id="planejamento">
                            <?php
                            if(count ($_SESSION["planLancados"])==0){
                                echo "O servidor não possui planejamento consolidado";
                            }
                            ?>
                          <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                         <?php foreach ($_SESSION["planLancados"] as $ArrEsp) 
                             {?>
                            <div class="box-group" id="planejamento">
                                <div class="panel box box-success">
                                  <div class="box-header with-border">
                                    <h4 class="box-title">
                                      <a data-toggle="collapse" data-parent="#planejamento" href="#collapse<?=$ArrEsp['idPlanejamentoAuxiliar']?>">
                                          <i class="fa fa-sort-down"></i> Em <?=$ArrEsp['mesAno']?> todo <?=diaSemana($ArrEsp['diaSemana'])?> de <?=$ArrEsp['hInicial']?> até <?=$ArrEsp['hFinal']?>
                                      </a>
                                    </h4>
                                  </div>
                                  <div id="collapse<?=$ArrEsp['idPlanejamentoAuxiliar']?>" class="panel-collapse collapse">
                                    <div class="box-body">
                                      <b><?=$ArrEsp['nomeSetor']?></b><br>
                                      <?=$ArrEsp['planejamentoTipo']?>
                                        <button <?=$inativo?>  class="btn btn-danger pull-right espaco-direita" onclick="postExcluirPlanejamento('excluirPlanejamento', '<?=$ArrEsp['idPlanejamentoAuxiliar']?>')" type="button">
                                                <i class="fa fa-trash"></i>
                                        </button>
                                        &nbsp;<input type="checkbox" disabled="disabled" <?php if($ArrEsp['feriado'] == 1){ echo 'checked'; }?>>Feriado
                                        <input type="checkbox" disabled="disabled" <?php if($ArrEsp['pontoFacult'] == 1){ echo 'checked'; }?>>Ponto Facultativo
                                    </div>
                                  </div>
                                </div>
                             </div>
                          <?php } ?>
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
            </div>
            </div>
        </div>
    </div>
    <!-- /.post -->
</div>
<?php
    //Excluir

    $s1 = array('idBoxImprimir','addClass','hidden');


    $success= array ($s1);
    $dados = array('acao', 'idPlanejamentoAuxiliar');
    postRestAjax('postExcluirPlanejamento','buscaPlanejamento','funcional/planejamentoResult.php',$dados,'',$success);
?>