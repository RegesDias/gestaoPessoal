<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $pst = 'folhaOn';
    $arq = 'validarVariaveis';
    print_p($respGet);
    //lotacaoVariavel
if($respGet[acao]=='selecionarSecretaria'){
    if(isset($respGet[idSecretaria])){
        $_SESSION[idLotacao] = $respGet[idSecretaria];
    }
    $lv = array($_SESSION[idLotacao]);
    $_SESSION[lotacaoSubVariavel]= Null; 
    $_SESSION[servidorVariavel]= Null; 
    $_SESSION[nomeVariavel]= Null; 
    $respGet[pgLotacao] = 1;
    $_SESSION[lotacaoVariavel] = getRest('variaveis/getListaVariaveisLotacao',$lv);
    $_SESSION[lotacaoSub] = getRest('lotacao/getListaLotacaoSubUsuario',$lv);
}
if($respGet[acao]=='selecionar'){
    $Array = $_SESSION[lotacaoVariavel];
    $p =  array_search($respGet[nomeVariavelDesc], array_column($Array, 'variaveisDesc')).'<br />';
    $p = intval($p);
    $_SESSION[lotacaoVariavel] = array($Array[$p]);
    if($_SESSION[lotacaoVariavel][0][status] == 1){
        $_SESSION['lotacaoSubFechado'] = 1;
    }else{
        $_SESSION['lotacaoSubFechado'] = 0;
    }
}
if(count($_SESSION[lotacaoVariavel])>0){?>
 <div class="box">
    <div class="box-header">
        <h3 class="box-title">
            Variável
        </h3>
        <div class="box-tools">
            <?php if(count($_SESSION[lotacaoVariavel]) == 1){?>
<!--                <form action="index.php" method="<?=$method?>" class="inline">-->
                    <input type="hidden" name="acao" value="selecionarSecretaria"/>
                    <!--<button type="submit" class="btn btn-primary"><i class="fa fa-mail-reply"></i></button>-->
<!--                </form>-->
                <button class="btn btn-primary" onclick="buscaVVariavel('selecionarSecretaria',$('#secretariaID').val())" type="button">
                    <i class="fa fa-mail-reply"></i>
                </button>
            <?php }else{ ?>
                <div class="input-group input-group-sm" style="width: 200px;">
                  <select name='nomeVariavelDesc'class="form-control select2" id='nomeVariavelDesc' style="width: 100%;">
                    <?php foreach ($_SESSION["variavelPerfil"] as $ArrEspPlan){
                        ?>
                      <option value="<?=$ArrEspPlan['nome']?>"><?=$ArrEspPlan['nome']?></option>
                      <?php }?>
                  </select>
                  <div class="input-group-btn">
                      <button class="btn btn-default" onclick="buscarVariavelNome('buscarVariavelLotacao',$('#nomeVariavelDesc').val())" type="button">
                            <i class="fa fa-search"></i>
                      </button>
                  </div>
                </div>
            <?php }?>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
      <table class="table table-condensed">
        <tr>
          <th>Ação</th>
          <th>Validação</th>
          <th>Status</th>
          <th>Variáveis</th>
          <th>Processo</th>
          <th style="width: 40px"></th>
        </tr>
        <?php foreach (paginaAtual($_SESSION[lotacaoVariavel],$respGet[pgLotacao]) as $ArrEsp){?>
            <tr>
               <td>
                    <button class="btn btn-default" onclick="buscaVSetor('selecionar','<?=$ArrEsp[idVariavelDesc]?>','<?=$ArrEsp[variaveisDesc]?>')" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                   <?php
                   $ArrEsp[codValidacao] = bin2hex(mhash(MHASH_ADLER32, $ArrEsp[codValidacao]));
                   if($ArrEsp[status] == 1){
                       $lableStatus = "label label-success";
                       $lableNome = "Fechado";
                       $MsnNome = "Aberto";
                       $barraPercent = "progress-bar progress-bar-success";
                       $numeroPercent = "badge bg-green";
                       $lableBtn = "btn btn-success";
                       $btnTipo = "fa fa-lock";
                    }else{
                       $lableStatus = "label label-warning";
                       $lableNome = "Aberto";
                       $MsnNome = "Fechado";
                       $barraPercent = "progress-bar progress-bar-yellow";
                       $numeroPercent = "badge bg-yellow-active";
                       $lableBtn = "btn btn-warning";
                       $btnTipo = "fa fa-unlock-alt";
                     }
                   if($btnFecharLotacao == true){?>
                        <button class="<?=$lableBtn?>" data-toggle="modal" data-target="#fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" ><i class="<?=$btnTipo?>"></i></button>

                        <div class="modal fade" id="fecharLotacao<?=$ArrEsp[idVariavelDesc]?>" role="dialog">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-body">
                                    <p>O status da variável <?=$ArrEsp[variaveisDesc]?> vai ser alterado para <?=$MsnNome?>. Deseja realmente fazer esta ação?</p>
                              </div>
                              <div class="modal-footer">
                                    <form action="index.php" method="<?=$method?>" class="inline">
                                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                                            <input type="hidden" name="idVariavelDesc" value="<?=$ArrEsp[idVariavelDesc]?>"/>
                                            <input type="hidden" name="nomeVariavelDesc" value="<?=$ArrEsp[variaveisDesc]?>"/>
                                            <input type="hidden" name="acao" value="fecharVariavelSecretaria"/>
                                            <button class="btn btn-primary">Confirmar</button>
                                    </form>
                                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <form action="index.php" method="<?=$method?>" class="inline">
                                <input type="hidden" name="vpst" value="<?=$pst?>" />
                                <input type="hidden" name="varq" value="<?=$arq?>" />
                                <input type="hidden" name="codValidacao" value="<?=$ArrEsp[codValidacao]?>" />
                                <input type="hidden" name="pst" value="print"/>
                                <input type="hidden" name="arq" value="info"/>
                                <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                <input type="hidden" name="pg" value="<?=$respGet[pgLotacao]?>"/>
                                <input type="hidden" name="acao" value="fichaFuncional"/>
                                <input type="hidden" name="idLotacao" value="<?=$_SESSION[idLotacao]?>"/>
                                <input type="hidden" name="idVariavelDesc" value="<?=$ArrEsp[idVariavelDesc]?>"/>
                                <input type="hidden" name="nomeVariavelDesc" value="<?=$ArrEsp[variaveisDesc]?>"/>
                                <input type="hidden" name="acao" value="relatVariavelLotacao"/>
                                <button class="btn btn-primary"><i class="fa fa-print"></i></button>
                        </form>
                       <?php if($btnTipo == "fa fa-lock"){?>
                        <form action="index.php" method="<?=$method?>" class="inline">
                                <input type="hidden" name="vpst" value="<?=$pst?>" />
                                <input type="hidden" name="varq" value="<?=$arq?>" />
                                <input type="hidden" name="codValidacao" value="<?=$ArrEsp[codValidacao]?>" />
                                <input type="hidden" name="pst" value="print"/>
                                <input type="hidden" name="arq" value="info"/>
                                <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                <input type="hidden" name="pg" value="<?=$respGet[pgLotacao]?>"/>
                                <input type="hidden" name="acao" value="fichaFuncional"/>
                                <input type="hidden" name="idLotacao" value="<?=$_SESSION[idLotacao]?>"/>
                                <input type="hidden" name="idVariavelDesc" value="<?=$ArrEsp[idVariavelDesc]?>"/>
                                <input type="hidden" name="nomeVariavelDesc" value="<?=$ArrEsp[variaveisDesc]?>"/>
                                <input type="hidden" name="acao" value="relatFechamentoVariavel"/>
                                <button class="btn btn-github"><i class="fa fa-stack-overflow"></i></button>
                        </form>
                    <?php }}
                   
                       ?>
               </td>
               <td><?=$ArrEsp[codValidacao]?></td>
               <td><span class="<?=$lableStatus?>"><?=$lableNome?></span></td>
             <td><?=$ArrEsp[variaveisDesc]?></td>
             <td>
               <div class="progress progress-xs progress-striped active">
                 <div class="<?=$barraPercent?>" style="width: <?=$ArrEsp[porcentagem]?>%"></div>
               </div>
             </td>
             <td><span class="<?=$numeroPercent?>"><?=$ArrEsp[porcentagem]?>%</span></td>
           </tr>         
       <?php }?>
      </table>
        <?=controleDePagina($_SESSION[lotacaoVariavel],$respGet[pgLotacao],"pgLotacao");?> 
    </div>
    <!-- /.box-body -->
  <!-- /.box -->
</div><br>
<?php }?>
