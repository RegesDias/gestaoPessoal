<div class="tab-pane <?= tabId('prontuario', $respGet['tab']) ?>" id="prontuario">
<?php
//VERIFICAR NIVEL DE ACESSO
foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
    if (($valor['pasta'] == 'funcional') AND ( $valor['arquivo'] == 'prontuario' AND ( $valor['menuN1'] == 'Prontuário'))) {
        $prmProntuario = $valor;
        break;
    }
}
modalAgendamento('agendamentoSesmt', 'Agendamento', 'print', 'info', 'contraCheque', '', 'funcional', 'perfil', 'gestao');


?>

        <div id="buscaProntuario">

        </div>

    <div class="box box-info collapsed-box">
        <div class="box-body" style="">
            


            <div id="idConteudoProntuario" class="table-responsive collapse">
                
            </div>
        </div>
    </div>  
    <?php
        if($enSES){
            echo "<div id=\"bloqueia\">";
        }
    ?>

    <div class="row">
        <div class="col-xs-12">
            <div>
                <div class="box-body">
<!--                    <form class="<?= permissaoAcesso($prmProntuario['incluir'], 'hide') ?> form-horizontal" method="<?= $method ?>" action="index.php">-->
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
                                                                    <input <?= $inativo ?> value='<?=$_SESSION[enderecoSESMIT][0][cepLogradouro]?>' type="text" name="cep" id="idCep" class="form-control" placeholder="____-___" data-inputmask='"mask": "99999-999"' data-mask>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label>Estado</label>
                                                                    <select <?= $inativo ?> name="estado" size="1"  class="form-control select2" id="idEstado" style="width: 100%;">
                                                                    <?php if($enSES){
                                                                        $id=$bce[0][idEstado];
                                                                        $nome=$bce[0][estado];
                                                                        echo " <option value='$id'>$nome</option>";
                                                                    }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Cidade</label>
                                                                    <select <?= $inativo ?> name="cidade" size="1"  class="form-control select2" id="idCidade" style="width: 100%;">
                                                                    <?php if($enSES){
                                                                        $id=$bce[0][idCidade];
                                                                        $nome=$bce[0][cidade];
                                                                        echo " <option value='$id'>$nome</option>";
                                                                    }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label>Bairro</label>
                                                                    <select <?= $inativo ?> name="bairro" size="1"  class="form-control select2" id="idBairro" style="width: 100%;">
                                                                    <?php if($enSES){
                                                                        $id=$bce[0][idBairro];
                                                                        $nome=$bce[0][bairro];
                                                                        echo " <option value='$id'>$nome</option>";
                                                                    }?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label>Logradouro</label>
                                                                    <input <?= $inativo ?> value='<?=$_SESSION[enderecoSESMIT][0][endereco]?>' type="text" name="logradouro" id="idLogradouro" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-2">
                                                                    <label>Número</label>
                                                                    <input <?= $inativo ?> value='<?=$_SESSION[enderecoSESMIT][0][numero]?>' type="text" name="numero" id="idNumero" class="form-control">
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <label>Complemento</label>
                                                                    <input <?= $inativo ?> value='<?=$_SESSION[enderecoSESMIT][0][complemento]?>' type="text" name="complemento" id="idComplemento" class="form-control" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label>Celular</label>
                                                                    <input <?= $inativo ?> value='<?=$_SESSION[enderecoSESMIT][0][celular]?>' type="text" name="celular" id="idCelular" class="form-control" placeholder="(___) ___-______" data-inputmask='"mask": "(999) 999-999999"' data-mask>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Teletone</label>
                                                                    <input <?= $inativo ?>  value='<?=$_SESSION[enderecoSESMIT][0][telefone]?>' type="text" name="teletone" id="idTelefone" class="form-control" placeholder="(___) ___-_____" data-inputmask='"mask": "(999) 999-99999"' data-mask>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label>Email</label>
                                                                    <input <?= $inativo ?> value='<?=$_SESSION[enderecoSESMIT][0][email]?>' type="email" name="email" id="idEmail" class="form-control" placeholder="Enter ..." >
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label>Espécie de Solicitação</label>
                                                                    <select <?= $inativo ?> class="form-control select2" id="idRequerimentoSolicitacao" name='idRequerimentoSolicitacao' style="width: 100%;">
                                                                        <option selected='selected'></option>
                                                                        <?php foreach ($_SESSION["tipoSolicitacaoSesmt"] as $ArrEsp){?>
                                                                          <option value="<?=$ArrEsp['id']?>"><?=$ArrEsp['item']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="acao" value="lancarProntuario">
                                            <input type="hidden" name="pst" value="<?= $pst ?>">
                                            <input type="hidden" name="arq" value="<?= $arq ?>">
                                            <div class="col-sm-12">
<!--                                                <button <?= $inativo ?> type="submit" class="btn btn-info pull-right  btn-sm"><i class="fa fa-edit"></i> Salvar</button>-->
                                            </div>
<!--                                            </form>-->
                                            <button  onclick="lancarProntuario('lancarProntuario', $('#idCep').val(), $('#idEstado').val(), $('#idCidade').val(), $('#idBairro').val(), $('#idLogradouro').val(), $('#idNumero').val(), $('#idComplemento').val(), $('#idCelular').val(), $('#idTelefone').val(), $('#idEmail').val(), $('#idRequerimentoSolicitacao option:selected').val())" class="btn btn-info pull-right btn-sm">
                                                            
                                                <i class="fa fa-edit"></i> Salvar
                                            </button>
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
<?php
require_once '../javascript/fProntuario.php';

    $s1 = array('idBoxImprimir','addClass','hidden');
    $success= array ($s1);
    $dados = null;
    postRestAjax('buscaProntuario','buscaProntuario','funcional/prontuarioResult.php',$dados, '', $success);
    
        //incluirVariaveis
  
    $s1 = array('idBoxImprimir','addClass','hidden');
    $success= array ($s1);
    $dados = array('acao','cep', 'estado', 'cidade', 'bairro', 'logradouro', 'numero', 'complemento', 'celular', 'teletone', 'email', 'idRequerimentoSolicitacao');
    //$dados = array('acao', 'idAvaliacao');
    postRestAjax('lancarProntuario','buscaProntuario','funcional/prontuarioResult.php',$dados, '', $success);

?>