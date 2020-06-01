<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
if($respGet[acao] == 'medicoSalvar'){
        $cadastrarMedico = array(      
                        'idHistFunc' => $respGet['idHistFunc'],
                        'CRM' => $respGet['CRM'],
                        'atendimentosManha' => $respGet['atendimentosManha'],
                        'atendimentosTarde' => $respGet['atendimentosTarde'],
                        'listDiaManha'=> $respGet['diaManha'],
                        'listDiaTarde'=> $respGet['diaTarde']
                    );
        
        
        $cadastrarMedico = array($cadastrarMedico);
        $executar = postRest('requerimento/postIncluirRequerimentoMedicos',$cadastrarMedico);
}
 exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
print_p();
?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Cadastro Médico</h3>
    </div>
    <div class="box-body">
        <?php if($respGet[acao] != 'editarMedico'){ ?>
        <div class="row" id="idBoxSelectSecretaria">
            <div class="col-md-12">
                <label>Secretaria</label>
                <select name="idSecretaria" size="1"  class="form-control select2" id='idSecretaria' style="width: 100%;">
                    <option value="0940">RH</option>
                </select>
            </div>
        </div>
        <div class="row" id="idBoxSelectSetor">
            <div class="col-md-12">
                <label>Setor</label>
                <select name="idSetor" size="1" class="form-control select2" id="setor" style="width: 100%;">
                    <option value="0940">setinf</option>
                </select>
            </div>
        </div>
        <?php }?>
        <label for="exampleInputEmail1">Servidor</label>
        <select  class="form-control select2" name='categoria' id='servidor' style="width: 100%;">
             <option selected='selected' value='0073540000'>Reges Dias</option>
            <?php foreach ($agendaSESMTsCategoria as $value) {
             }?>
        </select>
        <label for="exampleInputEmail1">CRM</label>
             <input type='text' id='CRM' class="form-control" style="width: 100%;">

        <div class="row" id="idBoxSelectDiaSemana">
            <div class="col-md-6">
                <label>Dia Semana Manhã</label>
                <select name="diaManha" size="1" multiple="multiple" class="form-control select2" id="diaManha" style="width: 100%;">
                    <option value = '1'>Sabado</option>
                    <option value = '2'>Segunda</option>
                    <option value = '3'>Terça</option>
                    <option value = '4'>Quarta</option>
                    <option value = '5'>Quinta</option>
                    <option value = '6'>Sexta</option>
                    <option value = '7' >Domingo</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Atendimentos Manhã</label>
                <input type='number' id='atendimentosManha' class="form-control" style="width: 100%;">
            </div>
        </div>
        <div class="row" id="idBoxSelectDiaSemana">
            <div class="col-md-6">
                <label>Dia Semana Tarde</label>
                <select name="diaTarde" size="1" multiple="multiple" class="form-control select2" id="diaTarde" style="width: 100%;">
                    <option value = '1'>Sabado</option>
                    <option value = '2'>Segunda</option>
                    <option value = '3'>Terça</option>
                    <option value = '4'>Quarta</option>
                    <option value = '5'>Quinta</option>
                    <option value = '6'>Sexta</option>
                    <option value = '7' >Domingo</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Atendimentos Tarde</label>
                <input type='number' id='atendimentosTarde' class="form-control" style="width: 100%;">
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?php if($respGet[acao] != 'editarMedico'){ ?>
            <button class="btn btn-success pull-right btn-sm" onclick="medicoSalvar('medicoSalvar',$('select#diaManha option').map(function() {return $(this).val();}).get(),$('select#diaTarde option').map(function() {return $(this).val();}).get(),$('#servidor').val(),$('#atendimentosManha').val(),$('#atendimentosTarde').val(),$('#CRM').val())" type="button">
                   <i class="fa fa-save"></i> Salvar
            </button>
        <?php }else{?>
            <button class="btn btn-success pull-right btn-sm" onclick="medicoSalvar('medicoSalvar',$('select#diaManha option').map(function() {return $(this).val();}).get(),$('select#diaTarde option').map(function() {return $(this).val();}).get(),$('#servidor').val(),$('#atendimentosManha').val(),$('#atendimentosTarde').val(),$('#CRM').val())" type="button">
                <i class="fa fa-edit"></i> Alterar
            </button>
        <?php }?>
        <button type="reset" class="btn btn-default" onclick="agendaSESMTMedico('Limpar')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
</div>
<div class="box-group" id="accordion">
          <div class="panel box box-primary">
            <div class="box-header with-border">
                  <div class="pull-right box-tools">
                      <div class="pull-right box-tools">
                          <button class="btn btn-primary btn-small" onclick="medicoStatus('editarMedico', '2555')" id="perfil<?=$valor['id']?>" type="button">
                              <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-info btn-small" onclick="medicoStatus('ativarMedico', '22555')" id="perfil<?=$valor['id']?>" type="button">
                              <i class="fa fa-toggle-off"></i>
                          </button>
                          <button class="btn btn-info btn-small" onclick="medicoStatus('desativarMedico', '22555')" id="perfil<?=$valor['id']?>" type="button">
                              <i class="fa fa-toggle-on"></i>
                          </button>
                      </div>
                  </div>
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#abre<?=$valor['id']?>">
                    22555- João Jabor
                  </a>
                </h4>
            </div>
            <div id="abre<?=$valor['id']?>" class="panel-collapse collapse <?=$in?>">
              <div class="box-body">
                  <button class="btn link-button-limpo inline" id="perfil2<?=$valor['id']?>" type="button">
                       <form action="#" method="post">
                         <div class="item">
                               <div>
                                   <div class="row">
                                       <div class="attachment">
                                           <p class="filename">
                                               <b>Atualizado em:</b> <?=dataHoraBr($data)?><?=$in?>
                                           </p>
                                           <p class="filename">
                                              <b>Total Atendimentos</b> 12<?=$in?>
                                           </p>
                                           <p class="filename">
                                              <b>Dias de Semana:</b> Segunda e Quinta <?=$in?>
                                           </p>
                                       </div>
                                  </div>
                               </div>
                           </div>
                       </form>
                   </button>
              </div>
            </div>
          </div>
</div>
<script>
    configuraTela(); 
</script>

<?php 
        //require_once "../javascript/fRelat.php";