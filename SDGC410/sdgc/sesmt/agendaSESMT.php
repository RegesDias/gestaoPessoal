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
                    <a href="#" onclick="agendaSESMTEntrada('Entrada')">
                        <i class="fa fa-ambulance"></i> Entrada
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" onclick="agendaSESMTAtendimentos('Atendimentos')">
                        <i class="fa fa-stethoscope"></i> Atendimentos
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" onclick="agendaSESMTBuscar('Buscar')">
                        <i class="fa fa-search"></i> Buscar
                        <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
               <?php if($btnChamadosAdm == true){ ?>
                    <li class="active">
                        <a href="#" onclick="agendaSESMTMedico('Cadastrar Médicos')">
                            <i class="fa fa-user-md"></i> Cadastrar Médicos
                            <span class="label label-primary pull-right"><i class="fa fa-angle-double-right"></i></span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" onclick="agendaSESMTAgendaEditar('Agenda Alterar')">
                            <i class="fa  fa-medkit"></i> Agenda
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
        //ENTRADA--------------------------------------------
        //--------------------------------------------------     
        //abrir
        $dados = array('tipo');
        postRestAjax('agendaSESMTEntrada','agendaSESMTCorpo','sesmt/agendaSESMTEntrada.php',$dados);
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownList','agendaSESMTCorpo','sesmt/agendaSESMTEntrada.php',$dados);  
        //Result
        $dados = array('acao','idChamado','texto');
        postRestAjax('agendaSESMTEntradaResult','agendaSESMTCorpo','sesmt/agendaSESMTEntradaResult.php',$dados);  
        
        //ATENDIMENTOS--------------------------------------------
        //--------------------------------------------------
        $dados = array('tipo');
        postRestAjax('agendaSESMTAtendimentos','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados);
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownList','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados); 
        //Result
        $dados = array('acao','idChamado','texto');
        postRestAjax('agendaSESMTAtendimentosResult','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentosResult.php',$dados);
        
        //Ficha
        $dados = array('acao','idChamado','texto');
        postRestAjax('agendaSESMTAtendimentosFichaMedica','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentosFichaMedica.php',$dados);

        //BUSCAR--------------------------------------------
        //--------------------------------------------------
        $dados = array('tipo');
        postRestAjax('agendaSESMTBuscar','agendaSESMTCorpo','sesmt/agendaSESMTBuscar.php',$dados);
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownList','agendaSESMTCorpo','sesmt/agendaSESMTBuscar.php',$dados); 
        //Result
        $dados = array('acao','idChamado','texto');
        postRestAjax('agendaSESMTBuscarResult','agendaSESMTCorpo','sesmt/agendaSESMTBuscarResult.php',$dados);
        
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
        
        //CADASTRAR MEDICO--------------------------------------------
        //--------------------------------------------------
        $dados = array('acao');
        postRestAjax('agendaSESMTMedico','agendaSESMTCorpo','sesmt/agendaSESMTMedico.php',$dados);
        
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
        postRestAjax('agendaSESMTAgendaEditar','agendaSESMTCorpo','sesmt/agendaSESMTAgendaEditar.php',$dados);
        //salvar
        $dados = array('acao', 'idUserLogin','idChamadoCategoria');
        postRestAjax('acessoSalvar','agendaSESMTCorpo','sesmt/agendaSESMTAbrirAgenda.php',$dados);
        //Alterar Status
        $dados = array('acao', 'id');
        postRestAjax('alterarStatusAcesso','agendaSESMTCorpo','sesmt/agendaSESMTAbrirAgenda.php',$dados);
        
  ?>
<script>
    window.onload = agendaSESMTEntrada('Entrada');
</script>