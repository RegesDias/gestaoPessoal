<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $_SESSION[getListaCargoGeral] = getRest('cargo/getListaCargoGeral');
?>
<h1>
    Atribuições Típicas de Cargos
    <small>Gerenciar</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Atribuições</a></li>
    <li class="active">Cargo</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="col-md-8">
                    <h3 class="box-title"></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nome Cargo</label>
                            <input type="text" id="nome" name="nome" value="<?= $respGet['nome'] ?>" class="form-control">
                        </div>
                    </div>
                  </div>
                </div>                    
                <div class="box-footer pull-right">
                    <button class="btn" onclick="buscaCargoGeral('buscaCargoGeral')" type="button">
                        <i class="fa fa-eraser"></i> limpar
                    </button>
                    <button class="btn btn-success" onclick="buscaCargoGeral('buscaCargoGeral',$('#nome').val())" type="button">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </div>
            </div>
            <div id="idCargoGeral">
            </div>
        </div>
    </div>
</div>
<?php 
    $dados = array('acao', 'nome');
    postRestAjax('buscaCargoGeral','idCargoGeral','tabela/atribuicoesTipicasCargoResult.php',$dados); 
    
    $dados = array('acao','id' ,'nome', 'desAtribuicao', 'idAtribuicao');
    postRestAjax('cadastraAtribuicao','idCargoGeral','tabela/atribuicoesTipicasCargoCad.php',$dados); 
    //pg
    $dados = array('acao', 'pg');
    postRestAjax('pagUpDown','idCargoGeral','tabela/atribuicoesTipicasCargoResult.php',$dados); 
 ?>
<script>
    window.onload = buscaCargoGeral('todos');
</script>