<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    $diasPlan = array();
    if ($respGet['acao']=='alterarDiasPlan'){
        foreach ($respGet['diasPlan'] as $value) {
            $diasPlan[] = "'data' => ".$value;
        }
        $aSetor = array($diasPlan);
        $executar = postRest('dataFrequenciaWs/postIncluirFolhaPreviaData',$aSetor);
        $msnTexto = "ao alterar mês de folha previa.";
    }
    $dataFolhaPrevia = getRest('dataFrequenciaWs/getListaFolhaPreviaData');
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
//TESTE
?>
<h1>
    Prévia de Folha
    <small>Alterar período do lançamento</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Planejamento</a></li>
    <li class="active">Alterar Período</li>
</ol>
<div class="row">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Redefinir meses para geração de folha prévia</h4>
                </div>
                   <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Liberação para cosulta</label>
                                <select class="form-control select2" multiple="multiple" name='diasPlan[]' id='diasPlan' data-placeholder="Não possui setor" style="width: 100%;">
                                  <?php foreach ($dataFolhaPrevia as $dataBanco) {
                                            if($dataBanco[ativo] == 1){
                                                $selected = "selected='selected'";
                                            }else{
                                                $selected = "";
                                            }
                                            $data = dataBr($dataBanco[data]);
                                            echo "<option value='$dataBanco[data]' $selected>".$data."</option>";
                                        }
                                        $dataBanco = date("Y-m-d", strtotime($dataBanco[data]. "+"."1 MONTH"));
                                        $data = dataBr($dataBanco);
                                        echo "<option value='$dataBanco'>".$data."</option>";
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" onclick="agendarData('alterarDiasPlan',$('#diasPlan').val())" type="button">
                                Alterar
                            </button>
                        </div>
                    </form>
            </div>
                   <div class="modal-body col-md-12">
               </div>
</div>
<?php
    //salvar
    $dados = array('acao','diasPlan');
    postRestAjax('agendarData', 'corpo', 'admin/alterDataPreviaFolha.php', $dados);
?>
<script>
   configuraTela(); 
</script>