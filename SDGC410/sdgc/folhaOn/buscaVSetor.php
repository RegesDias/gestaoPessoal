<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $pst = 'folhaOn';
    $arq = 'validarVariaveis';
if($respGet[acao]=='selecionar'){
    $lvs = array($_SESSION[idLotacao],$respGet[idVariavelDesc]);
    $_SESSION[nomeVariavel]=$respGet[nomeVariavelDesc];
    $_SESSION[nomeLotacaoSub] = Null;
    $_SESSION[servidorVariavel] = Null;
    $respGet[pgLotacaoSub] = 1;
    $_SESSION[lotacaoSubVariavel] = getRest('variaveis/getListaVariaveisLotacaoSub',$lvs);
    $respGet[acao] =  'buscarVariavelLotacao';
    $_SESSION[idVariavelDesc] = $respGet[idVariavelDesc];
}
    //Setor----------->
    //fecharVariavelSetor
  
//Fechar Variavel Setor
if($respGet[acao]=='fecharVariavelSetor'){
    $Array = $_SESSION[lotacaoSubVariavel];
    $p =  array_search($respGet[nomeLotacaoSub], array_column($Array, 'nomeLotacaoSub')).'<br />';
    $p = intval($p);
    $_SESSION[lotacaoSubVariavel] = array($Array[$p]);
    $v = array('idVariavelDesc'=>$respGet[idVariavelDesc],'idLotacaoSub'=>$respGet[idLotacaoSub]);
    $aVariaveis = array($v);
    if(isset($respGet[idLotacaoSub])){
        $executar = postRest('variaveis/postFecharVariaveisLotacaoSub',$aVariaveis);
        if (count($_SESSION[lotacaoSubVariavel]) == 1){
            if(($_SESSION[lotacaoSubVariavel][0][status] == 1) AND ($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
                $_SESSION[lotacaoSubVariavel][0][status] = 0;
                $i=0;
                $_SESSION['setorFechado'] = 0;
            }elseif(($_SESSION[lotacaoSubVariavel][0][status] == 0) AND ($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
                $_SESSION[lotacaoSubVariavel][0][status] = 1;
                $i=0;
                $_SESSION['setorFechado'] = 1;
            }
        }else{
            $respGet[acao]='selecionarSetor'; 
        }
        $Porcentagem = array('idLotacao'=>$_SESSION[idLotacao],'idVariavelDesc'=>$respGet[idVariavelDesc]);
        $busca = getRest('variaveis/getPorcentagemPorIdLotacaoIdVariavelDesc',$Porcentagem);
        $_SESSION[lotacaoVariavel][0][porcentagem] = $busca[0][porcentagem];
        $msnTexto = "ao alterar variavel. ".$executar['msn'];
    }
}
//Aprovar Variavel Setor
if($respGet[acao]=='aprovarVariavelSetor'){
    $v = array('idVariavelDesc'=>$respGet[idVariavelDesc],'idLotacaoSub'=>$respGet[idLotacaoSub]);
    $aVariaveis = array($v);
    $executar = postRest('variaveis/postAprovarVariaveisSetorId',$aVariaveis);
    if (count($_SESSION[lotacaoSubVariavel]) == 1){
        if(($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
            $i = 0;
            foreach ($_SESSION[servidorVariavel] as $t){
                $_SESSION[servidorVariavel][$i][status] = 'Aprovado';
                $i++;
            }
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] = $i;
        }
    }else{
        $respGet[acao]='selecionarSetor'; 
    }
    $msnTexto = "ao alterar variavel. ".$executar['msn'];
}
//Negar Variavel Setor
if($respGet[acao]=='negarVariavelSetor'){
    $v = array('idVariavelDesc'=>$respGet[idVariavelDesc],'idLotacaoSub'=>$respGet[idLotacaoSub]);
    $aVariaveis = array($v);
    $executar = postRest('variaveis/postNegarVariaveisSetorId',$aVariaveis);
    if (count($_SESSION[lotacaoSubVariavel]) == 1){
        if(($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
            $i = 0;
            foreach ($_SESSION[servidorVariavel] as $t){
                $_SESSION[servidorVariavel][$i][status] = 'Negado';
                $i++;
            }
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado]=0;
        }
    }else{
        $respGet[acao]='selecionarSetor'; 
    }
    $msnTexto = "ao alterar variavel. ".$executar['msn'];
}
//Lançar Variavel Setor
if($respGet[acao]=='lançarVariavelSetor'){
    $v = array('idVariavelDesc'=>$respGet[idVariavelDesc],'idLotacaoSub'=>$respGet[idLotacaoSub]);
    $aVariaveis = array($v);
    $executar = postRest('variaveis/postLancarVariaveisSetorId',$aVariaveis);
    if (count($_SESSION[lotacaoSubVariavel]) == 1){
        if(($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
            $i = 0;
            foreach ($_SESSION[servidorVariavel] as $t){
                $_SESSION[servidorVariavel][$i][status] = 'Lançado';
                $i++;
            }
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado]=0;
        }
    }else{
        $respGet[acao]='selecionarSetor'; 
    }
    sleep(10);
    $msnTexto = "ao alterar variavel. ".$executar['msn'];
}
//Excluir Variavel Setor
if($respGet[acao]=='excluirVariavelSetor'){
    $v = array('idVariavelDesc'=>$respGet[idVariavelDesc],'idLotacaoSub'=>$respGet[idLotacaoSub]);
    $aVariaveis = array($v);
    $executar = postRest('variaveis/postExcluirVariaveisSetorId',$aVariaveis);
    if (count($_SESSION[lotacaoSubVariavel]) == 1){
        //ver
        if(($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
            $i = 0;
            $_SESSION[servidorVariavel] = NULL;
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado]=0;
        }
    }else{
        $respGet[acao]='selecionarSetor'; 
    }
    $msnTexto = "ao alterar variavel. ".$executar['msn'];
}
if($respGet[acao]=='selecionarSetor'){
    $Array = $_SESSION[lotacaoSubVariavel];
    $p =  array_search($respGet[nomeLotacaoSub], array_column($Array, 'nomeLotacaoSub')).'<br />';
    $p = intval($p);
    $_SESSION[lotacaoSubVariavel] = array($Array[$p]);
    if($_SESSION[lotacaoSubVariavel][0][status] == 1){
        $_SESSION['setorFechado'] = 1;
    }else{
        $_SESSION['setorFechado'] = 0;
    }
}
exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
if(count($_SESSION[lotacaoSubVariavel])>0){?>
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Setor</h3>

              <div class="box-tools">
            <?php if(count($_SESSION[lotacaoSubVariavel]) == 1){?>
<!--                 <form action="index.php" method="<?=$method?>" class="inline">
                    <input type="hidden" name="idVariavelDesc" value="<?=$_SESSION[idVariavelDesc]?>"/>
                    <input type="hidden" name="acao" value="selecionarSetor"/>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-mail-reply"></i></button>
                </form>-->
                <button class="btn btn-primary" onclick="buscaVSetor('selecionar','<?=$_SESSION[idVariavelDesc]?>')" type="button">
                    <i class="fa fa-mail-reply"></i>
                </button>
            <?php }else{ ?>
                <div class="input-group input-group-sm" style="width: 200px;">
                <select name='nomeLotacaoSub'class="form-control select2" id='nomeLotacaoSub' style="width: 100%;">
                  <?php foreach ($_SESSION["lotacaoSub"] as $ArrEspPlan){
                      ?>
                    <option value="<?=$ArrEspPlan['nome']?>"><?=$ArrEspPlan['nome']?></option>
                    <?php }?>
                </select>
                  <div class="input-group-btn">
                      <button class="btn btn-default" onclick="buscarSetorNome('selecionarSetor',$('#nomeLotacaoSub').val())" type="button">
                            <i class="fa fa-search"></i>
                      </button>
                  </div>
                </div>
            <?php }?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-hover">
                <tr>
                  <th>SETOR</th>
                  <th>Aprovados</th>
                  <th>Data</th>
                  <th>Status</th>
                  <th>Ação</th>
                </tr>
                <?php 
                    foreach (paginaAtual($_SESSION[lotacaoSubVariavel],$respGet[pgSetor]) as $ArrEspp){
                        $id = str_replace(".", "", $ArrEspp[idLotacaoSub]);
                        if($ArrEspp[status] == 1){
                            $lableBtn = "btn btn-success";
                            $lableNome = "Fechado";
                            $MsnNome = "Aberto";
                            $lableStatus = "label label-success";
                            $disable = "disabled='disabled'";
                            $btnTipo ="fa fa-lock"; ?>
                        <?php }else{
                            $lableBtn = "btn btn-warning";
                            $lableNome = "Aberto";
                            $MsnNome = "Fechado";
                            $lableStatus = "label label-warning";
                            $disable = "";
                            $btnTipo ="fa fa-unlock-alt"; 
                            ?>
                        <?php }
                        if(1 == $_SESSION['lotacaoSubFechado']){
                            $disableLotacaoFechado = "disabled='disabled'";
                        }else{
                            $disableLotacaoFechado = "";
                        }   
                        
                        ?> 
                    <tr>
                      <td><?=$ArrEspp[nomeLotacaoSub]?></td>
                      <td><?=$ArrEspp[quantidadeAprovado]?></td>
                      <td><?=$ArrEspp[dataLancamento]?></td>
                      <td><span class="<?=$lableStatus?>"><?=$lableNome?></span></td>
                      <td>
                            <button class="btn btn-default" onclick="buscaVServidor('selecionarSetor','<?=$ArrEspp[idVariavelDesc]?>','<?=$ArrEspp[idLotacaoSub]?>','<?=$ArrEspp[nomeLotacaoSub]?>')" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                            <button <?=$disableLotacaoFechado?> class="<?=$lableBtn?>" data-toggle="modal" data-target="#fecha<?=$id?>"><i class="<?=$btnTipo?>"></i></button>
                            <div class="modal fade" id="fecha<?=$id?>" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-body">
                                        <p>O status da variável <?=$ArrEsp[variaveisDesc]?> do setor <?=$ArrEspp[nomeLotacaoSub]?> vai ser alterado para <?=$MsnNome?>. Deseja realmente fazer esta ação?</p>
                                  </div>
                                  <div class="modal-footer">
                                        <button class="btn btn-primary" onclick="fecharEmloteSetor('fecharVariavelSetor','<?=$ArrEspp[idVariavelDesc]?>','<?=$ArrEspp[idLotacaoSub]?>','<?=$ArrEspp[nomeLotacaoSub]?>','<?=$respGet[pgSetor]?>','<?=$_SESSION[nomeVariavel]?>')" type="button">
                                            Confirmar
                                        </button>
                                        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <?php //if($btnFecharLotacaoSub == true){?>
                            <button title="Troca o status de todos os lançamentos para Aprovado" type="submit" <?=$disable?>  class="btn btn-success" data-toggle="modal" data-target="#aprovar<?=$id?>"><i class="fa fa-check-circle"></i></button>
                            <div class="modal fade" id="aprovar<?=$id?>" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-body">
                                        <p> Aprovar todas as variáveis <?=$ArrEsp[variaveisDesc]?> do setor <?=$ArrEspp[nomeLotacaoSub]?>. Deseja realmente fazer esta ação?</p>
                                  </div>
                                  <div class="modal-footer">
                                        <button class="btn btn-primary" onclick="acaoEmlote('aprovarVariavelSetor','<?=$ArrEspp[idVariavelDesc]?>','<?=$ArrEspp[idLotacaoSub]?>','<?=$ArrEspp[nomeLotacaoSub]?>','<?=$respGet[pgSetor]?>')" type="button">
                                            Confirmar
                                        </button>
                                        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php// }?>
                            <button title="Troca o status de todos os lançamentos para Negado" type="submit" <?=$disable?>  class="btn btn-danger" data-toggle="modal" data-target="#reprovar<?=$id?>"><i class="fa fa-ban"></i></button>
                            <div class="modal fade" id="reprovar<?=$id?>" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-body">
                                        <p> Reprovar todas as variáveis <?=$ArrEsp[variaveisDesc]?> do setor <?=$ArrEspp[nomeLotacaoSub]?>. Deseja realmente fazer esta ação?</p>
                                  </div>
                                  <div class="modal-footer">
                                        <button class="btn btn-primary" onclick="acaoEmlote('negarVariavelSetor','<?=$ArrEspp[idVariavelDesc]?>','<?=$ArrEspp[idLotacaoSub]?>','<?=$ArrEspp[nomeLotacaoSub]?>','<?=$respGet[pgSetor]?>')" type="button">
                                            Confirmar
                                        </button>
                                        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <button title="Troca o status de todos os lançamentos para Lançado" type="submit" <?=$disable?>  class="btn btn-primary" data-toggle="modal" data-target="#lancar<?=$id?>"><i class="fa fa-sort-amount-desc"></i></button>
                            <div class="modal fade" id="lancar<?=$id?>" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-body">
                                        <p> Liberar todas as variáveis <?=$ArrEsp[variaveisDesc]?> do setor <?=$ArrEspp[nomeLotacaoSub]?> para modificação. Deseja realmente fazer esta ação?</p>
                                  </div>
                                  <div class="modal-footer">
                                        <button class="btn btn-primary" onclick="acaoEmlote('lançarVariavelSetor','<?=$ArrEspp[idVariavelDesc]?>','<?=$ArrEspp[idLotacaoSub]?>','<?=$ArrEspp[nomeLotacaoSub]?>','<?=$respGet[pgSetor]?>')" type="button">
                                            Confirmar
                                        </button>
                                        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <button title="Remove todos os lançamentos" type="submit" <?=$disable?>  class="btn btn-default" data-toggle="modal" data-target="#remover<?=$id?>"><i class="fa fa-close"></i></button>
                            <div class="modal fade" id="remover<?=$id?>" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-body">
                                        <p> Remover todas as variáveis <?=$ArrEsp[variaveisDesc]?> do setor <?=$ArrEspp[nomeLotacaoSub]?>. Deseja realmente fazer esta ação?</p>
                                  </div>
                                  <div class="modal-footer">
                                        <button class="btn btn-primary" onclick="acaoEmlote('excluirVariavelSetor','<?=$ArrEspp[idVariavelDesc]?>','<?=$ArrEspp[idLotacaoSub]?>','<?=$ArrEspp[nomeLotacaoSub]?>','<?=$respGet[pgLotacaoSub]?>')" type="button">
                                            Confirmar
                                        </button>
                                        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                             <form action="index.php" method="<?=$method?>" class="inline">
                                     <input type="hidden" name="vpst" value="<?=$pst?>" />
                                     <input type="hidden" name="varq" value="<?=$arq?>" />
                                     <input type="hidden" name="pst" value="print"/>
                                     <input type="hidden" name="arq" value="info"/>
                                     <input type="hidden" name="pg" value="<?=$respGet[pgLotacaoSub]?>"/>
                                     <input type="hidden" name="acao" value="fichaFuncional"/>
                                     <input type="hidden" name="idLotacaoSub" value="<?=$ArrEspp[idLotacaoSub]?>"/>
                                     <input type="hidden" name="idVariavelDesc" value="<?=$ArrEsp[idVariavelDesc]?>"/>
                                     <input type="hidden" name="acao" value="relatFechamentoVariavelSub"/>
                                     <button class="btn btn-primary" title="Imprimir" ><i class="fa fa-print"></i></button>
                             </form>
                      </td>
                    </tr>                
                <?php }?>
              </table>
            </div>
            <!-- /.box-body -->
           <?=controleDePagina($_SESSION[lotacaoSubVariavel],$respGet[pgSetor],"pgSetor",null,'pgSetor');?> 
          </div>
          <!-- /.box -->
        </div>
</div>
<?php }?>