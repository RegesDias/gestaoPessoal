<?php
    session_start();
    require_once '../func/fPhp.php';
    $buscAcessoNivel = array("4");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'soComissionados') AND ($valor['buscar'] == '1')){ 
             $btnSoComissionados = true;
             break;
        }
    }
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'biometria') AND ($valor['buscar'] == '1')){ 
             $btnBiometria = true;
             break;
        }
    }
    $listaCargosGeral = getRest('cargo/getListaCargoGeralUsuario');
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
                                    <label>Cargo</label>
                                    <select name="idCargoGeral" size="1"  class="form-control select2" id='idCargoGeral' style="width: 100%;">
                                        <?php foreach ($listaCargosGeral as $valor) { ?>
                                        <option value="<?=$valor['id']?>"><?=$valor['nome']?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer pull-right">
                        <input type="hidden" id="idInputIdSetor" value="0"/>
                        <button  class="btn btn-info pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('ServidoresPorCargoGeral', $('#idCargoGeral').val())" type="button">
                             <i class="fa fa-print"></i> Imprimir
                        </button>
                        
                        <button class="btn btn-facebook pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('ServidoresPorCargoGeral', $('#idCargoGeral').val(),true)" type="button">
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
        require_once "../javascript/fRelat.php";
        //relatorioEmRelatorio
        $be = array('idSpinLoaderGestao','removeClass','hidden');
        $s = array('idSpinLoaderGestao','addClass','hidden');
        $beforeSend= array ($be);
        $success= array ($s);
        $dados = array('acao','idCargoGeral','ver');
        postRestAjax('relatorioEmRelatorio','imprimir','print/info.php',$dados,$beforeSend,$success);
    ?>