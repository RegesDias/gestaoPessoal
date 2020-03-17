<?php
$pst = 'funcional';
$arq = 'buscar';
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
//configuração
    $pst = 'funcional';
    $arq = 'perfil';
    $n0 = 'id';             $c0 = $respGet['id'];
    $n1 = 'nome';           $c1 = $respGet['nome'];
    $n2 = 'matricula';      $c2 = $respGet['matricula'];
    $n3 = 'cpf';          $c3 = $respGet['cpf'];
    $cBusc = array($respGet['id']);
    $cData = array($n0 => $c0, $n1 => $c1, $n2 => $c2);
    $cExcl = array($n0 => $c0);
    $rest = ucfirst($arq);
//paginacao
    $hrefPag= array(
                "<input type='hidden' name='pst' value ='".$pst."'/>",
                "'arq' value='".$arq."'/>",
                "'orby' value='".$respGet['orby']."'/>",
                "'dir' value='".$respGet['dir']."'/>",
                "'$n1' value='".$c1."'/>",
                "'$n2' value='".$c2."'/>"
    );
//listar
    if (isset($respGet['id'])) {
        $funcionalBusca = getRest('funcionalws/getUmFuncionalPorMatricula',$cBusc);
        session_start();
        $_SESSION["dadosBuscaOcorrencia"] = null;
        $_SESSION["funcionalBusca"] = $funcionalBusca;
        $cPerfil = array($_SESSION["funcionalBusca"]['id']);
        $cpf = array($_SESSION["funcionalBusca"]['pessoa']['cpf']);
        $funcionalPerfil = getRest('funcionalws/getUmFuncionalPorId',$cPerfil);
        $_SESSION["funcionalBio"]  = getRest('funcionalws/getBiometriaCadastrada',$cPerfil);
        $biometria = getRest('funcionalws/getBiometriaCadastrada',$cpf);
        $periodoOcoBusca = str_replace("/", "-", $periodoMes);
        $inicioData = date("Y-m-d",strtotime($periodoOcoBusca[0]));
        $fimData = date("Y-m-d",strtotime($periodoOcoBusca[1]));
        $oPerfil = array('idFuncional' => $funcionalPerfil['id'], 'inicio' => $inicioData, 'fim' => $fimData,'idOcoDesc' => '');
        $ocorrenciaPerfil = getRest('OcorrenciaWs/getListaOcorrenciaPorIdData',$oPerfil);
        //busca Variaveis Lançadas
        $vPerfil = array('idFuncional' => $funcionalPerfil['id']);
        $variaveisLancadas = getRest('variaveis/getListaVariaveisFuncionalPorId',$vPerfil);
        $_SESSION["variaveisLancadas"] = $variaveisLancadas;
        $planejamentoPerfil = getRest('planejamento/getListaPlanejamentoDescricao');
        $variavelPerfil = getRest('variaveis/getListaVariaveisDesc');
        $funcionalBusca = getRest('funcionalws/getUmFuncionalPorMatricula',$cBusc);
        session_start();
        $_SESSION["funcionalPerfil"] = $funcionalPerfil;
        $_SESSION["ocorrenciaPerfil"] = $ocorrenciaPerfil;
        $_SESSION["planejamentoPerfil"] = $planejamentoPerfil;
        $_SESSION["variavelPerfil"] = $variavelPerfil;
        //BUSCAR PLANEJAMENTO
         $respGet['acao'] = 'buscarPlanejamento';
         //BIOMETRIA
         if ($biometria['biometria'] == 1){
             $_SESSION["funcionalBio"]['biometria'] = 'SIM';
         }else{
             $_SESSION["funcionalBio"]['biometria'] = 'NAO';
         }
        foreach ($_SESSION["funcionalPerfil"]["lotacoesSub"] as $ArrEsp){
            if($ArrEsp['ativo']==1){
                $lotacaoSubAtivo[] =array('idSetor' => $ArrEsp['idSetor'], 'nome' => $ArrEsp['nome']);
            }
         }
         $_SESSION["lotacoesSubAtivos"] = $lotacaoSubAtivo;
        $buscAcessoNivel = array("6");
        $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
        foreach ($listaAcesso as $valor) {
            if (($valor['link'] == 'Avaliacao') AND ($valor['alterar'] == '1')){
                 $_SESSION["AvaliacaoAnularBotao"] = true;
                 break;
            }
        }
        $_SESSION["pesoAvaliacao"] = getRest('avaliacao/getListaAvaliacaoPesoAtivas');
        $_SESSION["tipoSolicitacaoSesmt"] = getRest('requerimento/getListaRequerimentoSolicitacaoSesmt');
        $buscaR = array('idInfo' => $_SESSION["funcionalBusca"]['pessoa']['id']);
        $_SESSION["enderecoSESMIT"] = getRest('requerimento/getListarRequerimentoInfoPorIdPessoa',$buscaR);
        $requiSesmt = array('idInfo' => $_SESSION["funcionalBusca"]['id']);
        $_SESSION["requiSesmt"] = getRest('requerimento/getListaRequerimentoPorFuncional',$requiSesmt);
    }
//MODAL
    modalCriarAcesso('criarUsuario', 'Deseja vincular um usuário ao servidor?', 'usuario', 'usuario', 'cadastarUsuario');
//GESTAO-------------->
//LOTACAO
if ($respGet['acao'] == "alterarLotacao") {
    $alterLotacao = array('idLotacao' => $respGet['idLotacao'], 'idFuncional' => $respGet['idFuncional']);
    $aLotacao = array($alterLotacao);
    $executar = postRest('funcionalws/postAlterarLotacao',$aLotacao);
    $msnTexto = "ao alterar lotação.";
    $msnExibe = alterarArray($executar,$_SESSION["funcionalPerfil"]["lotacoes"],'lotacoes',$respGet['idLotacao'],'idLotacao');
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
    $respGet['acao']  = 'alterarSetor';
    $respGet['idSetor'] = array($respGet['idLotacao'].'.01');
    
    //listar novos setores
    $cPerfil = array($_SESSION["funcionalBusca"]['id']);
    $_SESSION["funcionalPerfil"]["lotacoesSub"] = getRest('funcionalws/getListaSetorPorId',$cPerfil);
    
    //alterar regime de trabalho
    $respGet['acao2']  = 'alterarRegime';
    $respGet['idRegime'] = '00001';
}
//SETOR
if ($respGet['acao'] == "alterarSetor") {
    $alterSetor = array();
    foreach ($respGet['idSetor'] as $value) {
        $alterSetor[] = "'idSetor' => $value, 'idFuncional' => ".$respGet['idFuncional'];
    }
    $aSetor = array($alterSetor);
    $executar = postRest('funcionalws/postAlterarSetor',$aSetor);
    $msnTexto = "ao alterar setor.";
    $cPerfil = array($_SESSION["funcionalBusca"]['id']);
    $_SESSION["funcionalPerfil"]["setoresAtivos"] = getRest('funcionalws/getListaSetorAtivoPorId',$cPerfil);
    $msnExibe = alterarArray($executar,$_SESSION["funcionalPerfil"]["lotacoesSub"],'lotacoesSub',$respGet['idSetor'],'idLotacao',true);
    foreach ($_SESSION["funcionalPerfil"]["lotacoesSub"] as $ArrEsp){
        if($ArrEsp['ativo']==1){
            $lotacaoSubAtivo[] =array('idSetor' => $ArrEsp['idSetor'], 'nome' => $ArrEsp['nome']);
        }
     }
    $_SESSION["lotacoesSubAtivos"] = $lotacaoSubAtivo;
    if($respGet['acao2']  == 'alterarRegime'){
        exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
        $respGet['acao']  = 'alterarRegime';
    }
}
//ESPECIALIDADE
if ($respGet['acao'] == "alterarEspecialidade") {
    $alterEspecialidade = array('idEspecialidade' => $respGet['idEspecialidade'], 'idFuncional' => $respGet['idFuncional']);
    $aEspecialidade = array($alterEspecialidade);
    $executar = postRest('funcionalws/postAlterarEspecialidade',$aEspecialidade);
    $msnTexto = "ao alterar especialidade.";
    $msnExibe = alterarArray($executar,$_SESSION["funcionalPerfil"]["especialidades"],'especialidades',$respGet['idEspecialidade'],'idEspecialidade');
}
//REGIME TRABALHO
if ($respGet['acao'] == "alterarRegime") {
    
    $alterRegime = array('idRegime' => $respGet['idRegime'], 'idFuncional' => $respGet['idFuncional']);
    $podeAlterar = getRest('funcionalws/getPodeAlterarRegime',$alterRegime);
    if($podeAlterar['podeAlterarRegime'] == 1){
        $aRegime = array($alterRegime);
        $executar = postRest('funcionalws/postAlterarRegime',$aRegime);
        $msnTexto = "ao alterar Regime.";
    }else{
        $executar['info'] = 400;
        $msnTexto = "! Regime incompatível.";      
    }

    $msnExibe = alterarArray($executar,$_SESSION["funcionalPerfil"]["regimes"],'regimes',$respGet['idRegime'],'idRegime');
}
exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);

//verifica a existencia de menus dublicados
$resultArrayAbas = removeArrayDublicado($_SESSION["funcionalPerfil"]['permissoes'], 'menuN2');
    
?>
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
            
                <div class="box-body box-profile">
                    <img src="<?=exibeFoto($_SESSION["funcionalBusca"]['pessoa']['cpf'])?>" class="profile-user-img img-responsive img-bordered-sm" id="imgSmile" alt="Imagem do Usuário"> 
                    <h5 class=" text-center"><?=$_SESSION["funcionalBusca"]['pessoa']['nome']?></h5>
                    <h6 class="text-muted text-center"><?=$_SESSION["funcionalBusca"]['cargo']['nome']?></h6>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                         <h6 class="text-muted text-center"><b><?=$_SESSION["funcionalBusca"]['regime']['nome']?></b></h6>
                        </li>
                        <li class="list-group-item">
                            <b>Matrícula</b> <a class="pull-right"><?=$_SESSION["funcionalBusca"]['matricula']?></a>
                        </li>
                        <li class="list-group-item">
                            <?php
                            if($_SESSION["funcionalBusca"]['cargoCom']['nome'] == 'NAO'){
                               $chs = $_SESSION["funcionalBusca"]['cargo']['horaSemanal'];
                            }else{
                               $chs = $_SESSION["funcionalBusca"]['cargoCom']['horaSemanal']; 
                            }
                            ?>
                            <b>Carga horária</b> <a class="pull-right"><?=$chs?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Status</b> <a class="pull-right"><?=$_SESSION["funcionalBusca"]['situacao']['nome']?></a>
                        </li>
                    </ul>
                    <?php
                    if($_SESSION["funcionalBusca"][podeCriarUsuario] == 1){
                        if($_SESSION["funcionalPerfil"]["temUsuario"]==1){?>
                            <form action="index.php" method="<?=$method?>" class="inline">
                                <input type="hidden" name="acao" value="buscar"/>
                                <input type="hidden" name="pst" value="usuario"/>
                                <input type="hidden" name="arq" value="perfil"/>
                                <input type="hidden" name="cpf" value="<?=$_SESSION['funcionalBusca']['pessoa']['cpf']?>"/>
                                <input type="hidden" name="pg" value="1"/>
                                <input type="hidden" name="relat" value="regimeServidor"/>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-users"></i><b> Usuário</b>
                                </button>
                            </form>
                    <?php }else{?>
                           <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#criarUsuario">
                              <i class="fa fa-users"></i><b> Converter em Usuário</b>
                            </button><?php
                        }
                    }?>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-pencil margin-r-5"></i> FG/CC</strong>
                    <hr>
                    <p class="text-muted">
                       <center><?=$_SESSION["funcionalBusca"]['cargoCom']['nome']?></center>
                    </p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- About Me Box -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa  fa-hand-pointer-o margin-r-5"></i> Biometria Cadastrada</strong>
                    <hr>
                    <p class="text-muted">
                       <center><?=$_SESSION["funcionalBio"]['biometria'];?></center>
                    </p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <?php
                        $padrao=true;
                        foreach ($resultArrayAbas as $valor) {
                            if ($valor['pasta'] == ''){ 
                                $require[] = $valor['menuN2'].".php";?>
                                <li class='//<?=tabId($valor['menuN2'], $respGet['tab'],$padrao)?>'><a href="#<?=$valor['menuN2']?>" data-toggle="tab"><?=$valor['menuN1']?></a></li><?php
                            }
                            $padrao=false;
                        }
                    ?>
                </ul>
                <?php
                
                ?>
                <div class="tab-content">
                    <?php
                        $padrao=true;
                        foreach ($require as $r) {
                           $cont++;
                           require_once $r;
                        }
                    ?>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<script>
   configuraTela(); 
</script>
