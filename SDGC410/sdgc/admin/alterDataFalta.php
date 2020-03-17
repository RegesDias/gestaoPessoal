<?php
//configuração
    $pst = 'admin';
    $arq = 'alterDataFalta';
    if ($respGet['acao'] == 'alterarDataFalta'){
        $alterData = array('dataAgenda' => $respGet['dataAgenda']);
        $dadosAlterData = array($alterData);
        $executar = postRest('dataFrequenciaWs/postAlterarPeriodoFalta',$dadosAlterData);
    }
   $dataOco = getRest('dataFrequenciaWs/getListaDataFrequencia');
   $pAtual=substr($dataOco[4]['dataFrequencia'], 0, 7);
   $pNovo=substr($dataOco[0]['dataFrequencia'], 0, 7);
    
//messagem incluir  
?>
<h1>
    Falta Previa
    <small>Carregamento de Arquivo</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Prévia Falta</a></li>
    <li class="active">Alterar Período</li>
</ol>
<div class="row">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Definir Data</h4>
                </div>
                    <div class="modal-body col-md-12">
                         <div class="col-md-4">
                             <label>Período Ativo:</label><input name="dataAtual" class="form-control" type="date" value="<?=$dataOco[6]['dataFrequencia']?>" disabled="disabled"><br>
                         </div>
                    </div>
                   <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-6">
                                <label>Novo Período</label>
                                <input name="dataAgenda" class="form-control" type="date" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="acao" value="alterarDataFalta">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <input type="submit" class="btn btn-primary" value='Alterar'>
                        </div>
                    </form>
            </div>
                   <div class="modal-body col-md-12">
               </div>
</div>