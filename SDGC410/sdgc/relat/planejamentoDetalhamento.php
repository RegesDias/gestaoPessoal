<?php

$cBusc = Array('n2'=>$respGet['menuN2'], 'n3'=>$respGet['menuN3']);
$lista = getRest('userMenu/getAcessoRelatorio',$cBusc);

$cBusc = Array('n2'=>$respGet['menuN2'], 'n3'=>$respGet['menuN3'], 'id'=> '0940');
$lista = getRest('userMenu/getAcessoRelatorio',$cBusc);

?>
<h1>
    Relatório
    <small>Detalhamento do Planejamento Por Setor </small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Relatórios</a></li>
    <li class="active">Planejamento</li>
    <li class="active">Detalhamento do Planejamento por Setor  </li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-md-12">
                    <h3 class="box-title">Selecionar Setor</h3>          
                </div>
            </div>
            <!--botões de controle-->
            <div class="box-body">
                <form action="index.php" method="<?=$method?>" name="formTemplate">
                    <div id="carregaLot">
                        <?php require_once 'boxSecretariaSetor.php'; ?>
                    </div>
                    
                    <div class="box-footer pull-right">
                        <input type="hidden" name="pg" value="1"/>
                        <input type="hidden" name="pst" value="print"/>
                        <input type="hidden" name="arq" value="info"/>
                        <input type="hidden" name="relat" value="planejamentoDetalhamento"/>
                        <input type="hidden" name="varq" value="planejamentoDetalhamento"/>
                        <input type="hidden" name="vpst" value="relat"/>
                        <input type="hidden" name="acao" value="planejamentoDetalhamento"/>
                        <button type="submit" class="btn btn-default">Gerar</button>
                    </div>
                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
</div>