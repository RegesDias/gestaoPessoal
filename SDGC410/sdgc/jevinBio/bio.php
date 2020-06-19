<?php
session_start();
require_once '../func/fPhp.php';
require_once 'connect.php';


if ($respGet['acao'] == 'verMarcacoesEmpresa') {
    //=====================
    //PEGA PONTO DA EMPRESA
    //=====================
    $sql = "select * from public.pto_pessoa where public.pto_pessoa.cpf = '"
            . $_SESSION['funcionalBusca']['pessoa']['cpf'] . "' and dt_registro BETWEEN '"
            . $respGet['dataInicio'] . " 00:00:00' AND '" . $respGet['dataFim'] . " 23:59:00'";
    //print_p($sql);
    $result = pg_query($connect, $sql);

    ///teste sql
    if (!$result) {
        echo "Houve algum erro ao consultar a base da empresa.";
    }

    $ptEmpresa = array();
    while ($row = pg_fetch_array($result)) {
        //print_p($row);
        //echo dataHoraBr($row[1]);
        //print_p($row);
        array_push($ptEmpresa, dataHoraBr($row[1]) . ' ' . $row[eqpt]);
    }
    //print_p($ptEmpresa);
    //=====================
    //PEGA PONTO DO SDGC
    //=====================

    $dados = array($_SESSION["funcionalBusca"]['pessoa']['cpf'], $respGet['dataInicio'], $respGet['dataFim']);
    $ponto = getRest('ponto/getServidorPontoMarcacao', $dados);

    $ptSDGC = array();
    foreach ($ponto as $p) {
        $dataHora = dataHoraBr($p[data] . ' ' . $p[hora]);
        array_push($ptSDGC, $dataHora . ' ' . $p['nomeEquipamento']);
    }
}
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Comparativo de registro biométrico (SDGC/EMPRESA)</h3>

        <div class="box-tools pull-right">
            <button onclick="document.getElementById('imprimir').innerHTML = '';" type="button" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-6 col-sm-8">

                <!-- PONTOS SDGC -->
                <!-- ----------------->
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">SDGC</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <?php
                      foreach ($ptSDGC as $p) {
                    ?>
                        <div class="box-body">
                            <span class="info-box-number"><?= $p ?></span>
                        </div>
                    <?php
                      }
                    ?>

                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-4">

                <!-- PONTOS EMPRESA -->
                <!-- ----------------->
                <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Empresa</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <?php
                      foreach ($ptEmpresa as $p) {
                    ?>
                        <div class="box-body">
                            <span class="info-box-number"><?= $p ?></span>
                        </div>
                    <?php
                      }
                    ?>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>

