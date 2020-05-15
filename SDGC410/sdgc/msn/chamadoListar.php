<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $cTipo = array($respGet['tipo']);
    if(isset($respGet[tipo])){
        $_SESSION[listaChamados] = getRest('chamadows/getListaChamadoUsuario', $cTipo);
        $_SESSION[chamadosCategoria] = getRest('chamadows/listarChamadoCategoria');
    }
    
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
        <?=controleDePagina($_SESSION[listaChamados] ,$respGet[pg],"pagUpDownList","chamadoModelo");?> 
    </div>
    <div class="table-responsive mailbox-messages">
      <table class="table table-hover table-striped">
        <tbody>
            <?php
            foreach (paginaAtual($_SESSION[listaChamados],$respGet[pg]) as $v) { ?>
            <tr> 
              <td>
                     <b><?=$v[id]?></b>
              </td>
              <td class="mailbox-subject">
                  <a href="#" onclick="chamadoLer('ler','<?=$v[id]?>')">
                    <?=$v[titulo]?>
                  </a>
              </td>
              <td class="mailbox-name">
                     <?=$v[nomeUserLogin]?>
              </td>
              <td class="mailbox-date">
                    <?=$v[categoria]?>
              </td>
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
        <?=controleDePagina($_SESSION[listaChamados] ,$respGet[pg],"pagUpDownList","chamadoModelo");?> 
    </div>
  </div>
</div>
<?php if (!count($_SESSION[listaChamados])){ ?>
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Vazio</h3>

              <p>Nenhum status chamados</p>
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
