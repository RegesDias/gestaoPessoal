<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    
?> 
<div class="box box-primary">
  <div class="box-header with-border">
    <div class="col-sm-12">
        <h3 class="box-title"><?=$respGet['tipo']?> <span class="label label-primary"><?=count($_SESSION[listaChamados])?></span></h3>
    </div>
    <div class="col-sm-12"><br></div>
    <div class="col-sm-6">
        <label>Período</label> <sup><div id="setor" class="hide">!</div></sup>
        <select id="agendaMedico"  class="form-control select2" style="width: 100%;">
            <option value=""></option>
            <option value="dia">Hoje</option>
            <option value="semana">Esta Semana</option>
            <option value="opel">Este mês</option>
        </select>
    </div>
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
    <div class="col-sm-12"><br></div>
    <div class="modal-footer">
          <button class="btn btn-primary" onclick="fecharEmSecretaria('fecharVariavelSecretaria','<?=$ArrEsp[idVariavelDesc]?>','<?=$ArrEsp[variaveisDesc]?>')" type="button">
              Buscar
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
      <table class="table table-hover table-striped">
        <tbody>
            <tr>
              <td>
                   <b>Data</b>
              </td>
              <td class="mailbox-subject">
                    <b>id</b>
              </td>
              <td class="mailbox-name">
                   <b>Dados</b>
              </td>
              <td class="mailbox-date">
                  <b>Requerimento</b>
              </td>
            </tr>
            <tr> 
              <td>
                  01/01/2020
              </td>
              <td class="mailbox-subject">
                    7
              </td>
              <td class="mailbox-name">
                  <a href="#" onclick="agendaSESMTAtendimentosResult('ler','<?=$v[id]?>')">
                      27437 - REGES FERNANDES DIAS
                  </a>
              </td>
              <td class="mailbox-date">
                   ATESTADO
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
<?php if (!count($_SESSION[listaChamados])){ ?>
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Vazio</h3>

              <p>Nenhum agendaSESMT encontrado</p>
            </div>
            <div class="icon">
              <i class="fa   fa-check-square-o"></i>
            </div>
            <a href="#" class="small-box-footer">
                <br>
            </a>
          </div>
        </div>
<?php } ?>
<script>
    configuraTela(); 
</script>