<?php
//configuração
    $pst = 'tabela';
    $arq = 'cargo';
    $n0 = 'id';             $c0 = $respGet['id'];
    $n1 = 'nome';           $c1 = $respGet['nome'];
    $n2 = 'horaSemanal';    $c2 = $respGet['horaSemanal'];
    $cBusc = array($c1,$c2);
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
//incluir
    if ($respGet['acao'] == "incluir") {
        $exec = postRest($arq.'/postIncluir'.$rest, $cData);
        $msnTexto = "ao incluir.";
        $respGet['acao'] = "buscar";
        $respGet['tabela'] = false;
    }
//remover
    if ($respGet['acao'] == "remover") {
        $exec = postRest($arq.'/postRemover'.$rest, $cExcl);
        $msnTexto = "ao remover.";
        $respGet['acao'] = "buscar";
    }
//alterar
    if ($respGet['acao'] == "alterar") {
        $exec = postRest($arq.'/postAlterar'.$rest, $cData);
        $msnTexto = "ao alterar.";
        $respGet['acao'] = "buscar";
    }
//buscar
    if ($respGet['acao'] == "buscar") {
        $lista = getRest($arq.'/getLista'.$rest.'Mult',$cBusc);
        session_start();
        $_SESSION["lista"] = $lista;
        if(!isset($msnTexto)){
            $msnTexto = "ao Buscar.";
        }
        $totalBusca = count($lista);
            if ($totalBusca == 0) {
                $exec['info'] = 400;
            }else{
                $exec['info'] = 200;
            }
    }
//listar
    if (($respGet['acao'] != "ordenar") and ($totalBusca == 0)) {
        $lista = getRest($arq.'/getLista'.$rest);
        session_start();
        $_SESSION["lista"] = $lista;
        $_SESSION["autoCompleteNome"] = $lista;
    }
    $campo = $respGet['orby'];
    $sinal = $respGet['dir'];
    $return = ordernarPor($_SESSION['lista'], $respGet);
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
//Auto complete
    autoComplete($_SESSION["autoCompleteNome"],'#compNome','nome');
?>
<h1>
    Cargos
    <small>Gerenciar</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> <?=$pst?></a></li>
    <li class="active"><?=$arq?></li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="col-md-8">
                    <h3 class="box-title"></h3>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <form method="<?=$method?>" action="index.php" class="inline">
                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                            <input type="hidden" name="pg" value="1" />
                            <input type="hidden" name="tabela" value="limpar" />
                            <button type="submit" class="btn btn-social-icon btn-bitbucket">
                              <i class="fa fa-list-ul"></i>
                            </button>
                        </form>
<!--                        <a rel="tooltip" title="Limpar ação" class="btn btn-social-icon btn-bitbucket" href="index.php?pst=<?=$pst?>&arq=<?=$arq?>&pg=1&tabela=limpar">
                            <i class="fa fa-list-ul"></i>
                        </a>-->
                        <form method="<?=$method?>" action="index.php" class="inline">
                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                            <input type="hidden" name="pg" value="1" />
                            <input type="hidden" name="tabela" value="incluir" />
                            <button type="submit" class="btn btn-social-icon btn-bitbucket">
                              <i class="fa fa-save"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-body">
            <!--fim botões-->
            <!--Formulario de busca, inclusão e alteração-->
                <form action="index.php" method="<?=$method?>">
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" id="compNome" name="nome" value="<?= $respGet['nome'] ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hora Semanal</label>
                                <input type="text" name="horaSemanal" value="<?= $respGet['horaSemanal'] ?>" class="form-control">
                            </div>
                        </div>
                      </div>
                    </div>                    
                    <div class="box-footer pull-right">
                        <input type="hidden" name="id" value="<?= $respGet['id'] ?>" class="form-control">
                        <input type="hidden" name="pg" value="1"/>
                        <input type="hidden" name="pst" value="<?=$pst?>"/>
                        <input type="hidden" name="arq" value="<?=$arq?>"/>
                        <?php if ($respGet['tabela'] == "incluir") { ?>
                            <input type="hidden" name="tabela" value="incluir" />
                            <input type="hidden" name="acao" value="incluir" />
                            <button type="submit" class="btn btn-default">Cadastrar</button>
                        <?php } else if ($respGet['tabela'] == "alterar") { ?>
                            <input type="hidden" name="tabela" value="alterar"/>
                            <input type="hidden" name="acao" value="alterar"/>
                            <button type="submit" class="btn btn-default">Alterar</button>
                        <?php } else { ?>
                            <input type="hidden" name="tabela" value="buscar" />
                            <input type="hidden" name="acao" value="buscar" />
                            <button type="submit" class="btn btn-default">Buscar</button>
                        <?php } ?>
                    </div>
                </form>
            <!--Fim do formulario-->
            <!--Tabela que mostra valores buscados-->
                <?php if (!($respGet['tabela'] == "incluir")) { ?>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin">
                            <?php exibePag($hrefPag, $respGet, $return); ?>
                        </ul>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th class='hidden-xs' style="width: 10%">
                                id
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="orby" value="id" />
                                    <input type="hidden" name="dir" value="up" />
                                    <input type="hidden" name="acao" value="ordenar" />
                                    <button type="submit" class="link-button">
                                      <i class="fa fa-arrow-up"></i>
                                    </button>
                                </form>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="orby" value="id" />
                                    <input type="hidden" name="dir" value="down" />
                                    <input type="hidden" name="acao" value="ordenar" />
                                    <button type="submit" class="link-button">
                                      <i class="fa fa-arrow-down"></i>
                                    </button>
                                </form>
                            </th>
                            <th style="width: 40%">
                              Nome
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="orby" value="nome" />
                                    <input type="hidden" name="dir" value="up" />
                                    <input type="hidden" name="acao" value="ordenar" />
                                    <button type="submit" class="link-button">
                                      <i class="fa fa-arrow-up"></i>
                                    </button>
                                </form>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="orby" value="nome" />
                                    <input type="hidden" name="dir" value="down" />
                                    <input type="hidden" name="acao" value="ordenar" />
                                    <button type="submit" class="link-button">
                                      <i class="fa fa-arrow-down"></i>
                                    </button>
                                </form>
                            </th>
                            <th style="width: 10%">
                             H/S
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="orby" value="horaSemanal" />
                                    <input type="hidden" name="dir" value="up" />
                                    <input type="hidden" name="acao" value="ordenar" />
                                    <button type="submit" class="link-button">
                                      <i class="fa fa-arrow-up"></i>
                                    </button>
                                </form>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="orby" value="horaSemanal" />
                                    <input type="hidden" name="dir" value="down" />
                                    <input type="hidden" name="acao" value="ordenar" />
                                    <button type="submit" class="link-button">
                                      <i class="fa fa-arrow-down"></i>
                                    </button>
                                </form>
                            </th>
                            <th class='hidden-xs' style="width: 10%">
                              Controle
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="orby" value="controle" />
                                    <input type="hidden" name="dir" value="up" />
                                    <input type="hidden" name="acao" value="ordenar" />
                                    <button type="submit" class="link-button">
                                      <i class="fa fa-arrow-up"></i>
                                    </button>
                                </form>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="orby" value="controle" />
                                    <input type="hidden" name="dir" value="down" />
                                    <input type="hidden" name="acao" value="ordenar" />
                                    <button type="submit" class="link-button">
                                      <i class="fa fa-arrow-down"></i>
                                    </button>
                                </form>
                            </th>
                            <th style="width: 10%">Ação</th>
                        </tr>
                      <?php
                        foreach ($return['pgExb'] as $valor) {
                            if ($valor['controle'] == 1) {
                                $cClass = "bg-light-blue";
                            } else {
                                $cClass = "bg-green";
                            }
                            if ($valor['horaSemanal'] == 0) {
                                $hsClass = "bg-red";
                            } else {
                                $hsClass = "bg-light-blue";
                            }
                            ?>
                            <tr>
                                <td class='hidden-xs'><?= $valor['id'] ?></td>
                                <td><?= $valor['nome'] ?></td>
                                <td><span class="badge <?= $hsClass ?>"><?= $valor['horaSemanal'] ?></span></td>
                                <td class='hidden-xs'><span class="badge <?= $cClass ?>"><?= $valor['controle'] ?></span></td>
                                <td>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="orby" value="<?=$respGet['orby']?>" />
                                    <input type="hidden" name="dir" value="<?=$respGet['dir']?>" />
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="tabela" value="alterar" />
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="id" value="<?=$valor['id']?>" />
                                    <input type="hidden" name="nome" value="<?=$valor['nome']?>" />
                                    <input type="hidden" name="horaSemanal" value="<?=$valor['horaSemanal']?>" />
                                    <button type="submit" class="btn btn-default">
                                      <i class="fa fa-pencil"></i>
                                    </button>
                                </form>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="orby" value="<?=$respGet['orby']?>" />
                                    <input type="hidden" name="dir" value="<?=$respGet['dir']?>" />
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="tabela" value="buscar" />
                                    <input type="hidden" name="pg" value="<?=$respGet['pg']?>" />
                                    <input type="hidden" name="id" value="<?=$valor['id']?>" />
                                    <input type="hidden" name="nome" value="<?=$valor['nome']?>" />
                                    <input type="hidden" name="horaSemanal" value="<?=$valor['horaSemanal']?>" />
                                    <input type="hidden" name="tabela" value="remover" />
                                    <button type="submit" class="btn btn-default">
                                      <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                 </td>
                            </tr>
                    <?php }?>
                    </table>
            <!--fim da tabela-->
                <?php } ?>
            </div>
        </div>
    </div>
</div>