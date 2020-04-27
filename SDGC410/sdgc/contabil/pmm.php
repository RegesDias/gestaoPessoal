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
//buscar
    session_start();
    $_SESSION["lotacao"] = getRest('lotacao/getListaLotacaoUsuarioContabil');
//ordenar
    $campo = $respGet['orby'];
    $sinal = 'up';
    $return = ordernarPor($_SESSION['lista'], $respGet);
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
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
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="exampleInputEmail1">Buscar NSD</label>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Data de Referência</label>
                                                <input name="dataNSD" id="dataNSD" class="form-control" type="month" max="<?= date('Y-m') ?>" value="<?=$_SESSION["buscaReferencia"]["dataPrevia"]?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Número Nota</label>
                                                <input type="text" name="numeroNSD" id="numeroNSD"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Secretaria</label>
                                                <select name='lotacaoNSD' id='lotacaoNSD' class="form-control select2" style="width: 100%;">
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
                            <button class="btn btn-default" onclick="templateBuscar('buscar',$('#lotacaoNSD').val(), $('#numeroNSD').val(),$('#dataNSD').val())" type="button">
                                Buscar
                            </button>
                        </div>
                    <!--Fim do formulario-->
                    <!--Tabela que mostra valores buscados-->
                </div>
            </div>
        </div>
    </div>
    <div id='pmmBusca'>
    </div>
        
        <?php 
}
    $dados = array('mesAnoInicial','acao', 'ver');
    postRestAjax('postexportFUNDEB', 'imprimir', 'print/info.php',$dados);
    
    
    
    $be = array('idBoxDados','removeClass','hidden');
    $beforeSend= array ($be);
    $dados = array('acao', 'lotacaoNSD','numeroNSD','dataNSD' );
    postRestAjax('templateBuscar','dados','contabil/pmmBusca.php',$dados,$beforeSend);  
    
    $dados = array('acao', 'pg');
    postRestAjax('pagUpDown','dados','contabil/pmmBusca.php',$dados); 
    
    $dados = array('acao','codNsd','ver');
    postRestAjax('gerarNSD','imprimir','print/info.php',$dados,$beforeSend, $success);
?>
