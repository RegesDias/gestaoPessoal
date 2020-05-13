<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $cTipo = array($respGet['tipo']);
    $chamadosLista = getRest('chamadows/getListaChamadoUsuario',$cTipo);   
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
            <?php  foreach ($chamadosLista as $v){ ?>
            <tr>
              <td>
                  <a href="#" onclick="chamadoLer('ler','<?=$v[id]?>')">
                    <?=$v[id]?>
                  </a>
              </td>
              <td class="mailbox-star"><a href="#"></a></td>
              <td class="mailbox-name">
                     <?=$v[nomeUserLogin]?>
                </a>
              <td class="mailbox-subject">
                  <?=$v[titulo]?>
              </td>
              <td class="mailbox-attachment"></td>
              <td class="mailbox-date"><?=$v[categoria]?></td>
            </tr>  
           <?php }?>
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