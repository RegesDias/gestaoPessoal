<?php
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
    if (($respGet['acao'] == "buscar")) {
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
//FREQUENCIA----------->
//EXCLUIR OCORRENCIA
if ($respGet['acao'] == "excluirOcorrencia") {
        $excluirOco = array(      
                        'idOcorrencia' => $respGet['id']
                        );
    $excluirOco = array($excluirOco);
    $executar = postRest('OcorrenciaWs/postExcluirOcorrencia',$excluirOco);
    $msnTexto = "ao excluir ocorrência.";
    $periodoOcoBusca = str_replace("/", "-", $periodoMes);
    $inicioData = date("Y-m-d",strtotime($periodoOcoBusca[0]));
    $fimData = date("Y-m-d",strtotime($periodoOcoBusca[1]));
    $oPerfil = array('idFuncional' => $_SESSION["funcionalBusca"]['id'], 'inicio' => $inicioData, 'fim' => $fimData,'idOcoDesc' => '');
    $buscaOcorrencia = getRest('OcorrenciaWs/getListaOcorrenciaPorIdData',$oPerfil);
    $_SESSION["ocorrenciaPerfil"] = $buscaOcorrencia;
}
//BUSCA OCORRENCIA
if ($respGet['acao'] == "buscarOcorrencia") {
    $dataTotal = $respGet['periodoOco'];
    $dataTotal = str_ireplace("/", "-", $dataTotal);
    $inicioFim = explode(" até ", $dataTotal);
    $inicioData = date("Y-m-d",strtotime($inicioFim[0]));
    $fimData = date("Y-m-d",strtotime($inicioFim[1]));
    $buscaOco = array('idFuncional' => $_SESSION["funcionalBusca"]['id'], 'inicio' => $inicioData, 'fim' => $fimData,'idOcoDesc' => $respGet['idOcorrencia']);
    $_SESSION["dadosBuscaOcorrencia"] = $buscaOco;
    $_SESSION["dadosBuscaOcorrencia"]['matricula'] = $_SESSION['funcionalBusca']['matricula'];
    $_SESSION["dadosBuscaOcorrencia"]['cpf'] = $_SESSION['funcionalBusca']['pessoa']['cpf'];
    $buscaOcorrencia = getRest('OcorrenciaWs/getListaOcorrenciaPorIdData',$buscaOco);
    $msnTexto = "! Ocorrencias não encontradas no período de ".$inicioFim[0]." até ".$inicioFim[1].".";
    $totalBusca = count($buscaOcorrencia);
        if ($totalBusca == 0) {
            $executar['info'] = 400;
        }else{
            $executar['info'] = 200;
        }
    $_SESSION["ocorrenciaPerfil"] = $buscaOcorrencia;
}
//PLANEJAMENTO----------->
//CADASTRAR PLANEJAMNETO
if ($respGet['acao'] == "lancarPlanejamento") {
    $variavel = array('pontoFacult','feriado');
    $respGet = trueFalse($respGet, $variavel);
    $lancarPlan = array(      
                    'idTpPlan' => $respGet['idTpPlan'],
                    'idFunc' => $_SESSION["funcionalBusca"]["id"],
                    'diaSemana' => $respGet['diaSemana'],
                    'hInicial' => $respGet['hInicial'],
                    'hFinal' => $respGet['hFinal'],
                    'setorPlan' => $respGet['setorPlan'],
                    'feriado' => $respGet['feriado'],
                    'pontoFacult' => $respGet['pontoFacult']
                        );
    $arquivoPlan = array($lancarPlan);
    $executar = postRest('planejamento/postIncluirPlanejamento',$arquivoPlan);
    $respGet['acao'] = 'buscarPlanejamento';
}
//REMOVER PLANEJAMENTO
if ($respGet['acao'] == "excluirPlanejamento") {
        $excluirPlan = array('idPlanejamentoAuxiliar'=>$respGet['idPlanejamentoAuxiliar']);
        $excluirP = array($excluirPlan);
        $executar = postRest('planejamento/postRemoverPlanejamentoAuxiliar',$excluirP);
        $msnTexto = "ao excluir Planejamento.";
        $respGet['acao'] = 'buscarPlanejamento';
}

//BUSCAR PLANEJAMENTO
if ($respGet['acao'] == "buscarPlanejamento") {
        $buscaPlan = array('idFuncional'=>$_SESSION["funcionalBusca"]['id']);
        $buscaPlanejamento = getRest('planejamento/getListaPlanejamento',$buscaPlan);
        $_SESSION["planLancados"] = $buscaPlanejamento;
}

//lançarProntuario
if ($respGet['acao'] == "lancarProntuario") {
$vowels = array(")", "(", " ", "-");
$respGet['teletone'] = str_replace($vowels, "", $respGet['teletone']);
$respGet['celular'] = str_replace($vowels, "", $respGet['celular']);
$respGet['cep'] = str_replace($vowels, "", $respGet['cep']);
$lancarPlan = array(      
                'idPessoa' => $_SESSION["funcionalBusca"]['pessoa']['id'],
                'cepLogradouro' => $respGet['cep'],
                'idEstado' => $respGet['estado'],
                'idCidade' => $respGet['cidade'],
                'idBairro' => $respGet['bairro'],
                'endereco' => $respGet['logradouro'],
                'numero' => $respGet['numero'],
                'complemento' => $respGet['complemento'],
                'celular' => $respGet['celular'],
                'telefone' => $respGet['teletone'],
                'email' => $respGet['email']
                    );
$arquivoPlan = array($lancarPlan);
$msnTexto = "ao cadastrar prontuário.";
$executar = postRest('requerimento/postIncluirRequerimentoInfo',$arquivoPlan);
}
$alterarProntuario = array('id'=> '','idPessoa' => $_SESSION["funcionalBusca"]['pessoa']['id']);
$buscaProntuario = getRest('requerimento/getListarRequerimentoInfo',$alterarProntuario);

////CRACHA------------------>
//requisitar Cracha
if ($respGet['acao'] == "crachaRequisitar") {
        $cracha = array('idHistFunc'=>$respGet['idHistFunc'],'idCrachaTipo'=>$respGet['idCrachaTipo']);
        $c = array($cracha);
        $executar = postRest('cracha/postIncluirCrachaRequisicao',$c);
        $msnTexto = "ao requisitar Crachá.";
}
// Cracha Impresso
if ($respGet['acao'] == "crachaImpresso") {
        $cracha = array('id'=>$respGet['idCrachaRequisicao']);
        $c = array($cracha);
        $executar = postRest('cracha/postCrachaImpresso',$c);
        $msnTexto = "ao alterar status para impresso.";
}
// Cracha Entregue
if ($respGet['acao'] == "crachaEntregue") {
        $cracha = array('id'=>$respGet['idCrachaRequisicao']);
        $c = array($cracha);
        $executar = postRest('cracha/postCrachaEntregue',$c);
        $msnTexto = "ao alterar status para entrege.";
}
// Cracha Cancelado
if ($respGet['acao'] == "crachaCancelado") {
        $cracha = array('id'=>$respGet['idCrachaRequisicao']);
        $c = array($cracha);
        $executar = postRest('cracha/postCrachaNegado',$c);
        $msnTexto = "ao alterar status para Cancelado.";
}
// Cracha Liberado
if ($respGet['acao'] == "crachaLiberarPedido") {
        $cracha = array('id'=>$respGet['idCrachaRequisicao']);
        $c = array($cracha);
        $executar = postRest('cracha/postLiberarCracha',$c);
        $msnTexto = "novo cracha pode ser requisitado";
}
////VARIAVEL------------------>
if ($respGet['acao'] == "variavelRemover") {
        $variavel = array('idVariavel'=>$respGet['idVariavel']);
        $v = array($variavel);
        $executar = postRest('variaveis/postVariaveisExcluir',$v);
        $msnTexto = "ao alterar status para Cancelado.";
        $vPerfil = array('idFuncional' => $_SESSION["funcionalBusca"]['id']);
        $variaveisLancadas = getRest('variaveis/getListaVariaveisFuncionalPorId',$vPerfil);
        $_SESSION["variaveisLancadas"] = $variaveisLancadas;
}
if ($respGet['acao'] == "variavelRemoverEmLote") {
    $getResp['idHistFuncional'];
    $getResp['dataFolha'];
}
//FIM ACAO------------
exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);

//verifica a existencia de menus dublicados
$resultArrayAbas = removeArrayDublicado($_SESSION["funcionalPerfil"]['permissoes'], 'menuN2');
//TESTE
//    echo '<pre>';
//    print_r($buscaOco );
//    echo '</pre><br>';
    
?>
<h1>
    Perfil
    <small>Servidor</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li><a href="#"> Buscar</a></li>
    <li class="active">Perfil</li>
</ol>
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
                    <form action="index.php" method="<?=$method?>" class="inline">
                        <input type="hidden" name="pst" value="funcional"/>
                        <input type="hidden" name="arq" value="buscar"/>
                        <input type="hidden" name="pg" value="<?=$respGet['pg']?>"/>
                        <input type="hidden" name="relat" value="regimeServidor"/>
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fa fa-rotate-left"></i><b> Voltar</b>
                        </button>
                    </form>
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
                            if ($valor['pasta'] == ''){ ?>
                                <li class='<?=tabId($valor['menuN2'], $respGet['tab'],$padrao)?>'><a href="#<?=$valor['menuN2']?>" data-toggle="tab"><?=$valor['menuN1']?></a></li><?php
                            }
                            $padrao=false;
                        }
                    ?>
                </ul>
                <div class="tab-content">
                    <?php
                        $padrao=true;
                        foreach ($resultArrayAbas as $valor) {
                            if ($valor['pasta'] == ''){ 
                                require_once $valor['menuN2'].".php";
                            }
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
