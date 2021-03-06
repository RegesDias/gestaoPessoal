<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $listaReqEntrada = getRest('requerimento/getRequerimentoEntrada');
    $listaMedicos = getRest('requerimento/getListarMedicoComVagasAbertas');
?> 
<div class="box box-primary">
  <!-- /.box-header -->
  <div class="box-body no-padding">
    <div class="mailbox-controls">
    </div>
    <div class="table-responsive mailbox-messages">
            <?php foreach ($listaReqEntrada as $value) {
                $value['protocolo'] = protocolo($value['protocolo']);
                $value['dataCriado'] = datahoraBr($value['dataCriado']);
                $ArrEsp = $value['idRequerimento'];
                ?>
            <div class="box-body chat" id="chat-box">
              <div class="item">
                <img src="<?=exibeFoto($value[cpf])?>" alt="user image" class="online">

                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> Requisitado em <?=$value['dataCriado']?></small>
                    <?=$value['matriculaServidor']?> - <?=$value['nomeServidor']?>
                  </a>
                </p>
                <div class="attachment">
                <table class="table table-hover table-striped">
                  <tbody>
                      <tr>
                        <td class="mailbox-date">
                            <b>Requerimento</b>
                        </td>
                        <td class="mailbox-subject">
                              <b>Protocolo</b>
                        </td>
                      </tr>
                      <tr> 
                        <td class="mailbox-date">
                             <?=$value['nomeSolicitaco']?>
                        </td>
                        <td>
                            <?=$value['protocolo']?>
                        </td>
                      </tr>
                  </tbody>
                </table>
                <div class="pull-right">
                      <button type="button" onclick="agendaSESMTEntradaResult('ler','<?=$value[cpf]?>')" class="btn btn-primary btn-sm">
                          <i class="fa fa-search"></i> Abrir
                      </button>
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#agenda<?=$ArrEsp?>" >
                        <i class="fa fa-calendar-check-o"></i> Agendar
                    </button>
                </div>
                  <?php require '../sesmt/modalAgendar.php'; ?>
                </div>
                <!-- /.attachment -->
              </div>
                </div>
            <?php }
            if (!count($listaReqEntrada)){ ?>
                    <div class="col-lg-12 col-xs-6">
                      <!-- small box -->
                      <div class="small-box bg-aqua">
                        <div class="inner">
                          <h3>Vazio</h3>

                          <p>Nenhum paciente encontrado</p>
                        </div>
                        <div class="icon">
                          <i class="fa fa-user"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            <br>
                        </a>
                      </div>
                    </div>
            <?php }?>
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
<?php 
        //Agendar
        $dados = array('acao','agendaMedico','agendaDia','agendaPeriodo','idPaciente');
        $funcao = array('fecharModal');
        postRestAjax('agendaSESMTAgendar','agendaSESMTCorpo','sesmt/agendaSESMTEntrada.php',$dados,'','',$funcao);

?>