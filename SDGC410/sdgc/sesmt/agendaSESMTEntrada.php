<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    
?> 
<div class="box box-primary">
  <div class="box-header with-border">
      <h3 class="box-title"><?=$respGet['tipo']?> <span class="label label-primary"><?=count($_SESSION[listaChamados])?></span></h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body no-padding">
    <div class="mailbox-controls">
    </div>
    <div class="table-responsive mailbox-messages">
      <table class="table table-hover table-striped">
        <tbody>
            <tr> 
              <td>
                     <b><?=$v[id]?></b>
              </td>
              <td class="mailbox-subject">
                    7
              </td>
              <td class="mailbox-name">
                  <a href="#" onclick="agendaSESMTEntradaResult('ler','<?=$v[id]?>')">
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