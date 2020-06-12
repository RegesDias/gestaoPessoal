<?php
session_start();
require_once '../func/fPhp.php';
$variaveis = getRest('variaveis/getListaVariaveisDesc');
?>
<h1>
    Relatório
    <small>Listar Variáveis</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Folha Online</a></li>
    <li class="active">Listar Variáveis</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <!--botões de controle-->
            <div class="box-body">

                <div id="carregaLot">
                    <?php require_once '../relat/boxSecretariaSetorSS.php'; ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="idVariaveisDescVL">Variável</label>
                            <select class="form-control select2" name='idVariavel' id='idVariavel' style="width: 100%;">
                                <?php foreach ($variaveis as $ArrEsp) { ?>
                                    <option value="<?= $ArrEsp['id'] ?>"><?= $ArrEsp['nome'] ?></option>
                                <?php
                                }
                                if ($lotAtivo != true) {
                                    echo "<option selected='selected'></option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer pull-right">
                    <button class=" btn btn-info " onclick="relatorioEmGestao('folhaOnListar', $('#idInputSecretaria').val(), $('#idInputSetor').val(), $('#idVariavel').val())" type="button">
                        <i class="fa fa-print"></i> Imprimir
                    </button>
                    <button class=" btn btn-facebook" onclick="relatorioEmGestao('folhaOnListar', $('#idInputSecretaria').val(), $('#idInputSetor').val(), $('#idVariavel').val(), true)" type="button">
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
$dados = array('acao','secretariaID', 'setorID', 'idVariavel', 'ver');
postRestAjax('relatorioEmGestao', 'imprimir', 'print/info.php', $dados, $beforeSend, $success);
?>