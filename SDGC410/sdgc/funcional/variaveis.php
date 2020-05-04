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
                                <button id="idLancamentos"  class="btn btn-facebook pull-right btn-sm espaco-direita" onclick="relatorioEmVariaveis('VariaveisLancamentos','<?= $_SESSION['funcionalBusca']['id'] ?>','<?=$_SESSION['dataPeriodoFolha']?>',true)" type="submit">
                                    <i class="fa fa-print"></i> Lançamentos</button>
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
        <form action="index.php" method="<?=$method?>">
            <div class="box">
                <div class="box-body">
                    <?php require_once 'lancaVariaveis.php'; ?>
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

    $s1 = array('idBoxImprimir','addClass','hidden');

    $success= array ($s1);
    $dados = array('acao', 'idSetorVL','idVariaveisDescVL','idQuantidadeVL','idValorVL');
    //$dados = array('acao', 'idAvaliacao');
    postRestAjax('incluirVariavel','buscaVariaveis','funcional/variaveisResult.php',$dados,'',$success);
    
    //imprimirVariaveis
    $dados = array('acao','idHistorioFunc','dataPeriodoFolha','ver');
    postRestAjax('relatorioEmVariaveis','imprimir','print/info.php',$dados);

?>
<script>
    configuraTela(); 
</script>
