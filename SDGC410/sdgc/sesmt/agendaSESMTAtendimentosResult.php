<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    if($respGet[acao] == 'alterarStatusRequerimento'){
        $ag = array('id' => $respGet[idRequerimento],'idStatus' => $respGet[status]);
        $agendar = array($ag);
        $executar = postRest('requerimento/postAlterarStatusRequerimento',$agendar);
    }
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?> 
<div class="box box-primary">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-widget">
                <?php require_once '../sesmt/dadosPaciente.php'; ?>
            </div>
                <?php require_once '../sesmt/historicoMedicoRecente.php'; ?>
        </div>
    </div>
</div>
<script>
    configuraTela(); 
</script>