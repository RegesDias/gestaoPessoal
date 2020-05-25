<?php

    session_start();
    $_SESSION['user']['trocarSenha'] = 0;
    require_once 'func/fPhp.php';
    if($method =='get'){
        $respGet = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    }else if($method =='post'){
        $respGet = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    }

//ALTERAR SENHA
    if ($respGet['acao'] == "alterarSenha") {
        $cBusc = array($_SESSION['user']['login'],$respGet['senha']);
        $lista = getRest('userloginws/getListaUserLogin',$cBusc);
        $acesso = count($lista);
        if($acesso >= 1){
            session_start();
            $_SESSION['user']=$lista;
            $_SESSION['user']['trocarSenha'] = 0;
            if($respGet['novaSenha'] == $respGet['confirmaNovaSenha']){
                $idTemplate = array(
                    'idUserLogin'=>$_SESSION["perfilUsuario"] ['0']['id'],
                    'novaSenha'=>$respGet['novaSenha']
                );
                $exec= postRest('userloginws/postAlterarSenha',$idTemplate);
                $msnTexto = ' ! '.$exec['msn'];
                if (($exec['info'] >= 200) AND ($exec['info'] <= 299)){
                    ?><meta http-equiv="refresh" content=1;url="index.php"><?php
                }
            }else{
                $exec['info'] = 400;
                $msnTexto = "Senhas não coincidem";
            }
        }else{
            $msnTexto = "Usuário ou senha incorretos";
            $exec['info'] = 400;
        }

    }
//echo'<pre>';
//    print_r($_SESSION['user']);
//echo'</pre>';
?>
<!DOCTYPE html>
<html>
 <?php require_once 'incl/head.php';?>
    <body class="hold-transition login-page"  oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..message perso .. '; return true;">
        <div class="login-box">
          <div class="login-logo">
            <img src="img/logoMenuPreto.png" class="img-rounded"><strong class="logo-sdgc">SDGC</strong><sub><i><?=$versaoSDGC?></i></sub>
          </div>
            <?php exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);?>
          <div class="login-box-body">
            <p class="login-box-msg">Trocar senha de acesso</p>
            <form name="login" method="<?=$method?>" action="trocasenha.php">
                <div class="form-group has-feedback">
                  <input type="text" name="nomeUser" class="form-control" placeholder="Chave do usuario" disabled="disabled" value="<?=$_SESSION['user']['login']?>">
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="password" name="senha" class="form-control" placeholder="Senha atual">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="password" name="novaSenha" class="form-control" placeholder="Nova senha">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="password" name="confirmaNovaSenha" class="form-control" placeholder="Confirmar senha">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                  </div>
                  <div class="col-xs-6">
                    <input type="hidden" name="acao" value="alterarSenha">
                    <button type="submit" class="btn btn-primary btn-block">OK</button>
                  </div>
                  <div class="col-xs-6">
                    <input type="hidden" name="acao" value="alterarSenha">
                    <a href="index.php" class="btn btn-default btn-block right" >VOLTAR</a>
                  </div>
                </div>
            </form>
          </div>
        </div>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="dist/js/adminlte.min.js"></script>
    </body>
</html>
