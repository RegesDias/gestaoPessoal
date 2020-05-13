<?php
session_start();
require_once '../func/fPhp.php';
?>
<div id="<?= $id ?>">
    <div class="box">

        <label>Nome do Template</label>
        <!--<input type="text" name="nomeTemplate" id="nomeTemplate" class="form-control">-->
        <input type="text" id="nomeTemplate">

        <button class="btn btn-primary" onclick="executarClone('clonarTemplate', '1', '<?= $respGet['idClone'] ?>', '<?= $respGet['idappversao'] ?>', $('#nomeTemplate').val())" type="button">
            OK
        </button>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>