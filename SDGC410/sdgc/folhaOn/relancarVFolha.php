<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    print_p($respGet);
    $pst = 'folhaOn';
    $arq = 'relancarVariaveis';
    if($respGet[acao]=='limparSessao'){
        $_SESSION[lotacaoVariavel] = Null; 
        $_SESSION[lotacaoSubVariavel] = Null;
        $_SESSION[servidorVariavel] = Null;
        $_SESSION[nomeVariavel]=Null;
        $_SESSION[nomeLotacaoSub] = Null;
        $_SESSION[idLotacao] = Null;
        $total = getRest('lotacao/getListaLotacaoUsuarioVariaveis');
        if(count($total) == 1){
           $respGet[acao] = 'selecionarSecretaria'; 
           $respGet[idSecretaria] = $total[0][id];
        }
    }
    if($respGet[acao]=='substituirVariaveis'){
        $carregarVariaveis = array('idLotacaoSub' => $respGet['idLotacaoSub'], 'idUserLogin' => $respGet['idUserLogin']);
        $carregarV = array($carregarVariaveis);
        $executar = postRest('variaveis/postCarregarVariaveisEmModelo',$carregarV);
        $msnTexto = "ao lançar Substituir Variáveis. ".$executar['msn'].'.';
        $respGet[acao] = 'selecionarSecretaria';
    }
     if($respGet[acao]=='carregarVariaveis'){
        $carregarVariaveis = array('idLotacaoSub' => $respGet['idLotacaoSub'], 'idUserLogin' => $respGet['idUserLogin']);
        $carregarV = array($carregarVariaveis);
        $executar = postRest('variaveis/postCarregarModeloEmVariaveis',$carregarV);
        $msnTexto = "ao lançar carregar Variáveis. ".$executar['msn'].'.';
        $respGet[acao] = 'selecionarSecretaria';
    }
    if($respGet[acao] == 'selecionarSecretaria'){
        if (!isset($_SESSION[idLotacao])){
            $_SESSION[idLotacao] = $respGet[idSecretaria];
        }
        $lv = array($_SESSION[idLotacao]);
        $usuario = array($_SESSION[user][login], $_SESSION[idLotacao]);
        $_SESSION[lotacaoVariavel] = getRest('variaveis/getVariaveisModeloLancamentoPorLogin',$usuario);
        $_SESSION[lotacaoSub] = getRest('lotacao/getListaLotacaoSubUsuario',$lv);
        if(!isset($respGet[pgLotacao])){
                $respGet[pgLotacao] = 1;
        }
    }
    if($respGet[acao]=='buscarVariavelLotacaoSub'){
        $Array = $_SESSION[lotacaoVariavel];
        $p =  array_search($respGet[nomeLotacaoSub], array_column($Array, 'nomeLotacaoSub')).'<br />';
        $p = intval($p);
        $_SESSION[lotacaoVariavel] = array($Array[$p]);
        if($_SESSION[lotacaoSubVariavel][0][status] == 1){
            $_SESSION['setorFechado'] = 1;
        }else{
            $_SESSION['setorFechado'] = 0;
        }
    }
    if(isset($respGet[pg])){
        $respGet[pgLotacao] = $respGet[pg];
    }
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?>
<div class="row">
        <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                    <div class="box box-success">
                      <div class="box-header">
                        <i class="fa fa-comments-o"></i>
                        <h3 class="box-title">Relançar folha</h3>
                        <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                          <div class="btn-group" data-toggle="btn-toggle">
                                <?php if(count($_SESSION[lotacaoVariavel]) == 1){?>
                                     <form action="index.php" method="<?=$method?>" class="inline">
                                        <input type="hidden" name="pst" value="<?=$pst?>"/>
                                        <input type="hidden" name="arq" value="<?=$arq?>"/>
                                        <input type="hidden" name="idVariavelDesc" value="<?=$_SESSION[idVariavelDesc]?>"/>
                                        <input type="hidden" name="acao" value="selecionarSecretaria"/>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-mail-reply"></i></button>
                                    </form>
                                <?php }else{ ?>
                                    <form action="index.php" method="<?=$method?>" class="inline">
                                        <div class="input-group input-group-sm" style="width: 200px;">
                                          <input type="hidden" name="pst" value="<?=$pst?>"/>
                                          <input type="hidden" name="arq" value="<?=$arq?>"/>
                                          <select name='nomeLotacaoSub'class="form-control select2" id='ocorrencia' style="width: 100%;">
                                            <?php foreach ($_SESSION["lotacaoSub"] as $ArrEspPlan){
                                                ?>
                                              <option value="<?=$ArrEspPlan['nome']?>"><?=$ArrEspPlan['nome']?></option>
                                              <?php }?>
                                          </select>
                                          <!--<input type="text" name="variaveisDesc" class="form-control pull-right" placeholder="Search">-->
                                          <div class="input-group-btn">
                                              <input type="hidden" name="acao" value="buscarVariavelLotacaoSub"/>
                                              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                            <!--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>-->
                                          </div>
                                        </div>
                                    </form>
                                <?php }?>
                          </div>
                        </div>
                      </div>
                      <div class="box-body chat" id="chat-box">
                        <!-- chat item -->
                        <?php foreach (paginaAtual($_SESSION[lotacaoVariavel] ,$respGet[pgLotacao]) as $ArrEsp){
                            $id = str_replace(".", "", $ArrEsp[idLotacaoSub]);
                            if ($ArrEsp[dataHora] == ""){
                                $dsb = "disabled";
                                $msnSubstituicao = "Não possui dados carregados";
                            }else{
                                $dsb = Null;
                                $msnSubstituicao =  "Arquivo salvo em:  ".dataHoraBr($ArrEsp[dataHora]);
                            }
                            if ($ArrEsp[dataHoraCarregado] == ""){
                                $msnCarregamento = Null;
                            }else{
                                $msnCarregamento = "<i class='fa fa-clock-o'></i> Carregado em ".dataHoraBr($ArrEsp[dataHoraCarregado]);
                            }
                            ?>
                        <div class="item">
                          <img src="img/devolvido.png" alt="user image" class="online">

                          <p class="message">
                            <a href="#" class="name">
                              <small class="text-muted pull-right"> <?=$msnCarregamento?></small><br>
                              <?=$ArrEsp[nomeLotacaoSub]?>
                            </a>
                          </p>
                          <div class="attachment">
                            <b><?=$msnSubstituicao?></b><br>


                            <p class="filename">
                            </p>

                            <div class="pull-right">
                                <form action="index.php" method="<?=$method?>" class="inline">
                                        <input type="hidden" name="vpst" value="<?=$pst?>" />
                                        <input type="hidden" name="varq" value="<?=$arq?>" />
                                        <input type="hidden" name="pst" value="print"/>
                                        <input type="hidden" name="arq" value="info"/>
                                        <input type="hidden" name="pg" value="<?=$respGet[pgLotacao]?>"/>
                                        <input type="hidden" name="acao" value="fichaFuncional"/>
                                        <input type="hidden" name="idLotacaoSub" value="<?=$ArrEsp[idLotacaoSub]?>"/>
                                        <input type="hidden" name="idUserLogin" value="<?=$ArrEsp[idUserLogin]?>"/>
                                        <input type="hidden" name="acao" value="relatorioVariavelCarregadas"/>
                                        <button <?=$dsb?> class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</button>
                                </form>
                               <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#substituir<?=$id?>"><i class="fa fa-save"></i> Salvar</button>
                                <div class="modal fade" id="substituir<?=$id?>" role="dialog">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-body">
                                            <p> Este procedimento ira <b>substituir</b> sua base de lancamentos atuais, este procedimento pode ser desfeito. Deseja realmente fazer esta ação?</p>
                                      </div>
                                      <div class="modal-footer">
                                            <form action="index.php" method="<?=$method?>" class="inline">
                                                    <input type="hidden" name="pgLotacao" value="<?=$respGet[pgLotacao]?>"/>
                                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                                    <input type="hidden" name="idLotacaoSub" value="<?=$ArrEsp[idLotacaoSub]?>"/>
                                                    <input type="hidden" name="idUserLogin" value="<?=$ArrEsp[idUserLogin]?>"/>
                                                    <input type="hidden" name="acao" value="substituirVariaveis"/>
                                                    <button class="btn btn-primary">Confirmar</button>
                                            </form>
                                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <button type="submit" <?=$dsb?> class="btn btn-success" data-toggle="modal" data-target="#carregar<?=$id?>"><i class="fa fa-sign-in"></i> Lançar</button>
                                <div class="modal fade" id="carregar<?=$id?>" role="dialog">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-body">
                                           <p> Este procedimento ira <b>lançar</b> as variaveis que estão salvas. Deseja realmente fazer esta ação?</p>
                                      </div>
                                      <div class="modal-footer">
                                            <form action="index.php" method="<?=$method?>" class="inline">
                                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                                    <input type="hidden" name="pgLotacao" value="<?=$respGet[pgLotacao]?>"/>
                                                    <input type="hidden" name="idLotacaoSub" value="<?=$ArrEsp[idLotacaoSub]?>"/>
                                                    <input type="hidden" name="idUserLogin" value="<?=$ArrEsp[idUserLogin]?>"/>
                                                    <input type="hidden" name="acao" value="carregarVariaveis"/>
                                                    <button class="btn btn-primary">Confirmar</button>
                                            </form>
                                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                          <!-- /.attachment -->
                        </div>
                        <?php }?>
                      </div>

                    </div>
                     <?=controleDePagina($_SESSION[lotacaoVariavel] ,$respGet[pgLotacao],"pgLotacao");?> 
                    <!-- /.box (chat box) -->
            </div>
        </div>
    </div>
</div>