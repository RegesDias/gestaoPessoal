<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
?> 
<section class="content-header">
      <h1>
        Chamados
        <small><i>13 novos</i></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Chamados</a></li>
        <li class="active">Entrada</li>
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
              <h3 class="box-title">Chamados</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="#" onclick="chamadoListar('Aberto')">
                        <i class="fa fa-inbox"></i> Aberto
                        <span class="label label-primary pull-right">12</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" onclick="chamadoListar('Analisando')">
                        <i class="fa  fa-comment-o"></i> Analisando
                        <span class="label label-primary pull-right">12</span>
                    </a>
                </li>
                 <li class="active">
                    <a href="#" onclick="chamadoListar('Finalizado')">
                        <i class="fa fa-coffee"></i> Finalizado
                        <span class="label label-primary pull-right">12</span>
                    </a>
                </li>
                 <li class="active">
                    <a href="#" onclick="chamadoListar('Todos')">
                        <i class="fa fa-hdd-o"></i> Todos
                        <span class="label label-primary pull-right">12</span>
                    </a>
                </li>
                 <li class="active">
                    <a href="#" onclick="chamadoModelo('Todos')">
                        <i class="fa fa-file-text"></i> Modelos
                        <span class="label label-primary pull-right">12</span>
                    </a>
                </li>
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
        //ESCREVER--------------------------------------------
        //-----------------------------------------------
        $dados = array('acao');
        postRestAjax('chamadoEscrever','chamadoCorpo','msn/chamadoEscrever.php',$dados);
        
        $dados = array('acao', 'categoria','assunto','texto');
        postRestAjax('chamadoSalvar','chamadoCorpo','msn/chamadoEscrever.php',$dados);
        
        //LER--------------------------------------------
        //-----------------------------------------------
        $dados = array('acao','idChamado','texto');
        postRestAjax('chamadoLer','chamadoCorpo','msn/chamadoLer.php',$dados);
        $dados = array('acao');
        postRestAjax('chamadoLer2','chamadoCorpo','msn/chamadoLer.php',$dados);

        
        //LISTAR--------------------------------------------
        //-----------------------------------------------
        $dados = array('tipo');
        postRestAjax('chamadoListar','chamadoCorpo','msn/chamadoListar.php',$dados);
        
        //MODELO--------------------------------------------
        $dados = array('acao');
        postRestAjax('chamadoModelo','chamadoCorpo','msn/chamadoModelo.php',$dados);
        
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownCh','chamadoCorpo','msn/chamadoModelo.php',$dados); 
  ?>
<script>
    window.onload = chamadoListar('Aberto');
</script>