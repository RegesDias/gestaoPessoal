<?php
session_start();
require_once '../func/fPhp.php';
autoComplete($_SESSION["nomePessoas"], '#nome', '1');
?>
<h1>
    Relatório
    <small>Folha de ponto em lote por setor</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li class="active">Folha de ponto</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-md-12">
                    <h3 class="box-title">Ordenar por</h3>          
                </div>
            </div>
            <!--botões de controle-->
            <div class="box-body">
                    <div id="carregaLot">
                    <?php require_once '../relat/boxSecretariaSetor.php'; ?>
                    </div>
                    <div class="box-footer pull-right">
                        <button class=" btn btn-info " onclick="relatorioEmGestao('folhaDePontoEmLote',$('#idSetor').val())" type="button">
                             <i class="fa fa-print"></i> Imprimir
                        </button>
                        <button class=" btn btn-facebook" onclick="relatorioEmGestao('folhaDePontoEmLote',$('#idSetor').val(),true)" type="button">
                             <i class="fa fa-eye"></i> Visualizar
                        </button>
                    </div>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
</div>
<?php
    $dados = array('acao','dado','ver');
    postRestAjax('relatorioEmGestao','imprimir','print/info.php',$dados,$beforeSend,$success);
?>