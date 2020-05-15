<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    $idChamado = array($respGet['idChamado']);
    $chamadosDesc = getRest('chamadows/getListaChamadoDescPorId',$idChamado); 
    $buscAcessoNivel = array("9");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao', $buscAcessoNivel);

    foreach ($listaAcesso as $valor) {
        if ($valor['link'] == 'chamadosAdm') {
            $btnChamadosAdm = true;
            break;
        }
    }
    if($respGet[acao]== 'salvar'){
        $cadChamado = array('idChamado' => $respGet['idChamado'], 'texto' => $respGet['texto']);
        $salvarChamado = array($cadChamado);
        $executar = postRest('chamadows/postCriarChamadoDesenv',$salvarChamado);
        $msnTexto = "ao enviar menssagem.";
    }
    if($respGet[acao]== 'alterar'){
        echo 'alterar';
        print_p();
        $cadChamado = array('id' => $respGet['texto'], 'idChamado' => $respGet['idChamado']);
        $salvarChamado = array($cadChamado);
        $executar = postRest('chamadows/postAlterarChamadoCategoria',$salvarChamado);
        $msnTexto = "ao enviar menssagem.";
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
    $chamadosDesenv = getRest('chamadows/getListaChamadoDesenvIdCham', $cTipo);
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
          <center>
          </button>
          <!-- /.btn-group -->
            <button type="button" class="btn btn-primary btn-sm" onclick="chamadoLer('aberto','<?=$respGet['idChamado']?>')">
                <i class="fa fa-inbox"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" onclick="chamadoLer('analizando','<?=$respGet['idChamado']?>')">
                <i class="fa fa-comment-o"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" onclick="chamadoLer('finalizado','<?=$respGet['idChamado']?>')">
                <i class="fa fa-coffee"></i>
            </button>
          <center>
         </div>
          <label for="exampleInputEmail1">Alterar Categoria</label>
            <select <?= $inativo ?> id="idChamadoCategoria" name="idLotacaoSubVariaveis" onchange="chamadoLer('alterar','<?=$respGet['idChamado']?>',$('#idChamadoCategoria').val())"  size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                <option>--</option>
                <?php foreach ($_SESSION[chamadosCategoria] as $ArrEsp) { ?>
                    <option value="<?= $ArrEsp['id'] ?>"><?= $ArrEsp['nome'] ?></option>
                <?php } ?>
            </select>
    <?php }?>
        <div>
            <div class="box-body">
                <div class="box box-primary direct-chat direct-chat-primary">
                    <div class="direct-chat-messages">
                        <?php foreach ($chamadosDesenv as $ArrEsp) { 
                            if($ArrEsp[suporte] == true){
                                $nome = "pull-right";
                                $tempo = "pull-left";
                                $adm = "right";
                            }else{
                                $nome = "pull-left";
                                $tempo = "pull-right";
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