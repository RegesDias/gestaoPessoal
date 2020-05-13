<?php
//configuração
    $pst = 'funcional';
    $arq = 'portaria';
    $n0 = 'id';             $c0 = $respGet['id'];
    $n1 = 'nome';           $c1 = $respGet['nome'];
    $n2 = 'matricula';      $c2 = $respGet['matricula'];
    $n3 = 'cpf';            $c3 = $respGet['cpf'];
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
    if ($respGet['acao'] == "limparSessao") {
        session_start();
        $_SESSION["lotacao"] = getRest('lotacao/getListaLotacao');
    }
    if ($respGet['acao'] == "buscar") {
        $cBusc = array(
                'nome'=>$respGet['nome'],
                'dataPublicacao'=>$respGet['dataPublicacao']
              );
                $lista= getRest('portariaWs/getListaPortaria',$cBusc);
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
    if(($respGet['acao'] == 'exibeServidores')){
                $cBusc = array(
                    'id_portaria'=>$respGet['id_portaria']
                  );
                   $lista= getRest('portariaWs/getListaPortariaRelacao',$cBusc);
    }
//ordenar
    $campo = $respGet['orby'];
    $sinal = 'up';
    $return = ordernarPor($_SESSION['lista'], $respGet);
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
//TESTE
//echo '<pre>';
//print_r($_SESSION["lista"]);
//echo '</pre>';
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
                <form action="index.php" method="<?=$method?>">
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
                                            <input type="date" name="dataPublicacao"  class="form-control">
                                        </div>
                                    </div>
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
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
</div>
<?php if (($_SESSION["totalLista"] >= 1)AND($respGet['acao'] != 'exibeServidores')){?>
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
                        <div class="active tab-pane" id="activity"> <?php
                        foreach ($return['pgExb'] as $valor) {
                            if($respGet['pg'] ==''){
                                $pg=1;
                            }else{
                                $pg=$respGet['pg'];
                            }
                            $vaiPerfil = "acao=buscar&pst=$pst&arq=$arq&id=$valor[2]&pg=$pg";
                            ?>
                            <!-- TO DO List -->
                            <div class="box box-primary">
                              <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                   <h3 class="box-title"><?=$valor['nome']?></h3>
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                                <ul class="todo-list">
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Data Publicação:</span> <?=dataBr($valor['dataPublicacao'])?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Data de início da portaria:</span> <?=dataBr($valor['dataInicio'])?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Data de seção da portaria:</span> <?=dataBr($valor['dataFim'])?>
                                  </li>
                              </div>
                              <!-- /.box-body -->
                              <div class="box-footer clearfix no-border">
                                    <form action="index.php" method="<?=$method?>"name="formTemplate">
                                        <button class='btn btn-default pull-right' value="Voltar">
                                            <img src="img/imprimir_ponto.png">
                                        </button>
                                        <input type='hidden' name='pst' value='print'>
                                        <input type="hidden" name="arq" value="info">
                                        <input type="hidden" name="vpst" value="<?=$pst?>"> 
                                        <input type="hidden" name="varq" value="<?=$arq?>"> 
                                        <input type="hidden" name="acao" value="exibePortaria">  
                                        <input type="hidden" name="portaria" value="<?=$valor['nome']?>">
                                    </form> 
                                    <form action="index.php" method="<?=$method?>"name="formTemplate">
                                        <button class='btn btn-default pull-right' value="Voltar">
                                            <img src="img/historico.png">
                                        </button>
                                        <input type='hidden' name='pst' value='<?=$pst?>'>
                                        <input type="hidden" name="arq" value="<?=$arq?>">
                                        <input type="hidden" name="vpst" value="<?=$pst?>"> 
                                        <input type="hidden" name="varq" value="<?=$arq?>"> 
                                        <input type="hidden" name="acao" value="exibeServidores">  
                                        <input type="hidden" name="id_portaria" value="<?=$valor['id']?>">
                                        <input type="hidden" name="nome" value="<?=$valor['nome']?>">
                                    </form> 
                                    <!--<a href="index.php?pst=print&arq=info&vpst=<?=$pst?>&varq=<?=$arq?>&portaria=<?=$valor['nome']?>&acao=exibePortaria" class="btn btn-default pull-right btn-large"><img src="img/imprimir_ponto.png"></a>-->
                                  <!--<a href="index.php?pst=<?=$pst?>&arq=<?=$arq?>&acao=exibeServidores&id_portaria=<?=$valor['id']?>&nome=<?=$valor['nome']?>" class="btn btn-default pull-right btn-large"><img src="img/historico.png"></a>-->
                              </div>
                            </div><?php
                            }?>
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
<?php }else if(($respGet['acao'] == 'exibeServidores')){
    
    ?>
<div class="row">
    <div class="box-body">
        <div class="box">
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity"> <?php
                            $vaiPerfil = "acao=buscar&pst=$pst&arq=$arq&id=$valor[2]&pg=$pg";?>
                            <!-- TO DO List -->
                            <div class="box box-primary">
                              <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                   <h3 class="box-title"><?=$respGet['nome']?></h3>
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                                <ul class="pagination pagination-sm no-margin">
                                    <?php exibePag($hrefPag, $respGet, $return); ?>
                                </ul>
                                <ul class="todo-list">
                                    <?php foreach ($lista as $valor) {?>
                                    <li>
                                        <form method="<?=$method?>" action="index.php" class="inline">
                                            <input type="hidden" name="acao" value="buscar" />
                                            <input type="hidden" name="pst" value="funcional"/>
                                            <input type="hidden" name="arq" value="perfil"/>
                                            <input type="hidden" name="id" value="<?=$valor['matricula']?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <button type="submit" class="link-button">
                                              <span class="text"><?=$valor['matricula']?></span> <?=$valor['nome']?>
                                            </button>
                                        </form>
<!--                                        <a href="index.php?acao=buscar&pst=funcional&arq=perfil&id=<?=$valor['matricula']?>&pg=1" target="blank">
                                            <span class="text"><?=$valor['matricula']?></span> <?=$valor['nome']?>
                                        </a>-->
                                    </li>
                                   <?php }?>
                                </ul>
                              </div>
                              <!-- /.box-body -->
                              <div class="box-footer clearfix no-border">
                                    <form action="index.php" method="<?=$method?>"name="formTemplate">
                                        <button class='btn btn-default pull-right btn-large' value="Voltar">
                                            Voltar
                                        </button>
                                        <input type='hidden' name='pst' value='<?=$pst?>'>
                                        <input type="hidden" name="arq" value="<?=$arq?>">
                                    </form> 
                              </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>