<?php
    //VERIFICAR NIVEL DE ACESSO
    foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
        if (($valor['pasta'] == 'funcional') AND ($valor['arquivo'] == 'prontuario' AND ($valor['menuN1'] == 'Prontuário'))){ 
             $prmProntuario = $valor;
              break;
        }
    }
modalAgendamento('agendamentoSesmt', 'Agendamento', 'print', 'info', 'contraCheque','','funcional','perfil','gestao');
?>
<div class="tab-pane <?= tabId('prontuario', $respGet['tab']) ?>" id="prontuario">
        <!-- FOLHA de PONTO -->

        <div class="box box-info collapsed-box">
            <!--            <div class="box-header with-border">
                            <h3 class="box-title">Folha de Ponto</h3>
            
                            <div class="box-tools pull-right">
                                <button onclick="exibeFolhaDePonto()" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>-->
            <!-- /.box-header -->
            <div class="box-body" style="">
                <!-- Carregamento -->
                <div id="idCarregamentoFolhaDePonto" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <!-- Fim Carregamento -->
                <!-- Inicio COnteudo Folha -->
                <div id="idConteudoFolhaDePonto" class="table-responsive collapse">
                    <!-- AQUI O JAVASCRIPT CRIA A FOLHA DE PONTO DINAMICAMENTE -->
                </div>
                <!-- Fim conteudo Folha-->
            </div>
            <!-- /.box-body -->
        </div>
                       <div class="box">
                                        <div class="box-body ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="box box-solid">
                                                        <!-- /.box-header -->
                                                        <div class="box-body">

                                                            <div class="box-group" id="ocorrencia">                               
                                                                    <div class="panel box box-success">
                                                                        <div class="box-header with-border">
                                                                            <h4 class="box-title">
                                                                                <a data-toggle="collapse" data-parent="#ocorrencia" href="#<?= $ArrEsp['id'] ?>">
                                                                                    <i class="fa fa-sort-down"></i> <?= $ArrEsp['id'] . ' - ' . $ArrEsp['ocorrenciaNome'] ?>
                                                                                </a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="<?= $ArrEsp['id'] ?>" class="panel-collapse collapse">
                                                                            <div class="box-body">
                                                                                    <form action="index.php" method="<?= $method ?>" name="formTemplate" class="<?= permissaoAcesso($prmfrequencia["excluir"], 'hide') ?>">
                                                                                        <button class="btn btn-danger pull-right espaco-direita">
                                                                                            <i class="fa fa-trash"></i>
                                                                                        </button>
                                                                                        <input type='hidden' name='idOcorrencia' value='<?= $ArrEsp['id'] ?>'>
                                                                                        <input type='hidden' name='cpf' value='<?= $ArrEsp['cpf'] ?>'>
                                                                                        <input type='hidden' name='tab' value='frequencia'>
                                                                                        <input type='hidden' name='acao' value='excluirOcorrencia'>
                                                                                        <input type="hidden" name="pst" value="<?= $pst ?>">
                                                                                        <input type="hidden" name="arq" value="<?= $arq ?>">
                                                                                        <input type="hidden" name="pg" value="1">
                                                                                    </form>
                                                                                    <form action="index.php" method="<?= $method ?>"name="formTemplate">
                                                                                        <button class="btn btn-info pull-right espaco-direita">
                                                                                            <i class="fa fa-user"></i>
                                                                                        </button>
                                                                                        <input type='hidden' name='cpf' value='<?= $ArrEsp['cpf'] ?>'>
                                                                                        <input type='hidden' name='acao' value='buscar'>
                                                                                        <input type="hidden" name="pst" value="usuario">
                                                                                        <input type="hidden" name="arq" value="perfil">
                                                                                        <input type="hidden" name="pg" value="1">
                                                                                    </form>
                                                                            </div>
                                                                            <div class="box-body">
                                                                                <b><?= $ArrEsp['nomeLotacao'] ?></b><br>
                                                                                <?= $msnPeriodo ?><br>
                                                                                    <b>Total de dias: </b><i><?= $numeroDias ?>
                                                                                    </i><br>
                                                                                <b>Lançado em: </b><i><?= $LancadoOco ?>
                                                                                    <?= $ArrEsp['login'] ?>
                                                                                </i><br>
                                                                                <b>Observação: </b>
                                                                                <div class="box-body">
                                                                                    <?= $ArrEsp['obs'] ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="panel box box-success">
                                                                        <div class="box-header with-border">
                                                                            <h4 class="box-title">
                                                                                <a data-toggle="collapse" data-parent="#ocorrencia" href="#analizar">
                                                                                    <i class="fa fa-sort-down"></i> <?= 'Analisador - ' . $ArrEsp['ocorrenciaNome'] ?>
                                                                                </a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="analizar" class="panel-collapse collapse">                                                 
                                                                            <div class="box-body">
                                                                                <b>Total de dias Gozados: </b><i><?= $totalDias ?>
                                                                                </i><br>
                                                                                <b>Período: </b><i><?= $msnPeriodo ?></i><br>
                                                                            </div>
                                                                        <button class=" btn btn-info" type="button" data-toggle="modal" data-target="#agendamentoSesmt">
                                                                          <i class="fa fa-calendar"></i> <b>Agendamento</b>
                                                                        </button>
                                                                        </div>

                                                                    </div>

                                                            </div>
                                                        </div>
                                                        <!-- /.box-body -->

                                                    </div>
                                                    <!-- /.box -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
        <div class="row">
            <div class="col-xs-12">
                <div>
                    <div class="box-body">
                        <form class="<?= permissaoAcesso($prmProntuario['incluir'], 'hide') ?> form-horizontal" method="<?= $method ?>" action="index.php">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Dados do Requerente</h3>
                                </div>
                                <div class="box-body">
                                    <div class="box-body">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <form>
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <div class="col-md-4">
                                                                        <label>CEP</label>
                                                                        <input <?=$inativo?> type="text" name="cep" id="idCep" class="form-control" placeholder="____-___" data-inputmask='"mask": "99999-999"' data-mask>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Estado</label>
                                                                        <select <?=$inativo?> name="estado" size="1"  class="form-control select2" id="idEstado" style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Cidade</label>
                                                                        <select <?=$inativo?> name="cidade" size="1"  class="form-control select2" id="idCidade" style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-4">
                                                                        <label>Bairro</label>
                                                                        <select <?=$inativo?> name="bairro" size="1"  class="form-control select2" id="idBairro" style="width: 100%;">

                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <label>Logradouro</label>
                                                                        <input <?=$inativo?> type="text" name="logradouro" id="idLogradouro" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-2">
                                                                        <label>Número</label>
                                                                        <input <?=$inativo?> type="text" name="numero" id="idNumero" class="form-control">
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <label>Complemento</label>
                                                                        <input <?=$inativo?> type="text" name="complemento" id="idComplemento" class="form-control" >
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <label>Celular</label>
                                                                        <input <?=$inativo?> type="text" name="celular" id="idCelular" class="form-control" placeholder="(___) ___-______" data-inputmask='"mask": "(999) 999-999999"' data-mask>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Teletone</label>
                                                                        <input <?=$inativo?> type="text" name="teletone" id="idTelefone" class="form-control" placeholder="(___) ___-_____" data-inputmask='"mask": "(999) 999-99999"' data-mask>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <label>Email</label>
                                                                        <input <?=$inativo?> type="email" name="email" id="idEmail" class="form-control" placeholder="Enter ..." >
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <label>Espécie de Solicitação</label>
                                                                        <input <?=$inativo?> type="text" name="solicitacao" id="idSolicitacao" class="form-control" placeholder="Enter ..." >
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="tab" value="prontuario">
                                                <input type="hidden" name="acao" value="lancarProntuario">
                                                <input type="hidden" name="pst" value="<?= $pst ?>">
                                                <input type="hidden" name="arq" value="<?= $arq ?>">
                                                <div class="col-sm-12">
                                                    <button <?=$inativo?> type="submit" class="btn btn-info pull-right  btn-sm"><i class="fa fa-edit"></i> Salvar</button>
                                                </div>
                                                </form>
                                        <div class="row">
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
                                                                    <button <?=$inativo?> type="submit" class="btn btn-primary"><i class="fa fa-print"></i><b> Requerimento</b></button>
                                                            </form>
                                                            <form action="index.php" method="<?=$method?>" class="inline <?=permissaoAcesso($prmPortaria["listar"],'hide')?>">
                                                                    <input type="hidden" name="vpst" value="funcional" />
                                                                    <input type="hidden" name="varq" value="perfil" />
                                                                    <input type="hidden" name="vtab" value="gestao" />
                                                                    <input type="hidden" name="pst" value="print"/>
                                                                    <input type="hidden" name="arq" value="info"/>
                                                                    <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                                                    <input type="hidden" name="pg" value="1"/>
                                                                    <input type="hidden" name="relat" value="portaria"/>
                                                                    <button <?=$inativo?> type="submit" class="btn btn-success"><i class="fa fa-info-circle"></i><b> Entrada</b></button>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
          
                                </div>
                            </div>
                    </div>

                         
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                    </div>
<?php require_once 'javascript/fProntuario.php';