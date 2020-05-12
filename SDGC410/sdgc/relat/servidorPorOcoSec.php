<?php
    session_start();
    require_once '../func/fPhp.php';
    $listaCargosGeral = getRest('cargo/getListaCargoGeralUsuario');
    $listaLotacao = getRest('lotacao/getListaLotacaoUsuario');
    $ocorrenciaDesc = getRest('funcionalws/getListaOcorrenciaDesc');
?>
<h1>
    Relatório
    <small>Lotados por secretaria</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Relatórios</a></li>
    <li>Gestão</li>
    <li class="active">Lotados por secretaria</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form action="index.php" method="<?=$method?>" name="formTemplate">   
                    <div class="box-body">
                        <div class="row">
                            <div>
                                <div class="col-md-12">
                                    <label>Secretaria</label>
                                    <select multiple name="idSec" id='idSec' size="1"  class="form-control select2"  style="width: 100%;">
                                        <?php foreach ($listaLotacao as $valor) { ?>
                                        <option value="<?=$valor['id']?>"><?=$valor['nome']?></option>
                                        <?php  } ?>
                                    </select>
                                    <label>Ocorrência</label>
                                    <select multiple name="idOco" id='idOco' size="1"  class="form-control select2"  style="width: 100%;">
                                        <?php foreach ($ocorrenciaDesc as $valor) { ?>
                                        <option value="<?=$valor['idOcorrencia']?>"><?=$valor['nome']?></option>
                                        <?php  } ?>
                                    </select>
                                    <label>Período</label>
                                    <input class="form-control" type="month" id="idPeriodo" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer pull-right">
                        <button class="btn btn-info pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('ocoQuantitativo',$('#idSec').val(),$('#idOco').val(),$('#idPeriodo').val())" type="button">
                             <i class="fa fa-print"></i> Imprimir
                        </button> 
                        <button class="btn btn-facebook pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('ocoQuantitativo',$('#idSec').val(),$('#idOco').val(),$('#idPeriodo').val(),true)" type="button">
                             <i class="fa fa-eye"></i> Visualizar
                        </button>
                    </div>
                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
</div>
    <?php
        $dados = array('acao','secretaria','ocorrencia','mesAno');
        postRestAjax('relatorioEmRelatorio','imprimir','print/info.php',$dados);
    ?>