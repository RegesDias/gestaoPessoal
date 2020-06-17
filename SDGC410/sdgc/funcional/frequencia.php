<?php
//VERIFICAR NIVEL DE ACESSO
foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
    if (($valor['pasta'] == 'funcional') AND ( $valor['arquivo'] == 'frequencia'AND ( $valor['menuN1'] == 'Frequência'))) {
        $prmfrequencia = $valor;
        break;
    }
}
foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
    if (($valor['pasta'] == 'funcional') AND ( $valor['arquivo'] == 'frequencia'AND ( $valor['menuN1'] == 'ConsultarUsuario'))) {
        $prmConsultaUsuario = $valor;
        break;
    }
}

foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
    if (($valor['menuN1'] == 'Frequência') AND ( $valor['menuN2'] == 'verificaColeta')AND ( $valor['listar'] == 1)) {
        $prmVerificaColeta = $valor;
        break;
    }
}

if ($prmfrequencia['listar'] == '1') {
    $idModal = 'InicioFim';
} else {
    $idModal = 'Inicio';
}
$today = date("Y-m-d");
$yesterday = date("Y-m-d", strtotime("-1 days"));
$usuario = array($_SESSION["funcionalBusca"]['pessoa']['cpf'], $yesterday, $today);
$ponto = getRest('ponto/getServidorPontoMarcacao', $usuario);
?>
<div class="tab-pane <?= tabId('frequencia', $respGet['tab']) ?>" id="frequencia">
    <!-- Post -->
    <div class="post clearfix">
        <?php modalInicio('macacoesInicio', 'Marcações', 'print', 'info', 'macacoesInicio', '', 'funcional', 'perfil', 'frequencia') ?>
        <?php modalInicoFim('macacoesInicioFim', 'Marcações', 'print', 'info', 'macacoesInicioFim', '', 'frequencia') ?>
        <?php modalEnviaSetorInicio('modalEnviaSetorInicio', 'Folha de Ponto', 'print', 'info', 'folhapontoInicio', 'frequencia') ?>
        <?php modalEnviaSetorInicioFim('modalEnviaSetorInicioFim', 'Folha de Ponto', 'print', 'info', 'folhapontoInicioFim', 'frequencia') ?>
        <?php modalInicoFimData('jevimBio', 'Consultar dados biométricos no servidor da Empresa', 'verMarcacoesEmpresa') ?>

        <!-- /.box -->
        <!-- /.post -->        
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <button type="button <?= permissaoAcesso($prmfrequencia['buscar'], 'hide') ?>" class="btn btn-info" data-toggle="modal" data-target="<?= '#modalEnviaSetor' . $idModal ?>">
                            <i class="fa fa-calendar"></i> <b>Folha de Ponto</b>
                        </button>
                        <button type="button <?= permissaoAcesso($prmfrequencia['buscar'], 'hide') ?>" class="btn btn-info" data-toggle="modal" data-target="<?= '#macacoes' . $idModal ?>">
                            <i class="fa fa-print"></i> <b>Marcações</b>
                        </button>

                        <button type="button <?= permissaoAcesso($prmVerificaColeta['buscar'], 'hide') ?>" class="btn btn-info" data-toggle="modal" data-target="#jevimBio">
                            <i class="fa fa-eye"></i> <b>Verifica Coleta</b>
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">

            <div class="box-header">
                <h3 class="box-title">Buscar e Analisar as Ocorrências lançadas</h3>
            </div>
            <div class="box-body">
                <form class="<?= permissaoAcesso($prmfrequencia["buscar"], 'hide') ?>"> 
                    <div class="col-sm-6">
                        <label>Tipo de Ocorrência</label>
                        <select class="form-control select2"  name='idOcorrencia'  id='idOcorrenciaBusca' style="width: 100%;">
                            <option selected='selected'></option>
                            <?php foreach ($_SESSION["funcionalPerfil"]["ocorrenciaDesc"] as $ArrEsp) { ?>ocorrenciaDesc
                                <option value="<?= $ArrEsp['idOcorrencia'] ?>"><?= $ArrEsp['nome'] ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="form-horizontal col-sm-5">
                        <label>Período</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="periodoOco" class="form-control pull-right" id="reservation">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class=" col-sm-12">
                        <br>
                    </div>
                    <div class=" col-sm-12">
                        <button class="btn btn-primary pull-right btn-sm" onclick="postBuscarOcorrencia($('#idOcorrenciaBusca').val(), $('#reservation').val(), 'buscarOcorrencia', 'funcional', 'ocorrenciaBusca')" type="button">
                            <i class="fa fa-search"></i> Buscar</button>
                        </button>                       
                    </div>
                </form>
            </div>
        </div>
        <div id='ocorrenciaBusca'>

        </div>
        <!-- FOLHA de PONTO -->
        <?php if (count($ponto) < 32) { ?>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Últimos registros</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table class="table  table-responsive">
                                    <tr>
                                        <th style="width: 10px">Dia</th>
                                        <th>Reg.01</th>
                                        <th>Reg.02</th>
                                        <th>Reg.03</th>
                                        <th>Reg.04</th>
                                        <th>Reg.05</th>
                                        <th>Reg.06</th>
                                    </tr>
                                    <?php
                                    foreach ($ponto as $p) {
                                        $databr = dataBr($p[data]);
                                        if ($databr != $databrAtual) {
                                            if ($cont >= 1) {
                                                $cont = 6 - $cont;
                                                for ($index = 0; $index < $cont; $index++) {
                                                    echo '<td></td>';
                                                }
                                                echo '</tr>';
                                            }
                                            $cont = 0;
                                            $fim = false;
                                            echo '<tr>';
                                            echo "<td>$databr</td>";
                                        }
                                        $cont++;
                                        echo "<td title='$p[nomeEquipamento]'>$p[hora]</td>";
                                        $databrAtual = $databr;
                                    }
                                    $cont = 6 - $cont;
                                    for ($index = 0; $index < $cont; $index++) {
                                        echo '<td></td>';
                                    }
                                    ?>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </section>

        <?php }
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div>
                    <div class="box-body">
                        <form class="<?= permissaoAcesso($prmfrequencia['incluir'], 'hide') ?> form-horizontal">
                            <?php require_once 'lancaOcorrencia.php'; ?>
                            <div class="col-sm-12">
                                <button class="<?= permissaoAcesso($prmfrequencia["incluir"], 'hide') ?> btn btn-success pull-right btn-sm" onclick="postLancarOcorrencia('frequencia', 'lancarOco', $('#secretariaID').val(), $('#setorID').val(), $('#tpOco').val(), $('#diasOco').val(), $('#datetimes').val(), $('#obsOco').val())" type="button">
                                    <i class="fa fa-edit"></i> Lançar</button>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Folha de Ponto -->
    </div>
</div>
<?php
//postLancarOcorrencia
$s2 = array('idBoxImprimir', 'addClass', 'hidden');
$success = array($s2);
$funcao = array('postBuscarOcorrencia');
$dados = array('tab', 'acao', 'secretariaID', 'setorID', 'ocorrencia', 'diasOco', 'datetimes', 'obsOco');
postRestAjax('postLancarOcorrencia', 'dados', 'funcional/perfil.php', $dados, '', $success, $funcao);

//postBuscarOcorrencia
$s1 = array('idBoxImprimir', 'addClass', 'hidden');
$success = array($s1);
$dados = array('idOcorrenciaBusca', 'reservation', 'acao');
postRestAjax('postBuscarOcorrencia', 'ocorrenciaBusca', 'funcional/ocorrenciaBusca.php', $dados, '', $success);

//Ver marcacoes da empresa
$dados = array('acao', 'user', 'dataInicio', 'dataFim', 'ver');
$funcao = array('fecharModal');
postRestAjax('postverMarcacoesEmpresa', 'imprimir', 'jevinBio/bio.php', $dados, '', '', $funcao);
?>

