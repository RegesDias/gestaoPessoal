<?php
if($_SESSION["funcionalBusca"]['situacao']['nome'] == 'INATIVO'){
    $inativo = 'disabled'; ?>
    <div>
        <div class="post clearfix">       
            <div class="box box-primary">
                <div class="box-body">
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-ban"></i> Alerta! Servidor encontra-se inativo.</h4>
                       Totas as funções de lançamento estão desativadas.
                    </div>
                </div>
            </div>
        </div>
    </div> 
<?php }
    //VERIFICAR NIVEL DE ACESSO
    if($_SESSION["funcionalBusca"]['situacao']['nome'] == 'ATIVO'){
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'Lotação')){
                 $prmLotacao = $valor;
                  break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'Setor')){
                 $prmSetor = $valor;
                  break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'Especialidade')){
                 $prmEspecialidade = $valor;
                 break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'Regime de trabalho')){
                 $prmRegTrabalho = $valor;
                 break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'contabil')){
                $prmContabil = $valor;
                break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'portaria')){
                $prmPortaria = $valor;
                break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'previaFolha')AND ($valor['listar'] == 1)){
                $prmPreviaFolha['listar'] = '1';
                break;
            }
        }
        
    }else{
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'Lotação') AND ($valor['listar'] == 1)){
                 $prmLotacao['listar'] = '1';
                  break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'Setor') AND ($valor['listar'] == 1)){
                 $prmSetor['listar'] = '1';
                  break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'Especialidade')AND ($valor['listar'] == 1)){
                 $prmEspecialidade['listar'] = '1';
                 break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'Regime de trabalho')AND ($valor['listar'] == 1)){
                 $prmRegTrabalho['listar'] = '1';
                 break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'contabil')AND ($valor['listar'] == 1)){
                $prmContabil['listar'] = '1';
                break;
            }
        }
        foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'portaria')AND ($valor['listar'] == 1)){
                $prmPortaria['listar'] = '1';
                break;
            }
        }
    }
    foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
        if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'cracha')){
             $prmCracha  = $valor;
             //Lista Pedidos
            $buscAcessoNivel = array("8");
            $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
            foreach ($listaAcesso as $valor) {
                if (($valor['link'] == 'CrachaAdministrar') AND ($valor['buscar'] == '1')){ 
                     $crachaAdm = true;
                     break;
                }
            }
            break; 
        }
}
    modalInicio('contraCheque', 'Contra Cheque', 'print', 'info', 'contraCheque','','gestao');
    modalInicio('previaFolha', 'Prévia Folha', 'print', 'info', 'previaFolha','','gestao');
    $printGestao = "vpst=funcional&varq=perfil&vtab=gestao&pst=print&arq=info&id=".$_SESSION["funcionalBusca"]["id"];
    //VERIFICAR COMPATIBILIDADE DE ESCALA
    $exibe=false;
    foreach ($_SESSION["funcionalPerfil"]["regimes"] as $ArrEsp){
        if($ArrEsp['idRegime']==="NAOPODE"){
            $exibe=true;
            break;
        }
    }
?>
<div class="tab-pane <?=tabId('gestao', $respGet['tab'],$padrao=true)?>" id="gestao">
    <div class="post clearfix">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
                            <form class="inline">
                                <button class="btn btn-info" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','fichaFuncional',true)" type="button">
                                    <i class="fa fa-print"></i><b> Ficha Funcional</b>
                                </button>
                            </form>
                            <button class="<?=permissaoAcesso($prmContabil["listar"],'hide')?> btn btn-info" type="button" data-toggle="modal" data-target="#contraCheque">
                              <i class="fa fa-calendar"></i> <b>Contra Cheque</b>
                            </button>
                            <button class="<?=permissaoAcesso($prmPreviaFolha["listar"],'hide')?> btn btn-info" type="button" data-toggle="modal" data-target="#previaFolha">
                              <i class="fa fa-calendar"></i> <b>Prévia Folha</b>
                            </button>
                            <form class="inline">
                                <button class="btn btn-info <?=permissaoAcesso($prmPortaria["listar"],'hide')?>" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','portaria',true)" type="button">
                                    <i class="fa fa-print"></i><b> Portarias</b>
                                </button>
                            </form>
                            <button type="button" class="btn btn-info <?=permissaoAcesso($prmCracha['buscar'],'hide')?>" onclick="buscaCracha('abrir', '<?=$_SESSION['funcionalBusca']['id']?>','<?=$crachaAdm?>')">
                                <i class="fa fa-calendar"></i> <b>Crachá</b>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="cracha" >
                                
                            </div>              
                        </div>
                    </div>
                </div>
            </div>
        <div>
            <div class="form-group col-sm-12">
            <?=muda('lotacao')?>
            <label>Lotação</label> <sup><div id="lotacao" class="hide">!</div></sup>
                <div class="form-group margin-bottom-none">
                    <form class="form-horizontal" onfocus="this.style.backgroundColor='#CCFF66'" onblur="this.style.backgroundColor='#ffffff'">
                        <div class="col-sm-9" onclick="lotacao()">
                            <select <?=permissaoAcesso($prmLotacao["buscar"],'disabled')?> class="form-control select2" name='idLotacao' id='idLotacao' style="width: 100%;">
                                <?php foreach ($_SESSION["funcionalPerfil"]["lotacoes"] as $ArrEsp){?>
                                  <option value="<?=$ArrEsp['idLotacao']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'"; $lotAtivo=true;}?>><?=$ArrEsp['nome']?></option>
                                <?php }
                                if($lotAtivo != true){
                                    echo "<option selected='selected'></option>";
                                }?>
                            </select>
                        </div>
                    </form>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmLotacao["alterar"],'hide')?> btn btn-success pull-right btn-sm" onclick="postEmGestao('gestao', 'alterarLotacao','<?=$_SESSION["funcionalBusca"]["id"]?>',$('#idLotacao').val())" type="button">
                             <i class="fa fa-edit"></i>
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmLotacao["listar"],'hide')?> btn btn-info pull-right btn-sm" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','lotacaoServidor')" type="button">
                             <i class="fa fa-print"></i>
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmLotacao["listar"],'hide')?> btn btn-facebook pull-right btn-sm" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','lotacaoServidor',true)" type="button">
                             <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
             <div class="form-group col-sm-12">
                 <?=muda('setor')?>
                 <label>Setor</label> <sup><div id="setor" class="hide">!</div></sup>
                 <div class="form-group margin-bottom-none">
                    <form class="form-horizontal">
                    <div class="col-sm-9" onclick="setor()">
                        <select <?=permissaoAcesso($prmSetor["buscar"],'disabled')?> class="form-control select2" multiple="multiple" name='idSetor[]' id="idSetor" data-placeholder="Não possui setor" style="width: 100%;">
                          <?php foreach ($_SESSION["funcionalPerfil"]["lotacoesSub"] as $ArrEsp){?>
                            <option value="<?=$ArrEsp['idSetor']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'"; $espAtivo=true;}?>><?=$ArrEsp['nome']?></option>
                            <?php }
                            if($espAtivo != true){
                                echo "<option></option>";
                            }
                            ?>
                        </select>
                    </div>
                    </form>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmSetor["alterar"],'hide')?> btn btn-success pull-right btn-sm" onclick="postEmGestao('gestao', 'alterarSetor','<?=$_SESSION["funcionalBusca"]["id"]?>','',$('#idSetor').val())" type="button">
                              <i class="fa fa-edit"></i>
                        </button>
                    </div>
                     <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmSetor["listar"],'hide')?> btn btn-info pull-right btn-sm" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','lotacaoSubServidor')" type="button">
                             <i class="fa fa-print"></i>
                        </button>
                     </div>
                     <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmSetor["listar"],'hide')?> btn btn-facebook pull-right btn-sm" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','lotacaoSubServidor',true)" type="button">
                             <i class="fa fa-eye"></i>
                        </button>
                     </div>
                     <div class="col-sm-1"></div>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <?=muda('regime')?>
                <!-- Lógica para exibir ou não o aviso para alterar o regime -->
                
                <label>Regime de trabalho</label> <sup><div id="regime" class="hide">!</div></sup>
                <strong class="<?=permissaoAcesso($exibe,'hide')?>" style="color: #990000;" >(Regime incompatível, favor alterar.)</strong>
                <div class="form-group margin-bottom">
                    <form class="form-horizontal">
                        <div class="col-sm-9" onclick="regime()">
                            <select <?=permissaoAcesso($prmRegTrabalho["buscar"],'disabled')?> class="form-control select2" name='idRegime' id="idRegime" style="width: 100%;">
                                <option selected='selected' value=0 >NAO POSSUI</option>
                                <?php foreach ($_SESSION["funcionalPerfil"]["regimes"] as $ArrEsp){?>
                                <option value="<?=$ArrEsp['idRegime']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'";$regAtivo=true;}?>><?=$ArrEsp['nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </form>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmRegTrabalho["alterar"],'hide')?> btn btn-success pull-right btn-sm" onclick="postEmGestao('gestao', 'alterarRegime','<?=$_SESSION["funcionalBusca"]["id"]?>','','',$('#idRegime').val())" type="button">
                             <i class="fa fa-edit"></i>
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmRegTrabalho["listar"],'hide')?> btn btn-info pull-right btn-sm" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','regimeServidor')" type="button">
                             <i class="fa fa-print"></i>
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmRegTrabalho["listar"],'hide')?> btn btn-facebook pull-right btn-sm" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','regimeServidor',true)" type="button">
                             <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="form-group col-sm-12">
                 <?=muda('especialidade')?>
                <label>Especialidade</label> <sup><div id="especialidade" class="hide">!</div></sup>
                <div class="form-group margin-bottom">
                    <form class="form-horizontal">
                        <div class="col-sm-9" onclick="especialidade()">
                            <select <?=permissaoAcesso($prmEspecialidade["buscar"],'disabled')?> class="form-control select2" name='idEspecialidade' id="idEspecialidade" style="width: 100%;">
                                <option selected='selected' value=0 >NAO POSSUI</option>
                                <?php foreach ($_SESSION["funcionalPerfil"]["especialidades"] as $ArrEsp){?>
                                <option value="<?=$ArrEsp['idEspecialidade']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'"; $espAtivo=true;}?>><?=$ArrEsp['nome']?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </form>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmEspecialidade["alterar"],'hide')?> btn btn-success pull-right btn-sm" onclick="postEmGestao('gestao', 'alterarEspecialidade','<?=$_SESSION["funcionalBusca"]["id"]?>','','','',$('#idEspecialidade').val())" type="button">
                             <i class="fa fa-edit"></i>
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmEspecialidade["listar"],'hide')?> btn btn-info pull-right btn-sm" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','especialidadeServidor')" type="button">
                             <i class="fa fa-print"></i>
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <button class="<?=permissaoAcesso($prmEspecialidade["listar"],'hide')?> btn btn-facebook pull-right btn-sm" onclick="relatorioEmGestao('<?=$_SESSION['funcionalBusca']['id']?>','especialidadeServidor',true)" type="button">
                             <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>  
        <?php
            //relatorioEmGestao

            $dados = array('dado','acao','ver');
            postRestAjax('relatorioEmGestao','imprimir','print/info.php',$dados);
            
            //postEmGestao
            $dados = array('tab','acao','idFuncional','idLotacao', 'idSetor', 'idRegime', 'idEspecialidade');
            postRestAjax('postEmGestao','dados','funcional/perfil.php',$dados);

            //buscaCracha
            $s1 = array('cracha','removeClass','hidden');
            $success= array ($s1);
            $dados = array('acao', 'idHistFunc','crachaAdm');
            postRestAjax('buscaCracha','cracha','funcional/cracha.php',$dados,'',$success);
            
            //postEmCrachaIncluir
            $success= array ($s);      
            $dados = array('acao','idHistFunc','idCrachaTipo','crachaAdm');
            postRestAjax('postEmCrachaIncluir','cracha','funcional/cracha.php',$dados,'',$success);
            
            //postEmCrachaStatus     
            $dados = array('acao','idCrachaRequisicao', 'idHistFunc','crachaAdm');
            postRestAjax('postEmCrachaStatus','cracha','funcional/cracha.php',$dados);
            
            //postEmCrachaPrint       
            $dados = array('acao','idCrachaTipo','nome', 'cpf','matricula','crachaAdm','idImagem', 'ver');
            postRestAjax('relatorioEmCracha','imprimir','print/info.php',$dados);      
           
        ?> 
            <script>
                //Fechar cracha
                function fecharCracha(){
                  $("#cracha").addClass("hidden");
                }
            </script>
