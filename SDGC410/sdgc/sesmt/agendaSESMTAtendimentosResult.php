<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
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
     <div class="box-footer box-comments">
   <div class="box-comment">
    <div class="comment-text">
          <span class="username">
            7 - ATESTADO
            <span class="text-muted pull-right">Aberto em: Não Agendado</span>
          </span><!-- /.username -->
    </div>
       <div class="modal-footer">
        <button class="btn btn-success" onclick="agendaSESMTAtendimentosFichaMedica('Agenda Alterar')" >
            <i class="fa fa-calendar-check-o"></i> Ficha Médica
        </button>
        <button class="btn btn-danger" onclick="agendaSESMTAtendimentosFichaMedica('Agenda Alterar')" >
            <i class="fa fa-calendar-check-o"></i> Não compareceu
        </button>
    </div>
</div></div>

</div>
<script>
    configuraTela(); 
</script>