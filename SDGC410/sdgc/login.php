<?php
    require_once 'func/fPhp.php';
    if($method =='get'){
        $respGet = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    }else if($method =='post'){
        $respGet = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    }
    session_start();
    if($respGet['verLogin'] == 1){
        $cBusc = array($respGet['nomeUser'],$respGet['senhaUser']);
        $lista = getRest('userloginws/getListaUserLogin',$cBusc);
        $acesso = count($lista);
        if($acesso >= 1){
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['user']=$lista;
            $listaNomes = getRest('pessoa/getListaPessoa/');
            $_SESSION["nomePessoas"] = $listaNomes;
            $_SESSION['foto'] = exibeFoto($_SESSION['user']['cpf']);
            print_p($_SESSION['user']['cpf']);
            //liberar menus Left/
                $_SESSION["menuLeft"]=getRest('userMenu/getListaUserMenuLeft/');
            //liberar menus
                $_SESSION["menuRight"]=getRest('userMenu/getListaUserMenuRight/');
            if($_SESSION['user']['trocarSenha'] == 1){
                header('Location: trocasenha.php');
            }else{
                header('Location: index.php');
            }
            
        }else{
            $msnTexto = "Usuário ou senha incorretos";
            $exec['info'] = 400;
        }
    }
//echo '<pre>';
//    print_r($_SESSION['user']);
//echo '</pre>';
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
            <p class="login-box-msg">Clique em entrar para iniciar seu acesso</p>
             <form name="login" method="<?=$method?>" action="login.php">
                <div class="form-group has-feedback">
                  <input type="text" name="nomeUser" class="form-control" placeholder="Chave de usuário">
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <input type="password" name="senhaUser" class="form-control" placeholder="Senha">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                  </div>
                  <div class="col-xs-4">
                    <input type="hidden" name="verLogin" value="1">
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                  </div>
                </div>
            </form>
            <!--<a href="#">Eu esqueci minha senha</a><br>-->
            <br>
             Para requisição de acesso é necessário encaminhamento de ofício digital com o seguinte formulário:
             <center><a href="doc/FORMULARIO_ACESSO.pdf" download><b> Formulário de requisição de acesso </b></a><br></center>
          </div>
        </div>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="dist/js/adminlte.min.js"></script>
    </body>
</html>
