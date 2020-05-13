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
            if (($valor['menuN1'] == 'Gestão') AND ($valor['menuN2'] == 'cracha')){
                 $prmCracha  = $valor;
                 //Tipos de Cracha
                 $crachaTipo = getRest('cracha/getListaCrachaTipo');
                 //Lista Pedidos
                $cPerfil = array($_SESSION["funcionalBusca"]['id']);
                $cracharequisicao = getRest('cracha/getListaCrachaRequisicaoPorIdFuncional',$cPerfil);
                foreach ($cracharequisicao as $cracha) {
                }
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
    modalInicio('contraCheque', 'Contra Cheque', 'print', 'info', 'contraCheque','','funcional','perfil','gestao');
    modalEnviaSetorInicioCracha('modalEnviaSetorInicioCracha', 'Requisitar Crachá', 'funcional', 'perfil', 'crachaFuncional', 'funcional', 'perfil', 'gestao',$cracha,$crachaAdm, $_SESSION["funcionalBusca"]['id']);
    $printGestao = "vpst=funcional&varq=perfil&vtab=gestao&pst=print&arq=info&id=".$_SESSION["funcionalBusca"]["id"];
    //VERIFICAR COMPATIBILIDADE DE ESCALA
    $exibe=false;
    foreach ($_SESSION["funcionalPerfil"]["regimes"] as $ArrEsp){
        if($ArrEsp['idRegime']==="NAOPODE"){
            $exibe=true;
            break;
        }
    }
//    echo "<pre>";
//    print_r($_SESSION["funcionalPerfil"]["lotacoesSub"]);
//    echo "</pre>";
                ?>

<div class="tab-pane <?=tabId('gestao', $respGet['tab'],$padrao=true)?>" id="gestao">
    <div class="post clearfix">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
                                <form action="index.php" method="<?=$method?>" class="inline">
                                        <input type="hidden" name="vpst" value="funcional" />
                                        <input type="hidden" name="varq" value="perfil" />
                                        <input type="hidden" name="vtab" value="gestao" />
                                        <input type="hidden" name="pst" value="print"/>
                                        <input type="hidden" name="arq" value="info"/>
                                        <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                        <input type="hidden" name="pg" value="1"/>
                                        <input type="hidden" name="acao" value="fichaFuncional"/>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-print"></i><b> Ficha Funcional</b></button>
                                </form>
                                <button class="<?=permissaoAcesso($prmContabil["listar"],'hide')?> btn btn-info" type="button" data-toggle="modal" data-target="#contraCheque">
                                  <i class="fa fa-calendar"></i> <b>Contra Cheque</b>
                                </button>
                                <form action="index.php" method="<?=$method?>" class="inline <?=permissaoAcesso($prmPortaria["listar"],'hide')?>">
                                        <input type="hidden" name="vpst" value="funcional" />
                                        <input type="hidden" name="varq" value="perfil" />
                                        <input type="hidden" name="vtab" value="gestao" />
                                        <input type="hidden" name="pst" value="print"/>
                                        <input type="hidden" name="arq" value="info"/>
                                        <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                        <input type="hidden" name="pg" value="1"/>
                                        <input type="hidden" name="relat" value="portaria"/>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-info-circle"></i><b> Portarias</b></button>
                                </form>
                        <button type="button" class="btn btn-info <?=permissaoAcesso($prmCracha['buscar'],'hide')?>" data-toggle="modal" data-target="<?='#modalEnviaSetorInicioCracha'.$idModal?>">
                            <i class="fa fa-calendar"></i> <b>Crachá</b>
                        </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>
        <div>
            <div class="form-group col-sm-12">
            <?=muda('lotacao')?>
            <label>Lotação</label> <sup><div id="lotacao" class="hide">!</div></sup>
                <div class="form-group margin-bottom-none">
                    <form class="form-horizontal" method="<?=$method?>" action="index.php" onfocus="this.style.backgroundColor='#CCFF66'" onblur="this.style.backgroundColor='#ffffff'">
                            <div class="col-sm-10" onclick="lotacao()">
                                <select <?=permissaoAcesso($prmLotacao["buscar"],'disabled')?> class="form-control select2" name='idLotacao' style="width: 100%;">
                                    <?php foreach ($_SESSION["funcionalPerfil"]["lotacoes"] as $ArrEsp){?>
                                      <option value="<?=$ArrEsp['idLotacao']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'"; $lotAtivo=true;}?>><?=$ArrEsp['nome']?></option>
                                    <?php }
                                    if($lotAtivo != true){
                                        echo "<option selected='selected'></option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button class="<?=permissaoAcesso($prmLotacao["alterar"],'hide')?> btn btn-success pull-right btn-sm" type="submit"><i class="fa fa-edit"></i></button>
                            </div>
                            <input type="hidden" name="tab" value="gestao">
                            <input type="hidden" name="acao" value="alterarLotacao">
                            <input type="hidden" name="idFuncional" value="<?=$_SESSION["funcionalBusca"]["id"]?>">
                            <input type="hidden" name="pst" value="<?=$pst?>">
                            <input type="hidden" name="arq" value="<?=$arq?>">
                    </form>
                    <div class="col-sm-1">
                        <form action="index.php" method="<?=$method?>" class="inline <?=permissaoAcesso($prmLotacao["listar"],'hide')?>">
                                <input type="hidden" name="vpst" value="funcional" />
                                <input type="hidden" name="varq" value="perfil" />
                                <input type="hidden" name="vtab" value="gestao" />
                                <input type="hidden" name="pst" value="print"/>
                                <input type="hidden" name="arq" value="info"/>
                                <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                <input type="hidden" name="pg" value="1"/>
                                <input type="hidden" name="relat" value="lotacaoServidor"/>
                                <button type="submit" class="btn btn-info pull-right btn-sm"><i class="fa fa-info-circle"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            
             <div class="form-group col-sm-12">
                 <?=muda('setor')?>
                 <label>Setor</label> <sup><div id="setor" class="hide">!</div></sup>
                 <div class="form-group margin-bottom-none">
                    <form class="form-horizontal" method="<?=$method?>" action="index.php">

                            <div class="col-sm-10" onclick="setor()">
                                <select <?=permissaoAcesso($prmSetor["buscar"],'disabled')?> class="form-control select2" multiple="multiple" name='idSetor[]' data-placeholder="Não possui setor" style="width: 100%;">
                                  <?php foreach ($_SESSION["funcionalPerfil"]["lotacoesSub"] as $ArrEsp){?>
                                    <option value="<?=$ArrEsp['idSetor']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'"; $espAtivo=true;}?>><?=$ArrEsp['nome']?></option>
                                    <?php }
                                    if($espAtivo != true){
                                        echo "<option></option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="tab" value="gestao">
                            <input type="hidden" name="acao" value="alterarSetor">
                            <input type="hidden" name="idFuncional" value="<?=$_SESSION["funcionalBusca"]["id"]?>">
                            <input type="hidden" name="pst" value="<?=$pst?>">
                            <input type="hidden" name="arq" value="<?=$arq?>">
                            <div class="col-sm-1">
                                <button class="<?=permissaoAcesso($prmSetor["alterar"],'hide')?> btn btn-success pull-right btn-sm" type="submit" ><i class="fa fa-edit"></i></button>
                            </div>
                    </form>
                     <div class="col-sm-1">
                        <form action="index.php" method="<?=$method?>" class="inline <?=permissaoAcesso($prmSetor["listar"],'hide')?>">
                                <input type="hidden" name="vpst" value="funcional" />
                                <input type="hidden" name="varq" value="perfil" />
                                <input type="hidden" name="vtab" value="gestao" />
                                <input type="hidden" name="pst" value="print"/>
                                <input type="hidden" name="arq" value="info"/>
                                <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                <input type="hidden" name="pg" value="1"/>
                                <input type="hidden" name="relat" value="lotacaoSubServidor"/>
                                <button type="submit" class="btn btn-info pull-right btn-sm"><i class="fa fa-info-circle"></i></button>
                        </form>
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
                    <form class="form-horizontal" method="<?=$method?>" action="index.php">
                            <div class="col-sm-10" onclick="regime()">
                                <select <?=permissaoAcesso($prmRegTrabalho["buscar"],'disabled')?> class="form-control select2" name='idRegime' style="width: 100%;">
                                    <option selected='selected' value=0 >NAO POSSUI</option>
                                    <?php foreach ($_SESSION["funcionalPerfil"]["regimes"] as $ArrEsp){?>
                                    <option value="<?=$ArrEsp['idRegime']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'";$regAtivo=true;}?>><?=$ArrEsp['nome']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button class="<?=permissaoAcesso($prmRegTrabalho["incluir"],'hide')?> btn btn-success pull-right btn-sm" type="submit"><i class="fa fa-edit"></i></button>
                            </div>
                            <input type="hidden" name="tab" value="gestao">
                            <input type="hidden" name="acao" value="alterarRegime">
                            <input type="hidden" name="idFuncional" value="<?=$_SESSION["funcionalBusca"]["id"]?>">
                            <input type="hidden" name="pst" value="<?=$pst?>">
                            <input type="hidden" name="arq" value="<?=$arq?>">
                    </form>
                    <div class="col-sm-1">
                        <form action="index.php" method="<?=$method?>" class="inline <?=permissaoAcesso($prmRegTrabalho["listar"],'hide')?>">
                                <input type="hidden" name="vpst" value="funcional" />
                                <input type="hidden" name="varq" value="perfil" />
                                <input type="hidden" name="vtab" value="gestao" />
                                <input type="hidden" name="pst" value="print"/>
                                <input type="hidden" name="arq" value="info"/>
                                <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                <input type="hidden" name="pg" value="1"/>
                                <input type="hidden" name="relat" value="regimeServidor"/>
                                <button type="submit" class="btn btn-info pull-right btn-sm"><i class="fa fa-info-circle"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="form-group col-sm-12">
                 <?=muda('especialidade')?>
                <label>Especialidade</label> <sup><div id="especialidade" class="hide">!</div></sup>
                <div class="form-group margin-bottom">
                    <form class="form-horizontal" method="<?=$method?>" action="index.php">
                            <div class="col-sm-10" onclick="especialidade()">
                            <select <?=permissaoAcesso($prmEspecialidade["buscar"],'disabled')?> class="form-control select2" name='idEspecialidade' style="width: 100%;">
                                <option selected='selected' value=0 >NAO POSSUI</option>
                                <?php foreach ($_SESSION["funcionalPerfil"]["especialidades"] as $ArrEsp){?>
                                <option value="<?=$ArrEsp['idEspecialidade']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'"; $espAtivo=true;}?>><?=$ArrEsp['nome']?></option>
                                <?php }
                                ?>
                            </select>
                            </div>
                            <div class="col-sm-1">
                                <button class="<?=permissaoAcesso($prmEspecialidade["incluir"],'hide')?> btn btn-success pull-right btn-sm" type="submit"><i class="fa fa-edit"></i></button>
                            </div>
                            <input type="hidden" name="tab" value="gestao">
                            <input type="hidden" name="acao" value="alterarEspecialidade">
                            <input type="hidden" name="idFuncional" value="<?=$_SESSION["funcionalBusca"]["id"]?>">
                            <input type="hidden" name="pst" value="<?=$pst?>">
                            <input type="hidden" name="arq" value="<?=$arq?>">
                    </form>
                    <div class="col-sm-1">
                        <form action="index.php" method="<?=$method?>" class="inline <?=permissaoAcesso($prmEspecialidade["listar"],'hide')?>">
                                <input type="hidden" name="vpst" value="funcional" />
                                <input type="hidden" name="varq" value="perfil" />
                                <input type="hidden" name="vtab" value="gestao" />
                                <input type="hidden" name="pst" value="print"/>
                                <input type="hidden" name="arq" value="info"/>
                                <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                <input type="hidden" name="pg" value="1"/>
                                <input type="hidden" name="relat" value="especialidadeServidor"/>
                                <button type="submit" class="btn btn-info pull-right btn-sm"><i class="fa fa-info-circle"></i></button>
                        </form>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
