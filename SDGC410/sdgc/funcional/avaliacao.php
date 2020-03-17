<div class="tab-pane <?= tabId('avaliacao', $respGet['tab']) ?>" id="avaliacao">
    <div class="post clearfix">
        <div class="box box-primary">
            <div class="overlay hidden" id="idSpinLoaderAvaliacao">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <button id="idBtnImprimir"  class="btn btn-info" onclick="relatorioEmAvaliacao('avaliacaoFicha',$('#idLotSubAvaliacao').val(),'<?= $_SESSION['funcionalBusca']['id']?>')" type="submit">
                            <i class="fa fa-print"></i><b> Ficha de avaliação</b>
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>
        
        <div id="buscaAvaliacao">
            
        </div>
        
    </div>
</div>
<?php

    //exibir
    $be = array('idSpinLoaderAvaliacao','removeClass','hidden');
    $s1 = array('idBoxImprimir','addClass','hidden');
    $s2 = array('idSpinLoaderAvaliacao','addClass','hidden');
    $beforeSend= array ($be);
    $success= array ($s1,$s2);
    $dados = null;
    postRestAjax('buscaAvaliacao','buscaAvaliacao','funcional/avaliacaoResult.php',$dados,$beforeSend,$success);

?>
