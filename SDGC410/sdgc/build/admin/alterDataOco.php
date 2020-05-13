<?php
//configuração
    $pst = 'admin';
    $arq = 'alterDataOco';
    if ($respGet['acao'] == 'alterarDataOco'){
        $respGet['data'] = $respGet['data'].'-01';
        $alterData = array('data' => $respGet['data'], 'dataAgenda' => $respGet['dataAgenda']);
        $dadosAlterData = array($alterData);
        $executar = postRest('dataFrequenciaWs/postAlterarPeriodoOcorrencia',$dadosAlterData);
    }
   $dataOco = getRest('dataFrequenciaWs/getListaDataFrequencia');
   //print_p($dataOco);
   $pAtual=substr($dataOco[4]['dataFrequencia'], 0, 7);
   $pNovo=substr($dataOco[0]['dataFrequencia'], 0, 7);

    
//messagem incluir  
//    echo "<pre>";
//    print_r($preArray);
//    echo "</pre>";
?>
<h1>
    Ocorrência
    <small>Alterar período do lançamento</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Ocorrência</a></li>
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
                        <h2>Status</h2>
                         <div class="col-md-4">
                             <label>Período Ativo:</label><input name="data" class="form-control" type="month" value="<?=$pAtual?>" disabled="disabled"><br>
                         </div>
                    </div>
                   <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-6">
                                <label>Novo periodo de lançamento</label>
                                <input name="data" class="form-control" type="month" value="">
                            </div>
                            <div class="col-md-6">
                                <label>Agentar Alteração</label>
                                <input name="dataAgenda" class="form-control" type="date" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="acao" value="alterarDataOco">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <input type="submit" class="btn btn-primary" value='Alterar'>
                        </div>
                       <div class="modal-body col-md-12">
                           <h2>Agendamento</h2>
                           <div class="col-md-6">
                                <label>Alteração agendada para:</label><input name="dataAgenda" class="form-control" type="date" value="<?=$dataOco[2]['dataFrequencia']?>" disabled="disabled"><br>
                           </div>
                           <div class="col-md-6">
                               <label>Novo Período:</label><input name="dataPeriodo" class="form-control" type="month" value="<?=$pNovo?>" disabled="disabled"><br>
                           </div>
                       </div>
                    </form>
            </div>
</div>