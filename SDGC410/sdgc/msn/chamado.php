<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $buscAcessoNivel = array("9");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao', $buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if ($valor['link'] == 'chamadosAdm') {
            $btnChamadosAdm = true;
            break;
        }
    }
?> 
<section class="content-header">
      <h1>
        Chamados
        <?php if($btnChamadosAdm == true){ ?>
            <!--<small><span class="label label-danger">12 abertos</span></small>-->
        <?php }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Chamados</a></li>
        <li class="active">Acesso</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
            <button class="btn btn-primary btn-block margin-bottom" onclick="chamadoEscrever('escrever')"  type="button">
                Escrever Chamado
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
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" onclick="chamadoListar('Analisando')">
                        <i class="fa fa-comment-o"></i> Analisando
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
                 <li class="active">
                    <a href="#" onclick="chamadoListar('Finalizado')">
                        <i class="fa fa-coffee"></i> Finalizado
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                        
                    </a>
                </li>
                 <li class="active">
                    <a href="#" onclick="chamadoListar('Todos')">
                        <i class="fa fa-hdd-o"></i> Todos
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
               <?php if($btnChamadosAdm == true){ ?>
                    <li class="active">
                        <a href="#" onclick="chamadoModelo('Todos')">
                            <i class="fa fa-file-text"></i> Modelos
                            <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" onclick="chamadoAcesso('Todos')">
                            <i class="fa fa-user-o"></i> Acesso
                            <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                        </a>
                    </li>
                <?php }?>
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
        //----------------------------------------------------
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
        //--------------------------------------------------
        $dados = array('tipo');
        postRestAjax('chamadoListar','chamadoCorpo','msn/chamadoListar.php',$dados);
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownList','chamadoCorpo','msn/chamadoListar.php',$dados); 
        
        //MODELO--------------------------------------------
        //--------------------------------------------------
        $dados = array('acao');
        postRestAjax('chamadoModelo','chamadoCorpo','msn/chamadoModelo.php',$dados);
        
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownCh','chamadoCorpo','msn/chamadoModelo.php',$dados); 
        //salvar
        $dados = array('acao', 'categoria','texto');
        postRestAjax('modeloSalvar','chamadoCorpo','msn/chamadoModelo.php',$dados);
        //editar
        $dados = array('acao', 'idCategoria','texto','id');
        postRestAjax('modeloEditar','chamadoCorpo','msn/chamadoModelo.php',$dados);
        //Alterar Status
        $dados = array('acao', 'id');
        postRestAjax('alterarStatusModelo','chamadoCorpo','msn/chamadoModelo.php',$dados);
        
        //ACESSO_____________________________________________________________
        //-------------------------------------------------------------------
        $dados = array('acao');
        postRestAjax('chamadoAcesso','chamadoCorpo','msn/chamadoAcesso.php',$dados);
        //salvar
        $dados = array('acao', 'idUserLogin','idChamadoCategoria');
        postRestAjax('acessoSalvar','chamadoCorpo','msn/chamadoAcesso.php',$dados);
        //Alterar Status
        $dados = array('acao', 'id');
        postRestAjax('alterarStatusAcesso','chamadoCorpo','msn/chamadoAcesso.php',$dados);
        
  ?>
<script>
    window.onload = chamadoListar('Aberto');
</script>