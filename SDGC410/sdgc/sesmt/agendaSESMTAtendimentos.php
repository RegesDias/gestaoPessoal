<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    print_p();
    
?> 
<div class="box box-primary">
  <div class="box-header with-border">
    <div class="col-sm-12">
        <h3 class="box-title"><?=$respGet['tipo']?> <span class="label label-primary"><?=count($_SESSION[listaChamados])?></span></h3>
    </div>
    <div class="col-sm-12"><br></div>
    <div class="col-sm-6">
        <label>Período</label> 
        <select id="buscaPeriodo"  class="form-control select2" style="width: 100%;">
            <option value=""></option>
            <option value="dia">Hoje</option>
            <option value="semana">Esta Semana</option>
            <option value="mes">Este mês</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Médico</label>
        <select id="buscaMedico" class="form-control select2" style="width: 100%;">
            <option value=""></option>
            <option value="1">dr1</option>
            <option value="2">dr2</option>
            <option value="3">dr3</option>
            <option value="4">dr4</option>
        </select>
    </div>
    <div class="col-sm-12"><br></div>
    <div class="modal-footer">
        <button class="btn btn-primary" onclick="buscaAtendimentos('buscaAtendimento',$('#buscaPeriodo').val(),$('#buscaMedico').val())" type="button">
            <i class="fa fa-search"></i> Buscar
        </button>
    </div>
    <!-- /.box-tools -->
  </div>
  <!-- /.box-header -->
  <div class="box-body no-padding">
    <div class="mailbox-controls">
        <?php require_once '../sesmt/dadosMedico.php'; ?>
    </div>
    <div class="table-responsive mailbox-messages">
        <h3>Atendimentos de Hoje</h3>
      <table class="table table-hover table-striped">
        <tbody>
            <tr>
                <td colspan='5'><center><b><h4>Manhã</h4></b></center></td>
            </tr>
            <tr>
              <td class="mailbox-subject">
                    <b>Status</b>
              </td>
              <td>
                   <b>Data</b>
              </td>
              <td class="mailbox-name">
                   <b>Servidor</b>
              </td>
              <td class="mailbox-date">
                  <b>Requerimento</b>
              </td>
              <td class="mailbox-date">
                  <b>Ação</b>
              </td>
            </tr>
            <tr>
              <td class="mailbox-subject">
                    Agendado
              </td>
              <td>
                  01/01/2020
              </td>
              <td class="mailbox-name">
                  <a href="#" onclick="agendaSESMTAtendimentosResult('ler','<?=$v[id]?>')">
                      27437 - REGES FERNANDES DIAS
                  </a>
              </td>
              <td class="mailbox-date">
                   ATESTADO
              </td>
              <td class="mailbox-date">
                <div class="modal-footer">
                    <button class="btn btn-info" data-toggle="modal" data-target="#fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" >
                        <i class="fa fa-calendar-check-o"></i> Agendar
                    </button>
                </div>
                <?php require_once '../sesmt/modalAgendar.php'; ?>
              </td>
            </tr>
            <tr>
                <td colspan='5'><center><b><h4>Tarde</h4></b></center></td>
            </tr>
            <tr>
              <td class="mailbox-subject">
                    <b>Status</b>
              </td>
              <td>
                   <b>Data</b>
              </td>
              <td class="mailbox-name">
                   <b>Servidor</b>
              </td>
              <td class="mailbox-date">
                  <b>Requerimento</b>
              </td>
              <td class="mailbox-date">
                  <b>Ação</b>
              </td>
            </tr>
            <tr>
              <td class="mailbox-subject">
                    -
              </td>
              <td>
                  01/01/2020
              </td>
              <td class="mailbox-name">
                  <a href="#" onclick="agendaSESMTAtendimentosResult('ler','<?=$v[id]?>')">
                      Horário Vago
                  </a>
              </td>
              <td class="mailbox-date">
                  -
              </td>
              <td class="mailbox-date">
                  <div class="modal-footer">
                <button class="btn btn-warning btn-small" data-toggle="modal" data-target="#fecharLotacao2<?=$ArrEsp[idVariavelDesc]?>" >
                    <i class="fa fa-calendar-check-o"></i> Agendar
                </button>
                <div class="modal fade" id="fecharLotacao2<?=$ArrEsp[idVariavelDesc]?>" role="dialog">
                  <div class="modal-dialog modal-md">

                    <div class="modal-content">
                      <div class="modal-body">
                            <div class="col-sm-12">
                              <label>Servidor</label>
                              <select id="agendaDia" class="form-control select2" style="width: 100%;">
                                  <option value=""></option>
                                  <option>2222-joao</option>
                                  <option>2223-Reges</option>
                                  <option>2224-Amauri</option>
                                </select>
                            </div>
                            <div class="col-sm-12"><br></div>
                      </div>
                      <div class="modal-footer">
                            <button class="btn btn-primary" onclick="buscaAtendimentos('agendar',$('#agendaMedico').val(),$('#agendaDia').val())" type="button">
                                Confirmar
                            </button>
                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
              </td>
            </tr> 
        </tbody>
      </table>
      <!-- /.table -->
    </div>
    <!-- /.mail-box-messages -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer no-padding">
    <div class="mailbox-controls">
    </div>
  </div>
</div>
<div class="modal-footer">
      <button class="btn btn-warning" onclick="fecharEmSecretaria('fecharVariavelSecretaria','<?=$ArrEsp[idVariavelDesc]?>','<?=$ArrEsp[variaveisDesc]?>')" type="button">
        <i class="fa fa-minus"></i> Remarcar Todos
      </button>
      <button class="btn btn-success" onclick="fecharEmSecretaria('fecharVariavelSecretaria','<?=$ArrEsp[idVariavelDesc]?>','<?=$ArrEsp[variaveisDesc]?>')" type="button">
        <i class="fa fa-plus"></i> Criar Vaga
      </button>
      <button class="btn btn-info" onclick="fecharEmSecretaria('fecharVariavelSecretaria','<?=$ArrEsp[idVariavelDesc]?>','<?=$ArrEsp[variaveisDesc]?>')" type="button">
        <i class="fa fa-print"></i> Imprimir
      </button>
</div>
<?php if (!count($_SESSION[listaChamados])){ ?>
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Vazio</h3>

              <p>Nenhum Atendimento Encontrado</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="#" class="small-box-footer">
                <br>
            </a>
          </div>
        </div>
<?php }  
        //Agendar
        $dados = array('acao','agendaMedico','agendaDia','agendaPeriodo','idPaciente');
        $funcao = array('fecharModal');
        postRestAjax('agendaSESMTAgendar','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados,'','',$funcao);
?>
<script>
    configuraTela(); 
</script>