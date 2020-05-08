<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
?> 
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$respGet['tipo']?></h3>

    <div class="box-tools pull-right">
      <div class="has-feedback">
        <input type="text" class="form-control input-sm" placeholder="Search Mail">
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
      </div>
    </div>
    <!-- /.box-tools -->
  </div>
  <!-- /.box-header -->
  <div class="box-body no-padding">
    <div class="mailbox-controls">
      <!-- Check all button -->
      </button>
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
        <button type="button" class="btn btn-default btn-sm">
            <i class="fa fa-share"></i>
        </button>
      </div>
      <!-- /.btn-group -->
        <button type="button" class="btn btn-default btn-sm" onclick="caixaEntrada('<?=$respGet['tipo']?>')">
            <i class="fa fa-refresh"></i>
        </button>
      <div class="pull-right">
        1-50/200
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
          <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
        </div>
        <!-- /.btn-group -->
      </div>
      <!-- /.pull-right -->
    </div>
    <div class="table-responsive mailbox-messages">
      <table class="table table-hover table-striped">
        <tbody>
        <tr>
          <td>
              <a href="#" onclick="chamadoLer('ler','<?=1553?>')">
                1553
              </a>
          </td>
          <td class="mailbox-star"><a href="#"></a></td>
          <td class="mailbox-name">
                 Alexander Pierce
            </a>
          <td class="mailbox-subject"><b>SDGC 4.0 Ocorrências</b> - Reportando bug
          </td>
          <td class="mailbox-attachment"></td>
          <td class="mailbox-date">Ocorrência</td>
        </tr>                  
        <tr>
          <td>
              <a href="#" onclick="chamadoLer('ler','<?=1554?>')">
                1554
              </a>
          </td>
          <td class="mailbox-star"><a href="#"></a></td>
          <td class="mailbox-name">
                 Alexander Pierce
            </a>
          <td class="mailbox-subject"><b>SDGC 4.0 Ocorrências</b> - Reportando bug
          </td>
          <td class="mailbox-attachment"></td>
          <td class="mailbox-date">Ocorrência</td>
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
      <!-- Check all button -->
      </button>
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
        <button type="button" class="btn btn-default btn-sm">
            <i class="fa fa-share"></i>
        </button>
      </div>
      <!-- /.btn-group -->
        <button type="button" class="btn btn-default btn-sm" onclick="caixaEntrada('<?=$respGet['tipo']?>')">
            <i class="fa fa-refresh"></i>
        </button>
      <div class="pull-right">
        1-50/200
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
          <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
        </div>
        <!-- /.btn-group -->
      </div>
      <!-- /.pull-right -->
    </div>
  </div>
</div>