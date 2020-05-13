<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
//print_p($respGet);
////CRACHA------------------>
//requisitar Cracha
if ($respGet['acao'] == "crachaRequisitar") {
    $crachaDados = array('idHistFunc' => $respGet['idHistFunc'], 'idCrachaTipo' => $respGet['idCrachaTipo']);
    $c = array($crachaDados);
    $executar = postRest('cracha/postIncluirCrachaRequisicao', $c);
    $msnTexto = "ao requisitar Crachá.";
    $respGet['acao'] = "buscarCreche";
}
// Cracha Impresso
if ($respGet['acao'] == "crachaImpresso") {
    $crachaDados = array('id' => $respGet['idCrachaRequisicao']);
    $c = array($crachaDados);
    $executar = postRest('cracha/postCrachaImpresso', $c);
    $msnTexto = "ao alterar status para impresso.";
    $respGet['acao'] = "buscarCreche";
}
// Cracha Entregue
if ($respGet['acao'] == "crachaEntregue") {
    $crachaDados = array('id' => $respGet['idCrachaRequisicao']);
    $c = array($crachaDados);
    $executar = postRest('cracha/postCrachaEntregue', $c);
    $msnTexto = "ao alterar status para entrege.";
    $respGet['acao'] = "buscarCreche";
}
// Cracha Cancelado
if ($respGet['acao'] == "crachaCancelado") {
    $crachaDados = array('id' => $respGet['idCrachaRequisicao']);
    $c = array($crachaDados);
    $executar = postRest('cracha/postCrachaNegado', $c);
    $msnTexto = "ao alterar status para Cancelado.";
    $respGet['acao'] = "buscarCreche";
}
// Cracha Liberado
if ($respGet['acao'] == "crachaLiberarPedido") {
    $crachaDados = array('id' => $respGet['idCrachaRequisicao']);
    $c = array($crachaDados);
    $executar = postRest('cracha/postLiberarCracha', $c);
    $msnTexto = "novo cracha pode ser requisitado";
    $respGet['acao'] = "buscarCreche";
}
//Tipos de Cracha
$crachaTipo = getRest('cracha/getListaCrachaTipo');
$cPerfil = array($respGet[idHistFunc]);
$cracharequisicao = getRest('cracha/getListaCrachaRequisicaoPorIdFuncional', $cPerfil);
foreach ($cracharequisicao as $cracha) {
    
}

exibeMsn($msnExibe, $msnTexto, $msnTipo, $executar);
?>
<div class="box box-primary">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $dataHora = dataHoraBr($cracha[dataHora]);
            $status = $cracha[status];
            $idCrachaRequisicao = $cracha[id];
            $idCrachaTipoFrente = $cracha[crachaTipo][imagemFrente][id];
            $idCrachaTipoVerso = $cracha[crachaTipo][imagemVerso][id];
            $nome = $cracha[funcional][pessoa][nome];
            $cpf = $cracha[funcional][pessoa][cpf];
            $matricula = $cracha[funcional][matricula];
            ?>
            <div class="modal-header">
                <button onclick="fecharCracha()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><center><?= $nome ?></center></h4>
            </div>
<?php if (!isset($status)) { ?>
                <div class="modal-body col-md-12">
                    <div class="col-md-12">
                        <label>Tipo de Crachá</label>
                        <select name="idCrachaTipo" size="1" class="form-control select2" id='idCrachaTipo' style="width: 100%;">
    <?php foreach ($crachaTipo as $value) { ?>
                                <option value='<?= $value['id'] ?>'><?= $value['nome'] ?></option>
                <?php } ?>
                        </select>
                    </div>
                </div><?php }
            ?>
            <div class="modal-footer">
                <hr><?php if (isset($status)) { ?>
                    <p class="text-muted">
                    <center>Pedido realizado em: <?= $dataHora ?></center>
                    </p>
                    <div class="callout callout-info">
                        <b>Status:</b> <?= $status ?>
                    </div><?php
            }
            if (!isset($status)) {
                ?>  
                    <form>
                        <button data-dismiss="modal" class = "btn btn-primary btn-block" onclick="postEmCrachaIncluir('crachaRequisitar', '<?= $respGet[idHistFunc] ?>', $('#idCrachaTipo').val(), '<?= $respGet[crachaAdm] ?>')" type="button">
                            <i class="fa fa-battery-1"></i><b> Requisitar</b>
                        </button>
                    </form> <?php
            }
            if ($status == 'Enviado') {
                ?>
                    <button onclick="postEmCrachaStatus('crachaCancelado', '<?= $idCrachaRequisicao ?>', '<?= $respGet[idHistFunc] ?>', '<?= $respGet[crachaAdm] ?>')" type="button" class="btn btn-danger btn-block">
                        <i class="fa fa-battery-empty"></i><b> Cancelar Requisição</b>
                    </button><?php
            }
            if (($status == 'Enviado') and ( $respGet[crachaAdm] == TRUE)) {
                ?>
                    <form>
                        <button onclick="postEmCrachaStatus('crachaImpresso', '<?= $idCrachaRequisicao ?>', '<?= $respGet[idHistFunc] ?>', '<?= $respGet[crachaAdm] ?>')" type="button" class="btn btn-primary btn-block">
                            <i class="fa fa-battery-2"></i><b> Impresso</b>
                        </button>
                    </form><?php
            }
            if (($status == 'Impresso') and ( $respGet[crachaAdm] == TRUE)) {
                ?>
                    <form>
                        <button onclick="postEmCrachaStatus('crachaEntregue', '<?= $idCrachaRequisicao ?>', '<?= $respGet[idHistFunc] ?>', '<?= $respGet[crachaAdm] ?>')" type="button" class="btn btn-primary btn-block">
                            <i class="fa fa fa-battery-4"></i><b> Entregue</b>
                        </button>
                    </form> <?php
            }
            if ((($status == 'Negado') OR ( $status == 'Entregue')) and ( $respGet[crachaAdm] == TRUE)) {
                ?>
                    <form>
                        <button onclick="postEmCrachaStatus('crachaLiberarPedido', '<?= $idCrachaRequisicao ?>', '<?= $respGet[idHistFunc] ?>', '<?= $respGet[crachaAdm] ?>')" type="button" class="btn btn-warning btn-block">
                            <i class="fa fa fa-battery-4"></i><b> Liberar Novo Pedido</b>
                        </button>
                    </form><br><?php
            }
            if (($status == 'Enviado') and ( $respGet[crachaAdm] == TRUE)) {
                ?>
                    <form>
                        <button onclick="relatorioEmCracha('crachaFuncional', '<?= $idCrachaRequisicao ?>', '<?= $nome ?>', '<?= $cpf ?>', '<?= $respGet[idHistFunc] ?>', '<?= $respGet[crachaAdm] ?>', '5', true)" type="button" class="btn btn-default btn-block">
                            <i class="fa fa-print"></i><b> Imprimir Frente</b>
                        </button>
                    </form>
                    <form action="index.php" method="<?= $method ?>" class="inline">
                        <button onclick="relatorioEmCracha('crachaFuncional', '<?= $idCrachaRequisicao ?>', '<?= $nome ?>', '<?= $cpf ?>', '<?= $matricula ?>', '<?= $respGet[crachaAdm] ?>', '8', true)" type="button" class="btn btn-default btn-block">
                            <i class="fa fa-print"></i><b> Imprimir Verso</b>
                        </button>
                    </form><?php }
            ?>
            </div>
        </div>
    </div>
    <b><br></b>
</div>
