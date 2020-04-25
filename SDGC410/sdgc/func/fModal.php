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
                <form method='<?= $method ?>' action='index.php' name='formTemplate'>
                <?= esconderItem('template') ?>
                    <div class="modal-body col-md-12">
                        <div class="col-md-12">
                            <label>Versão App</label>
                            <?php
                            global $gurl;
                            global $ajurl;
                            ?>
                            <div onclick="template()">
                                <div onclick="getAJAX(<?= "'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacao', '', selectMultipleSecretariasAjax);">

                                    <select multiple onchange="getAJAX(<?= "'" . $ajurl . "'"; ?>, 'appversao/getListaUserTemplatePorAppVersao/', this.value + '/', selectTemplateAjax)" name="idAppVersao" class="form-control select2" id='appVersaoID' style="width: 100%;">
                                        <?php foreach ($_SESSION['appv'] as $ArrEsp) { ?>
                                            <option value="<?= $ArrEsp['id'] ?>" <?php if ($ArrEsp['ativo'] == 1) {
                                        echo "selected='selected'";
                                        $lotAtivo = true;
                                    } ?>><?= $ArrEsp['nome'] . " " . $ArrEsp['versao'] ?></option>
                                    <?php
                                    }
                                    if ($lotAtivo != true) {
                                        echo "<option></option>";
                                    }
                                    ?>  
                                    </select>

                                </div>
                            </div>
                        </div>
    <?= esconderItem('secretaria') ?>
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
    <?= esconderItem('setor') ?>
                        <div onclick="setor()">
                            <div id="secretaria" class="hide">
                                <div class="col-md-12">
                                    <label>Secretaria</label>
                                    <select multiple onchange="getAJAX(<?= "'" . $ajurl . "'"; ?>, 'funcionalws/getListaSetorAtivoPorIdLotacao/', this.value, selectMultipleSetorAjax)" name="idSecretaria" size="1"  class="form-control select2" id="secretariaID" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                        </div>
    <?= esconderItem('cargoGeral') ?>
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
    foreach ($_SESSION['cargosGeral'] as $ArrEsp) {
        ?>
                                        <option value="<?= $ArrEsp['id'] ?>"><?= $ArrEsp['nome'] ?></option>
    <?php } ?> 
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
    require_once '../javascript/fBoxSecretariaSetor.php';
}

//ModalInicioFim
function modalInicoFim($id, $title, $pst, $arq, $acao, $padrao = null, $vtab = null, $user = null) {
    
    $be = array('idSpinLoaderGestao','removeClass','hidden');
    $s = array('idSpinLoaderGestao','addClass','hidden');
    $beforeSend= array ($be);
    $success = array ($s);
    $dados = array('mesAnoInicial','mesAnoFinal','acao','ver');
    postRestAjax('post'.$acao,'imprimir',$pst.'/'.$arq.'.php',$dados, $beforeSend, $success);
    
    
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                <form>
                    <div class="modal-body col-md-12">
                        <div class="col-md-6">
                            <label>Data Inicial</label>
                            <input id="idMesAnoInicialInicioFim" name="mesAnoInicial" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Data Final</label>
                            <input id="idMesAnoFinalInicioFim" name="mesAnoFinal" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
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
    <?php if ($user != null) { ?>
                            <input type="hidden" name="user" value="<?= $user ?>">
    <?php } ?>          
                        <button class="btn btn-primary" data-dismiss="modal" onclick="<?='post'.$acao?>($('#idMesAnoInicialInicioFim').val(), $('#idMesAnoFinalInicioFim').val(),'<?= $acao ?>',true)" type="button">
                             <b>OK</b>
                        </button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}

//ModalInicioFim
function modalInicoFimData($id, $title, $pst, $arq, $acao, $padrao = null, $vpst = null, $varq = null, $vtab = null, $user = null, $cpf = null) {
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
            } else {
                echo "<form method='$method' action='index.php'>";
            }
            ?>
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
    <?php if ($user != null) { ?>
                            <input type="hidden" name="user" value="<?= $user ?>">
                            <input type="hidden" name="cpf" value="<?= $cpf ?>">
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
function modalInicio($id, $title, $pst, $arq, $acao, $padrao = null, $vtab = null) {


    $be = array('idSpinLoaderGestao','removeClass','hidden');
    $s = array('idSpinLoaderGestao','addClass','hidden');
    $beforeSend= array ($be);
    $success = array ($s);
    $dados = array('dado','acao','ver');
    postRestAjax('post'.$acao,'imprimir',$pst.'/'.$arq.'.php',$dados, $beforeSend, $success);
    
    
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
            } else {
                echo "<form method='$method' action='index.php'>";
            }
            ?>
                <form>
                    <div class="modal-body col-md-12">
                        <div class="col-md-12">
                            <label>Período</label>
                            <input id="idMesAnoInicial<?= $id ?>" name="mesAnoInicial" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
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
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                        <button class="btn btn-primary" data-dismiss="modal" onclick="<?='post'.$acao?>($('#idMesAnoInicial<?= $id ?>').val(),'<?= $acao ?>',true)" type="button">
                             <b>OK</b>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}

function modalAgendamento($id, $title, $pst, $arq, $acao, $padrao = null, $vpst = null, $varq = null, $vtab = null) {
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
                                <input name="mesAnoInicial" class="form-control" type="date" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-12">
                                <label>Médico</label>
                                <select class="form-control select2" name='idEspecialidade' style="width: 100%;">
                                    <option selected='selected' value=0 >NAO POSSUI</option>
    <?php foreach ($_SESSION["funcionalPerfil"]["especialidades"] as $ArrEsp) { ?>
            <option value="<?= $ArrEsp['idEspecialidade'] ?>" <?php if ($ArrEsp['ativo'] == 1) {
            echo "selected='selected'";
            $espAtivo = true;
        } ?>><?= $ArrEsp['nome'] ?></option>
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
                <form method='<?= $method ?>' action='index.php'>";
                    <div class="modal-body col-md-12">
                        <div class="col-md-12">
                            <label>Defina a chave</label>
                            <input type="text" name="chave" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="nomeCompleto" value="<?= $_SESSION["funcionalBusca"]['pessoa']['nome'] ?>">
                        <input type="hidden" name="cpf" value="<?= $_SESSION["funcionalBusca"]['pessoa']['cpf'] ?>">
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
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                <form method='<?= $method ?>' action='index.php'>";
                    <div class="modal-body col-md-12">
                        <div class="col-md-12">
                            <label>Nome do Template</label>
                            <input type="text" name="nomeTemplate" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="acao" value="<?= $acao ?>">
                        <input type="hidden" name="closeResult" value="1">
                        <input type="hidden" name="idClone" value="<?= $id ?>">
                        <input type="hidden" name="idappversao" value="<?= $respGet['idappversao'] ?>">
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

//ModalInicioFim

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
                    <div class="modal-body col-md-12">
                        <div class="col-md-12">
                            <label>Senha</label>
                            <input name="senha" id="senha" class="form-control" type="password">
                        </div>
                        <div class="col-md-12">
                            <label>Redigite a senha</label>
                            <input name="confirmaSenha" id="confirmaSenha" class="form-control" type="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                        <button data-dismiss="modal" class="btn btn-primary" onclick="modalAlterarSenha('<?=$acao?>', $('#senha').val(),$('#confirmaSenha').val())" type="button">
                             OK
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}

//ModalCompetencia13
function modalComp($id, $title, $pst, $arq, $acao, $padrao = null, $vpst = null, $varq = null) {?>
    

    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                    <div class="modal-body">
                        <label>Competência</label>
                        <input name="mesAnoInicial" id="mesAnoInicial<?=$id?>" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>"><br>
                        <input type="checkbox" name="tem13salario" id="tem13salario<?=$id?>" value ='sim' class="flat-red" >
                        13º Salário
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="acao" value="<?= $acao ?>">
                        <button data-dismiss="modal" class="btn btn-primary" onclick="executaModalComp('<?=$acao?>', $('#mesAnoInicial<?=$id?>').val(),$('#tem13salario<?=$id?>').is(':checked'),true)" type="button">
                             OK
                        </button>
                        <button onclick="fecharModal()" type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                        
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal -->
    <?php
}

function modalInicoFimJavaScript($idSpinLoader, $id, $title, $pst, $arq, $acao, $padrao = null, $vpst = null, $varq = null, $vtab = null, $todos = null) { 
    global $respGet;
    
    global $competencia;
    
    if (isset($respGet[mesAnoInicial])) {
        $dataAnoInicial = mesAnoBanco($respGet[mesAnoInicial]);
    } else {
        $dataAnoInicial = date('Y-m');
    }
    if (isset($respGet[mesAnoFinal])) {
        $dataAnoFinal = mesAnoBanco($respGet[mesAnoFinal]);
    } else {
        $dataAnoFinal = date('Y-m');
    }
    ?>

    <div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button onclick="fecharModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>                          
                    </button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                <form>
                    <div class="modal-body col-md-12">
                        <div class="col-md-6">
                            <label>Data Inicial</label>
                            <input id="idMesAnoInicial<?= $id ?>" name="mesAnoInicial" class="form-control" value="<?=$dataAnoInicial?>" type="month"  max="<?= date('Y-m') ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Data Final</label><?php 
                            if ($padrao == 'combo'){
                                ?><div class="input-group input-group"><?php    
                            }?>
                            <input id="idMesAnoFinal<?= $id ?>" name="mesAnoFinal" class="form-control" value="<?=$dataAnoFinal?>" type="month"  max="<?= date('Y-m') ?>"><?php
                            if ($padrao == 'combo') { ?>
                                <span class="input-group-btn">
                                    <input type="hidden" name="pst" value="<?= $vpst ?>">
                                    <input type="hidden" name="arq" value="<?= $varq ?>">
                                    <input type="hidden" name="modal" value="<?= $id ?>">
                                    <input type="hidden" name="padrao" value="<?= $padrao ?>">
<!--                                    <button class="btn btn-info btn-flat" >
                                        executar
                                    </button>-->
                                    <button  class="btn btn-info btn-flat" onclick="executaInicioFim('<?=$id?>','<?=$padrao?>',$('#idMesAnoInicial<?=$id?>').val(),$('#idMesAnoFinal<?=$id?>').val())" type="button">
                                         Executar
                                    </button>
                                </span>
                                </div><?php
                            }
                            echo "</div>";
                            if ($padrao == 'nsd') { ?>
                                <div class="col-md-12">
                                    <br>
                                    <label>Organizar por</label>
                                    </br>
                                    <button onclick="exibeCompetencia()" id="btnCompetencia<?= $id ?>" type="button" class="btn">Competência</button>
                                    <button onclick="exibeNR()" id="btnNr<?= $id ?>" type="button" class="btn">NR</button>
                                    <br/><br/>
                                </div>
                                <div name="divCompetencia" id="idDivCompetencia<?= $id ?>" class="collapse">
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
                                <div id="idDivNR<?= $id ?>" class="collapse">
                                    <label>Nr</label>
                                    <select name='selectNr' class="form-control select2" style="width: 100%;">
                                        <option selected="selected" ></option>
                                        <option value='1'>Por Nr</option>
                                    </select><br/><br/>
                                    <input id="rd3" type="radio" name="orbyNr" value ='0' class="flat-red" checked="checked">
                                    <!--<label for="rd3">Imprimir</label>-->
                                    <input id="rd4" type="radio" name="orbyNr" value ='0' class="flat-red" >
                                    <label for="rd4">Exportar</label>
                                </div><?php 
                            
                            } ?>
                        </div>
                </form>
                <?php 
                    if ($respGet['padrao'] == 'combo') { ?>
                        <div class="col-md-12">
                            <label>Competência</label>
                            <select id="selectCompetencia" name='selectCompetencia' class="form-control select2" style="width: 100%;"><?php 
                                if ($todos == true) { ?>
                                    <option value="%" >TODOS</option><?php
                                }
                                foreach ($competencia as $data) {?>
                                        <option value="<?= $data ?>"><?= $data ?></option><?php 
                                }?>
                            </select>
                        </div><?php
                    } ?>
                    <div class="modal-footer">
                        <button data-dismiss="modal" onclick="fecharModal()" type="button" class="btn btn-default pull-left">Fechar</button>
                        <button data-dismiss="modal" class="btn btn-primary" onclick="relatorioInicioFim('<?=$idFlagOrgPor?>','<?=$acao?>','<?= $respGet['mesAnoInicial'] ?>','<?= $respGet['mesAnoFinal'] ?>',$('#selectCompetencia').val(),true)" type="button">
                             OK
                        </button>
                    </div>
                
            </div>
        </div>
    </div>
        <?php
        $be = array($idSpinLoader,'removeClass','hidden');
        $s = array($idSpinLoader,'addClass','hidden');
        $beforeSend= array ($be);
        $success= array ($s);            
        $dados = array('idFlagOrgPor', 'acao', 'mesAnoInicial', 'mesAnoFinal', 'selectCompetencia','ver');
        $funcao = array('fecharModal');
        postRestAjax('relatorioInicioFim', 'imprimir', 'print/info.php',$dados,$beforeSend,$success, $funcao);
        
        //executaContabilExterno        
        $dados = array('modal', 'padrao', 'mesAnoInicial', 'mesAnoFinal');
        postRestAjax('executaInicioFim', 'corpo', 'contabil/'.$varq.'.php', $dados);
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
                    <div class="modal-body col-md-12">
                        <div class="col-md-12">
                            <b>Treinamentos que usuário já realizou:</b><br>
                            <?php
                            foreach ($ldt as $array) {
                                echo dataBr($array[0]) . " - ";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="modal-body col-md-12">
                        <div class="col-md-12">
                            <label>Data</label>
                            <input name="dataTreinamento" id="data" class="form-control" type="date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left">Fechar</button>
                        <button data-dismiss="modal" class="btn btn-primary" onclick="modalDataTreinamento('<?=$acao?>',$('#data').val())" type="button">
                             OK
                        </button>
                        
                    </div>
            </div>
        </div>
    </div>
    <?php
}

//modal clonar acesso
function modalEnviaSetorInicio($id, $title, $pst, $arq, $acao, $vtab = null, $cpf = null) {
    
    $be = array('idSpinLoaderGestao','removeClass','hidden');
    $s = array('idSpinLoaderGestao','addClass','hidden');
    $beforeSend= array ($be);
    $success = array ($s);
    $dados = array('idSetor','acao','ver');
    postRestAjax('post'.$acao,'imprimir',$pst.'/'.$arq.'.php',$dados, $beforeSend, $success);
                              
                                ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                <form method='<?= $method ?>' action='index.php'>
                    <div class="modal-body col-md-12">
                        <div class="col-md-12">
                            <label>Nome do setor</label>
                            <select id="idSetorInicio" name="idSetor" size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
    <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp) { ?>
                                    <option value="<?= $ArrEsp['idSetor'] ?>"><?= $ArrEsp['nome'] ?></option>
    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                        
                        <button class="btn btn-primary" data-dismiss="modal" onclick="<?='post'.$acao?>($('#idSetorInicio').val(),'<?= $acao ?>',true)" type="button">
                             <b>OK</b>
                        </button>
                        
                        
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
function modalEnviaSetorInicioFim($id, $title, $pst, $arq, $acao, $vtab = null, $cpf = null) {

    
    $be = array('idSpinLoaderGestao','removeClass','hidden');
    $s = array('idSpinLoaderGestao','addClass','hidden');
    $beforeSend= array ($be);
    $success = array ($s);
    $dados = array('mesAnoInicial','mesAnoFinal', 'idSetor','acao','ver');
    postRestAjax('post'.$acao,'imprimir',$pst.'/'.$arq.'.php',$dados, $beforeSend, $success);
    
    ?>
    <div class="modal fade" id="<?= $id ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $title ?></h4>
                </div>
                <form method='<?= $method ?>' action='index.php'>
                    <div class="modal-body col-md-12">
                        <div class="col-md-12">
                            <label>Nome do setor</label>
                            <select id="idSetorInicioFim" name="idSetor" size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
    <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp) { ?>
                                    <option value="<?= $ArrEsp['idSetor'] ?>"><?= $ArrEsp['nome'] ?></option>
    <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Data Inicial</label>
                            <input id="idMesAnoSetorInicialInicioFim"name="mesAnoInicial" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Data Final</label>
                            <input id="idMesAnoSetorFinalInicioFim" name="mesAnoFinal" class="form-control" type="month" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>">
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                        
                        <button class="btn btn-primary" data-dismiss="modal" onclick="<?='post'.$acao?>($('#idMesAnoSetorInicialInicioFim').val(), $('#idMesAnoSetorFinalInicioFim').val(), $('#idSetorInicioFim').val(),'<?= $acao ?>',true)" type="button">
                             <b>OK</b>
                        </button>
                        
                        
                        
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
                }?>

