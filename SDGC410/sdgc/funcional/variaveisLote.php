<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $lote = true;
    $_SESSION["funcionalPerfil"] = '';
    $_SESSION["funcionalBusca"] = '';
    if ($respGet['acao'] == "lancarVariaveis") {
        if($_SESSION["funcionalBusca"] == ''){
            $arrayJson2D= postJson2D($respGet['to'],'idFunc');
        }else{
            $to = array($_SESSION["funcionalBusca"]["id"]);
            $arrayJson2D= postJson2D($to,'idFunc');
        }
        if($respGet['diasOco'] == ''){
            $respGet['diasOco'] = '0';
        }
        if (count($arrayJson2D) == 0){
            $to = array('0000000000');
            $arrayJson2D = postJson2D($to ,'idFunc');
        }
        if($respGet['idQuantidadeVL']==''){$respGet['idQuantidadeVL']=0;}
        if($respGet['idValorVL']==''){$respGet['idValorVL']=0;}
        if(($respGet['idVariaveisDescVL'])<1){$respGet['idVariaveisDescVL']=0;}
        $lancarVariaveis = array(      
                                'idFuncs' => $arrayJson2D,
                                'idVariaveisDesc' => $respGet['idVariaveisDescVL'],
                                'idLotacaoSub' => $respGet['idSetorVL'],
                                'quantidade' => $respGet['idQuantidadeVL'],
                                'valor' => $respGet['valor']
                            );
        $LV = array($lancarVariaveis);
        $executar = postRest('variaveis/postVariaveisIncluirEmLote',$LV);
        $msnTexto = "ao lançar Variável. ".$executar['msn'].".";
        exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
        //buscaVariaveis
        $vPerfil = array('idFuncional' =>$_SESSION["funcionalBusca"]['id']);
        $variaveisLancadas = getRest('variaveis/getListaVariaveisFuncionalPorId',$vPerfil);
        $_SESSION["variaveisLancadas"] = $variaveisLancadas;
    }
?>
<h1>
    Lançar
    <small id="idEstaEmLote">Variáveis em lote</small>
    <br><br>
    
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li class="active" id="">Variáveis em lote</li>
</ol>
<section class="content">
    <div class="row">
        <form class="form-horizontal" method="<?=$method?>" action="index.php" name="formTemplate">
            <?php require_once '../funcional/lancaVariaveisLote.php'; ?>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Selecionar servidor</h3>
                </div>
                <div class="box-body">
                    <div class="box-body">
                        <div id="wrap" class="container col-md-12">
                            <br>
                         </div>
                        <div id="wrap" class="container col-md-12">            
                            <div class="row">
                                <div class="col-sm-12" id="servidores">
                                    <select name="servidor" multiple="multiple" size="8" id="multiselect" class="form-control select2" style="height: 100%;"> </select>
                                </div>
                                <div class="col-sm-12"><br></div>
                                <div class="col-sm-12">
                                    <div class="col-sm-2"></div>
                                     <div class="col-sm-2">
                                        <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-down"></i></button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-up"></i></button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-erase"></i></button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="fa fa-list-ul"></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-12"><br></div>
                                <div class="col-sm-12" id="carregaFuncional">
                                    <select name="to[]" id="multiselect_to" class="form-control " size="8" multiple="multiple"></select>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript" src="dist/js/multiselect.min.js"></script>
                    </div>
                    <input type="hidden" name="tab" value="variaveis">
                    <input type="hidden" name="acao" value="lancarVariaveis">
                    <input type="hidden" name="pst" value="funcional">
                    <input type="hidden" name="arq" value="variaveisLote">
                    <button id="idBtnLancarVariaveis" class="btn btn-info pull-right  btn-sm" onclick="incluirVariavel('lancarVariaveis', $('#idSetorVL').val() , $('#idVariaveisDescVL').val(), $('#idQuantidadeVL').val(), $('#idValorVL').val(),$('select#multiselect_to option').map(function() {return $(this).val();}).get())" type="button">
                       <i class="fa fa-edit"></i> Lançar
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
<?php
    $dados = array('acao', 'idSetorVL','idVariaveisDescVL','idQuantidadeVL','idValorVL','to');
    postRestAjax('incluirVariavel','corpo','funcional/variaveisLote.php',$dados);
?>
<script>
    configuraTela(); 
</script>