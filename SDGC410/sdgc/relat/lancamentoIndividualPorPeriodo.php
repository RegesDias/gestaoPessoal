<?php
    session_start();
    require_once '../func/fPhp.php';
if ($respGet['acao'] == "buscar") {
    $cBusc = array($respGet['login'], $respGet['cpf'], $respGet['nome']);
    $lista = getRest('userloginws/getListaUserLoginMult', $cBusc);
    $_SESSION['consolidaPlanejamento']['nome'] = $lista['0']['nome'];
    $_SESSION['consolidaPlanejamento']['login'] = $lista['0']['login'];
    $_SESSION['consolidaPlanejamento']['foto'] = $lista['0']['cpf'];
} elseif($respGet['tab']!='voltar') {
    $_SESSION['consolidaPlanejamento']['nome'] = $_SESSION['user']['nome'];
    $_SESSION['consolidaPlanejamento']['login'] = $_SESSION['user']['login'];
    $_SESSION['consolidaPlanejamento']['foto'] = $_SESSION['user']['cpf'];
}
?>
<h1>
    Relatório
    <small>Lançamento Individual Por Período</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Relatórios</a></li>
    <li class="active">Lançamento Individual</li>
</ol>
<?php
// echo "<pre>";
//    print_r($_SESSION['user']);
// echo "</pre>";
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-md-12">
                    <div class="box box-widget widget-user-2">
                        <div class="widget-user-header bg-aqua">
                            <div class="widget-user-image">
                                <img class="img-bordered-sm" src="<?= exibeFoto($_SESSION['consolidaPlanejamento']['foto']) ?>" alt="User Avatar"><br>
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username"><?= $_SESSION['consolidaPlanejamento']['nome'] ?></h3>
                            <h5 class="widget-user-desc"><?= $_SESSION['consolidaPlanejamento']['login'] ?></h5>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <?php foreach ($consolidados as $valor) { ?>
                                    <li><a href="#"><div class="fa fa-calendar"></div> <?= dataHoraBr($valor['data']) ?> <div class="fa fa-mail-forward"></div> <?= $valor['nomeSetor'] ?><span class="pull-right badge bg-blue">Consolidado</span></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <br>
                            <div class="box-footer no-padding col-md-1"></div>
                            <div class="box-footer no-padding col-md-9">
                                <form action="index.php" method="<?=$method?>" name="formTemplate1">
                                    <div class="box-body">
                                        <label for="exampleInputEmail1">Periodo</label>
                                        <div class="form-group ">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="month" id="idperiodo" name="periodo" class="form-control pull-right">
                                                <div>
                                                </div>
                                            </div>
                                            <br>
                                            <button  class="btn btn-info pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('LancamentoIndividualPorPeriodo','<?=$_SESSION[consolidaPlanejamento][foto]?>',$('#idperiodo').val())" type="button">
                                                 <i class="fa fa-print"></i> Imprimir
                                            </button>
                                            <button class="btn btn-facebook pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('LancamentoIndividualPorPeriodo','<?=$_SESSION[consolidaPlanejamento][foto]?>',$('#idperiodo').val(),true)" type="button">
                                                 <i class="fa fa-eye"></i> Visualizar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    //relatorioEmRelatorio
    $dados = array('acao','cpf','periodo','ver');
    postRestAjax('relatorioEmRelatorio','imprimir','print/info.php',$dados);
?>