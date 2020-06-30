<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    if($respGet[acao] =='buscaCargoGeral'){
        $nome = array($respGet[nome]);
        $lista = getRest('cargo/getListaCargoGeralPorNome',$nome);
    }
    if(count($lista) == 0){
        $lista = $_SESSION[getListaCargoGeral];
    }
?>
<div class="box-footer clearfix">
    <ul class="pagination pagination-sm no-margin">
        <?=controleDePagina($lista ,$respGet[pg],"pagUpDown","buscaResult");?> 
    </ul>
</div>
<table class="table table-bordered">
    <tr>
        <th class='hidden-xs' style="width: 10%">
            id
        </th>
        <th style="width: 40%">
          Nome
        </th>
        <th style="width: 10%">
           Ação
        </th>
    </tr><?php
        foreach (paginaAtual($lista,$respGet[pg]) as $valor) {
        if ($valor['controle'] == 1) {
            $cClass = "bg-light-blue";
        } else {
            $cClass = "bg-green";
        }
        if ($valor['horaSemanal'] == 0) {
            $hsClass = "bg-red";
        } else {
            $hsClass = "bg-light-blue";
        }
        ?>
        <tr>
            <td class='hidden-xs'><?= $valor['id'] ?></td>
            <td><?= $valor['nome'] ?></td>
            <td>

            <button class="btn" onclick="cadastraAtribuicao('buscaCargoGeral','<?=$valor[id]?>','<?=$valor[nome]?>')" type="submit">
              <i class="fa fa-pencil"></i>
            </button>
             </td>
        </tr><?php
    }?>
</table>