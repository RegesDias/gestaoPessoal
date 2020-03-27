<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $pst = 'folhaOn';
    $arq = 'validarVariaveis';
    print_p($respGet);
if($respGet[acao]=='servidoresVariavel'){
    if($respGet[idLotacaoSub] != ""){$_SESSION[idLotacaoSub] = $respGet[idLotacaoSub];}
    if($respGet[idVariavelDesc] != ""){$_SESSION[idVariavelDesc] = $respGet[idVariavelDesc];}
    if($respGet[nomeLotacaoSub] != ""){$_SESSION[nomeLotacaoSub] = $respGet[nomeLotacaoSub];}
    $sv = array($_SESSION[idLotacaoSub],$_SESSION[idVariavelDesc]);
    $_SESSION[servidorVariavel] = getRest('variaveis/getListaVariaveisPorSetorPorVariavelDesc',$sv);
    $i=0;
    $f=0;
    foreach ($_SESSION[servidorVariavel] as $t){
        if($_SESSION[servidorVariavel][$i][status] == 'Aprovado'){
            $f++;
        }
        $i++;
    }
    $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado]=$f;
    $respGet[acao]='buscarVariavelLotacaoSub';
    $respGet[pgServidor] = 1;
}
if(count($_SESSION[servidorVariavel])>0){?>
     <div class="row">
        <div class="col-xs-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Servidor</h3>
              <div class="box-tools">
                <?php if(($respGet[nomeMatriculaPessoa])!=""){?>
                     <form action="index.php" method="<?=$method?>" class="inline">
                        <input type="hidden" name="pst" value="<?=$pst?>"/>
                        <input type="hidden" name="arq" value="<?=$arq?>"/>
                        <input type="hidden" name="idVariavelDesc" value="<?=$_SESSION[idVariavelDesc]?>"/>
                        <input type="hidden" name="acao" value="servidoresVariavel"/>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-mail-reply"></i></button>
                    </form>
                <?php }else{ ?>
                    <form action="index.php" method="<?=$method?>" class="inline">
                        <div class="input-group input-group-sm" style="width: 200px;">
                          <input type="hidden" name="pst" value="<?=$pst?>"/>
                          <input type="hidden" name="arq" value="<?=$arq?>"/>
                          <input type="text" name="nomeMatriculaPessoa" class="form-control pull-right" placeholder="Procurar...">
                          <div class="input-group-btn">
                              <input type="hidden" name="acao" value="buscarVariavelServidor"/>
                              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            <!--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>-->
                          </div>
                        </div>
                    </form>
                <?php }?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Matrícula</th>
                  <th>Nome</th>
                  <th>Quantidade/Valor</th>
                  <th>Data</th>
                  <th>Status</th>
                  <th>Ação</th>
                </tr>
                <?php foreach (paginaAtual($_SESSION[servidorVariavel],$respGet[pgServidor]) as $ArrEspServidor){
                    $lable = statusVariaveis($ArrEspServidor[status]);
                    if(1== $_SESSION['setorFechado']){
                        $disablelotacaoSubFechado = "disabled='disabled'";
                    }
                    ?>
                    <tr>
                      <td><?=$ArrEspServidor[matricula]?></td>
                      <td><?=$ArrEspServidor[nome]?></td>
                       <td><?=$ArrEspServidor[quantidadeValor]?></td>
                      <td><?=dataHoraBr($ArrEspServidor[data])?></td>
                      <td><span class="<?=$lable?>"><?=$ArrEspServidor[status]?></span></td>
                      <td>
                            <form action="index.php" method="<?=$method?>" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="idVariavel" value="<?=$ArrEspServidor[idVariavel]?>"/>
                                    <input type="hidden" name="idVariavelDesc" value="<?=$respGet[idVariavelDesc]?>"/>
                                    <input type="hidden" name="nomeMatriculaPessoa" value="<?=$respGet[nomeMatriculaPessoa]?>"/>
                                    <input type="hidden" name="idLotacaoSub" value="<?=$respGet[idLotacaoSub]?>"/>
                                    <input type="hidden" name="nomeLotacaoSub" value="<?=$respGet[nomeLotacaoSub]?>"/>
                                    <input type="hidden" name="pgServidor" value="<?=$respGet[pgServidor]?>"/>
                                    <input type="hidden" name="acao" value="aprovarVariavelServidor"/>
                                    <button title="Aprovar lançamento" <?=$disablelotacaoSubFechado?> type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i></button>
                            </form>
                            <form action="index.php" method="<?=$method?>" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="idVariavel" value="<?=$ArrEspServidor[idVariavel]?>"/>
                                    <input type="hidden" name="idVariavelDesc" value="<?=$respGet[idVariavelDesc]?>"/>
                                    <input type="hidden" name="nomeMatriculaPessoa" value="<?=$respGet[nomeMatriculaPessoa]?>"/>
                                    <input type="hidden" name="idLotacaoSub" value="<?=$respGet[idLotacaoSub]?>"/>
                                    <input type="hidden" name="nomeLotacaoSub" value="<?=$respGet[nomeLotacaoSub]?>"/>
                                    <input type="hidden" name="pgServidor" value="<?=$respGet[pgServidor]?>"/>
                                    <input type="hidden" name="acao" value="negarVariavelServidor"/>
                                    <button title="Negar lançamento" <?=$disablelotacaoSubFechado?> type="submit" class="btn btn-danger"><i class="fa fa-ban"></i></button>
                            </form>
                            <form action="index.php" method="<?=$method?>" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="idVariavel" value="<?=$ArrEspServidor[idVariavel]?>"/>
                                    <input type="hidden" name="idVariavelDesc" value="<?=$respGet[idVariavelDesc]?>"/>
                                    <input type="hidden" name="nomeMatriculaPessoa" value="<?=$respGet[nomeMatriculaPessoa]?>"/>
                                    <input type="hidden" name="idLotacaoSub" value="<?=$respGet[idLotacaoSub]?>"/>
                                    <input type="hidden" name="nomeLotacaoSub" value="<?=$respGet[nomeLotacaoSub]?>"/>
                                    <input type="hidden" name="pgServidor" value="<?=$respGet[pgServidor]?>"/>
                                    <input type="hidden" name="acao" value="lancarVariavelServidor"/>
                                    <button title="Liberar lançamento para alteração" <?=$disablelotacaoSubFechado?> type="submit" class="btn btn-primary"><i class="fa fa-sort-amount-desc"></i></button>
                            </form>
                            <form action="index.php" method="<?=$method?>" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="idVariavel" value="<?=$ArrEspServidor[idVariavel]?>"/>
                                    <input type="hidden" name="idVariavelDesc" value="<?=$respGet[idVariavelDesc]?>"/>
                                    <input type="hidden" name="nomeMatriculaPessoa" value="<?=$respGet[nomeMatriculaPessoa]?>"/>
                                    <input type="hidden" name="idLotacaoSub" value="<?=$respGet[idLotacaoSub]?>"/>
                                    <input type="hidden" name="nomeLotacaoSub" value="<?=$respGet[nomeLotacaoSub]?>"/>
                                    <input type="hidden" name="pgServidor" value="<?=$respGet[pgServidor]?>"/>
                                    <input type="hidden" name="acao" value="variavelRemover"/>
                                    <button title="Apagar Lançamento" <?=$disablelotacaoSubFechado?> type="submit" class="btn btn-default"><i class="fa fa-close"></i></button>
                            </form>
                      </td>
                    </tr>
                <?php }?>
              </table>
            </div>
            <!-- /.box-body -->
            <?=controleDePagina($_SESSION[servidorVariavel],$respGet[pgServidor],"pgServidor");?> 
          </div>
          <!-- /.box -->
        </div>
      </div>
<?php }
    if((count($_SESSION[servidorVariavel]) == 0) AND (isset($respGet[idLotacaoSub])) AND ($respGet[acao] == 'servidoresVariavel')){?>
            <div class="box-body">
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check-circle"></i> Atenção!</h4>
                 Não foram encontrados lançamentos. 
              </div>
                </div>
<?php }?>