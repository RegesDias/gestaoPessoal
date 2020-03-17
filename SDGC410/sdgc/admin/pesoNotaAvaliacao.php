<?php
//configuração
    $pst = 'admin';
    $arq = 'pesoNotaAvaliacao';
    if ($respGet['acao'] == 'alterPesoAvaliacao'){
        $alterPeso1 = array('id' => $respGet['id1'], 'valor' => $respGet['1']);
        $alterPeso2 = array('id' => $respGet['id2'], 'valor' => $respGet['2']);
        $alterPeso3 = array('id' => $respGet['id3'], 'valor' => $respGet['3']);
        $alterPeso4 = array('id' => $respGet['id4'], 'valor' => $respGet['4']);
        $alterPeso5 = array('id' => $respGet['id5'], 'valor' => $respGet['5']);
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
            <h4 class="modal-title">Alterar Período</h4>
        </div>
           <form method='<?=$method?>' action='index.php'>
                <div class="modal-body col-md-12">
                    <?php foreach ($_SESSION["pesoAvaliacao"] as $pa){?>
                        <div class="col-md-2">
                            <label><?=$pa[nome]?>: <?=$pa[valor]*8?></label>
                            <input name="<?=$pa[id]?>" type="number" value="<?=$pa[valor]?>">
                        </div>
                        <input type="hidden" name="id<?=$pa[id]?>" value="<?=$pa[id]?>">
                    <?php }?>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="acao" value="alterPesoAvaliacao">
                    <input type="hidden" name="pst" value="<?= $pst ?>">
                    <input type="hidden" name="arq" value="<?= $arq ?>">
                    <input type="submit" class="btn btn-primary" value='Alterar'>
                </div>
               <div class="modal-body col-md-12">
               </div>
            </form>
    </div>
</div>