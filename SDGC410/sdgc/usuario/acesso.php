<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
//Auto complete
    autoComplete($_SESSION["nomePessoas"],'#compNome','1');
?>
<h1>
    Acesso
    <small>Editar/Cadastrar</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Usuário</a></li>
    <li class="active">Acesso - Editar/Cadastrar</li>
</ol>
<div class="box"> 
    <div class="box-body">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome</label>
                            <input type="text" id="compNome" name="nome" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Login</label>
                            <input type="text" name="login"  id="login" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer pull-right">
                <button class="btn btn-primary" onclick="acessoBusca('buscar','1',$('#compNome').val(),$('#login').val(),$('#cpf').val())" type="button">
                    Buscar
                </button>
            </div>
    </div>
    <div id='acessoBusca'>
        carregando...
    </div>
</div>
<?php
    $dados = array('acao', 'pg','nome','login','cpf' );
    postRestAjax('acessoBusca','acessoBusca','usuario/acessoBusca.php',$dados); 
    
    $dados = array('acao','cpf' );
    postRestAjax('perfilBusca','acessoBusca','usuario/perfil.php',$dados); 
    
    $dados = array('acao','valorStatus' );
    postRestAjax('perfilBloquear','acessoBusca','usuario/perfil.php',$dados); 
    
?>