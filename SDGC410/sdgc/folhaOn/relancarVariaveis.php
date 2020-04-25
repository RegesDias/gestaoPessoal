<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
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
            <div class="overlay hidden" id="idSpinLoaderRelancarVariaveis">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div class="box-body">
                <div class="row">
                    <form name="formTemplate">
                    <div class="col-md-12">
                        <label for="carregaLot-variaveis">Destino</label>
                        <div class="box-body no-padding">
                            <div id="carregaLot-variaveis-validar">
                                <?php require_once '../relat/boxSecretaria.php'; ?>
                            </div>
                            <div class="box-footer pull-right">
                                <button class="btn btn-primary" onclick="relancarVFolha('selecionarSecretaria', $('#secretariaID').val())" type="button">
                                    Abrir
                                </button>
                            </div>
                        </div> 
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="relancarVFolha">
</div>
<?php
    $before = array('idSpinLoaderRelancarVariaveis','removeClass','hidden');
    $latter = array('idSpinLoaderRelancarVariaveis','addClass','hidden');
    $beforeSend= array ($before);
    $success= array ($latter);
    $dados = array('acao', 'idSecretaria');
    postRestAjax('relancarVFolha', 'relancarVFolha', 'folhaOn/relancarVFolha.php', $dados, $beforeSend,$success);

    
    $before = array('idSpinLoaderRelancarVFolha','removeClass','hidden');
    $latter = array('idSpinLoaderRelancarVFolha','addClass','hidden');
    $beforeSend= array ($before);
    $success= array ($latter);
    $dados = array('acao', 'nomeLotacaoSub');
    postRestAjax('buscarRVFolha', 'relancarVFolha', 'folhaOn/relancarVFolha.php', $dados, $beforeSend,$success);

    $dados = array('acao', 'pg', 'idLotacaoSub', 'idUserLogin', 'ver');
    postRestAjax('rRelancarV', 'rRelancarV', 'print/info.php', $dados);

    //salvar
    $before = array('idSpinLoaderRelancarVFolha','removeClass','hidden');
    $latter = array('idSpinLoaderRelancarVFolha','addClass','hidden');
    $beforeSend= array ($before);
    $success= array ($latter);
    
    $dados = array('acao', 'pg', 'idLotacaoSub', 'idUserLogin');
    $funcao = array('fecharModal');
    postRestAjax('RVSalvarFolha', 'relancarVFolha', 'folhaOn/relancarVFolha.php', $dados, $beforeSend, $success, $funcao);

    //lançar
    $before = array('idSpinLoaderRelancarVFolha','removeClass','hidden');
    $latter = array('idSpinLoaderRelancarVFolha','addClass','hidden');
    $beforeSend= array ($before);
    $success= array ($latter);
    
    $dados = array('acao', 'pg', 'idLotacaoSub', 'idUserLogin');
    $funcao = array('fecharModal');
    postRestAjax('RVLancarFolha', 'relancarVFolha', 'folhaOn/relancarVFolha.php', $dados, $beforeSend, $success, $funcao);

    //pg
    $dados = array('acao', 'pg');
    postRestAjax('pgLotacao', 'relancarVFolha', 'folhaOn/relancarVFolha.php', $dados, $beforeSend, $success);
    ?>
    <input type="hidden" name="acao" value="substituirVariaveis"/>
    <input type="hidden" name="pgLotacao" value="<?= $respGet[pgLotacao] ?>"/>
    <input type="hidden" name="idLotacaoSub" value="<?= $ArrEsp[idLotacaoSub] ?>"/>
    <input type="hidden" name="idUserLogin" value="<?= $ArrEsp[idUserLogin] ?>"/>
<script>
    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'myfirstchart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
            {y: '2019-01', a: 50, b: 10},
            {y: '2019-02', a: 65, b: 20},
            {y: '2019-03', a: 50, b: 30},
            {y: '2019-04', a: 75, b: 40},
            {y: '2019-05', a: 80, b: 50},
            {y: '2019-06', a: 90, b: 55},
            {y: '2019-07', a: 100, b: 73},
            {y: '2019-08', a: 115, b: 82}
        ],
        // The name of the data record attribute that contains x-values.
        xkey: 'y',
        ykeys: ['a', 'b'],
        // A list of names of data record attributes that contain y-values.
        //ykeys: ['value'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Quantidade em 2019', 'Quantidade em 2020'],
        xLabelFormat: function (x) {
            var retorno;
            if (x.getMonth() === 0) {
                retorno = "Janeiro";
            } else if (x.getMonth() === 1) {
                retorno = "Fevereiro";
            } else if (x.getMonth() === 2) {
                retorno = "Março";
            } else if (x.getMonth() === 3) {
                retorno = "Abril";
            } else if (x.getMonth() === 4) {
                retorno = "Maio";
            } else if (x.getMonth() === 5) {
                retorno = "Junho";
            } else if (x.getMonth() === 6) {
                retorno = "Julho";
            } else if (x.getMonth() === 7) {
                retorno = "Agosto";
            } else if (x.getMonth() === 8) {
                retorno = "Setembro";
            } else if (x.getMonth() === 9) {
                retorno = "Outubro";
            } else if (x.getMonth() === 10) {
                retorno = "Novembro";
            } else if (x.getMonth() === 11) {
                retorno = "Dezembro";
            } else {
                retorno = "falha";
            }
            return retorno;
        }

    });
    $("#myModal").on("show", function () {    // wire up the OK button to dismiss the modal when shown
        $("#myModal a.btn").on("click", function (e) {
            console.log("button pressed");   // just as an example...
            $("#myModal").modal('hide');     // dismiss the dialog
        });
    });

    $("#myModal").on("hide", function () {    // remove the event listeners when the dialog is dismissed
        $("#myModal a.btn").off("click");
    });

    $("#myModal").on("hidden", function () {  // remove the actual elements from the DOM when fully hidden
        $("#myModal").remove();
    });

    $("#myModal").modal({// wire up the actual modal functionality and show the dialog
        "backdrop": "static",
        "keyboard": true,
        "show": true                     // ensure the modal is shown immediately
    });
</script>
