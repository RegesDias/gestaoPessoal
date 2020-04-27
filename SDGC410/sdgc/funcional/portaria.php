<?php
   session_start();
   require_once '../func/fPhp.php';
   autoComplete($_SESSION["nomePessoas"], '#nome', '1');

?>
<h1>
    Buscar
    <small>Portarias</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li class="active">Portarias</li>
</ol>
<div class="row">
        <div class="col-md-12">
        <div class="box">

            <div class="box-body">
                <!--<form action="index.php" method="<?=$method?>">-->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Número</label>
                                            <input type="text" id="compNome" name="nome" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Data de Publicação:</label>
                                            <input type="date" id='dataPublicacao' name="dataPublicacao"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer pull-right">
                        <button class="btn btn-primary pull-right btn-sm" onclick="postBuscarPortaria('buscar',$('#compNome').val(),$('#dataPublicacao').val())" type="button">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>
            </div>
        </div>
    </div>
</div>
<div id='buscaPortarias'>
</div>
<?php
//pg
    $dados = array('acao', 'pg');
    postRestAjax('pagUpDown','buscaPortarias','funcional/portariaResult.php',$dados); 
//
//relatorioEmPortariaUser
    $dados = array('acao','portaria','ver');
    postRestAjax('relatorioEmPortariaUser','imprimir','print/info.php',$dados);
//relatorioEmPortariaIm 
    $dados = array('acao','nome','id_portaria','ver');
    postRestAjax('relatorioEmPortariaIm','dados','funcional/portariaResult.php',$dados);
//buscarServidor 
    $dados = array('acao','matricula');
    postRestAjax('buscarServidor','imprimir','funcional/buscaResult.php',$dados);
    
//postBuscarPortaria
    $be = array('idBoxResultado','removeClass','hidden');
    $s2 = array('idBoxDados','removeClass','hidden');
    $beforeSend= array ($be);
    $success = array ($s2);
    $dados = array('acao','nome', 'dataPublicacao');
    postRestAjax('postBuscarPortaria','dados','funcional/portariaResult.php',$dados, $beforeSend, $success);

?>