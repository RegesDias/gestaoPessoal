<?php
if ($_SESSION["funcionalPerfil"] == '') {
    $ocorrenciaDesc = getRest('funcionalws/getListaOcorrenciaDesc');
} else {
    $setoresAtivos = $_SESSION["funcionalPerfil"]["setoresAtivos"];
    $ocorrenciaDesc = $_SESSION["funcionalPerfil"]["ocorrenciaDesc"];
}
$variavelDesc = getRest('funcionalws/getListaOcorrenciaDesc');
$respGet = dataHora24($respGet);
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
    if($respGet['quantidade']==''){$respGet['quantidade']=0;}
    if($respGet['valor']==''){$respGet['valor']=0;}
    if(($respGet['idVariaveisDesc'])<1){$respGet['idVariaveisDesc']=0;}
    $lancarVariaveis = array(      
                            'idFuncs' => $arrayJson2D,
                            'idVariaveisDesc' => $respGet['idVariaveisDesc'],
                            'idLotacaoSub' => $respGet['idLotacaoSub'],
                            'quantidade' => $respGet['quantidade'],
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
//teste 
//print_p($_SESSION["variaveisLancadas"]);
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Lançar Variáveis</h3>
    </div>
    <div class="box-body">
        <div class="box-body">
            <div class="box-body">
                    <div class="col-md-12" id="idDivSecretaria">
                        <div class="form-group">
                        <label for="idLocalVL">Secretaria</label>
                            <select <?=$inativo?> name="nameLocal" size="1" class="form-control select2" id="idSecretariaVL" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <label for="idLocalVL">Setor</label>
                            <select <?=$inativo?> name="idLotacaoSub" size="1" class="form-control select2" id="idSetorVL" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="idVariaveisDescVL">Variável</label>
                            <select <?=$inativo?> name='idVariaveisDesc'class="form-control select2" id="idVariaveisDescVL" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 hidden" id="idDivQuantidadeVL">
                        <div class="form-group">
                            <label for="idQuantidadeVL">Quantidade</label>
                            <input type="number" name='quantidade' id="idQuantidadeVL" class="form-control" >
                            
                        </div>
                    </div>
                    <div class="col-md-12 hidden" id="idDivValorVL">
                        
                        <div class="form-group">
                            <label for="idValorVL">Valor</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <label>R$</label>
                                </div>
                                <input type="text" name='valor' id="idValorVL" class="form-control">
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>