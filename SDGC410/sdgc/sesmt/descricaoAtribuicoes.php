<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $pieces = explode("-", $respGet[id]);
if($pieces[1] == 1){
?> 
<div class="col-md-12">

    <div class="box-header with-border">
        <h3 class="box-title">Atribuições do Cargo</h3>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 8px"></th>
                <th style="width: 32px">Descrição</th>
            </tr>
            <?php
            $nome = array('00002');
            $lista = getRest('cargo/getListAtribuicoesCargoPorIdCargoGeral', $nome);
            foreach ($lista as $value) {
                ?>
                <tr>
                    <td>
                        <label>
                            <input type="checkbox" class="flat-red" checked>
                        </label>
                    </td>
                    <td>
                        <?= $value[descricaoAtribuicao] ?>
                    </td>

                </tr>

            <?php } ?>
        </table>
    </div>
</div>
<?php }?>