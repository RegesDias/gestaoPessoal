<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    //autoComplete($_SESSION["nomePessoas"], '#nome', '1');
    $lote = true;
    $_SESSION["funcionalPerfil"] = '';
    $_SESSION["funcionalBusca"] = '';

?>
<h1>
    Lançar
    <small>Ocorrências em lote</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li class="active">Ocorrências em lote</li>
</ol>
<section class="content">
    <div class="row">
        <!--<form class="form-horizontal" method="<?=$method?>" action="index.php" name="formTemplate">-->
            <?php require_once 'lancaOcorrencia.php'; ?>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Selecionar servidor</h3>
                </div>
                <div class="box-body">
                    <div class="box-body">
                        <div id="wrap" class="container col-md-12">
                            <br>
                         </div>
                        <div id="wrap" class="container col-md-12">            
                            <div class="row">
                                <div class="col-sm-12" id="servidores">
                                    <select name="servidor" multiple="multiple" size="8" id="multiselect" class="form-control select2" style="height: 100%;"> </select>
                                </div>
                                <div class="col-sm-12"><br></div>
                                <div class="col-sm-12">
                                    <div class="col-sm-2"></div>
                                     <div class="col-sm-2">
                                        <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-down"></i></button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-up"></i></button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-erase"></i></button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="fa fa-list-ul"></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-12"><br></div>
                                <div class="col-sm-12" id="carregaFuncional">
                                    <select name="to[]" id="multiselect_to" class="form-control " size="8" multiple="multiple"></select>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript" src="dist/js/multiselect.min.js"></script>
                    </div>
                    <input type="hidden" name="tab" value="frequencia">
                    <input type="hidden" name="acao" value="lancarOco">
                    <input type="hidden" name="pst" value="funcional">
                    <input type="hidden" name="arq" value="ocorrencia">
                    <div class="col-sm-12">
                    <button class="btn btn-success pull-right btn-sm" onclick="postLancarOcorrencia('lancarOco',$('select#multiselect_to option').map(function() {return $(this).val();}).get(),$('#setorID').val(),$('#tpOco').val(),$('#diasOco').val(),$('#datetimes').val(),$('#obsOco').val())" type="button">
                           <i class="fa fa-edit"></i> Lançar
                        </button>
                    </div>
                </div>
            </div>
        <!--</form>-->
    </div>
    <?php require_once '../javascript/fBoxSecretariaSetor.php'; ?>
<script>

    //postLancarOcorrencia
    function postLancarOcorrencia(acao,to,setorID,ocorrencia,diasOco,datetimes,obsOco){ 

                $.ajax
                        ({
                            type: 'POST', 
                            dataType: 'html', 
                            url:  'funcional/ocorrencia.php', 
                            data: {acao: acao, to: to, setorID: setorID, ocorrencia: ocorrencia, diasOco: diasOco, datetimes: datetimes,obsOco: obsOco}, //Dados para consulta
                            //data: {acao: acao+')'},
                            success: function (msg)
                            {   
                                $('#dados').html(msg);
                                //$("#idBoxImprimir").removeClass("hidden");
                            }
                        });
            }
</script>
</section>
