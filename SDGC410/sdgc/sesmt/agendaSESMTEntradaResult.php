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
        <button class="btn btn-success" data-toggle="modal" data-target="#fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" ><i class="fa fa-calendar-check-o"></i> Agendar</button>
        <div class="modal fade" id="fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" role="dialog">
          <div class="modal-dialog modal-md">

            <div class="modal-content">
              <div class="modal-body">
                    <div class="col-sm-6">
                        <label>Médico</label>
                        <select id="agendaMedico" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <option value="1">dr1</option>
                            <option value="2">dr2</option>
                            <option value="3">dr3</option>
                            <option value="4">dr4</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                      <label>Dia</label>
                      <select id="agendaDia" class="form-control select2" style="width: 100%;">
                          <option value=""></option>
                          <option>01/02/2020</option>
                          <option>01/02/2020</option>
                          <option>01/02/2020</option>
                          <option>01/02/2020</option>
                        </select>
                    </div>
                    <div class="col-sm-12"><br></div>
              </div>
              <div class="modal-footer">
                    <button class="btn btn-primary" onclick="agendaSESMTAgendar('agendar',$('#agendaMedico').val(),$('#agendaDia').val())" type="button">
                        Confirmar
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<script>
    configuraTela(); 
</script>