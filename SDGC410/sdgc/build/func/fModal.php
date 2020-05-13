<?php
//Modalcaduser
function modalCadUser($id, $title, $pst, $arq) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>                          
                        </button>
                        <h4 class="modal-title" id="exampleModalLabel"><?= $title ?></h4>
                    </div>
                    <form method='<?=$method?>' action='index.php' name='formTemplate'>
                         <?=esconderItem('template')?>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Versão App</label>
                                <?php global $gurl;
                                      global $ajurl;
                                ?>
                                <div onclick="template()">
                                        <div onclick="getAJAX(<?="'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacao', '', selectMultipleSecretariasAjax);">
                                            
                                                <select multiple onchange="getAJAX(<?="'" . $ajurl . "'"; ?>, 'appversao/getListaUserTemplatePorAppVersao/', this.value+'/', selectTemplateAjax)" name="idAppVersao" class="form-control select2" id='appVersaoID' style="width: 100%;">
                                                    <?php foreach ($_SESSION['appv'] as $ArrEsp){?>
                                                      <option value="<?=$ArrEsp['id']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'"; $lotAtivo=true;}?>><?=$ArrEsp['nome']." ".$ArrEsp['versao']?></option>
                                                    <?php }
                                                    if($lotAtivo != true){
                                                        echo "<option></option>";
                                                    }
                                                    ?>  
                                                </select>
                                            
                                        </div>
                                    </div>
                            </div>
                            <?=esconderItem('secretaria')?>
                            <div onclick="secretaria()">
                                <div onclick="cargoGeral()">
                                    <div id="template" class="hide">
                                        <div class="col-md-12">
                                            <label>Template</label>
                                            <select multiple name="idTemplate" size="1"  class="form-control select2" id='templateID' style="width: 100%;">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?=esconderItem('setor')?>
                            <div onclick="setor()">
                                <div id="secretaria" class="hide">
                                    <div class="col-md-12">
                                        <label>Secretaria</label>
                                        <select multiple onchange="getAJAX(<?="'" . $ajurl . "'"; ?>, 'funcionalws/getListaSetorAtivoPorIdLotacao/', this.value, selectMultipleSetorAjax)" name="idSecretaria" size="1"  class="form-control select2" id="secretariaID" style="width: 100%;">
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?=esconderItem('cargoGeral')?>
                            <div id="setor" class="hide">
                                <div class="col-md-12">
                                    <label>Setor</label>
                                    <select multiple name="idSetor" size="1" class="form-control select2" id="setorID" style="width: 100%;">
                                    </select>
                                </div>
                            </div>
                            <div id="cargoGeral" class="hide">
                                <div class="col-md-12">
                                    <label>Cargo Geral</label>
                                    <select multiple name="idCargoGeral[]" size="1" class="form-control select2" id="cargoGeralID" style="width: 100%;">
                                        <?php 
                                        $_SESSION['cargosGeral'] = getRest('cargo/getListaCargoGeral');
                                        foreach ($_SESSION['cargosGeral'] as $ArrEsp){?>
                                          <option value="<?=$ArrEsp['id']?>"><?=$ArrEsp['nome']?></option>
                                        <?php }?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="acao" value="incluirAcesso">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Carrega todas secretarias neste modal -->
        
<?php
require_once 'javascript/fBoxSecretariaSetor.php';
}
//ModalInicioFim
function modalInicoFim($id, $title, $pst, $arq, $acao, $padrao = null, $vpst=null, $varq=null,$vtab=null,$user=null) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div><?php 
                if ($arq == 'csv') {    
                     echo "<form method='$method' action='export/csv.php'>";
                }else{
                     echo "<form method='$method' action='index.php'>";
                }?>
                    <form>
                        <div class="modal-body col-md-12">
                            <div class="col-md-6">
                                <label>Data Inicial</label>
                                <input name="mesAnoInicial" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Data Final</label>
                                <input name="mesAnoFinal" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
                            </div>
                            <?php if ($padrao == 'nsd') { ?>
                                <div class="col-md-12">
                                    <br>
                                    <label>Organizar por</label>
                                    </br>
                                    <input type="radio" name="orby" value ='competencia' class="flat-red" checked="checked"> Competência
                                    <input type="radio" name="orby" value ='nr' class="flat-red" > NR
                                </div>
                            <?php } ?>
                        </div>
                        <div class="modal-footer">
                            <?php if($user != null){ ?>
                                <input type="hidden" name="user" value="<?= $user ?>">
                            <?php } ?>
                            <input type="hidden" name="vtab" value="<?= $vtab ?>">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <input type="hidden" name="vpst" value="<?= $vpst ?>">
                            <input type="hidden" name="varq" value="<?= $varq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
            </div>
        </div>
    </div>
<?php
}
//ModalInicioFim
function modalInicoFimData($id, $title, $pst, $arq, $acao, $padrao = null, $vpst=null, $varq=null,$vtab=null,$user=null) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div><?php 
                if ($arq == 'csv') {    
                     echo "<form method='$method' action='export/csv.php'>";
                }else{
                     echo "<form method='$method' action='index.php'>";
                }?>
                    <form>
                        <div class="modal-body col-md-12">
                            <div class="col-md-6">
                                <label>Data Inicial</label>
                                <input name="mesAnoInicial" class="form-control" type="date" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Data Final</label>
                                <input name="mesAnoFinal" class="form-control" type="date" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
                            </div>
                            <?php if ($padrao == 'nsd') { ?>
                                <div class="col-md-12">
                                    <br>
                                    <label>Organizar por</label>
                                    </br>
                                    <input type="radio" name="orby" value ='competencia' class="flat-red" checked="checked"> Competência
                                    <input type="radio" name="orby" value ='nr' class="flat-red" > NR
                                </div>
                            <?php } ?>
                        </div>
                        <div class="modal-footer">
                            <?php if($user != null){ ?>
                                <input type="hidden" name="user" value="<?= $user ?>">
                            <?php } ?>
                            <input type="hidden" name="vtab" value="<?= $vtab ?>">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <input type="hidden" name="vpst" value="<?= $vpst ?>">
                            <input type="hidden" name="varq" value="<?= $varq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
            </div>
        </div>
    </div>
<?php
}
//ModalInicioFim
function modalInicio($id, $title, $pst, $arq, $acao, $padrao = null, $vpst=null, $varq=null,$vtab=null) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div><?php 
                if ($arq == 'csv') {    
                     echo "<form method='$method' action='export/csv.php'>";
                }else{
                     echo "<form method='$method' action='index.php'>";
                }?>
                    <form>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Período</label>
                                <input name="mesAnoInicial" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
                            </div>
                            <?php if ($padrao == 'nsd') { ?>
                                <div class="col-md-12">
                                    <br>
                                    <label>Organizar por</label>
                                    </br>
                                    <input type="radio" name="orby" value ='competencia' class="flat-red" checked="checked"> Competência
                                    <input type="radio" name="orby" value ='nr' class="flat-red" > NR
                                </div>
                            <?php } ?>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="vtab" value="<?= $vtab ?>">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <input type="hidden" name="vpst" value="<?= $vpst ?>">
                            <input type="hidden" name="varq" value="<?= $varq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
            </div>
        </div>
    </div>
<?php
}
function modalAgendamento($id, $title, $pst, $arq, $acao, $padrao = null, $vpst=null, $varq=null,$vtab=null) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                <form method='$method' action='index.php'>    
                    <form>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Dia da consulta</label>
                                <input name="mesAnoInicial" class="form-control" type="date" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
                            </div>
                            <div class="col-md-12">
                                <label>Médico</label>
                            <select class="form-control select2" name='idEspecialidade' style="width: 100%;">
                                <option selected='selected' value=0 >NAO POSSUI</option>
                                <?php foreach ($_SESSION["funcionalPerfil"]["especialidades"] as $ArrEsp){?>
                                <option value="<?=$ArrEsp['idEspecialidade']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'"; $espAtivo=true;}?>><?=$ArrEsp['nome']?></option>
                                <?php }
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="vtab" value="<?= $vtab ?>">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <input type="hidden" name="vpst" value="<?= $vpst ?>">
                            <input type="hidden" name="varq" value="<?= $varq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
            </div>
        </div>
    </div>
<?php
}
///ModalCriarAcesso
function modalCriarAcesso($id, $title, $pst, $arq, $acao) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                    <form method='<?=$method?>' action='index.php'>";
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Defina a chave</label>
                                <input type="text" name="chave" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="nomeCompleto" value="<?=$_SESSION["funcionalBusca"]['pessoa']['nome']?>">
                            <input type="hidden" name="cpf" value="<?=$_SESSION["funcionalBusca"]['pessoa']['cpf']?>">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php
}

//modal clonar acesso
function modalClonarTemplate($id, $title, $pst, $arq, $acao, $respGet) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$title?></h4>
                </div>
                    <form method='<?=$method?>' action='index.php'>";
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Nome do Template</label>
                                <input type="text" name="nomeTemplate" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="closeResult" value="1">
                            <input type="hidden" name="idClone" value="<?=$id?>">
                            <input type="hidden" name="idappversao" value="<?=$respGet['idappversao']?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php
}//ModalInicioFim
function modalAlterarSenha($id, $title, $pst, $arq, $acao) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                    <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Senha</label>
                                <input name="senha" class="form-control" type="password">
                            </div>
                            <div class="col-md-12">
                                <label>Redigite a senha</label>
                                <input name="confirmaSenha" class="form-control" type="password">
                            </div>
                            <?php if ($padrao == 'nsd') { ?>
                                <div class="col-md-12">
                                    <br>
                                    <label>Organizar por</label>
                                    </br>
                                    <input type="radio" name="orby" value ='0' class="flat-red" checked="checked"> Competência
                                    <input type="radio" name="orby" value ='0' class="flat-red" > NR
                                </div>
                            <?php } ?>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
            </div>
        </div>
    </div>
<?php
}
//ModalCompetencia13
function modalComp($id, $title, $pst, $arq, $acao, $padrao = null, $vpst=null, $varq=null) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                <form method="<?=$method?>" action="index.php">
                    <div class="modal-body">
                        <label>Competência</label>
                        <input name="mesAnoInicial" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>"><br>
                        <input type="checkbox" name="tem13salario" value ='sim' class="flat-red" >
                        13º Salário
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="tab" value="frequencia">
                        <input type="hidden" name="acao" value="<?= $acao ?>">
                        <input type="hidden" name="pst" value="<?= $pst ?>">
                        <input type="hidden" name="arq" value="<?= $arq ?>">
                        <input type="hidden" name="vpst" value="<?= $vpst ?>">
                        <input type="hidden" name="varq" value="<?= $varq ?>">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                        <input type="submit" class="btn btn-primary" value='OK'>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php
}

function modalInicoFimJavaScript($id, $title, $pst, $arq, $acao, $padrao = null, $vpst=null, $varq=null,$vtab=null, $todos=null){
        global $method;
        global $respGet;
        global $competencia;
        if(isset($respGet[mesAnoInicial])){
            $dataAnoInicial = mesAnoBanco($respGet[mesAnoInicial]);
            echo $dataAnoInicial;
        }else{
            $dataAnoInicial = date('Y-m');
        }
        if(isset($respGet[mesAnoFinal])){
            $dataAnoFinal = mesAnoBanco($respGet[mesAnoFinal]);
            echo $dataAnoFinal;
        }else{
            $dataAnoFinal = date('Y-m');
        }
?>
    
    <div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>                          
                        </button>
                        <h4 class="modal-title" id="exampleModalLabel"><?= $title ?></h4>
                    </div>
                    <?php 
                    if ($arq == 'csv') {    
                         echo "<form method='$method' action='export/csv.php'>";
                    }else{
                         echo "<form method='$method' action='index.php'>";
                    }?>
                    <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-6">
                                <label>Data Inicial</label>
                                <input id="idMesAnoInicial<?=$id?>" name="mesAnoInicial" class="form-control" type="month" value="<?=$dataAnoInicial?>" max="<?= date('Y-m') ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Data Final</label>
                                <?php if ($padrao == 'combo'){ ?>
                                <div class="input-group input-group">
                                <?php }?>
                                 <input id="idMesAnoFinal<?=$id?>" name="mesAnoFinal" class="form-control" type="month" value="<?=$dataAnoFinal?>" max="<?= date('Y-m') ?>">
                                <?php if ($padrao == 'combo'){ ?>
<!--                                        <span class="input-group-btn">
                                            <button onclick="definirCompetencia('<?=$id?>')" type="button" class="btn btn-info btn-flat"><span name="lblDefinir" id="idLblDefinir<?=$id?>">Definir</span><i name="voltinhaCarregar" id="idVoltinhaCarregar<?=$id?>" class="fa fa-refresh fa-spin hide"></i></button>
                                        </span>-->
                                 <span class="input-group-btn">
                                    <input type="hidden" name="pst" value="<?= $vpst ?>">
                                    <input type="hidden" name="arq" value="<?= $varq ?>">
                                    <input type="hidden" name="modal" value="<?=$id?>">
                                    <input type="hidden" name="padrao" value="<?=$padrao?>">
                                    
                                    <button class="btn btn-info btn-flat" >
                                        executar
                                    </button>
                                 </span>
                                </div>
                                <?php }?>
                            </div>
                            <?php if ($padrao == 'nsd') { ?>
                                <div class="col-md-12">
                                    <br>
                                    <label>Organizar por</label>
                                    </br>
                                    <button onclick="exibeCompetencia()" id="btnCompetencia<?=$id?>" type="button" class="btn">Competência</button>
                                    <button onclick="exibeNR()" id="btnNr<?=$id?>" type="button" class="btn">NR</button>
                                    <br/><br/>
                                </div>
                                <div name="divCompetencia" id="idDivCompetencia<?=$id?>" class="collapse">
                                    <label>Competência</label>
                                    <select name='selectCompetencia' class="form-control select2" style="width: 100%;">
                                        <option selected="selected" ></option>
                                        <option value='1'>Por Competência</option>
                                    </select><br/><br/>
                                    <input id="rd1" type="radio" name="orbyCompetencia" value ='0' class="flat-red" checked="checked">
                                    <label for="rd1">Imprimir</label>
                                    <input id="rd2" type="radio" name="orbyCompetencia" value ='0' class="flat-red" > 
                                    <label for="rd2">Exportar</label>
                                </div>
                                <div id="idDivNR<?=$id?>" class="collapse">
                                    <label>Nr</label>
                                    <select name='selectNr' class="form-control select2" style="width: 100%;">
                                        <option selected="selected" ></option>
                                        <option value='1'>Por Nr</option>
                                    </select><br/><br/>
                                    <input id="rd3" type="radio" name="orbyNr" value ='0' class="flat-red" checked="checked">
                                    <label for="rd3">Imprimir</label>
                                    <input id="rd4" type="radio" name="orbyNr" value ='0' class="flat-red" >
                                    <label for="rd4">Exportar</label>
                                </div>
                            <?php } ?>
                        </div>
                     </form>
                    <form method='<?=$method?>' action='index.php'>
                            <?php if ($respGet['padrao'] == 'combo'){?>
                                   <div class="col-md-12">
                                         <label>Competência</label>
                                         <select name='selectCompetencia' class="form-control select2" style="width: 100%;">
                                             <?php
                                                if($todos == true){ ?>
                                                    <option value="%" >TODOS</option><?php 
                                                }
                                                 foreach ($competencia as $data){ 
                                                        print_r($data);
                                                   ?>
                                                    <option value="<?=$data?>"><?=$data?></option> 
                                               <?php }?>
                                         </select>
                                     </div>
                            <?php }?>
                        <div class="modal-footer">
                            <input type="hidden" name="orgPor" id="idFlagOrgPor">
                            <input type="hidden" name="vtab" value="<?= $vtab ?>">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <input type="hidden" name="vpst" value="<?= $vpst ?>">
                            <input type="hidden" name="varq" value="<?= $varq ?>">
                            <input type="hidden" name="mesAnoInicial" value="<?= $respGet['mesAnoInicial'] ?>">
                            <input type="hidden" name="mesAnoFinal" value="<?= $respGet['mesAnoFinal'] ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
}
function modaldefinirData($id, $title, $pst, $arq, $acao, $ldt) {
        global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                    <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <b>Treinamentos que usuário já realizou:</b><br>
                                <?php 
                                     foreach ($ldt as $array){
                                         echo dataBr($array[0])." - ";
                                     }    
                                 ?>
                            </div>
                        </div>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Data</label>
                                <input name="dataTreinamento" class="form-control" type="date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
            </div>
        </div>
    </div>
<?php
}

//modal clonar acesso
function modalEnviaSetorInicio($id, $title, $pst, $arq, $acao, $vpst=null, $varq=null,$vtab=null, $cpf=null) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$title?></h4>
                </div>
                    <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Nome do setor</label>
                                <select name="idSetor" size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                                        <option selected='selected'></option>
                                      <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp){?>
                                              <option value="<?=$ArrEsp['idSetor']?>"><?=$ArrEsp['nome']?></option>
                                       <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <input type="hidden" name="vtab" value="<?= $vtab ?>">
                            <input type="hidden" name="vpst" value="<?= $vpst ?>">
                            <input type="hidden" name="varq" value="<?= $varq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php
}
//modal clonar acesso
function modalEnviaSetorInicioFim($id, $title, $pst, $arq, $acao, $vpst=null, $varq=null,$vtab=null, $cpf=null) {
    global $method;
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$title?></h4>
                </div>
                    <form method='<?=$method?>' action='index.php'>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Nome do setor</label>
                                <select name="idSetor" size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                                        <option selected='selected'></option>
                                       <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp){?>
                                              <option value="<?=$ArrEsp['idSetor']?>"><?=$ArrEsp['nome']?></option>
                                       <?php }?>
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label>Data Inicial</label>
                                <input name="mesAnoInicial" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Data Final</label>
                                <input name="mesAnoFinal" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="acao" value="<?= $acao ?>">
                            <input type="hidden" name="pst" value="<?= $pst ?>">
                            <input type="hidden" name="arq" value="<?= $arq ?>">
                            <input type="hidden" name="vtab" value="<?= $vtab ?>">
                            <input type="hidden" name="vpst" value="<?= $vpst ?>">
                            <input type="hidden" name="varq" value="<?= $varq ?>">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value='OK'>
                        </div>
                    </form>
                <div class="modal-body col-md-12"></div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php
}
//modal Cracha Administrar
function modalEnviaSetorInicioCracha($id, $title, $pst, $arq, $acao, $vpst=null, $varq=null,$vtab=null, $cracharequisicao=null,$crachaAdm =null ,$idHistFunc=null ) {
    global $method;
    global $crachaTipo;
    //print_p($cracharequisicao);
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$title?></h4>
                </div>
                    <form method='<?=$method?>' action='index.php'>
                        <?php 
                            //print_p($cracharequisicao);
                            $dataHora = dataHoraBr ($cracharequisicao[dataHora]);
                            $status =  $cracharequisicao[status];
                            $idCrachaRequisicao =  $cracharequisicao[id];
                            $idCrachaTipoFrente = $cracharequisicao[crachaTipo][imagemFrente][id];
                            $idCrachaTipoVerso = $cracharequisicao[crachaTipo][imagemVerso][id];
                            $nome = $cracharequisicao[funcional][pessoa][nome];
                            $cpf = $cracharequisicao[funcional][pessoa][cpf];
                            $matricula = $cracharequisicao[funcional][matricula];
                        ?>
                        <?php if(!isset ($status)){?>
                        <div class="modal-body col-md-12">
                            <div class="col-md-12">
                                <label>Tipo de Crachá</label>
                                <select name="idCrachaTipo" size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                                    <?php 
                                    foreach ($crachaTipo as $value){?>
                                        <option value='<?=$value['id']?>'><?=$value['nome']?></option>
                                   <?php }?>
                                </select>
                            </div>
                        </div>
                        <?php }?>
                        <div class="modal-footer">
                                <hr>
                                <?php if(isset ($status)){?>
                                        <p class="text-muted">
                                           <center>Pedido realizado em: <?=$dataHora?></center>
                                        </p>
                                        <div class="callout callout-info">
                                            <b>Status:</b> <?=$status?>
                                        </div><?php
                                    }
                                    if(!isset($status)){ ?>
                                            <input type="hidden" name="acao" value="crachaRequisitar"/>
                                            <input type="hidden" name="pst" value="funcional"/>
                                            <input type="hidden" name="arq" value="perfil"/>
                                            <input type="hidden" name="idHistFunc" value="<?=$idHistFunc?>"/>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fa fa-battery-1"></i><b> Requisitar</b>
                                            </button>
                                        </form>
                                    <?php }
                                     if($status == 'Enviado'){?>
                                        <form action="index.php" method="<?=$method?>" class="inline">
                                            <input type="hidden" name="acao" value="crachaCancelado"/>
                                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                                            <input type="hidden" name="idCrachaRequisicao" value="<?=$idCrachaRequisicao?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <button type="submit" class="btn btn-danger btn-block">
                                                <i class="fa fa-battery-empty"></i><b> Cancelar Requisição</b>
                                            </button>
                                        </form>                                    
                                    <?php }                                
                                     if(($status == 'Enviado') and ($crachaAdm == TRUE)){?>
                                        <form action="index.php" method="<?=$method?>" class="inline">
                                           <input type="hidden" name="acao" value="crachaImpresso"/>
                                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                                            <input type="hidden" name="idCrachaRequisicao" value="<?=$idCrachaRequisicao?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fa fa-battery-2"></i><b> Impresso</b>
                                            </button>
                                        </form>                                    
                                    <?php }
                                    if(($status == 'Impresso') and ($crachaAdm == TRUE)){?>
                                        <form action="index.php" method="<?=$method?>" class="inline">
                                           <input type="hidden" name="acao" value="crachaEntregue"/>
                                            <input type="hidden" name="pst" value="funcional"/>
                                            <input type="hidden" name="arq" value="perfil"/>
                                            <input type="hidden" name="idCrachaRequisicao" value="<?=$idCrachaRequisicao?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fa fa fa-battery-4"></i><b> Entregue</b>
                                            </button>
                                        </form>                                   
                                    <?php }
                                    if((($status == 'Negado') OR ($status == 'Entregue')) and ($crachaAdm == TRUE)){?>
                                        <form action="index.php" method="<?=$method?>" class="inline">
                                           <input type="hidden" name="acao" value="crachaLiberarPedido"/>
                                            <input type="hidden" name="pst" value="funcional"/>
                                            <input type="hidden" name="arq" value="perfil"/>
                                            <input type="hidden" name="idCrachaRequisicao" value="<?=$idCrachaRequisicao?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <button type="submit" class="btn btn-warning btn-block">
                                                <i class="fa fa fa-battery-4"></i><b> Liberar Novo Pedido</b>
                                            </button>
                                        </form><br>                                    
                                    <?php }
                                    if(($status == 'Enviado') and ($crachaAdm == TRUE)){?>
                                        <form action="index.php" method="<?=$method?>" class="inline">
                                            <input type="hidden" name="vpst" value="<?=$vpst?>" />
                                            <input type="hidden" name="varq" value="<?=$varq?>" />
                                            <input type="hidden" name="vtab" value="gestao" />
                                            <input type="hidden" name="pst" value="print"/>
                                            <input type="hidden" name="arq" value="info"/>
                                            <input type="hidden" name="idCrachaTipo" value="<?=$idCrachaTipoFrente?>"/>
                                            <input type="hidden" name="nome" value="<?=$nome?>"/>
                                            <input type="hidden" name="cpf" value="<?=$cpf?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <input type="hidden" name="acao" value="crachaFuncional"/>
                                            <input type="hidden" name="relat" value="crachaFuncional"/>
                                            <button type="submit" class="btn btn-default btn-block">
                                                <i class="fa fa-print"></i><b> Imprimir Frente</b>
                                            </button>
                                        </form>
                                        <form action="index.php" method="<?=$method?>" class="inline">
                                            <input type="hidden" name="vpst" value="<?=$vpst?>" />
                                            <input type="hidden" name="varq" value="<?=$varq?>" />
                                            <input type="hidden" name="vtab" value="gestao" />
                                            <input type="hidden" name="pst" value="print"/>
                                            <input type="hidden" name="arq" value="info"/>
                                            <input type="hidden" name="idCrachaTipo" value="<?=$idCrachaTipoVerso?>"/>
                                            <input type="hidden" name="nome" value="<?=$nome?>"/>
                                            <input type="hidden" name="cpf" value="<?=$cpf?>"/>
                                            <input type="hidden" name="matricula" value="<?=$matricula?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <input type="hidden" name="acao" value="crachaFuncional"/>
                                            <input type="hidden" name="relat" value="crachaFuncional"/>
                                            <input type="hidden" name="idImagem" value="8"/>
                                            <button type="submit" class="btn btn-default btn-block">
                                                <i class="fa fa-print"></i><b> Imprimir Verso</b>
                                            </button>
                                        </form>
                                    <?php
                                    }
                                    ?>
                        </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php
}