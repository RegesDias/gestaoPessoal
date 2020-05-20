<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $buscAcessoNivel = array("9");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao', $buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
//        if ($valor['link'] == 'agendaSESMTsAdm') {
            $btnChamadosAdm = true;
            break;
//        }
    }
    $btnChamadosAdm = true;
?> 
<section class="content-header">
      <h1>
        Acompanhamento
        <?php if($btnChamadosAdm == true){ ?>
            <!--<small><span class="label label-danger">12 abertos</span></small>-->
        <?php }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Agenda SESMT</a></li>
        <li class="active">Acompanhamento</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
<!--            <button class="btn btn-primary btn-block margin-bottom" onclick="agendaSESMTEscrever('escrever')"  type="button">
                Escrever Chamado
            </button>-->
          <div class="box box-solid">
            <div class="box-header with-border">
              <!--<h3 class="box-title">Chamados</h3>-->
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="#" onclick="agendaSESMTListar('Entrada')">
                        <i class="fa fa-medkit"></i> Entrada
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" onclick="agendaSESMTListar('Agendado')">
                        <i class="fa fa-stethoscope"></i> Agendando
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
                 <li class="active">
                    <a href="#" onclick="agendaSESMTListar('Finalizado')">
                        <i class="fa fa-thumbs-o-up"></i> Finalizado
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                        
                    </a>
                </li>
                 <li class="active">
                    <a href="#" onclick="agendaSESMTListar('Todos')">
                        <i class="fa fa-hdd-o"></i> Todos
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
               <?php if($btnChamadosAdm == true){ ?>
                    <li class="active">
                        <a href="#" onclick="agendaSESMTModelo('Todos')">
                            <i class="fa fa-user-md"></i> Cadastrar Médicos
                            <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" onclick="agendaSESMTAcesso('Todos')">
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
        <div class="col-md-9" id="agendaSESMTCorpo">
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  <?php
        //ESCREVER--------------------------------------------
        //----------------------------------------------------
        $dados = array('acao');
        postRestAjax('agendaSESMTEscrever','agendaSESMTCorpo','sesmt/agendaSESMTEscrever.php',$dados);
        
        $dados = array('acao', 'categoria','assunto','texto');
        postRestAjax('agendaSESMTSalvar','agendaSESMTCorpo','sesmt/agendaSESMTEscrever.php',$dados);
        
        //LER--------------------------------------------
        //-----------------------------------------------
        $dados = array('acao','idChamado','texto');
        postRestAjax('agendaSESMTLer','agendaSESMTCorpo','sesmt/agendaSESMTLer.php',$dados);
        $dados = array('acao');
        postRestAjax('agendaSESMTLer2','agendaSESMTCorpo','sesmt/agendaSESMTLer.php',$dados);
        
        //LISTAR--------------------------------------------
        //--------------------------------------------------
        $dados = array('tipo');
        postRestAjax('agendaSESMTListar','agendaSESMTCorpo','sesmt/agendaSESMTListar.php',$dados);
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownList','agendaSESMTCorpo','sesmt/agendaSESMTListar.php',$dados); 
        
        //MODELO--------------------------------------------
        //--------------------------------------------------
        $dados = array('acao');
        postRestAjax('agendaSESMTModelo','agendaSESMTCorpo','sesmt/agendaSESMTModelo.php',$dados);
        
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownCh','agendaSESMTCorpo','sesmt/agendaSESMTModelo.php',$dados); 
        //salvar
        $dados = array('acao', 'categoria','texto');
        postRestAjax('modeloSalvar','agendaSESMTCorpo','sesmt/agendaSESMTModelo.php',$dados);
        //editar
        $dados = array('acao', 'idCategoria','texto','id');
        postRestAjax('modeloEditar','agendaSESMTCorpo','sesmt/agendaSESMTModelo.php',$dados);
        //Alterar Status
        $dados = array('acao', 'id');
        postRestAjax('alterarStatusModelo','agendaSESMTCorpo','sesmt/agendaSESMTModelo.php',$dados);
        
        //ACESSO_____________________________________________________________
        //-------------------------------------------------------------------
        $dados = array('acao');
        postRestAjax('agendaSESMTAcesso','agendaSESMTCorpo','sesmt/agendaSESMTAcesso.php',$dados);
        //salvar
        $dados = array('acao', 'idUserLogin','idChamadoCategoria');
        postRestAjax('acessoSalvar','agendaSESMTCorpo','sesmt/agendaSESMTAcesso.php',$dados);
        //Alterar Status
        $dados = array('acao', 'id');
        postRestAjax('alterarStatusAcesso','agendaSESMTCorpo','sesmt/agendaSESMTAcesso.php',$dados);
        
  ?>
<script>
    window.onload = agendaSESMTListar('Aberto');
</script>