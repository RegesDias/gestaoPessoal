<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Lançar Variáveis</h3>
    </div>
    <div class="box-body">
        <div class="box-body">
            <div class="box-body">
                    <div class="col-md-12" id="idDivSecretaria">
                        <div class="form-group">
                        <label for="idLocalVL">Secretaria</label>
                            <select <?=$inativo?> name="nameLocal" size="1" class="form-control select2" id="idSecretariaVL" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <label for="idLocalVL">Setor</label>
                            <select <?=$inativo?> name="idLotacaoSub" size="1" class="form-control select2" id="idSetorVL" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="idVariaveisDescVL">Variável</label>
                            <select <?=$inativo?> name='idVariaveisDesc'class="form-control select2" id="idVariaveisDescVL" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 hidden" id="idDivQuantidadeVL">
                        <div class="form-group">
                            <label for="idQuantidadeVL">Quantidade</label>
                            <input type="number" name='quantidade' id="idQuantidadeVL" class="form-control" step="0.5">
                            
                        </div>
                    </div>
                    <div class="col-md-12 hidden" id="idDivValorVL">
                        
                        <div class="form-group">
                            <label for="idValorVL">Valor</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <label>R$</label>
                                </div>
                                <input type="text" name='valor' id="idValorVL" class="form-control">
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php 
require_once '../javascript/fLancaVariaveisLote.php';
?>

