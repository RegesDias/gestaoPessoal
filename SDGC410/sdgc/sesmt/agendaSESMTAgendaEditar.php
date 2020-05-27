<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
print_p();
?>

<div class="box box-primary">
    <div class="box-group" id="accordion">
       <div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#abrirAgenda" data-toggle="tab">Abrir</a></li>
              <li><a href="#alterarAgenda" data-toggle="tab">Alterar</a></li>
            </ul>
            <div class="tab-content">
              <!-- /.tab-pane -->
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
                        <div class="form-group">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mês</label></label> 
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
              <!-- /.tab-pane -->

              <div class="tab-pane" id="alterarAgenda">
                    <div id="<?=$valor['id']?>" class="panel-collapse collapse <?=$in?>">
                      <div class="box-body">
                          <button class="btn link-button-limpo inline" id="perfil2<?=$valor['id']?>" type="button">
                               <form action="#" method="post">
                                 <div class="item">
                                       <div>
                                           <div class="row">
                                               <div class="attachment">
                                                   <p class="filename">
                                                       <b>Atualizado em:</b> <?=dataHoraBr($valor['dataHora'])?><?=$in?>
                                                   </p>
                                                   <p class="filename">
                                                       <b>Categoria:</b> <?=$valor[agendaSESMTCategoria][nome]?>
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
</div>
<script>
    configuraTela(); 
</script>

