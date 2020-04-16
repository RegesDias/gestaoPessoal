<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
//buscar
    if ($respGet['acao'] == "buscar") {
        $cBusc = array($respGet[login],$respGet[cpf],$respGet[nome]);
        $lista = getRest('userloginws/getListaUserLoginMult',$cBusc);
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
    $return = ordernarPor($_SESSION['lista'], $respGet);
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
?>
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
                                        </form>
                                        <button class="pull-right btn-social-icon btn-box-tool btn btn-primary" onclick="perfilBusca('buscar','<?=$valor[cpf]?>')" type="button">
                                            <i class="fa fa-edit"></i>
                                        </button>
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
