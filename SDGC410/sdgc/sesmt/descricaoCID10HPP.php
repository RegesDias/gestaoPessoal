<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $CIDsHPP = array(getRestArray($respGet[cid]));
    $listaHistHPP = getRest('cid/getListCidCategoriaSubMultiplosId',$CIDsHPP);
?> 
<div class="box">
    <div class="box-header with-border">
        <h4 class="box-title">CID(s) da Ficha Médica</h3>
    </div>
    <div class="box-body">
      <?php foreach ($listaHistHPP as $value) {?>
    <div class="comment-text"  style="background-color: rgb(224,224,224); padding: 10px">
          <span class="username">
            <?=$value[id]?>
          </span><!-- /.username -->
          <p><?=$value[descricaoCidCapitulo]?></p>
          <p><?=$value[descricaoCidCategoria]?></p>
          <p><?=$value[descricaoCidGrupo]?></p>
    </div>
    <?php }?>
    <!-- /.comment-text -->
  </div>
</div>