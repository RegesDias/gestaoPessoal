<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
    if ($respGet['acao'] == 'alterPesoAvaliacao'){
        $alterPeso1 = array('id' => $_SESSION["pesoAvaliacao"][0]['id'], 'valor' => $respGet['val1']);
        $alterPeso2 = array('id' => $_SESSION["pesoAvaliacao"][1]['id'], 'valor' => $respGet['val2']);
        $alterPeso3 = array('id' => $_SESSION["pesoAvaliacao"][2]['id'], 'valor' => $respGet['val3']);
        $alterPeso4 = array('id' => $_SESSION["pesoAvaliacao"][3]['id'], 'valor' => $respGet['val4']);
        $alterPeso5 = array('id' => $_SESSION["pesoAvaliacao"][4]['id'], 'valor' => $respGet['val5']);
        $dadosAlterData = array($alterPeso1,$alterPeso2,$alterPeso3,$alterPeso4,$alterPeso5);
        $executar = postRest('avaliacao/postIncluirAvaliacaoPeso',$dadosAlterData);
        $msnTexto = "ao alterar peso de avaliação.";
    }
   exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
   $_SESSION["pesoAvaliacao"] = getRest('avaliacao/getListaAvaliacaoPesoAtivas');
?>
<h1>
    Avaliação
    <small>Definir peso dos itens da Avaliação</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Avaliação</a></li>
    <li class="active">Peso</li>
</ol>
<div class="row">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Peso das notas</h4>
        </div>
<!--           <form method='<?=$method?>' action='index.php'>-->
                <div class="modal-body col-md-12">
                    <?php foreach ($_SESSION["pesoAvaliacao"] as $pa){?>
                        <div class="col-md-2">
                            <label><?=$pa[nome]?>: <?=$pa[valor]*8?></label>
                            <input id="val<?=$pa[id]?>" type="number" class="form-control" value="<?=$pa[valor]?>">
                        </div>
                    <?php }?>
                        
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="agendarData('alterPesoAvaliacao',$('#val1').val(),$('#val2').val(),$('#val3').val(),$('#val4').val(),$('#val5').val())" type="button">
                        Alterar
                    </button>
                </div>
               <div class="modal-body col-md-12">
               </div>
<!--            </form>-->
    </div>
</div>
<?php
    //salvar
    $dados = array('acao','val1','val2','val3','val4','val5');
    postRestAjax('agendarData', 'corpo', 'admin/pesoNotaAvaliacao.php', $dados);
?>