<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $pst = 'folhaOn';
    $arq = 'validarVariaveis';
//acesso
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

    //remover variavel servidor
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
    //*variaveis------------------------------------------------------>
    $dados = array('acao', 'idSecretaria');
    $b1 = array('buscaVSetor','addClass','hidden');
    $b2 = array('buscaVServidor','addClass','hidden');
    $beforeSend= array ($b1,$b2);
    postRestAjax('buscaVVariavel','buscaVVariavel','folhaOn/buscaVVariavel.php',$dados,$beforeSend); 
    
    //fecharVariavelSecretaria
    $dados = array('acao', 'idVariavelDesc','nomeVariavelDesc');
    $b1 = array('buscaVSetor','addClass','hidden');
    $b2 = array('buscaVServidor','addClass','hidden');
    $beforeSend= array ($b1,$b2);
    $funcao = array('fecharModal();');
    postRestAjax('fecharEmSecretaria','buscaVVariavel','folhaOn/buscaVVariavel.php',$dados,$beforeSend,'',$funcao); 
    
    //buscarVariavelNome
    $dados = array('acao', 'nomeVariavelDesc');
    $b1 = array('buscaVSetor','removeClass','hidden');
    $b2 = array('buscaVServidor','addClass','hidden');
    $beforeSend= array ($b1,$b2);
    postRestAjax('buscarVariavelNome','buscaVVariavel','folhaOn/buscaVVariavel.php',$dados,$beforeSend); 
    
    //pg
    $dados = array('acao', 'pgVariavel');
    postRestAjax('pgVariavel','buscaVVariavel','folhaOn/buscaVVariavel.php',$dados);  
    
    //*setor------------------------------------------------------------------------->
    $dados = array('acao', 'idVariavelDesc','nomeVariavelDesc');
    $b1 = array('buscaVSetor','removeClass','hidden');
    $b2 = array('buscaVServidor','addClass','hidden');
    $beforeSend= array ($b1,$b2);
    $funcao = array('buscarVariavelNome(acao,nomeVariavelDesc);');
    postRestAjax('buscaVSetor','buscaVSetor','folhaOn/buscaVSetor.php',$dados,$beforeSend,'', $funcao);
    
    //acaoEmlote
    $dados = array('acao','idVariavelDesc','idLotacaoSub', 'nomeLotacaoSub','pgLotacaoSub');
    $funcao = array('fecharModal(); buscaVServidor(acao,idVariavelDesc,idLotacaoSub,nomeLotacaoSub)');
    postRestAjax('acaoEmlote', 'buscaVSetor', 'folhaOn/buscaVSetor.php',$dados,'','', $funcao);

    //fecharEmloteSetor
    $dados = array('acao','idVariavelDesc','idLotacaoSub', 'nomeLotacaoSub','pgLotacaoSub','nomeVariavelDesc');
    $funcao = array('fecharModal(); buscaVServidor(acao,idVariavelDesc,idLotacaoSub,nomeLotacaoSub);buscarVariavelNome(acao, nomeVariavelDesc)');
    postRestAjax('fecharEmloteSetor', 'buscaVSetor', 'folhaOn/buscaVSetor.php',$dados,'','', $funcao);
    
    //busca
    $dados = array('acao', 'nomeLotacaoSub');
    $b1 = array('buscaVSetor','removeClass','hidden');
    $b2 = array('buscaVServidor','addClass','hidden');
    $beforeSend= array ($b1,$b2);
    postRestAjax('buscarSetorNome','buscaVSetor','folhaOn/buscaVSetor.php',$dados,$beforeSend);
    postRestAjax('buscarSetorServidor','buscaVSetor','folhaOn/buscaVSetor.php',$dados);
    
    //pg
    $dados = array('acao', 'pgSetor');
    postRestAjax('pgSetor','buscaVSetor','folhaOn/buscaVSetor.php',$dados);
    
    $dados = array('acao', 'idVariavelDesc','variaveisDesc','pgLotacaoSub');
    postRestAjax('buscaVServidorNegar','buscaVSetor','folhaOn/buscaVVariavel.php',$dados); 
    
    //*servidor--------------------------------------------->
    $dados = array('acao','idVariavelDesc','idLotacaoSub','nomeLotacaoSub');
    $funcao = array('buscarSetorNome(acao,nomeLotacaoSub); $("#buscaVServidor").removeClass("hidden");');
    postRestAjax('buscaVServidor','buscaVServidor','folhaOn/buscaVServidor.php',$dados,'','',$funcao);
    
    //pg
    $dados = array('acao', 'pgServidor');
    postRestAjax('pgServidor','buscaVServidor','folhaOn/buscaVServidor.php',$dados);   
    
    //buscar
    $dados = array('acao','nomeMatriculaPessoa');
    postRestAjax('buscarServidorNomeMatricula','buscaVServidor','folhaOn/buscaVServidor.php',$dados); 
    
    //acao
    $dados = array('acao','idVariavel','idVariavelDesc','nomeMatriculaPessoa','idLotacaoSub','nomeLotacaoSub','pgServidor','status');
    $funcao = array('buscarSetorServidor(acao, nomeLotacaoSub)');
    postRestAjax('acaoServidor','buscaVServidor','folhaOn/buscaVServidor.php',$dados,'','',$funcao);
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