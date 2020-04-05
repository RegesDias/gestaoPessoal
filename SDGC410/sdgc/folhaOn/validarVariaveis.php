<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $pst = 'folhaOn';
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
    $respGet[acao]='limparSessao';
    if($respGet[acao]=='limparSessao'){
        $_SESSION[lotacaoVariavel] = Null; 
        $_SESSION[lotacaoSubVariavel] = Null;
        $_SESSION[servidorVariavel] = Null;
        $_SESSION[nomeVariavel]=Null;
        $_SESSION[nomeLotacaoSub] = Null;
        $_SESSION[idLotacao] = Null;
        $_SESSION[variavelPerfil] = getRest('variaveis/getListaVariaveisDesc');
        $total = getRest('lotacao/getListaLotacaoUsuarioVariaveis');
        if(count($total) == 1){
           $respGet[acao] = 'selecionarSecretaria'; 
           $respGet[idSecretaria] = $total[0][id];
        }
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
    //remover variavel servidor
    if ($respGet['acao'] == "variavelRemover") {
            $variavel = array('idVariavel'=>$respGet['idVariavel']);
            $v = array($variavel);
            $executar = postRest('variaveis/postVariaveisExcluir',$v);
            if (count($_SESSION[lotacaoSubVariavel]) == 1){
               if(($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
                    $Array = $_SESSION[servidorVariavel];
                    $p =  array_search($respGet[idVariavel], array_column($Array, 'idVariavel')).'<br />';
                    $p = intval($p);
                    unset($Array[$p]);
                    sort($Array);         
                    $_SESSION[servidorVariavel] =$Array;
                }
            }else{
                $respGet[acao]='selecionarSetor'; 
            }
            $msnTexto = "ao alterar variavel. ".$executar['msn'];
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
                    <form>   
                        <div id="carregaLot-variaveis">
                            <?php require_once '../relat/boxSecretaria.php';?>
                        </div>
                        <div class="box-footer pull-right">
                            <input type="hidden" name="acao" value="selecionarSecretaria"/>
                            <!--<button type="submit" class="btn btn-primary">Abrir</button>-->
                         <button class="btn btn-primary" onclick="buscaVVariavel('selecionarSecretaria',$('#secretariaID').val())" type="button">
                            <i class="fa fa-search"></i> Abrir
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="buscaVVariavel">
</div>

<div id="buscaVSetor">
</div>

<div id="buscaVServidor">
</div>
<?php
    //variaveis
    $dados = array('acao', 'idSecretaria');
    $b1 = array('buscaVSetor','addClass','hidden');
    $b2 = array('buscaVServidor','addClass','hidden');
    $beforeSend= array ($b1,$b2);
    postRestAjax('buscaVVariavel','buscaVVariavel','folhaOn/buscaVVariavel.php',$dados,$beforeSend); 
    
    $dados = array('acao', 'nomeVariavelDesc');
    $b1 = array('buscaVSetor','removeClass','hidden');
    $b2 = array('buscaVServidor','removeClass','hidden');
    $beforeSend= array ($b1,$b2);
    postRestAjax('buscarVariavelNome','buscaVVariavel','folhaOn/buscaVVariavel.php',$dados,$beforeSend); 
    
    //setor
    $dados = array('acao', 'idVariavelDesc','nomeVariavelDesc');
    $b1 = array('buscaVSetor','removeClass','hidden');
    $b2 = array('buscaVServidor','addClass','hidden');
    $beforeSend= array ($b1,$b2);
    $funcao = array('buscarVariavelNome(acao,nomeVariavelDesc);');
    postRestAjax('buscaVSetor','buscaVSetor','folhaOn/buscaVSetor.php',$dados,$beforeSend,'', $funcao);
    
    //busca
    $dados = array('acao', 'nomeLotacaoSub');
    $b1 = array('buscaVSetor','removeClass','hidden');
    $b2 = array('buscaVServidor','addClass','hidden');
    $beforeSend= array ($b1,$b2);
    postRestAjax('buscarSetorNome','buscaVSetor','folhaOn/buscaVSetor.php',$dados,$beforeSend); 
    
    $dados = array('acao', 'idVariavelDesc','variaveisDesc','pgLotacaoSub');
    postRestAjax('buscaVServidorNegar','buscaVSetor','folhaOn/buscaVVariavel.php',$dados); 
    
    
    //servidor
    $dados = array('acao','idVariavelDesc','idLotacaoSub','nomeLotacaoSub');
    $funcao = array('buscarSetorNome(acao,nomeLotacaoSub); $("#buscaVServidor").removeClass("hidden");');
    postRestAjax('buscaVServidor','buscaVServidor','folhaOn/buscaVServidor.php',$dados,'','',$funcao); 
?>
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
<?php if($respGet[acao] !='limparSessao'){?>
    <!--    Faz a pagina descer ate este ponto-->
    <a id='descer'></a>
<?php }?>