<?php
//configuração
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);

?>
<h1>
    Usuário
    <small>Cadastrar</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Usuário</a></li>
    <li class="active">Usuário - Cadastrar </li>
</ol>
<div class="row">
    <div class="col-md-3"></div>
            <div class="modal-content col-md-6">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Preencha todos os Campos</h4>
                </div>
                <div class="modal-body col-md-12">
                    <div class="col-md-12">
                        <label>Nome Completo</label>
                        <input name="nomeCompleto" id="nomeCompleto" value="<?=$respGet['nomeCompleto']?>" class="form-control" type="text">
                    </div>
                    <div class="col-md-12">
                        <label>Chave</label>
                        <input name="chave" id="chave" value="<?=$respGet['chave']?>" class="form-control" type="text">
                    </div>
                    <div class="col-md-12">
                        <label>CPF</label>
                        <input name="cpf" id="cpf" value="<?=$respGet['cpf']?>" class="form-control" type="text">
                    </div>
                    <div class="col-md-12"><br></div>
                    <div class="col-md-12">
                        <button class="btn btn-primary" onclick="cadastrarUsuario('cadastarUsuario',$('#nomeCompleto').val(),$('#chave').val(),$('#cpf').val())" type="button">
                            Cadastrar
                        </button>
                    </div>
                </div>
            </div>
</div>
<div id='cadastro'>
</div>
<br>
<?php
    $dados = array('acao','nomeCompleto','chave', 'cpf');
    postRestAjax('cadastrarUsuario','cadastro','usuario/acessoPerfil.php',$dados);  
?>