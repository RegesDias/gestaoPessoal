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
    if($respGet[acao]== 'salvar'){
        echo 'salvar';
        print_p();
    }
    if($respGet[acao] == 'aberto'){
        $chamado = array('id' => $respGet['idChamado']);
        $chamadoE = array($chamado);
        $executar = postRest('chamadows/postAlterarStatusParaAberto',$chamadoE);
        $msnTexto = "Status Alterado.";
    }
    if($respGet[acao] == 'analizando'){
        $chamado = array('id' => $respGet['idChamado']);
        $chamadoE = array($chamado);
        $executar = postRest('chamadows/postAlterarStatusParaAnalisando',$chamadoE);
        $msnTexto = "Status Alterado.";
    }
    if($respGet[acao] == 'finalizado'){
        $chamado = array('id' => $respGet['idChamado']);
        $chamadoE = array($chamado);
        $executar = postRest('chamadows/postAlterarStatusParaFinalizado',$chamadoE);
        $msnTexto = "Status Alterado.";
    }
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
    $cTipo = array($respGet['idChamado']);
    $chamadosLista = getRest('chamadows/getBuscaChamadoPorId',$cTipo);   
    $chamadosLista[0][dataHora] = dataHoraBr($chamadosLista[0][dataHora]);
    autoComplete($_SESSION["nomePessoas"], '#message', '1');
?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Ler Chamado <?=$respGet['idChamado']?></h3>
    </div>
    <div class="box-body no-padding">
        <div class="mailbox-read-info">
            <h3>Assunto: <?=$chamadosLista[0][titulo]?>
            <span class="mailbox-read-time pull-right"><b><h3><?=$chamadosLista[0][status]?></h3></b></span>
            </h3>
            <h5><b>Categoria:</b> 
                <?=$chamadosLista[0][categoria]?>
                <span class="mailbox-read-time pull-right"><?=$chamadosLista[0][dataHora]?></span>
            </h5>
            <h5><b>Descrição:</b> 
                <i><?=$chamadosLista[0][texto]?></i>
               
            </h5>
        </div>
    <?php if($btnChamadosAdm == true){ ?>
        <div class="mailbox-controls">
          <!-- Check all button -->
          </button>
          <!-- /.btn-group -->
            <button type="button" class="btn btn-default btn-sm" onclick="chamadoLer('aberto','<?=$respGet['idChamado']?>')">
                <i class="fa fa-inbox"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm" onclick="chamadoLer('analizando','<?=$respGet['idChamado']?>')">
                <i class="fa fa-comment-o"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm" onclick="chamadoLer('finalizado','<?=$respGet['idChamado']?>')">
                <i class="fa fa-coffee"></i>
            </button>
          <!-- /.pull-right -->
        </div>
    <?php }?>
        <div>
            <div class="box-body">
                <div class="box box-primary direct-chat direct-chat-primary">
                    <div class="direct-chat-messages">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                            </div>
                            <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
                            <div class="direct-chat-text">
                                Is this template really for free? That's unbelievable!
                            </div>
                        </div>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                            </div>
                            <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
                            <div class="direct-chat-text">
                                You better believe it!
                            </div>
                        </div>
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp pull-right">23 Jan 5:37 pm</span>
                            </div>
                            <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
                            <div class="direct-chat-text">
                                Working with AdminLTE on a great new app! Wanna join?
                            </div>
                        </div>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp pull-left">23 Jan 6:10 pm</span>
                            </div>
                            <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
                            <div class="direct-chat-text">
                                I would love to.
                            </div>
                        </div>
                    </div>      
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-12">
                    <form action="#" method="post">
                         <?php if($btnChamadosAdm == true){ ?>
                            <div class="input-group">
                                <input type="text" name="message" id='message' placeholder="Escreva aqui ..." class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" onclick="chamadoLer('salvar','<?=$respGet['idChamado']?>',$('#message').val())" class="btn btn-default btn-flat">Enviar</button>
                                </span>
                            </div>
                         <?php }else{ ?>
                            <div class="input-group">
                                <input type="text" name="message" id='message' placeholder="Escreva aqui ..." class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" onclick="chamadoLer('salvar','<?=$respGet['idChamado']?>',$('#message').val())" class="btn btn-default btn-flat">Enviar</button>
                                </span>
                            </div>
                         <?php }?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>