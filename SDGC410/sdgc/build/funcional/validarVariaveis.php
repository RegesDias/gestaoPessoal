<?php
    $pst = 'funcional';
    $arq = 'validarVariaveis';
//acesso
    $buscAcessoNivel = array("7");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'FecharLotacao') AND ($valor['buscar'] == '1')){ 
             $btnFecharLotacao = true;
             break;
        }
    }
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'FecharLotacaoSub') AND ($valor['buscar'] == '1')){ 
             $btnFecharLotacaoSub = true;
             break;
        }
    }
    if(isset($respGet[pg])){
        $respGet[pgLotacao] = $respGet[pg];
        $respGet[pgLotacaoSub] = $respGet[pg];
        $respGet[pgServidor] = $respGet[pg];
    }
    if($respGet[acao]=='limparSessao'){
        $_SESSION[lotacaoVariavel] = Null; 
        $_SESSION[lotacaoSubVariavel] = Null;
        $_SESSION[servidorVariavel] = Null;
        $_SESSION[nomeVariavel]=Null;
        $_SESSION[nomeLotacaoSub] = Null;
        $_SESSION[idLotacao] = Null;
        $_SESSION[variavelPerfil] = getRest('variaveis/getListaVariaveisDesc');
    }
    if($respGet[acao]=='fecharVariavelSecretaria'){
        $v = array('idVariavelDesc'=>$respGet[idVariavelDesc],'idLotacao'=>$_SESSION[idLotacao]);
        $aVariaveis = array($v);
        $executar = postRest('variaveis/postFecharVariaveisLotacao',$aVariaveis);
        if (count($_SESSION[lotacaoVariavel]) == 1){
            if(($_SESSION[lotacaoVariavel][0][status] == 1) AND ($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
                $_SESSION[lotacaoVariavel][0][status] = 0;
                $i=0;
                $_SESSION['lotacaoSubFechado'] = 0;
            }elseif(($_SESSION[lotacaoVariavel][0][status] == 0) AND ($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
                $_SESSION[lotacaoVariavel][0][status] = 1;
                $i=0;
                $_SESSION['lotacaoSubFechado'] = 1;
                $codValidacao = getRest('variaveis/getCodValidacaoVariavelLotacao',$v);
                $_SESSION[lotacaoVariavel][0][codValidacao] = bin2hex(mhash(MHASH_ADLER32, $codValidacao[0][codValidacao]));
            }
        }else{
            $respGet[acao]='selecionarSecretaria';   
        }
        $msnTexto = "ao alterar variavel. ".$executar['msn'];       
    }
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
    
    //Setor----------->
    //fecharVariavelSetor
  
    //Fechar Variavel Setor
    if($respGet[acao]=='fecharVariavelSetor'){
        $v = array('idVariavelDesc'=>$respGet[idVariavelDesc],'idLotacaoSub'=>$respGet[idLotacaoSub]);
        $aVariaveis = array($v);
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
    //setorVariavel
    //------------------------------------------------->

    //----------
    if($respGet[acao]=='selecionarSetor'){
        $lvs = array($_SESSION[idLotacao],$respGet[idVariavelDesc]);
        $_SESSION[nomeVariavel]=$respGet[nomeVariavelDesc];
        $_SESSION[nomeLotacaoSub] = Null;
        $_SESSION[servidorVariavel] = Null;
        $respGet[pgLotacaoSub] = 1;
        $_SESSION[lotacaoSubVariavel] = getRest('variaveis/getListaVariaveisLotacaoSub',$lvs);
        $respGet[acao] =  'buscarVariavelLotacao';
        $_SESSION[idVariavelDesc] = $respGet[idVariavelDesc];
    }
    
    //servidor----------->---
    //Alterar Status Aprovar Variavel Servidor
    if($respGet[acao]=='aprovarVariavelServidor'){
        $v = array('id'=>$respGet[idVariavel]);
        $aVariaveis = array($v);
        $executar = postRest('variaveis/postAprovarVariaveisPorId',$aVariaveis);
        if(isset($respGet[nomeMatriculaPessoa])){
            $respGet[acao]='buscarVariavelServidor';
        }else{
            $respGet[acao]='servidoresVariavel';
        }
        if($_SESSION[servidorVariavel][0][status] == 'Negado'){
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] = $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] + 1;
        }
        $msnTexto = "ao alterar variavel. ".$executar['msn'];
    }
    //Alterar Status Negar Variavel Servidor
    if($respGet[acao]=='negarVariavelServidor'){
        $v = array('id'=>$respGet[idVariavel]);
        $aVariaveis = array($v);
        $executar = postRest('variaveis/postNegarVariaveisPorId',$aVariaveis);
        if(isset($respGet[nomeMatriculaPessoa])){
            $respGet[acao]='buscarVariavelServidor';
        }else{
            $respGet[acao]='servidoresVariavel';
        }
        if($_SESSION[servidorVariavel][0][status] == 'Aprovado'){
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] = $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] - 1;
        }
        $msnTexto = "ao alterar variavel. ".$executar['msn'];
    }
    //Alterar Status Lançar Variavel Servidor
    if($respGet[acao]=='lancarVariavelServidor'){
        $v = array('id'=>$respGet[idVariavel]);
        $aVariaveis = array($v);
        $executar = postRest('variaveis/postLancarVariaveisPorId',$aVariaveis);
        if(isset($respGet[nomeMatriculaPessoa])){
            $respGet[acao]='buscarVariavelServidor';
        }else{
            $respGet[acao]='servidoresVariavel';
        }
        if($_SESSION[servidorVariavel][0][status] == 'Aprovado'){
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] = $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] - 1;
        }
        $msnTexto = "ao alterar variavel. ".$executar['msn'];
    }
    //servidoresVariavel
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
    if($respGet[acao]=='buscarVariavelServidor'){
        if(is_numeric($respGet[nomeMatriculaPessoa]) == true ){
            $matricula = $respGet[nomeMatriculaPessoa];
            $respGet[nomeMatriculaPessoa] = '';
        }
        $sv = array($_SESSION[idLotacaoSub],$_SESSION[idVariavelDesc],$respGet[nomeMatriculaPessoa],$matricula);
        $encontrados = getRest('variaveis/getListaVariaveisPorSetorPorVariavelDescPorNomePorMatricula',$sv);
        if (count($encontrados) >= 1){
            $executar['info'] = 200;
            $_SESSION[servidorVariavel] = $encontrados;
            $msnTexto = "ao buscar servidor. ";
        }else{
            $executar['info'] = 400;
            $msnTexto = "! Servidor não encontrado. ";
        }

        
    } 
    if($respGet[acao]=='buscarVariavelLotacao'){
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
    if($respGet[acao]=='buscarVariavelLotacaoSub'){
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
?>
<h1 id="idTituloValidar">
    Validar 
    <small>Variáveis </small>
    <br><br>
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li class="active">Validar Variáveis</li>
</ol>
    <!-- Main content -->
<div class="box-body">
    <div class="row">
         <div class="box">
            <div class="box-header">
                <div class="box-body no-padding">
                    <form action="index.php" method="<?=$method?>" name="formTemplate">   
                        <?php require_once 'relat/boxSecretariaVariaveis.php';?>
                        <div class="box-footer pull-right">
                            <input type="hidden" name="pg" value="1"/>
                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                            <input type="hidden" name="acao" value="selecionarSecretaria"/>
                            <button type="submit" class="btn btn-primary">Abrir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(count($_SESSION[lotacaoVariavel])>0){?>
 <div class="box">
    <div class="box-header">
        <h3 class="box-title">
            Variável
        </h3>
        <div class="box-tools">
            <?php if(count($_SESSION[lotacaoVariavel]) == 1){?>
                 <form action="index.php" method="<?=$method?>" class="inline">
                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                    <input type="hidden" name="acao" value="selecionarSecretaria"/>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-mail-reply"></i></button>
                </form>
            <?php }else{ ?>
                <form action="index.php" method="<?=$method?>" class="inline">
                    <div class="input-group input-group-sm" style="width: 200px;">
                      <input type="hidden" name="pst" value="<?=$pst?>"/>
                      <input type="hidden" name="arq" value="<?=$arq?>"/>
                      <select name='nomeVariavelDesc'class="form-control select2" id='ocorrencia' style="width: 100%;">
                        <?php foreach ($_SESSION["variavelPerfil"] as $ArrEspPlan){
                            ?>
                          <option value="<?=$ArrEspPlan['nome']?>"><?=$ArrEspPlan['nome']?></option>
                          <?php }?>
                      </select>
                      <div class="input-group-btn">
                          <input type="hidden" name="acao" value="buscarVariavelLotacao"/>
                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                </form>
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
        <?php foreach (paginaAtual($_SESSION[lotacaoVariavel],$respGet[pgLotacao]) as $ArrEsp){ ?>
            <tr>
               <td>
                    <form action="index.php" method="<?=$method?>" class="inline">
                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                            <input type="hidden" name="idVariavelDesc" value="<?=$ArrEsp[idVariavelDesc]?>"/>
                            <input type="hidden" name="nomeVariavelDesc" value="<?=$ArrEsp[variaveisDesc]?>"/>
                            <input type="hidden" name="acao" value="selecionarSetor"/>
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </form>
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
                       <?php if($btnTipo == "fa fa-lock"){?>
                        <form action="index.php" method="<?=$method?>" class="inline">
                                <input type="hidden" name="vpst" value="<?=$pst?>" />
                                <input type="hidden" name="varq" value="<?=$arq?>" />
                                <input type="hidden" name="codValidacao" value="<?=$ArrEsp[codValidacao]?>" />
                                <input type="hidden" name="pst" value="print"/>
                                <input type="hidden" name="arq" value="info"/>
                                <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                <input type="hidden" name="pg" value="1"/>
                                <input type="hidden" name="acao" value="fichaFuncional"/>
                                <input type="hidden" name="idLotacao" value="<?=$_SESSION[idLotacao]?>"/>
                                <input type="hidden" name="idVariavelDesc" value="<?=$ArrEsp[idVariavelDesc]?>"/>
                                <input type="hidden" name="nomeVariavelDesc" value="<?=$ArrEsp[variaveisDesc]?>"/>
                                <input type="hidden" name="acao" value="relatFechamentoVariavel"/>
                                <button class="btn btn-primary"><i class="fa fa-print"></i></button>
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
<?php if(count($_SESSION[lotacaoSubVariavel])>0){?>
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Setor</h3>

              <div class="box-tools">
            <?php if(count($_SESSION[lotacaoSubVariavel]) == 1){?>
                 <form action="index.php" method="<?=$method?>" class="inline">
                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                    <input type="hidden" name="idVariavelDesc" value="<?=$_SESSION[idVariavelDesc]?>"/>
                    <input type="hidden" name="acao" value="selecionarSetor"/>
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
                    foreach (paginaAtual($_SESSION[lotacaoSubVariavel],$respGet[pgLotacaoSub]) as $ArrEspp){
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
                            <form action="index.php" method="<?=$method?>" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="idVariavelDesc" value="<?=$ArrEspp[idVariavelDesc]?>"/>
                                    <input type="hidden" name="idLotacaoSub" value="<?=$ArrEspp[idLotacaoSub]?>"/>
                                    <input type="hidden" name="nomeLotacaoSub" value="<?=$ArrEspp[nomeLotacaoSub]?>"/>
                                    <input type="hidden" name="acao" value="servidoresVariavel"/>
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </form>
                            <button <?=$disableLotacaoFechado?> class="<?=$lableBtn?>" data-toggle="modal" data-target="#fecha<?=$id?>"><i class="<?=$btnTipo?>"></i></button>
                            <div class="modal fade" id="fecha<?=$id?>" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-body">
                                        <p>O status da variável <?=$ArrEsp[variaveisDesc]?> do setor <?=$ArrEspp[nomeLotacaoSub]?> vai ser alterado para <?=$MsnNome?>. Deseja realmente fazer esta ação?</p>
                                  </div>
                                  <div class="modal-footer">
                                        <form action="index.php" method="<?=$method?>" class="inline">
                                                <input type="hidden" name="pst" value="<?=$pst?>"/>
                                                <input type="hidden" name="arq" value="<?=$arq?>"/>
                                                <input type="hidden" name="idVariavelDesc" value="<?=$ArrEspp[idVariavelDesc]?>"/>
                                                <input type="hidden" name="idLotacaoSub" value="<?=$ArrEspp[idLotacaoSub]?>"/>
                                                <input type="hidden" name="nomeLotacaoSub" value="<?=$ArrEspp[nomeLotacaoSub]?>"/>
                                                <input type="hidden" name="pgLotacaoSub" value="<?=$respGet[pgLotacaoSub]?>"/>
                                                <input type="hidden" name="acao" value="fecharVariavelSetor"/>
                                                <button class="btn btn-primary">Confirmar</button>
                                        </form>
                                        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php if($btnFecharLotacaoSub == true){?>
                            <button type="submit" <?=$disable?>  class="btn btn-success" data-toggle="modal" data-target="#aprovar<?=$id?>"><i class="fa fa-check-circle"></i></button>
                            <div class="modal fade" id="aprovar<?=$id?>" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-body">
                                        <p> Aprovar todas as variáveis <?=$ArrEsp[variaveisDesc]?> do setor <?=$ArrEspp[nomeLotacaoSub]?>. Deseja realmente fazer esta ação?</p>
                                  </div>
                                  <div class="modal-footer">
                                        <form action="index.php" method="<?=$method?>" class="inline">
                                                <input type="hidden" name="pst" value="<?=$pst?>"/>
                                                <input type="hidden" name="arq" value="<?=$arq?>"/>
                                                <input type="hidden" name="idVariavelDesc" value="<?=$ArrEspp[idVariavelDesc]?>"/>
                                                <input type="hidden" name="idLotacaoSub" value="<?=$ArrEspp[idLotacaoSub]?>"/>
                                                <input type="hidden" name="nomeLotacaoSub" value="<?=$ArrEspp[nomeLotacaoSub]?>"/>
                                                <input type="hidden" name="pgLotacaoSub" value="<?=$respGet[pgLotacaoSub]?>"/>
                                                <input type="hidden" name="acao" value="aprovarVariavelSetor"/>
                                                <button class="btn btn-primary">Confirmar</button>
                                        </form>
                                        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php }?>
                            <button type="submit" <?=$disable?>  class="btn btn-danger" data-toggle="modal" data-target="#reprovar<?=$id?>"><i class="fa fa-ban"></i></button>
                            <div class="modal fade" id="reprovar<?=$id?>" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-body">
                                        <p> Reprovar todas as variáveis <?=$ArrEsp[variaveisDesc]?> do setor <?=$ArrEspp[nomeLotacaoSub]?>. Deseja realmente fazer esta ação?</p>
                                  </div>
                                  <div class="modal-footer">
                                        <form action="index.php" method="<?=$method?>" class="inline">
                                                <input type="hidden" name="pst" value="<?=$pst?>"/>
                                                <input type="hidden" name="arq" value="<?=$arq?>"/>
                                                <input type="hidden" name="idVariavelDesc" value="<?=$ArrEspp[idVariavelDesc]?>"/>
                                                <input type="hidden" name="idLotacaoSub" value="<?=$ArrEspp[idLotacaoSub]?>"/>
                                                <input type="hidden" name="nomeLotacaoSub" value="<?=$ArrEspp[nomeLotacaoSub]?>"/>
                                                <input type="hidden" name="pgLotacaoSub" value="<?=$respGet[pgLotacaoSub]?>"/>
                                                <input type="hidden" name="acao" value="negarVariavelSetor"/>
                                                <button class="btn btn-primary">Confirmar</button>
                                        </form>
                                        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php if($btnTipo == "fa fa-lock"){?>
                             <form action="index.php" method="<?=$method?>" class="inline">
                                     <input type="hidden" name="vpst" value="<?=$pst?>" />
                                     <input type="hidden" name="varq" value="<?=$arq?>" />
                                     <input type="hidden" name="pst" value="print"/>
                                     <input type="hidden" name="arq" value="info"/>
                                     <input type="hidden" name="pg" value="1"/>
                                     <input type="hidden" name="acao" value="fichaFuncional"/>
                                     <input type="hidden" name="idLotacaoSub" value="<?=$ArrEspp[idLotacaoSub]?>"/>
                                     <input type="hidden" name="idVariavelDesc" value="<?=$ArrEsp[idVariavelDesc]?>"/>
                                     <input type="hidden" name="acao" value="relatFechamentoVariavelSub"/>
                                     <button class="btn btn-primary"><i class="fa fa-print"></i></button>
                             </form>
                            <?php } ?>
                      </td>
                    </tr>                
                <?php }?>
              </table>
            </div>
            <!-- /.box-body -->
           <?=controleDePagina($_SESSION[lotacaoSubVariavel],$respGet[pgLotacaoSub],"pgLotacaoSub");?> 
          </div>
          <!-- /.box -->
        </div>
     <?php //print_p($respGet);?>
</div>
<?php }?>
<?php if(count($_SESSION[servidorVariavel])>0){?>
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
                                    <button <?=$disablelotacaoSubFechado?> type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i></button>
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
                                    <button <?=$disablelotacaoSubFechado?> type="submit" class="btn btn-danger"><i class="fa fa-ban"></i></button>
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
                                    <button <?=$disablelotacaoSubFechado?> type="submit" class="btn btn-primary"><i class="fa fa-sort-amount-desc"></i></button>
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
    if((count($_SESSION[servidorVariavel]) == 0) AND (isset($respGet[idLotacaoSub]))){?>
            <div class="box-body">
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check-circle"></i> Atenção!</h4>
                 Não foram encontrados lançamentos. 
              </div>
                </div>
<?php }?>
    <script>
        $("#myModal").on("show", function() {    // wire up the OK button to dismiss the modal when shown
            $("#myModal a.btn").on("click", function(e) {
                console.log("button pressed");   // just as an example...
                $("#myModal").modal('hide');     // dismiss the dialog
            });
        });

        $("#myModal").on("hide", function() {    // remove the event listeners when the dialog is dismissed
            $("#myModal a.btn").off("click");
        });

        $("#myModal").on("hidden", function() {  // remove the actual elements from the DOM when fully hidden
            $("#myModal").remove();
        });

        $("#myModal").modal({                    // wire up the actual modal functionality and show the dialog
            "backdrop"  : "static",
            "keyboard"  : true,
            "show"      : true                     // ensure the modal is shown immediately
        });
    </script>