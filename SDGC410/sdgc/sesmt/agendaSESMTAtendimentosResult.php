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
    <div class="modal-footer">
        <button class="btn btn-success" onclick="agendaSESMTAtendimentosFichaMedica('Agenda Alterar')" ><i class="fa fa-calendar-check-o"></i> Ficha Médica</button>
    </div>
</div>
<script>
    configuraTela(); 
</script>