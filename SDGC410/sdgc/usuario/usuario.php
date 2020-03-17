<?php
//configuração
    $pst = 'usuario';
    $arq = 'perfil';
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
//redireciona
//echo'<pre>';
//    print_r($respPost);
//echo'</pre>';

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
                   <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Nome Completo</label>
                                <input name="nomeCompleto" value="<?=$respGet['nomeCompleto']?>" class="form-control" type="text">
                            </div>
                            <div class="col-md-12">
                                <label>Chave</label>
                                <input name="chave" value="<?=$respGet['chave']?>" class="form-control" type="text">
                            </div>
                            <div class="col-md-12">
                                <label>CPF</label>
                                <input name="cpf" value="<?=$respGet['cpf']?>" class="form-control" type="text">
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <input type="hidden" name="acao" value="cadastarUsuario">
                                <input type="hidden" name="pst" value="<?= $pst ?>">
                                <input type="hidden" name="arq" value="<?= $arq ?>">
                                <input type="submit" class="btn btn-primary" value='Cadastrar'>
                            </div>
                        </div>
                    </form>
            </div>
</div><br>
