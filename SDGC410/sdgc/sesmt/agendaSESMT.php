<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $btnChamadosAdm = true;
?> 
<section class="content-header">
      <h1>
        Acompanhamento
        <?php if($btnChamadosAdm == true){ ?>

        <?php }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Agenda SESMT</a></li>
        <li class="active">Acompanhamento</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-solid">
            <div class="box-header with-border">
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="#" onclick="agendaSESMTEntrada('Entrada')">
                        <i class="fa fa-ambulance"></i> Entrada
                    </a>
                </li>
                <li class="active">
                    <a href="#" onclick="agendaSESMTAtendimentos('Atendimentos')">
                        <i class="fa fa-medkit"></i> Atendimentos
                        
                    </a>
                </li>
                <li class="active">
                    <a href="#" onclick="agendaSESMTBuscar('Buscar')">
                        <i class="fa fa-search"></i> Buscar
                        
                    </a>
                </li>
               <?php if($btnChamadosAdm == true){ ?>
                    <li class="active">
                        <a href="#" onclick="agendaSESMTAgendaEditar('Agenda Alterar')">
                            <i class="fa  fa-calendar-o"></i> Agenda
                            
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" onclick="agendaSESMTMedico('Cadastrar Médicos')">
                            <i class="fa fa-stethoscope"></i> Cadastrar Médicos
                            
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
        //---------------------------------------------------     
        //Abrir
        $dados = array('tipo');
        postRestAjax('agendaSESMTEntrada','agendaSESMTCorpo','sesmt/agendaSESMTEntrada.php',$dados);
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownList','agendaSESMTCorpo','sesmt/agendaSESMTEntrada.php',$dados);  
        //Result
        $dados = array('acao','cpf','texto');
        postRestAjax('agendaSESMTEntradaResult','agendaSESMTCorpo','sesmt/agendaSESMTEntradaResult.php',$dados);  
        
        //ATENDIMENTOS--------------------------------------------
        //--------------------------------------------------------
        $dados = array('tipo');
        postRestAjax('agendaSESMTAtendimentos','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados);
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownList','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados); 
        
        //Buscar
        $dados = array('acao','inicio','fim','medico');
        postRestAjax('buscaAtendimentos','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados);    
        
        //Result
        $dados = array('acao','cpf');
        postRestAjax('agendaSESMTAtendimentosResult','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentosResult.php',$dados);
        //status
        $dados = array('acao','idRequerimento','cpf','status');
        $funcao = array('fecharModal();');
        postRestAjax('alterarStatusRequerimento','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentosResult.php',$dados,'','',$funcao);
        //status modal
        $dados = array('acao', 'inicio','fim','medico','idRequerimento','status');
        $funcao = array('fecharModal();');
        postRestAjax('alterarStatusRequerimentoModal','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados,'','',$funcao);

        //Ficha
        $dados = array('acao','idRequerimento','cpf');
        postRestAjax('agendaSESMTAtendimentosFichaMedica','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentosFichaMedica.php',$dados);
        
        //criarVaga
        $dados = array('acao','idFolha','inicio','fim','medico');
        postRestAjax('criarVaga','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados);   

        //BUSCAR--------------------------------------------
        //--------------------------------------------------
        $dados = array('tipo');
        postRestAjax('agendaSESMTBuscar','agendaSESMTCorpo','sesmt/agendaSESMTBuscar.php',$dados);
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownList','agendaSESMTCorpo','sesmt/agendaSESMTBuscar.php',$dados); 
        //Buscar
        $dados = array('acao','nome','matricula','cpf');
        postRestAjax('buscaServidor','agendaSESMTCorpo','sesmt/agendaSESMTBuscar.php',$dados);  
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
        //------------------------------------------------------------
        $dados = array('acao');
        postRestAjax('agendaSESMTMedico','agendaSESMTCorpo','sesmt/agendaSESMTMedico.php',$dados);
        
        //pg
        $dados = array('acao', 'pg');
        postRestAjax('pagUpDownCh','agendaSESMTCorpo','sesmt/agendaSESMTMedico.php',$dados); 
        
        //salvar
        $dados = array('acao', 'diaManha','diaTarde','idHistFunc','atendimentosTarde','atendimentosManha','CRM');
        postRestAjax('medicoSalvar','agendaSESMTCorpo','sesmt/agendaSESMTMedico.php',$dados);
        
        //ativar-desativar-editar
        $dados = array('acao', 'idMedico');
        postRestAjax('medicoStatus','agendaSESMTCorpo','sesmt/agendaSESMTMedico.php',$dados);
        
        //conferirAgenda
        $dados = array('acao', 'mes','idMedico');
        $funcao = array('fecharModal();');
        $b2 = array('calendarioMedico','removeClass','hidden');
        $beforeSend= array ($b2);
        postRestAjax('conferirAgenda','calendarioMedico','sesmt/calendario.php',$dados,$beforeSend,'',$funcao);
        
        //conferirAgenda
        $dados = array('acao', 'inicio','fim','idMedico','periodo');
        $funcao = array('fecharModal();');
        postRestAjax('conferirAgendaAbrir','calendarioMedico','sesmt/calendario.php',$dados,'','',$funcao);
        
        //AGENDA-------------------------------------------------------------
        //-------------------------------------------------------------------
        $dados = array('acao');
        postRestAjax('agendaSESMTAgendaEditar','agendaSESMTCorpo','sesmt/agendaSESMTAgendaEditar.php',$dados);
        //salvar
        $dados = array('acao', 'inicio','fim','idMedico','periodo');
        postRestAjax('agendaSESMTAgendaSalvar','agendaSESMTCorpo','sesmt/agendaSESMTAgendaEditar.php',$dados);
        //Alterar Status
        $dados = array('acao', 'id');
        postRestAjax('alterarStatusAcesso','agendaSESMTCorpo','sesmt/agendaSESMTAbrirAgenda.php',$dados);
        //AgendarServidor
        $dados = array('acao','idRequerimentoFuncional','idLinha','inicio','fim','medico');
        $funcao = array('fecharModal();');
        postRestAjax('agendaSESMTAgendarServidor','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados,'','',$funcao);
        //Agendar
        $dados = array('acao','idLinha','idRequerimentoFuncional','medico');
        $funcao = array('fecharModal();');
        postRestAjax('agendaSESMTAtendimentoMarcar','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados,'','',$funcao);
        //remacarEmLote
        $dados = array('acao','idLinha','idFolhaOrigem','medico');
        $funcao = array('fecharModal();');
        postRestAjax('agendaSESMTAtendimentoRemarcar','agendaSESMTCorpo','sesmt/agendaSESMTAtendimentos.php',$dados,'','',$funcao);
        
  ?>
<script>
    window.onload = agendaSESMTEntrada('Entrada');
</script>