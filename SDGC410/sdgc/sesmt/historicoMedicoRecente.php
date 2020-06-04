<?php
    $histR = array($respGet[cpf]);
    $listaHist = getRest('requerimento/getListaRequerimentoPorFuncionalTodos',$histR);
?>
<h3>Histórico Médico Recente</h3>
<div class="box-footer box-comments">
      <?php foreach ($listaHist as $value) {
          $ArrEsp = $value[id];
          ?>
        <div class="box-comment">
            <div class="comment-text">
                  <span class="username">
                    <?=$value[id]." - ".$value[solicitacao]?>
                    <span class="text-muted pull-right btn-success"><?=$value[status]?></span>
                  </span><!-- /.username -->
                  <b>Protocolo:</b> <?=$value[protocolo]?>
            </div>
            <?php if($value[idStatus] < 5){?>
            <div class="modal-footer">
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#agenda<?=$ArrEsp?>" >
                    <i class="fa fa-calendar-check-o"></i> Agendar
                </button>
            </div>
            <?php }?>
          </div>
        <?php require '../sesmt/modalAgendar.php'; ?>
      <?php }?>
</div>