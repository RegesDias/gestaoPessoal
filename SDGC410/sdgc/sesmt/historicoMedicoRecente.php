<?php
    $histR = array($respGet[cpf]);
    $listaHist = getRest('requerimento/getListaRequerimentoPorFuncionalTodos',$histR);
    print_p($listaHist);
?>
<h3>Histórico Médico Recente</h3>
<div class="box-footer box-comments">
  <div class="box-comment">
    <div class="comment-text">
          <span class="username">
            5 - PERICULOSIDADE
            <span class="text-muted pull-right btn-success"> Atendido em: 01/02/2010 </span>
          </span><!-- /.username -->
      It is a long established fact that a reader will be distracted
      by the readable content of a page when looking at its layout.
    </div>
  </div>
  <div class="box-comment">
    <div class="comment-text">
          <span class="username">
            2 - ATESTADO
            <span class="text-muted pull-right btn-success"> Atendido em: 01/02/2010 </span>
          </span><!-- /.username -->
      It is a long established fact that a reader will be distracted
      by the readable content of a page when looking at its layout.
    </div>
  </div>
</div>