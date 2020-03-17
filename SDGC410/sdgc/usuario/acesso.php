<?php
//configuração
    $pst = 'usuario';
    $arq = 'acesso';
    $n0 = 'id';             $c0 = $respGet['id'];
    $n1 = 'login';      $c1 = $respGet['login'];
    $n2 = 'cpf';          $c2 = $respGet['cpf'];
    $n3 = 'nome';           $c3 = $respGet['nome'];
    $cBusc = array($c1,$c2,$c3);
    $cData = array($n0 => $c0, $n1 => $c1, $n2 => $c2);
    $cExcl = array($n0 => $c0);
    $rest = ucfirst($arq);
//paginacao
    $hrefPag= array(
                "<input type='hidden' name='pst' value ='".$pst."'/>",
                "'arq' value='".$arq."'/>",
                "'orby' value='".$respGet['orby']."'/>",
                "'dir' value='".$respGet['dir']."'/>",
                "'$n1' value='".$c1."'/>",
                "'$n2' value='".$c2."'/>"
    );
//buscar
    if ($respGet['acao'] == "buscar") {
        $lista = getRest('userloginws/getListaUserLoginMult',$cBusc);
        session_start();
        $_SESSION["lista"] = $lista;
        $_SESSION["totalLista"] = count($_SESSION["lista"]);
        if(!isset($msnTexto)){
            $msnTexto = "ao Buscar. <br>Total de ".$_SESSION["totalLista"]." encontrado(s)";
        }
        $totalBusca = count($lista);
            if ($totalBusca == 0) {
                $exec['info'] = 400;
            }else{
                $exec['info'] = 200;
            }
    }
    if ($respGet['acao'] == "limparSessao") {
        $_SESSION['appv'] = getRest('appversao/getListaAppVersao');
    }
//ordenar
    $campo = $respGet['orby'];
    $sinal = 'up';
    $return = ordernarPor($_SESSION['lista'], $respGet);
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
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
        <form action="index.php" method="<?=$method?>">
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
                            <input type="text" name="login"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">CPF</label>
                            <input type="text" name="cpf" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer pull-right">
                <input type="hidden" name="pg" value="1"/>
                <input type="hidden" name="pst" value="<?= $pst ?>"/>
                <input type="hidden" name="arq" value="<?= $arq ?>"/>
                <input type="hidden" name="tabela" value="buscar" />
                <input type="hidden" name="acao" value="buscar" />
                <button type="submit" class="btn btn-default">Buscar</button>
            </div>
        </form>
    </div>
</div>
<?php if ($_SESSION["totalLista"] >= 1){?>
<div class="row">
    <div class="box-body">
        <div class="box">
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <?php exibePag($hrefPag, $respGet, $return); ?>
            </ul>
        </div>
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <!-- Post -->

                      <?php
                        foreach ($return['pgExb'] as $valor) {
                            $ultimoLogin = array($valor['id']);
                            $ultimoLogin = getRest('userloginws/getDataHoraUltimoLog',$ultimoLogin);
                            if($ultimoLogin[0] == ''){
                                $ultimoLogin[0] = 'Usuário não posssui requistro';
                            }else{
                                $ultimoLogin[0] = dataHoraBr($ultimoLogin[0]);
                            }
                            $cpf = $valor['cpf'];
                            if($respGet['pg'] ==''){
                                $pg=1;
                            }else{
                                $pg=$respGet['pg']; 
                            }
                            $vaiPerfil = "acao=buscar&pst=$pst&arq=perfil&cpf=$cpf&pg=$pg";
                        ?>
                        <div class="post">
                            <div class="row">
                                <div class="user-block">
                                    <a href="#">
                                        <img src="<?=exibeFoto($valor['cpf'])?>" class="img-circle img-bordered-sm" alt="Imagem do Usuário">
                                    </a>
                                    <span class="username">
                                        <form method="<?=$method?>" action="index.php" class="inline">
                                            <input type="hidden" name="acao" value="buscar" />
                                            <input type="hidden" name="pst" value="usuario"/>
                                            <input type="hidden" name="arq" value="perfil"/>
                                            <input type="hidden" name="cpf" value="<?=$valor['cpf']?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <button type="submit" class="link-button">
                                              <?=$valor['cpf']?>
                                            </button>
                                        </form>
                                        <?=$valor['login']?>
                                        <form method="<?=$method?>" action="index.php" class="inline">
                                            <input type="hidden" name="acao" value="buscar" />
                                            <input type="hidden" name="pst" value="usuario"/>
                                            <input type="hidden" name="arq" value="perfil"/>
                                            <input type="hidden" name="cpf" value="<?=$valor['cpf']?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <button type="submit" class="pull-right btn-social-icon btn-box-tool btn btn-primary">
                                              <i class="fa fa-edit"></i>
                                            </button>
                                        </form>
                                    </span>
                                    <span class="description"><?=$valor['nome']?></span>
                                    <span class="description">Último acesso: <?=$ultimoLogin[0]?></span>
                                </div>
                            </div>
                            </div>
                        <?php }?>
                         </div>
                    </div>
                </div>
            </div>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <?php exibePag($hrefPag, $respGet, $return); ?>
            </ul>
        </div>
        </div>
    </div>
</div>
<?php }?>
