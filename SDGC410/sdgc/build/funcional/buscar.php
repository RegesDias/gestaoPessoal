<?php
//configuração
    $pst = 'funcional';
    $arq = 'buscar';
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
    if ($respGet['acao'] == "buscar") {
        $lista = getRest('funcionalws/getListarFuncionalPorNomeMatriculaCpf',$cBusc);
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
//ordenar
    $campo = $respGet['orby'];
    $sinal = 'up';
    $return = ordernarPor($_SESSION['lista'], $respGet);
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
//Auto complete
    autoComplete($_SESSION["nomePessoas"],'#compNome','1');
//    echo"<pre>";
//    print_r($lista);
//    echo"</pre>";
?>
<h1>
    Buscar
    <small>Servidor</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li class="active">Buscar</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="col-md-12">
                    <h3 class="box-title">Ordenar por</h3>          
                </div>
            </div>
            <div class="box-body">
                <form action="index.php" method="<?=$method?>">
                <div class="col-md-12">
                    <div class="form-group">
                      <label>
                        <input type="radio" name="orby" value ='nome' class="flat-red" checked>
                         Nome
                      </label>
                      <label>
                        <input type="radio" name="orby" value ='matricula' class="flat-red">
                         Matrícula
                      </label>
                      <label>
                        <input type="radio" name="orby" value ='dataAdmissao' class="flat-red">
                         Data de Admissão
                      </label>
                      <label>
                        <input type="radio" name="orby" value ='cargo' class="flat-red">
                         Cargo
                      </label>
                    </div>                        
                </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome</label>
                                    <input type="text" id="compNome" name="nome" class="form-control">
                                </div>
<!--                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lotação</label>
                                    <input type="text" id="compLotacao" name="lotacao"  class="form-control">
                                </div>-->
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Matrícula</label>
                                    <input type="text" name="matricula"  class="form-control">
                                </div>
<!--                                <div class="form-group">
                                    <label for="exampleInputEmail1">Cursos</label>
                                    <input type="text" id="compCursos" name="cursos" value="<?= $respGet['cursos'] ?>" class="form-control">
                                </div>-->
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CPF</label>
                                    <input type="text" name="cpf" class="form-control">
                                </div>
<!--                                <div class="form-group">
                                    <label for="exampleInputEmail1">Grau Máximo</label>
                                    <input type="text" name="grau" value="<?= $respGet['grau'] ?>" class="form-control">
                                </div>-->
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
                            if($respGet['pg'] ==''){
                                $pg=1;
                            }else{
                                $pg=$respGet['pg']; 
                            }
                            if($valor['situacao'] == 'INATIVO'){
                               $lable = 'label label-danger'; 
                            }else{
                               $lable = '';
                            }
                        ?>
                        <div class="box-body chat" id="chat-box">
                              <!-- chat item -->
                              <div class="item">
                                <div class="inline img-lg-responsive img-rounded img-bordered-sm">
                                      <img src="<?=exibeFoto($valor['cpf'])?>" alt="Imagem do Usuário">
                                </div>
                                <div class="post">
                                    <div class="row" style="margin: 30px">
                                        <div class="user-block">
                                            <div style="margin-right: 100px">
                                            <span class="username">
                                                <form method="<?=$method?>" action="index.php" class="inline">
                                                    <input type="hidden" name="acao" value="buscar" />
                                                    <input type="hidden" name="pst" value="<?= $pst ?>"/>
                                                    <input type="hidden" name="arq" value="perfil"/>
                                                    <input type="hidden" name="id" value="<?=$valor['matricula']?>"/>
                                                    <input type="hidden" name="pg" value="1"/>
                                                    <button type="submit" class="link-button">
                                                     &nbsp; <?=$valor['nome']?>
                                                    </button>
                                                </form>
                                            </span>
                                            </div>
                                              <div class="item">

                                                <div class="attachment">
                                                    <small class="text-muted pull-right"><i class="fa fa-calendar"></i> <b>Data de Admissão:</b> <?=dataBr($valor['dataAdmissao'])?></small>
                                                  <h4><?=$valor['matricula']." - ".$valor['cargo']?></h4>
                                                  <p class="filename">
                                                      <span class="<?=$lable?>"><?=$valor['regime'].' '.$valor['situacao']?></span>
                                                  </p>
                                                  <div class="pull-right">
                                                    <form action="index.php" method="<?=$method?>">
                                                        <div class="pull-right btn-box-tool">
                                                            <input type="hidden" name="acao" value="buscar" />
                                                            <input type="hidden" name="pst" value="<?= $pst ?>"/>
                                                            <input type="hidden" name="arq" value="perfil"/>
                                                            <input type="hidden" name="id" value="<?=$valor['matricula']?>"/>
                                                            <input type="hidden" name="pg" value="1"/>
                                                            <button type="submit" class="btn btn-primary btn-small"><i class="fa fa-edit"></i></button>
                                                        </div>
                                                    </form>
                                                  </div>
                                                </div>
                                                <!-- /.attachment -->
                                              </div>
                                        </div>
                                    </div>
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
