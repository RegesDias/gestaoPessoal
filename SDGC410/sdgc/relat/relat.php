<?php
session_start();
require_once '../func/fPhp.php';
$buscAcessoNivel = array("4");
$listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao', $buscAcessoNivel);
foreach ($listaAcesso as $valor) {
    if (($valor['link'] == 'soComissionados') AND ( $valor['buscar'] == '1')) {
        $btnSoComissionados = true;
        break;
    }
}
foreach ($listaAcesso as $valor) {
    if (($valor['link'] == 'biometria') AND ( $valor['buscar'] == '1')) {
        $btnBiometria = true;
        break;
    }
}
$_SESSION["relatorio"] = $respGet;
?>
<h1>
    Relatório
    <small><?= $_SESSION["relatorio"][menuN2] ?> <?= $_SESSION["relatorio"][link] ?></small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Relatórios</a></li>
    <li>Relatório</li>
    <li class="active"><?= $_SESSION["relatorio"][menuN2] ?></li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            
            <div class="overlay" id="idSpinLoaderRelat">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            
            <div class="box-header with-border">
                <div class="col-md-12">
                    <h3 class="box-title">Gerar por</h3>          
                </div>
            </div>
            <div class="box-body" id="setor">
                <form action="index.php" method="<?= $method ?>" name="formTemplate">

                    <!-- ************************************************* -->
                    <!-- RADIO Ordenar        || MANIPULADOR POR JAVASCRIPT-->
                    <!-- ************************************************* -->
                    <div class="box-body " id="idBoxRadioOrdenar">
                        <div class="col-md-12">
                            <label>Ordenar:</label>
                            <div class="form-group">
                                <label>
                                    <input type="radio" name="ordenar" value ='nome' class="flat-red" checked>
                                    Nome
                                </label>
                                <label>
                                    <input type="radio" name="ordenar" value ='nome_cargo' class="flat-red">
                                    Cargo
                                </label>
                            </div>                        
                        </div>
                    </div>

                    <!-- ************************************************* -->
                    <!-- RADIO Filtrar        || MANIPULADOR POR JAVASCRIPT-->
                    <!-- ************************************************* -->
                    <div class="box-body " id="idBoxRadioFiltrar">
                        <div class="col-md-12">
                            <label>Filtrar:</label>
                            <div class="form-group">
                                <label>
                                    <input type="radio" name="exibicao" value ='todos' class="flat-red" checked>
                                    Todos
                                </label>
                                <?php if ($btnSoComissionados == true) { ?>
                                    <label>
                                        <input type="radio" name="exibicao" value ='so_comissionado' class="flat-red">
                                        Só Comissionado
                                    </label>
                                <?php } if ($btnBiometria == true) { ?>
                                    <label>
                                        <input type="radio" name="exibicao" value ='biometria' class="flat-red">
                                        Cadastro de Biometria
                                    </label>
                                <?php } ?>
                            </div>                    
                        </div>
                    </div>

                    <!-- ************************************************* -->
                    <!-- RADIO SECRETARIA SETOR|| MANIPULADOR POR JAVASCRIPT-->
                    <!-- ************************************************* -->
                    <div class="box-body hidden" id="idBoxRadio">
                        <div class="col-md-12">
                            <label>Tipo:</label>
                            <div class="form-group">
                                <label>
                                    <input id="idRadioSecretaria" type="radio" name="orby" value ='setor' class="flat-red">
                                    Secretaria
                                </label>
                                <label>
                                    <input id="idRadioSetor" type="radio" name="orby" value ='secretaria' class="flat-red" checked>
                                    Setor
                                </label>
                            </div>                        
                        </div>
                    </div>
                    <!-- ************************* -->
                    <!-- FIM BOX SECRETARIA SETOR -->
                    <!-- ************************* -->




                    <!-- ************************************************* -->
                    <!-- BOX SECRETARIA SETOR || MANIPULADOR POR JAVASCRIPT-->
                    <!-- ************************************************* -->
                    <div id="carregaLot-relat">
                        <div class="box-body" >
                            <div class="row" id="idBoxSelectSecretaria">
                                <div class="col-md-12">
                                    <label>Secretaria</label>
                                    <select name="idSecretaria" size="1"  class="form-control select2" id='idSecretaria' style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                            <!--</div>-->
                            <div class="row" id="idBoxSelectSetor">
                                <div class="col-md-12">
                                    <label>Setor</label>
                                    <select name="idSetor" size="1" class="form-control select2" id="idSetor" style="width: 100%;">

                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- ************************* -->
                    <!-- FIM BOX SECRETARIA SETOR -->
                    <!-- ************************* -->
                    <div class="box-footer pull-right">
<!--                        <input type="hidden" name="pg" value="1"/>
                        <input type="hidden" name="menuN2" value="<?= $_SESSION["relatorio"][menuN2] ?>"/>
                        <input type="hidden" name="menuN3" value="<?= $_SESSION["relatorio"][menuN3] ?>"/>
                        <input type="hidden" name="link" value="<?= $_SESSION["relatorio"][link] ?>"/>
                        <input type="hidden" name="acao" value="menuN2"/>
                        <button class="btn btn-danger pull-right">
                            <i class="fa fa-print"></i> Imprimir
                        </button>
                        <button class="<?=permissaoAcesso($prmLotacao["listar"],'hide')?> btn btn-facebook pull-right btn-sm" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','especialidadeServidor',true)" type="button">
                             <i class="fa fa-eye"></i>
                        </button>-->
                        <input type="hidden" id="idInputIdSetor" value="0"/>
                        <button  class="btn btn-info pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('<?=$_SESSION[relatorio][menuN2]?>','<?=$_SESSION[relatorio][menuN3]?>','<?=$_SESSION[relatorio][link]?>', $('#idSecretaria').val(), $('#idInputIdSetor').val())" type="button">
                             <i class="fa fa-print"></i> Imprimir
                        </button>
                        
                        <button class="btn btn-facebook pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('<?=$_SESSION[relatorio][menuN2]?>','<?=$_SESSION[relatorio][menuN3]?>','<?=$_SESSION[relatorio][link]?>', $('#idSecretaria').val(), $('#idInputIdSetor').val(),true)" type="button">
                             <i class="fa fa-eye"></i> Visualizar
                        </button>

                    </div>


                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
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
        $dados = array('menuN2','menuN3','link','idSecretaria','idSetor','ver');
        postRestAjax('relatorioEmRelatorio','imprimir','print/info.php',$dados,$beforeSend,$success);
    ?>
    