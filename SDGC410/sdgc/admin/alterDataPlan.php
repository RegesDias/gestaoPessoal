<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    $diasPlan = array();
    if ($respGet['acao']=='alterarDiasPlan'){
        foreach ($respGet['diasPlan'] as $value) {
            $diasPlan[] = "'dia' => ".$value;
        }
        $aSetor = array($diasPlan);
        $executar = postRest('planejamento/postIncluirPlanejamentoData',$aSetor);
        $msnTexto = "ao alterar dias do planejamento.";
    }
    $diaPlan = getRest('planejamento/getListaPlanejamentoData');
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?>
<h1>
    Planejamento
    <small>Alterar período do lançamento</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Planejamento</a></li>
    <li class="active">Liberar dias para consolidação</li>
</ol>
<div class="row">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Definir dias</h4>
                </div>
                   <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Liberação para Consolidação</label>
                                <select class="form-control select2" multiple="multiple" name='diasPlan[]' id='diasPlan' data-placeholder="Não possui setor" style="width: 100%;">
                                  <?php for ($diaMes = 1; $diaMes < 32; $diaMes++) {
                                            foreach ($diaPlan as $diaBanco) {
                                                if ($diaBanco == $diaMes){
                                                    $cont++;
                                                    echo "<option selected='selected'>".$diaMes."</option>";
                                                    break;
                                                }
                                            }
                                            if($cont == 0){
                                                 echo "<option>".$diaMes."</option>";  
                                             }
                                             $cont = 0;     
                                         }?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" onclick="agendarData('alterarDiasPlan',$('#diasPlan').val())" type="button">
                                Alterar
                            </button>
                        </div>
                    </form>
               <div class="modal-body col-md-12">
               </div>
            </div>
</div>
<?php
    //salvar
    $dados = array('acao','diasPlan');
    postRestAjax('agendarData', 'corpo', 'admin/alterDataPlan.php', $dados);
?>
<script>
   configuraTela(); 
</script>