<?php
    session_start();
    require_once '../func/fPhp.php';
        $var = array($respGet["idLotacaoSub"],$_SESSION["funcionalBusca"]['id']);
        $varDados = getRest('variaveis/getListaVariaveisSetorHistFunc',$var);
        autoComplete($varDados, '#idVariaveisDescVL', 'codigo','nome');
        ?>
<div class="col-md-12">
    <label for="idVariaveisDescVL">Variável</label>
    <div class="input-group margin">
          <input type="text" id='idVariaveisDescVL' class="form-control" value='<?=$respGet[idVariaveisDescVL]?>' >
          <span class="input-group-btn">
            <button onclick="carregarVariavel('carregarVariavel',$('#idVariaveisDescVL').val(),'<?=$respGet['idLotacaoSub']?>')" type="button" class="btn btn-info btn-flat">
                Selecionar
            </button>
          </span>
    </div>
</div>
<?php
if($respGet[acao] == 'carregarVariavel'){
    foreach ($varDados as $valor) {
        if (($valor['codigo'] ==  substr($respGet[idVariaveisDescVL], 0, 4))){
             $varSelect = $valor;
              break;
        }
    }
    if($varSelect[quantidade] == '1'){?>
        <div class="col-md-12" id="idDivQuantidadeVL">
            <div class="form-group">
                <label for="idQuantidadeVL">Quantidade</label>
                <input type="number" name='quantidade' id="idQuantidadeVL" placeholder="<?=$varSelect[minimo]." até ".$varSelect[maximo]?>" class="form-control" step="0.5" min="<?=$varSelect[minimo]?>" max="<?=$varSelect[maximo]?>">
            </div>
        </div><?php 
    }else if($varSelect[valor] == '1'){?>
        <div class="col-md-12" id="idDivValorVL">
            <div class="form-group">
                <label for="idValorVL">Valor</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <label>R$</label>
                    </div>
                    <input type="text" name='valor' id="idValorVL" class="form-control">
                </div>
            </div>
         </div><?php
    }?>
<button id="idBtnLancarVariaveis" class="btn btn-info pull-right  btn-sm" onclick="incluirVariavel('lancarVariaveis', '<?=$respGet[idLotacaoSub]?>' , <?=$varSelect[id]?>, $('#idQuantidadeVL').val(), $('#idValorVL').val())" type="button">
   <i class="fa fa-edit"></i> Lançar
</button>
<?php }?>