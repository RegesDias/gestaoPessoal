<script type="text/javascript">
 //----------------------------------------------
 //---------------INÍCIO AJAX--------------------
 //----------------------------------------------
function getAJAX(vgurl, vservico, parametro, callback){
    
    var xhr = new XMLHttpRequest();
    var linkPedido = vgurl + vservico + parametro;
    //console.log(linkPedido);
    
    xhr.open('GET', linkPedido, true);
    xhr.timeout = 1000;
    xhr.addEventListener('load', function(){
        var objJSON = JSON.parse(xhr.responseText);
        callback(objJSON);
    });
    xhr.addEventListener('error', function(e){
      console.warn("Houve algum problema com a requisição AJAX.");
    });
    //Adicinando Header antes de enviar
    xhr.setRequestHeader('chave', '<?php echo $_SESSION["user"]["chave"]; ?>');
    xhr.setRequestHeader('appv', '<?php echo $gappv; ?>');
    xhr.send(null);
}
//-----------------------------------------------------
//---------------FIM AJAX------------------------------
//-----------------------------------------------------

</script>
