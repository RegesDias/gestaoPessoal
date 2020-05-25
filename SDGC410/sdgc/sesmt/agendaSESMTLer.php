<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
?> 
<div class="box box-primary">
      <div class="row">
        <div class="col-md-12">
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="<?=exibeFoto('09487331794')?>" alt="User Image">
                <span class="username"><a href="#">027437 - REGES FERNANDES DIAS</a></span>
                <span class="description">Assistente de Adm e Logistica</span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                  <i class="fa fa-circle-o"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <p><b>Nascimento:</b> 21/08/1982 <b>Data Admissão:</b>01/02/2010</p>
              <p><b>Regime:</b> Estatutario  <b>Hora/Semanal:</b> 30 </p>
              
            <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Marcações</button>
            <button class="btn btn-success" data-toggle="modal" data-target="#fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" ><i class="fa fa-calendar-check-o"></i> Agendar</button>
                <div class="modal fade" id="fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" role="dialog">
                  <div class="modal-dialog modal-md">

                    <div class="modal-content">
                      <div class="modal-body">
                            <div class="col-sm-6">
                                <label>Médico</label> <sup><div id="setor" class="hide">!</div></sup>
                                <select id="agendaMedico" class="form-control select2" style="width: 100%;">
                                    <option value=""></option>
                                    <option value="volvo">dr1</option>
                                    <option value="saab">dr2</option>
                                    <option value="opel">dr3</option>
                                    <option value="audi">dr4</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                              <label>Dia</label> <sup><div id="setor" class="hide">!</div></sup>
                              <select id="agendaDia" class="form-control select2" style="width: 100%;">
                                  <option value=""></option>
                                  <option value="volvo">01/02</option>
                                  <option value="saab">02/02</option>
                                  <option value="opel">03/02</option>
                                  <option value="audi">04/02</option>
                                </select>
                            </div>
                            <div class="col-sm-12"><br></div>
                      </div>
                      <div class="modal-footer">
                            <button class="btn btn-primary" onclick="fecharEmSecretaria('fecharVariavelSecretaria','<?=$ArrEsp[idVariavelDesc]?>','<?=$ArrEsp[variaveisDesc]?>')" type="button">
                                Confirmar
                            </button>
                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                      </div>
                    </div>
                  </div>
                </div>
              <span class="pull-right"><h3>Atendimento 7</h3></span>
            </div>
            <!-- /.box-body -->
            <div class="box-footer box-comments">
              <div class="box-comment">

                <div class="comment-text">
                      <span class="username">
                        5 - PERICULOSIDADE
                        <span class="text-muted pull-right">Aberto em: 01/02/2010</span>
                      </span><!-- /.username -->
                  It is a long established fact that a reader will be distracted
                  by the readable content of a page when looking at its layout.
                </div>
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
              <div class="box-comment">
                        
                <div class="comment-text">
                      <span class="username">
                        2 - ATESTADO
                        <span class="text-muted pull-right">Aberto em: 01/02/2010</span>
                      </span><!-- /.username -->
                  It is a long established fact that a reader will be distracted
                  by the readable content of a page when looking at its layout.
                </div>
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
   
</div>
<script>
    configuraTela(); 
</script>