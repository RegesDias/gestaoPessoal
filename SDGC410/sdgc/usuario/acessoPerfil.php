<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
$_SESSION['appv'] = getRest('appversao/getListaAppVersao');

print_p($respGet);

$limparAcesso = 'nao';
$pst = 'usuario';
$arq = 'perfil';
$cUser = array('',$respGet['cpf'],'');
//CRIAR
    if ($respGet['acao'] == "cadastarUsuario") {
        $idTemplate = array(
             'login'=>$respGet['chave'],
             'nomeCompleto'=>$respGet['nomeCompleto'],
             'cpf'=>$respGet['cpf']
              );
        $msnTexto = " ao cadastrar usuario";
        $exec= postRest('userloginws/postIncluirUsuario',$idTemplate);
        $msnTexto = ' ! '.$exec['msn'];
        if ($exec['info'] == 200){
            $_SESSION['appv'] = getRest('appversao/getListaAppVersao');
        }
        $respGet['acao'] = 'buscar';
        $cUser = array('',$respGet["cpf"],'');
    }
//ALTERAR SENHA
    if ($respGet['acao'] == "alterarSenha") {
        if($respGet['senha'] == $respGet['confirmaSenha']){
            $idTemplate = array(
                'idUserLogin'=>$_SESSION["perfilUsuario"] ['0']['id'],
                 'novaSenha'=>$respGet['senha']
                  );
            $exec= postRest('userloginws/postAlterarSenhaUsuario',$idTemplate);
            $msnTexto = ' ! '.$exec['msn'];
        }else{
            $exec['info'] = 400;
            $msnTexto = "Senhas não coincidem";
        }
        $respGet['acao'] = 'buscar';
        $cUser = array('',$_SESSION["perfilUsuario"] ['0']['cpf'],'');
    }
//ALTERAR STATUS
    if ($respGet['acao'] == "bloquearLiberar") {
        $idTemplate = array(
            'idUserLogin'=>$_SESSION["perfilUsuario"] ['0']['id'],
             'status'=>$respGet['valorStatus']
              );
        $msnTexto = " ao alterar status";
        $exec= postRest('userloginws/postAlterarStatusUsuario',$idTemplate);
        $respGet['acao'] = 'buscar';
        $cUser = array('',$_SESSION["perfilUsuario"] ['0']['cpf'],'');
    }
//EXCLUIR TEMPLATE
    if ($respGet['acao'] == "excluirTemplate") {
        $idTemplate = array(
            'idUserLogin'=>$_SESSION["perfilUsuario"] ['0']['id'],
            'idlotacao'=>$respGet['idlotacao'],
            'idlotacaosub'=>$respGet['idlotacaosub']
              );
              //print_r($idTemplate);
        $msnTexto = " ao remover acesso";
        $exec= postRest('userMenu/postExcluirTemplateDoUsuario',$idTemplate);
        $cUser = array('',$_SESSION["perfilUsuario"] ['0']['cpf'],'');
        $respGet['acao'] = 'buscar';
    }
//EXIBIR ACESSOS
    if ($respGet['acao'] == "exibirAcesso") {
        $buscaAcessoTemplate = array('id' => $respGet['idtemplate']);
        $_SESSION['verTemplate']= getRest('userMenu/getListaTemplatePermissaoAccesso',$buscaAcessoTemplate);
        $_SESSION['template']= array('id'=>$respGet['idtemplate'],'nome'=>$respGet['nometemplate']);
    }
//INCLUIR ACESSOS
    if ($respGet['acao'] == "incluirAcesso") {
        if(!isset($respGet['idSecretaria'])){
            $respGet['idSecretaria'][0] = null;
        }
        if(isset($respGet['idCargoGeral'])){
            $cargoGeralJson2D = postJson2D($respGet['idCargoGeral'],'idCargoGeral');
        }else{
            $cargoGeralJson2D = null;
        }
        if ((count($respGet['idSecretaria'])==1) AND $respGet['idSecretaria'][0] !='todasSecretarias'){
            $setorJson2D= postJson2D($respGet['idSetor'],'idSetor');
            if($respGet['idSecretaria']==''){$respGet['idSecretaria']=null;}
                $idTemplate = array(
                    'id' => $respGet['idTemplate']['0'],
                    'idSecretaria' => $respGet['idSecretaria']['0'],
                    'idUserLogin'=>$_SESSION["perfilUsuario"] ['0']['id'],
                    'idSetor' => $setorJson2D,
                    'idCargoGeral' => $cargoGeralJson2D
                );
            $msnTexto = "ao incluir acesso.";
            $exec= postRest('userMenu/postAlocarTemplateAoUsuario',$idTemplate);
        //Multiplas secretaria
        }else if ($respGet['idSecretaria'][0] !='todasSecretarias'){
            foreach ($respGet['idSecretaria'] as $idSecretaria){
                $idTemplate = array(
                    'id' => $respGet['idTemplate']['0'],
                    'idSecretaria' => $idSecretaria,
                    'idUserLogin'=>$_SESSION["perfilUsuario"] ['0']['id'],
                    'idSetor' => null,
                    'idCargoGeral' => $cargoGeralJson2D
                 );
            $msnTexto = "ao incluir acesso.";
            $exec= postRest('userMenu/postAlocarTemplateAoUsuario',$idTemplate);
            }
        //Todas as Secretarias
        }else if ($respGet['idSecretaria'][0] =='todasSecretarias'){
            $todasLotacoes= getRest('lotacao/getListaLotacao');
            foreach ($todasLotacoes as $idSecretaria){
                $idTemplate = array(
                    'id' => $respGet['idTemplate'],
                    'idSecretaria' => $idSecretaria['id'],
                    'idUserLogin'=>$_SESSION["perfilUsuario"] ['0']['id'],
                    'idSetor' => null,
                    'idCargoGeral' => $cargoGeralJson2D
                 );
            $msnTexto = "ao incluir acesso.";
            $exec= postRest('userMenu/postAlocarTemplateAoUsuario',$idTemplate);
            }
        }
        print_p($idTemplate);
        $buscaAcessoTemplate = array('id' => $_SESSION['template']['id']);
        $_SESSION['verTemplate']= getRest('userMenu/getListaTemplatePermissaoAccesso',$buscaAcessoTemplate);
        $cUser = array('',$_SESSION["perfilUsuario"] ['0']['cpf'],'');
        $respGet['acao'] = 'buscar';
        
    }
//BUSCAR ACESSOS
    if ($respGet['acao'] == "buscar") {
        $_SESSION['perfilUsuario'] = getRest('userloginws/getListaUserLoginMult', $cUser);
        $_SESSION['perfilAcesso'] = getRest('userloginws/getListaUserLoginMult', $cUser);
        $idUser = array(
                'idUsuario'=>$_SESSION["perfilUsuario"] ['0']['id']
              );
       $_SESSION['perfilTemplates'] = getRest('userMenu/getTemplatesUsuario', $idUser);
//        echo "<pre>";
//         print_r($_SESSION['perfilTemplates']);
//        echo "</pre>";
        $_SESSION["menuModulos"] = $menuModulos;
        $_SESSION['template'] = '';
        $_SESSION['verTemplate'] = '';
    }
    if ($respGet['acao'] == "dataTreinamento") {
                $idTemplate = array(
                    'idUserLogin' => $_SESSION["perfilUsuario"] ['0']['id'],
                    'data'=>$respGet['dataTreinamento']
                  );
                $idTemplate = array($idTemplate);
                $msnTexto = " ao cadastrar data de treinamento";
                $exec= postRest('userDataTreinamento/postIncluirUserDataTreinamento',$idTemplate);
                $cUser = array('',$_SESSION["perfilUsuario"] ['0']['cpf'],'');
    }
    
//msn
exibeMsn($msnExibe, $msnTexto, $msnTipo, $exec);
modalCadUser('cadUser', 'Cadastrar Perfil', $pst, $arq);
modalAlterarSenha('alterarSenha', 'Alterar Senha', $pst, $arq, 'alterarSenha');

modalInicoFimData('historicoAcesso', 'Historico de Acessos', 'historicoAcesso',$_SESSION["perfilUsuario"] ['0']['login']);
//$dados('acao','user', 'mesAnoInicial', 'mesAnoFinal','ver');
$dados = array('acao','user', 'mesAnoInicial', 'mesAnoFinal','ver');
postRestAjax('posthistoricoAcesso','imprimir','print/info.php',$dados);  
   
modalInicoFimData('graficoAcesso', 'Grafico de Acessos', 'userAcesso',$_SESSION["perfilUsuario"] ['0']['login']);
$dados = array('acao','user', 'mesAnoInicial', 'mesAnoFinal');
postRestAjax('postuserAcesso','imprimir','grafico/userAcesso.php',$dados);  

$userDataTreinamento = array($_SESSION["perfilUsuario"] ['0']['id']);
$listaUserDataTreinamento = getRest('userDataTreinamento/getListaUserDataTreinamentoPorUserLogin',$userDataTreinamento);
modaldefinirData('dataTreinamento', 'Data Treinamento', $pst, $arq, 'dataTreinamento',$listaUserDataTreinamento);

//nivel acesso
    $buscAcessoNivel = array("6");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        $prmUsuario = $valor;
    }
    $ultimoLogin = array($_SESSION["perfilUsuario"] ['0']['id']);
    $ultimoLogin = getRest('userloginws/getDataHoraUltimoLog',$ultimoLogin);
    if($ultimoLogin[0] == ''){
        $ultimoLogin[0] = 'Não';
    }else{
        $ultimoLogin[0] = dataHoraBr($ultimoLogin[0]);
    }
?>
<!-- Pega o id dousuario com o javascript-->
<script>
    var idUsuario = <?php echo $_SESSION["perfilUsuario"] ['0']['id'];?>
</script>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php 
                            if($_SESSION["perfilUsuario"]['0']['status'] == 'Ativo'){
                                $acaoStatus = 'Bloquear Acesso';
                                $valorStatus= 'Inativo';
                            }else{
                                $acaoStatus = 'Liberar Acesso';
                                $valorStatus= 'Ativo';
                            }
                            ?>
                            <?php if($prmUsuario['alterar']==true){ ?>
                                <button class="btn btn-info" onclick="perfilBloquear('bloquearLiberar','<?=$valorStatus?>')" type="button">
                                    <i class="fa fa-lock"></i><b> <?=$acaoStatus?>
                                </button>
                                <button  style="margin: 4px"type="button" class="btn btn-info" data-toggle="modal" data-target="#alterarSenha">
                                  <i class="fa fa-key"></i> <b>Redefinir senha </b>
                                </button>
                                <button style="margin: 4px" type="button" class="btn btn-info" data-toggle="modal" data-target="#dataTreinamento">
                                  <i class="fa fa-book"></i> <b>Cadastrar data de Treinamento</b>
                                </button>
                            <?php }if($prmUsuario['buscar']==true){?>
                                
                                <button style="margin: 4px" type="button" class="btn btn-info" data-toggle="modal" data-target="#historicoAcesso">
                                  <i class="fa fa-book"></i> <b>Histórico de Acessos</b>
                                </button>
                            
                                <button style="margin: 4px" type="button" class="btn btn-info" data-toggle="modal" data-target="#graficoAcesso">
                                  <i class="fa fa-book"></i> <b>Gráfico de Acessos</b>
                                </button>
                                    <?php }if($prmUsuario['listar']==true){?>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="funcional">
                                    <input type="hidden" name="arq" value="consolidarPlanejamento">
                                    <input type="hidden" name="cpf" value='<?=$_SESSION["perfilUsuario"] ['0']['cpf']?>'>
                                    <input type="hidden" name="acao" value='buscar'>
                                    <button class="btn btn-info" type="submit">
                                        <i class="fa fa-search-plus"></i><b> Planejamento Consolidado
                                    </button>
                                </form>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="relat">
                                    <input type="hidden" name="arq" value="lancamentoIndividualPorPeriodo">
                                    <input type="hidden" name="cpf" value='<?=$_SESSION["perfilUsuario"] ['0']['cpf']?>'>
                                    <input type="hidden" name="acao" value='buscar'>
                                    <button class="btn btn-info" type="submit">
                                        <i class="fa fa-info-circle"></i><b> Lançamento Individual
                                    </button>
                                </form>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="orby" value="0">
                                    <input type="hidden" name="pst" value="funcional">
                                    <input type="hidden" name="arq" value="buscar">
                                    <input type="hidden" name="cpf" value='<?=$_SESSION["perfilUsuario"] ['0']['cpf']?>'>
                                    <input type="hidden" name="acao" value='buscar'>
                                    <button class="btn btn-info" type="submit">
                                        <i class="fa fa-search-plus"></i><b> Procurar Vinculo com PMM</b>
                                    </button>
                                </form>
                                <!--<a href="index.php?orby=0&pst=funcional&arq=buscar&acao=buscar&cpf=<?=$_SESSION["perfilUsuario"] ['0']['cpf']?>&acao=buscar" class="btn btn-info"><i class="fa fa-search-plus"></i><b> Procurar Vinculo com PMM</b></a>-->
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>
        <div class="box box-primary">
            <div class="box-body">
            <div class="col-lg-4 col-xs-6">
                <div class="box box-widget widget-user">
                    <?= '#' . $_SESSION["perfilUsuario"] ['0']['id'].' '.$_SESSION["perfilUsuario"] ['0']['login']?>
                   <div class="widget-user-header bg-aqua-active">
                        <h5 class="widget-user-desc"><?= $_SESSION["perfilUsuario"] ['0']['nome'] ?></h5>
                    </div>
                    <div class="widget-user-image">
                        <br>
                        <img class="img-responsive" src="<?= exibeFoto($_SESSION["perfilUsuario"] ['0']['cpf']) ?>" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <div id="identificadorDeNecessidadeDeCarregamentoDoUltimoLogin">
                                        <h5 class="description-header"><b>Login</b></h5>
                                        <span id="txtUltimoLogin" class="description-text"><?=$ultimoLogin[0];?></span>
                                    </div>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"></h5>
                                    <span class="description-text"></span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">Status</h5>
                                    <?= $_SESSION["perfilUsuario"] ['0']['status']?>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <center><?php 
                                    echo 'Último treinamento ';
                                    foreach ($listaUserDataTreinamento as $array){
                                        $data= dataBr($array[0])." - ";
                                    }  
                                    echo substr($data, 0, 10);
                                 ?>
                        </div>
                </div>
                <!-- /.widget-user -->
            </div>
            <div class="primary col-lg-8 col-xs-6 box-footer clearfix">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Perfis de acesso</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="todo-list">
                        <?php foreach ($_SESSION["perfilTemplates"] as $ArrEsp){
                            if(!isset($ArrEsp['nomeSetor'])){
                                $inativoSetor = "hide";
                            }else{
                                $inativoSetor = "";
                            }
                            if(!isset($ArrEsp['nomeCargoGeral'])){
                                $inativoCargoGeral = "hide";
                            }else{
                                $inativoCargoGeral = "";
                                $ArrEsp['nomeCargoGeral'] = explode('||', $ArrEsp['nomeCargoGeral']);
                            }
                            if(!isset($ArrEsp['nomeSecretaria'])){
                                $ArrEsp['nomeSecretaria'] = '# PREFEITURA MUNICIPAL DE MACAE';
                                $ArrEsp['idSecretaria'] = null;
                                $ArrEsp['idSetor'] = null;
                            }
                            ?>
                        <li>
                            
                            <span class="text"><?=$ArrEsp['nomeSecretaria']?></span>
                                        <h1 class="label label-default">
                                            <i class="fa fa-user-secret"></i> <?=$ArrEsp['nomeTemplate']?>
                                        </h1>
                                        <h1 class="label label-success <?=$inativoSetor?>">
                                            <i class="fa fa-dot-circle-o"></i> <?=$ArrEsp['nomeSetor']?>
                                        </h1>
                                        <?php foreach ($ArrEsp['nomeCargoGeral'] as $arrayCargoGeral){?>
                                            <h1 class="label label-danger  <?=$inativoCargoGeral?>">
                                                <i class="fa fa-user-plus"></i> <?=$arrayCargoGeral?>
                                            </h1>
                                        <?php } ?>
                                           <h1 class="label label-important">
                                                <form method="<?=$method?>" action="index.php" class="inline">
                                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                                    <input type="hidden" name="closeAcesso" value="1" />
                                                    <input type="hidden" name="idtemplate" value="<?=$ArrEsp['idTemplate']?>"/>
                                                    <input type="hidden" name="nomeTemplate" value="<?=$ArrEsp['nomeTemplate']?>"/>
                                                    <input type="hidden" name="acao" value="exibirAcesso" />
                                                    
                                                    <button type="submit" class="btn btn-small btn-primary">
                                                      <i class="fa fa-search-plus"></i>
                                                    </button>
                                                </form>
                                               <?php if($prmUsuario['excluir']==true){?>
                                                    <form class="inline">

                                                        <input type="hidden" name="closeAcesso" value="1" />
                                                        <input type="hidden" name="idlotacao" value="<?=$ArrEsp['idSecretaria']?>"/>
                                                        <input type="hidden" name="idlotacaosub" value="<?=$ArrEsp['idSetor']?>"/>
                                                        <input type="hidden" name="acao" value="excluirTemplate" />
                                                        
                                                        <button onclick="excluiTemplate('excluirTemplate','1','<?=$ArrEsp['idSecretaria']?>','<?=$ArrEsp['idSetor']?>')" type="button" class="btn btn-small btn-danger">
                                                          <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                               <?php }?>
                                           </h1>
                               <?php 
                               

                                $oldIdLotacao = $ArrEsp['idSecretaria'];
                            }
                            ?>
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                    <?php if($prmUsuario['incluir']==true){?>
                    <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#cadUser">
                        <i class="fa fa-plus"></i> Add item
                    </button>
                    <?php }?>
                    <div class="box-tools">
                    </div>
                </div>
            </div>
        </div>
     </div>
        <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title"><?=$respGet['nomeTemplate']?></h3>
        </div>
        <?php
            $classAcessos = 'hide';
            require_once '../usuario/showAcessoTemplate.php';
        ?>
</section>

<?php 



?>