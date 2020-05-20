<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    $buscAcessoNivel = array("9");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao', $buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if ($valor['link'] == 'agendaSESMTsAdm') {
            $btnChamadosAdm = true;
            break;
        }
    }
    if($respGet[acao]== 'salvar'){
        $cadChamado = array('idChamado' => $respGet['idChamado'], 'texto' => $respGet['texto']);
        $salvarChamado = array($cadChamado);
        $executar = postRest('agendaSESMTws/postCriarChamadoDesenv',$salvarChamado);
        $sesmtTexto = "ao enviar menssagem.";
    }
    if($respGet[acao]== 'alterar'){
        $cadChamado = array('id' => $respGet['idChamado'], 'idCategoria' => $respGet['texto']);
        $salvarChamado = array($cadChamado);
        $executar = postRest('agendaSESMTws/postAlterarChamadoCategoria',$salvarChamado);
        $sesmtTexto = "ao alterar Categoria.";
        $respGet[acao]= 'ler';
    }
    if($respGet[acao] == 'aberto'){
        $agendaSESMT = array('id' => $respGet['idChamado']);
        $agendaSESMTE = array($agendaSESMT);
        $executar = postRest('agendaSESMTws/postAlterarStatusParaAberto',$agendaSESMTE);
        $sesmtTexto = "Status Alterado.";
    }
    if($respGet[acao] == 'analizando'){
        $agendaSESMT = array('id' => $respGet['idChamado']);
        $agendaSESMTE = array($agendaSESMT);
        $executar = postRest('agendaSESMTws/postAlterarStatusParaAnalisando',$agendaSESMTE);
        $sesmtTexto = "Status Alterado.";
    }
    if($respGet[acao] == 'finalizado'){
        $agendaSESMT = array('id' => $respGet['idChamado']);
        $agendaSESMTE = array($agendaSESMT);
        $executar = postRest('agendaSESMTws/postAlterarStatusParaFinalizado',$agendaSESMTE);
        $sesmtTexto = "Status Alterado.";
    }
    exibeMsn($sesmtExibe,$sesmtTexto,$sesmtTipo,$executar);
    $cTipo = array($respGet['idChamado']);
    $agendaSESMTsLista = getRest('agendaSESMTws/getBuscaChamadoPorId',$cTipo);   
    $agendaSESMTsLista[0][dataHora] = dataHoraBr($agendaSESMTsLista[0][dataHora]);
    $agendaSESMTsDesenv = getRest('agendaSESMTws/getListaChamadoDesenvIdCham', $cTipo);
    
    $idChamado = array($respGet['idChamado']);
    $agendaSESMTsDesc = getRest('agendaSESMTws/getListaChamadoDescPorId',$idChamado); 
    
    if($respGet[acao]== 'ler'){
        $idCategoria = array($agendaSESMTsLista[0][idCategoria]);
        $_SESSION[agendaSESMTsModelo]= getRest('agendaSESMTws/getListarChamadoMsnModelo',$idCategoria); 
    }
    autoComplete($_SESSION["agendaSESMTsModelo"], '#message', 'texto');

?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Ler Chamado <?=$respGet['idChamado']?></h3>
    </div>
    <div class="box-body no-padding">
        <div class="mailbox-read-info">
            <h3>Assunto: <?=$agendaSESMTsLista[0][titulo]?>
            <span class="mailbox-read-time pull-right"><b><h3><?=$agendaSESMTsLista[0][status]?></h3></b></span>
            </h3>
            <h5><b>Categoria:</b> 
                <?=$agendaSESMTsLista[0][categoria]?>
                <span class="mailbox-read-time pull-right"><?=$agendaSESMTsLista[0][dataHora]?></span>
            </h5>
            <h5><b>Descrição:</b> 
                <i><?=$agendaSESMTsLista[0][texto]?></i>
               
            </h5>
        </div>
    <?php if($btnChamadosAdm == true){ ?>
        <div class="mailbox-controls">
          <center>
          </button>
          <!-- /.btn-group -->
            <button type="button" class="btn btn-primary btn-sm" onclick="agendaSESMTLer('aberto','<?=$respGet['idChamado']?>')">
                <i class="fa fa-inbox"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" onclick="agendaSESMTLer('analizando','<?=$respGet['idChamado']?>')">
                <i class="fa fa-comment-o"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" onclick="agendaSESMTLer('finalizado','<?=$respGet['idChamado']?>')">
                <i class="fa fa-coffee"></i>
            </button>
          <center>
         </div>
          <label for="exampleInputEmail1">Alterar Categoria</label>
            <select <?= $inativo ?> id="idChamadoCategoria" name="idLotacaoSubVariaveis" onchange="agendaSESMTLer('alterar','<?=$respGet['idChamado']?>',$('#idChamadoCategoria').val())"  size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                <option>--</option>
                <?php foreach ($_SESSION[agendaSESMTsCategoria] as $ArrEsp) { ?>
                    <option value="<?= $ArrEsp['id'] ?>"><?= $ArrEsp['nome'] ?></option>
                <?php } ?>
            </select>
    <?php }?>
        <div>
            <div class="box-body">
                <div class="box box-primary direct-chat direct-chat-primary">
                    <div class="direct-chat-messages">
                        <?php foreach ($agendaSESMTsDesenv as $ArrEsp) { 
                            if($ArrEsp[suporte] == true){
                                $nome = "pull-right";
                                $tempo = "pull-left";
                                $adm = "right";
                            }else{
                                $nome = "pull-left";
                                $tempo = "pull-right";
                                $adm = "";
                            }
                            $dataHora=dataHoraBr($ArrEsp[dataHora]);
                            ?>
                            <div class="direct-chat-msg <?=$adm?>">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name <?=$nome?>"><?=$ArrEsp[nomeUserLogin]?></span>
                                    <span class="direct-chat-timestamp <?=$tempo?>"><?=$dataHora?></span>
                                </div>
                                <img class="direct-chat-img" src="<?=exibeFoto($ArrEsp['cpfUserlogin'])?>" alt="message user image">
                                <div class="direct-chat-text">
                                    <?=$ArrEsp[texto]?>
                                </div>
                            </div>
                        <?php }?>
                    </div>      
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-12">    
                   <?php if($agendaSESMTsLista[0][status] == 'Analisando'){ ?>
                    <form action="#" method="post">
                         <?php if($btnChamadosAdm == true){ ?>
                            <div class="input-group">
                                <input type="text" name="message" id='message' placeholder="Escreva aqui ..." class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" onclick="agendaSESMTLer('salvar','<?=$respGet['idChamado']?>',$('#message').val())" class="btn btn-default btn-flat">Enviar</button>
                                </span>
                            </div>
                         <?php }else{ ?>
                            <div class="input-group">
                                <input type="text" name="message" id='message' placeholder="Escreva aqui ..." class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" onclick="agendaSESMTLer('salvar','<?=$respGet['idChamado']?>',$('#message').val())" class="btn btn-default btn-flat">Enviar</button>
                                </span>
                            </div>
                         <?php }?>
                    </form>
                   <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>