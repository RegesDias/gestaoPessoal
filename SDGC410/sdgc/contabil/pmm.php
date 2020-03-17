<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
//acesso
    $buscAcessoNivel = array("4");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'FUNDEB') AND ($valor['buscar'] == '1')){ 
             $btnFUNDEB = true;
             break;
        }
    }
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'AcompanhamentoOrçamentario') AND ($valor['buscar'] == '1')){ 
             $btnAcompanhamentoOrçamentario = true;
             break;
        }
    }
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'BuscaNSD') AND ($valor['buscar'] == '1')){ 
             $btnBuscaNSD = true;
             break;
        }
    }
//configuração
    $pst = 'contabil';
    $arq = 'pmm';
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
        $_SESSION["lotacao"] = getRest('lotacao/getListaLotacaoUsuarioContabil');
        //$_SESSION["lotacao"] = getRest('lotacao/getListaLotacaoUsuario');
    }
    if ($respGet['acao'] == "buscar") {
        $_SESSION["buscaReferencia"] =  array(
                        'dataPrevia'=>$respGet['dataNSD'],
                        'lotacaoPrevia'=>$respGet['lotacaoNSD']
        );
        $cBusc = array(
                'mes'=>substr($respGet['dataNSD'], -2),
                'ano'=>substr($respGet['dataNSD'], 0, -3),
                'numeroNota'=>$respGet['numeroNSD'],
                'secretaria'=>$respGet['lotacaoNSD'],
              );
        $lista= getRest('nsdWs/getListaNsd',$cBusc);
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
    $competencia = getRest('nsdWs/getListaReferenciaNsd',$cBusc);
}
modalInicio('exportFUNDEB', 'Exportar dados FUNDEB', 'print', 'info', 'exportFUNDEB','','contabil','pmm');
modalInicoFimJavaScript('idSpinLoaderPMM', 'exportAcomOrcamentario', 'Acompanhamento Orçamentário', 'print', 'info', 'exportAcomOrcamentario','combo','contabil','pmm','',1);
?>
<h1>
    Gerar 
    <small>Dados para órgãos da PMM</small>
    <br><br>
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Contábil</a></li>
    <li class="active">PMM</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            
            <div class="overlay hidden" id="idSpinLoaderPMM">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="exampleInputEmail1">Relatórios</label>
                        <div class="form-group"><?php 
                            if($btnFUNDEB == true){ ?>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exportFUNDEB">
                                    <i class="fa fa-download"></i><b> FUNDEB</b>
                                </button> <?php
                            } 
                            if($btnAcompanhamentoOrçamentario == true){?>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exportAcomOrcamentario">
                                     <i class="fa fa-download"></i><b> Folha sintética</b>
                                 </button>
                               <?php 
                            }?>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php
 $key = array_search($_SESSION["buscaReferencia"]["lotacaoPrevia"], array_column($_SESSION["lotacao"], 'id'));
if($btnBuscaNSD == true){ ?>
    <div class="row">
            <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form action="index.php" method="<?=$method?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="exampleInputEmail1">Buscar NSD</label>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Data de Referência</label>
                                                <input name="dataNSD" class="form-control" type="month" max="<?= date('Y-m') ?>" value="<?=$_SESSION["buscaReferencia"]["dataPrevia"]?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Número Nota</label>
                                                <input type="text" name="numeroNSD"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Secretaria</label>
                                                <select name='lotacaoNSD' class="form-control select2" style="width: 100%;">
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
                            $valor[1] = dataBr($valor[1]);
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
                                   <h3 class="box-title"><?=$valor[0]?></h3>
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                                <ul class="todo-list">
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Referência:</span> <?=$valor[1]?> <span class="text">Emissão:</span> <?=dataBr($valor[4])?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Destino:</span> <?=$valor[2]?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Origem:</span> <?=$valor[3]?>
                                  </li>
                              </div>
                              <!-- /.box-body -->
                              <div class="box-footer clearfix no-border">
                                    <form action="index.php" method="<?=$method?>"name="formTemplate">
                                        <button class='btn btn-default pull-right' value="Voltar">
                                            <img src="img/nsda.png">
                                        </button>
                                        <input type='hidden' name='pst' value='print'>
                                        <input type="hidden" name="arq" value="info">
                                        <input type="hidden" name="vpst" value="<?=$pst?>"> 
                                        <input type="hidden" name="varq" value="<?=$arq?>"> 
                                        <input type="hidden" name="acao" value="getRelNsda">  
                                        <input type="hidden" name="codNsda" value="<?=$valor[0]?>">
                                    </form>                                    
                                    <form action="index.php" method="<?=$method?>"name="formTemplate">
                                        <button class='btn btn-default pull-right' value="Voltar">
                                            <img src="img/nsds.png">
                                        </button>
                                        <input type='hidden' name='pst' value='print'>
                                        <input type="hidden" name="arq" value="info">
                                        <input type="hidden" name="vpst" value="<?=$pst?>"> 
                                        <input type="hidden" name="varq" value="<?=$arq?>"> 
                                        <input type="hidden" name="acao" value="getRelNsds">  
                                        <input type="hidden" name="codNsds" value="<?=$valor[0]?>">
                                    </form>
                                    <form action="index.php" method="<?=$method?>"name="formTemplate">
                                        <button class='btn btn-default pull-right' value="Voltar">
                                            <img src="img/nsd.png">
                                        </button>
                                        <input type='hidden' name='pst' value='print'>
                                        <input type="hidden" name="arq" value="info">
                                        <input type="hidden" name="vpst" value="<?=$pst?>"> 
                                        <input type="hidden" name="varq" value="<?=$arq?>"> 
                                        <input type="hidden" name="acao" value="getRelNsd">  
                                        <input type="hidden" name="codNsd" value="<?=$valor[0]?>">
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
<?php }

    $be = array('idSpinLoaderPMM','removeClass','hidden');
    $s2 = array('idSpinLoaderPMM','addClass','hidden');
    $beforeSend= array ($be);
    $success= array ($s2);
    $dados = array('mesAnoInicial','acao', 'ver');
    postRestAjax('postexportFUNDEB', 'imprimir', 'print/info.php',$dados, $beforeSend, $success);
    
    
//    //postEmCrachaPrint
//    $be = array('idSpinLoaderPMM','removeClass','hidden');
//    $s = array('idSpinLoaderPMM','addClass','hidden');
//    $beforeSend= array ($be);
//    $success= array ($s);            
//    $dados = array('idFlagOrgPor', 'acao', 'mesAnoInicial', 'mesAnoFinal', 'selectCompetencia','ver');
//    $funcao = array('fecharModal');
//    postRestAjax('relatorioInicioFim', 'imprimir', 'print/info.php',$dados,$beforeSend,$success, $funcao);
//
//    //executaContabilExterno        
//    $dados = array('modal', 'padrao', 'mesAnoInicial', 'mesAnoFinal');
//    postRestAjax('executaInicioFim', 'corpo', 'contabil/externo.php', $dados);
    
?>
