<?php
//configuração
    $pst = 'admin';
    $arq = 'alterDataAvaliacao';
    if ($respGet['acao'] == 'alterDataAvaliacao'){
        $respGet['data'] = $respGet['data'].'-01';
        $respGet['dataAgenda'] = $respGet['dataAgenda'].'-01';
        $alterData = array('data' => $respGet['data'], 'dataAgenda' => $respGet['dataAgenda']);
        $dadosAlterData = array($alterData);
        $executar = postRest('dataFrequenciaWs/postAlterarPeriodoAvaliacao',$dadosAlterData);
        $msnTexto = "ao alterar periodo de avaliação.";
    }
   $dataOco = getRest('dataFrequenciaWs/getListaDataFrequencia');
   $pAtual=substr($dataOco[10]['dataFrequencia'], 0, 7);
   $pNovo=substr($dataOco[11]['dataFrequencia'], 0, 7);
   exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);

    
//messagem incluir  
?>
<h1>
    Avaliação
    <small>Definir período do lançamento</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Avaliação</a></li>
    <li class="active">Alterar Período</li>
</ol>
<div class="row">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Alterar Período</h4>
        </div>
            <div class="modal-body col-md-12">
                <h2>Período Ativo</h2>
                    <div class="col-md-6">
                        <label>Inicial</label>
                        <input name="data" class="form-control" type="month" value="<?=$pAtual?>" disabled="disabled">
                    </div>
                    <div class="col-md-6">
                        <label>Final</label>
                        <input name="dataAgenda" class="form-control" type="month" value="<?=$pNovo?>" disabled="disabled">
                    </div>
            </div>
           <form method='<?=$method?>' action='index.php'>
                <div class="modal-body col-md-12">
                    <h2>Novo Período</h2>
                    <div class="col-md-6">
                        <label>Inicial</label>
                        <input name="data" class="form-control" type="month" value="">
                    </div>
                    <div class="col-md-6">
                        <label>Final</label>
                        <input name="dataAgenda" class="form-control" type="month" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="acao" value="alterDataAvaliacao">
                    <input type="hidden" name="pst" value="<?= $pst ?>">
                    <input type="hidden" name="arq" value="<?= $arq ?>">
                    <input type="submit" class="btn btn-primary" value='Alterar'>
                </div>
               <div class="modal-body col-md-12">
               </div>
            </form>
    </div>
</div>