<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Cadastro Médico</h3>
    </div>
    <div class="box-body">
        <div class="row" id="idBoxSelectSecretaria">
            <div class="col-md-12">
                <label>Secretaria</label>
                <select name="idSecretaria" size="1"  class="form-control select2" id='idSecretaria' style="width: 100%;">

                </select>
            </div>
        </div>
        <div class="row" id="idBoxSelectSetor">
            <div class="col-md-12">
                <label>Setor</label>
                <select name="idSetor" size="1" class="form-control select2" id="idSetor" style="width: 100%;">

                </select>
            </div>
        </div>
        <label for="exampleInputEmail1">Servidor</label>
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
                <label>Dia Semana</label>
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
                <label>Atendimentos</label>
                <input type='number' class="form-control" style="width: 100%;">
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?php if($respGet[acao] != 'buscarId'){ ?>
            <button type="submit" id='enviarChamado' class="pull-right btn btn-primary" onclick="modeloSalvar('modeloSalvar', $('#idCategoria').val(), $('#textoMsn').val())">
                <i class="fa fa-envelope-o"></i> Enviar
            </button>
        <?php }else{?>
            <button type="submit" id='enviarChamado' class="pull-right btn" onclick="modeloEditar('modeloEditar', $('#idCategoria').val(), $('#textoMsn').val(),<?=$editarModelo[0][id]?>)">
                <i class="fa fa-edit"></i> Alterar
            </button>
        <?php }?>
        <button type="reset" class="btn btn-default" onclick="agendaSESMTModelo('Todos')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
</div>
<div class="box-group" id="accordion">
          <div class="panel box box-primary">
            <div class="box-header with-border">
                  <div class="pull-right box-tools">
                      <div class="pull-right box-tools">
                          <button class="btn btn-primary btn-small" onclick="alterarStatusModelo('buscarId', '<?=$valor['id']?>')" id="perfil<?=$valor['id']?>" type="button">
                              <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-danger btn-small" onclick="alterarStatusModelo('<?=$acao?>', '<?=$valor['id']?>')" id="perfil<?=$valor['id']?>" type="button">
                              <i class="fa fa-print"></i>
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