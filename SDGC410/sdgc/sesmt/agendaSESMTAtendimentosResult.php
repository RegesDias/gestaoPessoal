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
    print_p($ag);
?> 
<script>
    configuraTela(); 
</script>