<?php
    $pst = 'funcional';
    $arq = 'relancarVariaveis';
    if($respGet[acao]=='limparSessao'){
        $_SESSION[lotacaoVariavel] = Null; 
        $_SESSION[lotacaoSubVariavel] = Null;
        $_SESSION[servidorVariavel] = Null;
        $_SESSION[nomeVariavel]=Null;
        $_SESSION[nomeLotacaoSub] = Null;
        $_SESSION[idLotacao] = Null;
    }
    if($respGet[acao]=='substituirVariaveis'){
        $carregarVariaveis = array('idLotacaoSub' => $respGet['idLotacaoSub'], 'idUserLogin' => $respGet['idUserLogin']);
        $carregarV = array($carregarVariaveis);
        $executar = postRest('variaveis/postCarregarVariaveisEmModelo',$carregarV);
        $msnTexto = "ao lançar Substituir Variáveis. ".$executar['msn'].'.';
        $respGet[acao] = 'selecionarSecretaria';
    }
     if($respGet[acao]=='carregarVariaveis'){
        $carregarVariaveis = array('idLotacaoSub' => $respGet['idLotacaoSub'], 'idUserLogin' => $respGet['idUserLogin']);
        $carregarV = array($carregarVariaveis);
        $executar = postRest('variaveis/postCarregarModeloEmVariaveis',$carregarV);
        $msnTexto = "ao lançar carregar Variáveis. ".$executar['msn'].'.';
        $respGet[acao] = 'selecionarSecretaria';
    }
    if($respGet[acao] == 'selecionarSecretaria'){
        if (!isset($_SESSION[idLotacao])){
            $_SESSION[idLotacao] = $respGet[idSecretaria];
        }
        $usuario = array($_SESSION[user][login], $_SESSION[idLotacao]);
        $_SESSION[lotacaoVariavel] = getRest('variaveis/getVariaveisModeloLancamentoPorLogin',$usuario);
        $respGet[pgLotacao] = 1;
    }
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?>
<h1 id="idTituloCarregarVariaveis">
    Gerar 
    <small>Carregar Variáveis</small>
    <br><br>
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Folha Online</a></li>
    <li class="active">Carregar Variáveis</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="exampleInputEmail1">Relatórios</label>
                            <div class="box-body no-padding">
                                <form action="index.php" method="<?=$method?>" name="formTemplate">   
                                    <?php require_once 'relat/boxSecretariaVariaveis.php';?>
                                    <div class="box-footer pull-right">
                                        <input type="hidden" name="pg" value="1"/>
                                        <input type="hidden" name="pst" value="<?=$pst?>"/>
                                        <input type="hidden" name="arq" value="<?=$arq?>"/>
                                        <input type="hidden" name="acao" value="selecionarSecretaria"/>
                                        <button type="submit" class="btn btn-primary">Abrir</button>
                                    </div>
                                </form>
                            </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
            <div class="col-md-12">
            <div class="box">
                <div class="box-body">
<!--                    <div class="nav-tabs-custom">
                         Tabs within a box 
                        <ul class="nav nav-tabs pull-right">
                          <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                          <li class="pull-left header"><i class="fa fa-inbox"></i> Acompanhamento de Lançamentos em Folha</li>
                        </ul>
                        <div class="tab-content no-padding">
                           Morris chart - Sales 
                          <div class="chart tab-pane active" id="myfirstchart" style="position: relative; height: 300px;"></div>
                          <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                        </div>
                    </div>-->
                        <!-- /.nav-tabs-custom -->
                        <!-- Chat box -->
                        <div class="box box-success">
                          <div class="box-header">
                            <i class="fa fa-comments-o"></i>

                            <h3 class="box-title">Relançar folha</h3>

                            <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                              <div class="btn-group" data-toggle="btn-toggle">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
                              </div>
                            </div>
                          </div>
                          <div class="box-body chat" id="chat-box">
                            <!-- chat item -->
                            <?php foreach (paginaAtual($_SESSION[lotacaoVariavel] ,$respGet[pgLotacao]) as $ArrEsp){
                                $id = str_replace(".", "", $ArrEsp[idLotacaoSub]);
                                if ($ArrEsp[dataHora] == ""){
                                    $dsb = "disabled";
                                    $msnSubstituicao = "Não possui dados carregados";
                                }else{
                                    $dsb = Null;
                                    $msnSubstituicao =  "Arquivo salvo em:  ".dataHoraBr($ArrEsp[dataHora]);
                                }
                                if ($ArrEsp[dataHoraCarregado] == ""){
                                    $msnCarregamento = Null;
                                }else{
                                    $msnCarregamento = "<i class='fa fa-clock-o'></i> Carregado em ".dataHoraBr($ArrEsp[dataHoraCarregado]);
                                }
                                ?>
                            <div class="item">
                              <img src="img/devolvido.png" alt="user image" class="online">

                              <p class="message">
                                <a href="#" class="name">
                                  <small class="text-muted pull-right"> <?=$msnCarregamento?></small><br>
                                  <?=$ArrEsp[nomeLotacaoSub]?>
                                </a>
                              </p>
                              <div class="attachment">
                                <b><?=$msnSubstituicao?></b><br>


                                <p class="filename">
                                </p>

                                <div class="pull-right">
                                    <form action="index.php" method="<?=$method?>" class="inline">
                                            <input type="hidden" name="vpst" value="<?=$pst?>" />
                                            <input type="hidden" name="varq" value="<?=$arq?>" />
                                            <input type="hidden" name="pst" value="print"/>
                                            <input type="hidden" name="arq" value="info"/>
                                            <input type="hidden" name="id" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <input type="hidden" name="acao" value="fichaFuncional"/>
                                            <input type="hidden" name="idVariavelDesc" value="<?=$ArrEsp[idVariavelDesc]?>"/>
                                            <input type="hidden" name="nomeVariavelDesc" value="<?=$ArrEsp[variaveisDesc]?>"/>
                                            <input type="hidden" name="acao" value="relatorioVariavelCarregadas"/>
                                            <button <?=$dsb?> class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</button>
                                    </form>
                                   <button type="submit" class="btn btn-github" data-toggle="modal" data-target="#substituir<?=$id?>"><i class="fa fa-save"></i> Salvar</button>
                                    <div class="modal fade" id="substituir<?=$id?>" role="dialog">
                                      <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                          <div class="modal-body">
                                                <p> Este procedimento ira <b>substituir</b> sua base de lancamentos atuais. Deseja realmente fazer esta ação?</p>
                                          </div>
                                          <div class="modal-footer">
                                                <form action="index.php" method="<?=$method?>" class="inline">
                                                        <input type="hidden" name="pst" value="<?=$pst?>"/>
                                                        <input type="hidden" name="arq" value="<?=$arq?>"/>
                                                        <input type="hidden" name="idLotacaoSub" value="<?=$ArrEsp[idLotacaoSub]?>"/>
                                                        <input type="hidden" name="idUserLogin" value="<?=$ArrEsp[idUserLogin]?>"/>
                                                        <input type="hidden" name="acao" value="substituirVariaveis"/>
                                                        <button class="btn btn-primary">Confirmar</button>
                                                </form>
                                                <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <button type="submit" <?=$dsb?> class="btn btn-success" data-toggle="modal" data-target="#carregar<?=$id?>"><i class="fa fa-sign-in"></i> Carregar</button>
                                    <div class="modal fade" id="carregar<?=$id?>" role="dialog">
                                      <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                          <div class="modal-body">
                                               <p> Este procedimento ira <b>carregar</b> sua base de lancamentos atuais. Deseja realmente fazer esta ação?</p>
                                          </div>
                                          <div class="modal-footer">
                                                <form action="index.php" method="<?=$method?>" class="inline">
                                                        <input type="hidden" name="pst" value="<?=$pst?>"/>
                                                        <input type="hidden" name="arq" value="<?=$arq?>"/>
                                                        <input type="hidden" name="idLotacaoSub" value="<?=$ArrEsp[idLotacaoSub]?>"/>
                                                        <input type="hidden" name="idUserLogin" value="<?=$ArrEsp[idUserLogin]?>"/>
                                                        <input type="hidden" name="acao" value="carregarVariaveis"/>
                                                        <button class="btn btn-primary">Confirmar</button>
                                                </form>
                                                <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                              </div>
                              <!-- /.attachment -->
                            </div>
                            <?php }?>
                          </div>
                           
                        </div>
                         <?=controleDePagina($_SESSION[lotacaoVariavel] ,$respGet[pgLotacao],"pgLotacao");?> 
                        <!-- /.box (chat box) -->
                </div>
            </div>
        </div>
    </div>
<!-- Morris.js charts -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script>
    new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'myfirstchart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: [
                { y: '2019-01', a: 50, b: 10},
                { y: '2019-02', a: 65,  b: 20},
                { y: '2019-03', a: 50,  b: 30},
                { y: '2019-04', a: 75,  b: 40},
                { y: '2019-05', a: 80,  b: 50},
                { y: '2019-06', a: 90,  b: 55},
                { y: '2019-07', a: 100, b: 73},
                { y: '2019-08', a: 115, b: 82}
            ],
            // The name of the data record attribute that contains x-values.
            xkey: 'y',
            ykeys: ['a','b'],
            // A list of names of data record attributes that contain y-values.
            //ykeys: ['value'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Quantidade em 2019','Quantidade em 2020'],
            xLabelFormat: function (x) {
                                        var retorno;
                                        if(x.getMonth()===0){
                                            retorno = "Janeiro";
                                        }else if(x.getMonth()===1){
                                            retorno = "Fevereiro";
                                        }else if(x.getMonth()===2){
                                            retorno = "Março";
                                        }else if(x.getMonth()===3){
                                            retorno = "Abril";
                                        }else if(x.getMonth()===4){
                                            retorno = "Maio";
                                        }else if(x.getMonth()===5){
                                            retorno = "Junho";
                                        }else if(x.getMonth()===6){
                                            retorno = "Julho";
                                        }else if(x.getMonth()===7){
                                            retorno = "Agosto";
                                        }else if(x.getMonth()===8){
                                            retorno = "Setembro";
                                        }else if(x.getMonth()===9){
                                            retorno = "Outubro";
                                        }else if(x.getMonth()===10){
                                            retorno = "Novembro";
                                        }else if(x.getMonth()===11){
                                            retorno = "Dezembro";
                                        }else{
                                            retorno = "falha";
                                        }
                                        return retorno;
                                    }

            });
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
