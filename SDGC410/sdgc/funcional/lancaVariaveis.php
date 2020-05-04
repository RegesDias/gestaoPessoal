<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Lançar Variáveis</h3>
    </div>
    <div class="box-body">
        <div class="box-body">
            <div class="box-body">
                    <div class="col-md-12">
                         <label for="idVariaveisDescVL">Variável</label>
                        <div class="input-group margin">
                            <select <?= $inativo ?> id="idLotacaoSubVariaveis" name="idLotacaoSubVariaveis" <?php if ($lote) { ?> onchange="loadList(this.value)" <?php } ?> size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                                <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp) { ?>
                                    <option value="<?= $ArrEsp['idSetor'] ?>"><?= $ArrEsp['nome'] ?></option>
                                <?php } ?>
                            </select>
                              <span class="input-group-btn">
                                <button onclick="carregarVariaveisTipo('variavelTipo',$('#idLotacaoSubVariaveis').val())" type="button" class="btn btn-info btn-flat">
                                    Selecionar
                                </button>
                              </span>
                        </div>
                    </div>
                    <div id='carregarVariaveisTipo'>
                    </div>
                
            </div>
        </div>
    </div>
</div>
<?php
    $dados = array('acao','idLotacaoSub');
    postRestAjax('carregarVariaveisTipo','carregarVariaveisTipo','funcional/lancaVariaveisTipo.php',$dados);
    $dados = array('acao','idVariaveisDescVL','idLotacaoSub');
    postRestAjax('carregarVariavel','carregarVariaveisTipo','funcional/lancaVariaveisTipo.php',$dados);
?>

