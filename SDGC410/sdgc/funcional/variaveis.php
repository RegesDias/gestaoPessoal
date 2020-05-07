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
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Lançar Variáveis</h3>
                        </div>
                        <div class="box-body">
                            <div class="box-body">
                                <div class="box-body">
                                        <div class="col-md-12">
                                             <label for="idVariaveisDescVL">Setor</label>
                                                <select <?= $inativo ?> id="idLotacaoSubVariaveis" name="idLotacaoSubVariaveis" onchange="carregarVariaveisTipo('variavelTipo',$('#idLotacaoSubVariaveis').val())"  size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                                                    <option>--</option>
                                                    <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp) { ?>
                                                        <option value="<?= $ArrEsp['idSetor'] ?>"><?= $ArrEsp['nome'] ?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                        <div id='carregarVariaveisTipo'>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
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
    postRestAjax('buscaVariaveis','buscaVariaveis','funcional/variaveisResult.php');
    
    //incluirVariaveis
    $s1 = array('idBoxImprimir','addClass','hidden');
    $success= array ($s1);
    $dados = array('acao', 'idSetorVL','idVariaveisDescVL','idQuantidadeVL','idValorVL');
    postRestAjax('incluirVariavel','buscaVariaveis','funcional/variaveisResult.php',$dados,'',$success);
    
    //imprimirVariaveis
    $dados = array('acao','idHistorioFunc','dataPeriodoFolha','ver');
    postRestAjax('relatorioEmVariaveis','imprimir','print/info.php',$dados);

    $dados = array('acao','idLotacaoSub');
    postRestAjax('carregarVariaveisTipo','carregarVariaveisTipo','funcional/lancaVariaveisTipo.php',$dados);
    $dados = array('acao','idVariaveisDescVL','idLotacaoSub');
    postRestAjax('carregarVariavel','carregarVariaveisTipo','funcional/lancaVariaveisTipo.php',$dados);
?>
<script>
    configuraTela(); 
</script>
