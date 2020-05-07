<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
?>     
<section class="content-header">
      <h1>
        Mailbox
        <small>13 new messages</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mailbox</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
            <button class="btn btn-primary btn-block margin-bottom" onclick="chamadoEscrever('escrever')"  type="button">
                Criar Chamado
            </button>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="#" onclick="caixaEntrada('Aberto')">
                        <i class="fa fa-inbox"></i> Aberto
                        <span class="label label-primary pull-right">12</span>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="caixaEntrada('Analisando')">
                        <i class="fa fa-inbox"></i> Analisando
                        <span class="label label-primary pull-right">12</span>
                    </a>
                </li>
                <li><a href="#"><i class="fa fa-file-text-o"></i> Finalizado</a></li>
                <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
                </li>
                <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col ------------------------------------------------------------------------->
        <div class="col-md-9" id="chamadoCorpo">
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  <?php
      //exibir
        $dados = array('acao');
        postRestAjax('chamadoEscrever','chamadoCorpo','msn/chamadoEscrever.php',$dados);
        $dados = array('acao');
        postRestAjax('chamadoLer','chamadoCorpo','msn/chamadoLer.php',$dados);
        $dados = array('acao');
        postRestAjax('caixaEntrada','chamadoCorpo','msn/chamadoEntrada.php',$dados);
  ?>
<script>
    window.onload = caixaEntrada();
</script>