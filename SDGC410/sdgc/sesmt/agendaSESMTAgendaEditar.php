<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
print_p();
?>
 <div class="tab-pane active" id="abrirAgenda">
    <div class="box-header with-border">
        <h3 class="box-title">Abrir Agenda</h3>
    </div>
    <div class="box-body">
        <label for="exampleInputEmail1">Médico</label>
        <select id="buscaMedico" class="form-control select2" style="width: 100%;">
            <option value=""></option>
            <option value="1">dr1</option>
            <option value="2">dr2</option>
            <option value="3">dr3</option>
            <option value="4">dr4</option>
        </select>
        <label for="exampleInputEmail1">Período</label>
        <select id="buscaMedico" multiple="multiple" class="form-control select2" style="width: 100%;">
            <option value=""></option>
            <option value="1">Manhã</option>
            <option value="2">Tarde</option>
        </select>
        <div class="form-group">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    Mês <input type="radio" id="male" name="gender" value="male" checked="checked">
                    Dia <input type="radio" id="female" name="gender" value="female">           
                </label> 
                <input type='month'  class="form-control" name='mes' id='mes' style="width: 100%;">
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" id='enviarChamado' class="pull-right btn btn-primary" onclick="agendaSESMTAgendaSalvar('AbrirAgenda', $('#buscaMedico').val(), $('#mes').val())">
            <i class="fa fa-envelope-o"></i> Liberar
        </button>
        <button type="reset" class="btn btn-default" onclick="agendaSESMTAgendaEditar('limpar')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
</div>
<script>
    configuraTela(); 
</script>

