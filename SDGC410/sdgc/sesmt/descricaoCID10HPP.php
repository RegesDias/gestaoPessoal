<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $CIDsHPP = array(getRestArray($respGet[cid]));
    $listaHistHPP = getRest('cid/getListCidCategoriaSubMultiplosId',$CIDsHPP);
?> 
<div class="box-footer box-comments">
  <div class="box-comment">
      <?php foreach ($listaHistHPP as $value) {?>
    <div class="comment-text">
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