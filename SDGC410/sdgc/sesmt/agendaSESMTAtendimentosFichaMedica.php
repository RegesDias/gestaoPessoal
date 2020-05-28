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
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Ficha Médica</h3>
    </div>
    <div class="box-body">
        <div class="row" id="idBoxSelectSecretaria">
            <div class="col-md-12">
                <label>dado 1</label>
                <select name="idSecretaria" size="1"  class="form-control select2" id='idSecretaria' style="width: 100%;">

                </select>
            </div>
        </div>
        <div class="row" id="idBoxSelectSetor">
            <div class="col-md-12">
                <label>dado</label>
                <select name="idSetor" size="1" class="form-control select2" id="idSetor" style="width: 100%;">

                </select>
            </div>
        </div>
        <label for="exampleInputEmail1">dado</label>
        <select  class="form-control select2" name='categoria' id='idCategoria' style="width: 100%;">
             <option selected='selected' value='nulo'></option>
            <?php foreach ($agendaSESMTsCategoria as $value) {
                if($value[id] == $editarModelo[0][agendaSESMTCategoria][id]){
                    $slc = 'selected';
                }else{
                    $slc = '';
                }
                ?>
                <option <?=$slc?> value='<?=$value[id]?>'><?=$value[nome]?></option>
            <?php }?>
        </select>
        <div class="row" id="idBoxSelectDiaSemana">
            <div class="col-md-6">
                <label>dado</label>
                <select name="idSetor" size="1" multiple="multiple" class="form-control select2" id="idSetor" style="width: 100%;">
                    <option>Segunda</option>
                    <option>Terça</option>
                    <option>Quarta</option>
                    <option>Quinta</option>
                    <option>Sexta</option>
                    <option>Sabado</option>
                    <option>Domingo</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>dado</label>
                <input type='number' class="form-control" style="width: 100%;">
            </div>
        </div>
    </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" data-toggle="modal" data-target="#fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" >
            <i class="fa fa-check"></i> Finalizar
        </button>
        <button class="btn btn-primary"  data-target="#fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" >
            <i class="fa fa-save"></i> Salvar
        </button>
    </div>
    <div class="modal fade" id="fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-sm-12">
                    <label>Ação</label>
                    <select id="agendaMedico" class="form-control select2" style="width: 100%;">
                        <option value=""></option>
                        <option value="1">Homologado</option>
                        <option value="2">Não Homologado</option>
                        <option value="3">Pendente de Documentos</option>
                        <option value="4">Junta Médica</option>
                    </select>
                </div>
                <div class="col-sm-12"><br></div>
            </div>
            <div class="modal-footer">
                  <button class="btn btn-primary" onclick="agendaSESMTAgendar('agendar',$('#agendaMedico').val(),$('#agendaDia').val(),$('#agendaPeriodo').val())" type="button">
                      Confirmar
                  </button>
                  <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
            </div>
        </div>
      </div>
    </div>
</div>
<script>
    configuraTela(); 
</script>