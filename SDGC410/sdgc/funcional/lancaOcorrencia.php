<?php
if ($_SESSION["funcionalPerfil"] == '') {
    $ocorrenciaDesc = getRest('funcionalws/getListaOcorrenciaDesc');
} else {
    $setoresAtivos = $_SESSION["funcionalPerfil"]["setoresAtivos"];
    $ocorrenciaDesc = $_SESSION["funcionalPerfil"]["ocorrenciaDesc"];
}   
$respGet = dataHora24($respGet);
if ($respGet['acao'] == "lancarOco") {
    
    if($_SESSION["funcionalBusca"] == ''){
        if(count($respGet['to']) == 0){
            $respGet['to'] = array('');
        }
        $arrayJson2D= postJson2D($respGet['to'],'idFunc');
    }else{
        $to = array($_SESSION["funcionalBusca"]["id"]);
        $arrayJson2D= postJson2D($to,'idFunc');
    }
    if($respGet['diasOco'] == ''){
        $respGet['diasOco'] = '0';
    }
    $lancarOco = array(      
                    'idFuncs' => $arrayJson2D,
                    'entrada' => $respGet['inicioDataHora'],
                    'saida' => $respGet['fimDataHora'],
                    'setorOco' => $respGet['setorID'],
                    'dias' => $respGet['diasOco'],
                    'obs' => $respGet['obsOco'],     
                    'idTipoOco' => $respGet['ocorrencia']        
                       );
    print_p($lancarOco);
    $arquivoOco = array($lancarOco);
    $executar = postRest('OcorrenciaWs/postIncluirOcorrencia',$arquivoOco);
    $periodoOcoBusca = str_replace("/", "-", $periodoMes);
    $inicioData = date("Y-m-d",strtotime($periodoOcoBusca[0]));
    $fimData = date("Y-m-d",strtotime($periodoOcoBusca[1]));
    $buscaOco = array('idFuncional' => $_SESSION["funcionalBusca"]['id'], 'inicio' => $inicioData, 'fim' => $fimData,'idOcoDesc' => $respGet['idOcorrencia']);
    $buscaOcorrencia = getRest('OcorrenciaWs/getListaOcorrenciaPorIdData',$buscaOco);
    $_SESSION["ocorrenciaPerfil"] = $buscaOcorrencia;
    $msnTexto = "ao lançar ocorrência. ".$executar['msn'].'.';
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
}
//teste 
//echo "<pre>";
//print_r($lancarOco);
//echo "</pre>";
?>
<div class="box box-primary">
    

    
    <div class="box-header">
        <h3 class="box-title">Lançar Ocorrências</h3>
    </div>
    <div class="box-body">
        <div class="box-body">
            <div class="box-body">
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="form-group">
                                
                            <form id="formTemplate" name="formTemplate">
                                
                                <label for="exampleInputEmail1">Local da Ocorrência</label>
                                <?php $servico = "funcionalws/getListaFuncionalPorIdSetor/"; ?>
                                <div onclick="apagarSelect('multiselect_to')">
                                <?php if($_SESSION["funcionalBusca"] == ''){?>
                                    <div onclick="apagarSelect('multiselect_to')">
                                        <div class="box-body">
                                            <div class="row">
                                                <div id="carregaLot-ocorrencia">
                                                    <div class="col-md-12">
                                                        <label>Secretaria</label>
                                                        <select onchange="getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', this.value, selectSingleSetorAjax)" name="idSecretaria" size="1"  class="form-control select2" id='secretariaID' style="width: 100%;">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                                <div class="row">
                                                    <div id="identificadorDeNecessidadeDeCarregamentoDosSetoresTendoAsSecretariasEmUmSelect">
                                                        <div class="col-md-12">
                                                            <label>Setor</label>

                                                            <select name="idSetor" <?php if ($lote) { ?> onchange="getAJAX(<?= "'" . $ajurl . "'"; ?>, <?= " '" . $servico . "'"; ?>, this.value, selectServidoresPorSetor)" <?php } ?>  size="1" class="form-control select2" id="setorID" style="width: 100%;">
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <?php }else{?>
                                            <select name="idSetor" id='setorID' <?php if ($lote) { ?> onchange="getAJAX(<?= "'" . $ajurl . "'"; ?>, <?= " '" . $servico . "'"; ?>, this.value, selectServidoresPorSetor)" <?php } ?> size="1" class="form-control select2" style="width: 100%;"> 
                                            <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp){?>
                                                    <option value='<?= $ArrEsp['idSetor'] ?>'><?= $ArrEsp['nome'] ?></option>
                                            <?php }?>
                                            </select>
                                         <?php } ?>       
                                        
                                            

                                </div>
                             </form>
                            </div>
                        </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tipo de Ocorrência</label>
                            <?php CombEvent('updateText', 'obsOco', 'diasOco','periodo') ?>
                            <select name="tpOco" id='tpOco' onchange="updateText(this);" class="form-control select2"  style="width: 100%;">
                                <option selected='selected'></option>
                                <?php
                                foreach ($ocorrenciaDesc as $ArrEsp) {
                                    if ($ArrEsp['diasMax'] > 0) {
                                        $maxMimOco = $ArrEsp['diasMin'] . " a " . $ArrEsp['diasMax'];
                                    } else {
                                        $maxMimOco = 0;
                                    }
                                    $descricaoOco = $ArrEsp['descricao'] . "--" . $maxMimOco . "--" . $ArrEsp['definirPeriodo'];
                                    ?>
                                    <option value="<?= $ArrEsp['idOcorrencia'] ?>" id="<?= $descricaoOco ?>"   ><?= $ArrEsp['nome'] ?></option>
                                    
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Dias</label>
                            <input type="number" name="diasOco" id="diasOco" value="" min="1" class="form-control">
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="form-group col-sm-12">
                <label>
                       Intervalo
                       <div class='hide' id='periodo'>
                            <span><button id="btnSim" onclick="alterarPadraoDataLancamento(1)" type="button" class="btn btn-primary btn-sm">SIM</button></span>
                            <span><button id="btnNao"onclick="alterarPadraoDataLancamento(0)" type="button" class="btn btn-secondary btn-sm">NÃO</button></span>
                       </div>
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="datetimes" id="datetimes" autocomplete=off class="form-control pull-right" /> 
                </div>
            </div>
            <script>
                $(document).on("keydown", "#obsOco", function () {
                    var caracteresRestantes = 499;
                    var caracteresDigitados = parseInt($(this).val().length);
                    var caracteresRestantes = caracteresRestantes - caracteresDigitados;

                    $(".caracteres").text(caracteresRestantes);
                });
            </script>
            <div class="form-group col-sm-12">
                <label>Observação<i><sub class="caracteres">500</sub> <sub>Restantes </sub></i></label> 
                <textarea id="obsOco" name='ObsOco'class="form-control"  maxlength="500"rows="4"></textarea>
            </div>
        </div>
    </div>
</div>
</div>