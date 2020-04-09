<?php
foreach ($respData as $data) {
    if ($data[id] == 300){
         $dataPeriodoFolha = $data[dataFrequencia];
         break;
    }
}
//echo "Data: ".$dataPeriodoFolha;
$_SESSION['dataPeriodoFolha'] = $dataPeriodoFolha;
?>
<div class="tab-pane <?= tabId('variaveis', $respGet['tab']) ?>" id="variaveis">
    <div class="post clearfix">
        <div class="box box-primary">
            

            
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
<!--                        <form action="index.php" method="<?=$method?>" class="inline">
                                <input type="hidden" name="relat" value="VariaveisLancamentos"/>
                            <input type="hidden" name="acao" value="VariaveisLancamentos"/>
                                <input type="hidden" name="idhistfunc" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                <input type="hidden" name="periodofolha" value="<?=$_SESSION['dataPeriodoFolha']?>"/>
                                <input type="hidden" name="pg" value="1"/>
                                <button type="submit" class="btn btn-info" id="idLancamentos">
                                    <i class="fa fa-print"></i><b> Lançamentos</b>
                                </button>-->
                                <button id="idLancamentos"  class="btn btn-facebook pull-right btn-sm espaco-direita" onclick="relatorioEmVariaveis('VariaveisLancamentos','<?= $_SESSION['funcionalBusca']['id'] ?>','<?=$_SESSION['dataPeriodoFolha']?>',true)" type="submit">
                                    <i class="fa fa-print"></i> Lançamentos</button>
                                </button>
<!--                        </form>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>
        <div>
        <form action="index.php" method="<?=$method?>">
            <div class="box">
                <div class="overlay hidden" id="idSpinLoaderLancarVariaveis">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="box-body">
                    <?php require_once 'lancaVariaveisLote.php'; ?>
<!--                    <input type="hidden" name="tab" value="variaveis">
                    <input type="hidden" name="acao" value="lancarVariaveis">-->
<!--                    <button <?=$inativo?> type="submit" class="btn btn-info pull-right  btn-sm"><i class="fa fa-edit"></i> Lançar</button>-->
                    
                    <button id="idBtnLancarVariaveis" class="btn btn-info pull-right  btn-sm" onclick="incluirVariavel('lancarVariaveis', $('#idSetorVL').val() , $('#idVariaveisDescVL').val(), $('#idQuantidadeVL').val(), $('#idValorVL').val())" type="button">
                       <i class="fa fa-edit"></i> Lançar
                   </button>
                </div>
            </div>
        </form>
        <div id="buscaVariaveis">
            
        </div>
        </div>
          <!-- /.box -->          
            </div>
            <!-- /.post -->
        </div>
<?php 
    //exibir
    $dados = null;
    postRestAjax('buscaVariaveis','buscaVariaveis','funcional/variaveisResult.php',$dados,$beforeSend,$success);
    
    //incluirVariaveis
    $be = array('idSpinLoaderLancarVariaveis','removeClass','hidden');
    $s1 = array('idBoxImprimir','addClass','hidden');
    $s2 = array('idSpinLoaderLancarVariaveis','addClass','hidden');
    $beforeSend= array ($be);
    $success= array ($s1,$s2);
    $dados = array('acao', 'idSetorVL','idVariaveisDescVL','idQuantidadeVL','idValorVL');
    //$dados = array('acao', 'idAvaliacao');
    postRestAjax('incluirVariavel','buscaVariaveis','funcional/variaveisResult.php',$dados,$beforeSend,$success);
    
    //imprimirVariaveis
    $dados = array('acao','idHistorioFunc','dataPeriodoFolha','ver');
    postRestAjax('relatorioEmVariaveis','imprimir','print/info.php',$dados);

?>
<script>
    configuraTela(); 
</script>
