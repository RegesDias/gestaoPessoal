<?php
//acesso
    $buscAcessoNivel = array("4");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'BuscaPrevia') AND ($valor['buscar'] == '1')){ 
             $btnBuscaPrevia = true;
             break;
        }
    }
//configuração
    $pst = 'contabil';
    $arq = 'previa';
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
        $_SESSION["lotacao"] = getRest('lotacao/getListLotacaoUsuarioFolhaPrevia');
        //$_SESSION["lotacao"] = getRest('lotacao/getListaLotacaoUsuario');
    }
    if ($respGet['acao'] == "buscar") {
        $_SESSION["buscaReferencia"] =  array(
                        'dataPrevia'=>$respGet['dataPrevia'],
                        'lotacaoPrevia'=>$respGet['lotacaoPrevia']
        );
        $cBusc = array(
                'anoMes'=>$respGet['dataPrevia'].'-01',
                'secretaria'=>$respGet['lotacaoPrevia'],
              );
        $lista= getRest('previaWs/getListFolhaPrevia',$cBusc);
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
if($respGet['modal'] == 'exportAcomOrcamentario'){?>
    <script>
        jQuery(document).ready(function(){
            $('#exportAcomOrcamentario').modal('show');
        });
    </script>
<?php
    $respGet['mesAnoInicial'] = mesAno($respGet['mesAnoInicial']);
    $respGet['mesAnoFinal'] = mesAno($respGet['mesAnoFinal']);
    $cBusc = array($respGet['mesAnoInicial'],$respGet['mesAnoFinal']);
    $competencia = getRest('nsdFolhaPrevia/getListaPrevia',$cBusc);
}
?>
<h1>
    Gerar 
    <small>Prévia da Folha de Pagamento</small>
    <br><br>
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Contábil</a></li>
    <li class="active">Prévia</li>
</ol>
<?php
 $key = array_search($_SESSION["buscaReferencia"]["lotacaoPrevia"], array_column($_SESSION["lotacao"], 'id'));
if($btnBuscaPrevia == true){ ?>
    <div class="row">
            <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form action="index.php" method="<?=$method?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="exampleInputEmail1">Buscar Prévia</label>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <script>
                                                    var isFirefox = typeof InstallTrigger !== 'undefined';
                                                    if(isFirefox){
                                                        alert("Estou no firefox");
                                                    }
                                                </script>
                                                <label for="exampleInputEmail1">Referência</label>
                                                <input id="referenciaID" name="dataPrevia" class="form-control" type="month" max="<?= date('Y-m') ?>" value="<?=$_SESSION["buscaReferencia"]["dataPrevia"]?>">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Secretaria</label>
                                                <select name='lotacaoPrevia' class="form-control select2" style="width: 100%;">
                                                    <?php     
                                                        if(count ($_SESSION["lotacao"])>=40){ 
                                                            if(isset ($_SESSION["buscaReferencia"]["lotacaoPrevia"])){?>
                                                                <option selected="selected" value='<?=$_SESSION["buscaReferencia"]["lotacaoPrevia"]?>'> <?=$_SESSION["lotacao"][$key]['nome']?> </option><?php 

                                                            }else{ 
                                                                ?><option selected="selected" value=''> ------- </option><?php
                                                            }
                                                        }
                                                    
                                                    ?>
                                                    <?php foreach ($_SESSION["lotacao"] as $ArrEsp){?>
                                                        <option value='<?=$ArrEsp[id]?>'><?=$ArrEsp[nome]?></option>
                                                    <?php }?>
                                                </select>
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
    </div><?php 
}
if ($_SESSION["totalLista"] >= 1){?>
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
                            $dataCompleta= $valor[1];
                            $valor[1]= dataBr($valor[1]);
                            $valor[1] = substr($valor[1], 3);
                            if($respGet['pg'] ==''){
                                $pg=1;
                            }else{
                                $pg=$respGet['pg'];
                            }
                            $vaiPerfil = "acao=buscar&pst=$pst&arq=$arq&id=$valor[2]&pg=$pg";?>
                            <!-- TO DO List -->
                            <div class="box box-primary">
                              <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                   <h3 class="box-title">Prévia da Folha de Pagamento</h3>
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                                <ul class="todo-list">
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Referência:</span> <?=$valor[1]?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Secretaria:</span> <?=$valor[2]?>
                                  </li>
                              </div>
                              <!-- /.box-body -->
                              <div class="box-footer clearfix no-border">
                                    <form action="index.php" method="<?=$method?>"name="formTemplate">
                                        <button class='btn btn-default pull-right' value="Voltar">
                                            <img src="img/imprimir.png">
                                        </button>
                                        <input type='hidden' name='pst' value='print'>
                                        <input type="hidden" name="arq" value="info">
                                        <input type="hidden" name="vpst" value="<?=$pst?>"> 
                                        <input type="hidden" name="varq" value="<?=$arq?>">
                                        <input type="hidden" name="mesAnoInicial" value="<?=$dataCompleta?>">
                                        <input type="hidden" name="idSecretaria" value="<?=$valor[0]?>">
                                        <input type="hidden" name="acao" value="getRelRevia">
                                        <input type="hidden" name="exibeHTML" value="false"/>
                                    </form>
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
<?php }?>
