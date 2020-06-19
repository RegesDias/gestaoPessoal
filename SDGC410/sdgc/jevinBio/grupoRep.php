<?php
session_start();
require_once '../func/fPhp.php';
require_once 'connect.php';


if ($respGet['acao'] == 'verGrupoRep') {
    //=====================
    //PEGA PONTO DA EMPRESA
    //=====================
//    $sql = "select * from public.pto_pessoa where public.pto_pessoa.cpf = '"
//            . $_SESSION['funcionalBusca']['pessoa']['cpf'] . "' and dt_registro BETWEEN '"
//            . $respGet['dataInicio'] . " 00:00:00' AND '" . $respGet['dataFim'] . " 23:59:00'";

    $sql = "select gr.ds_grupo_rep, gr.id_grupo_rep ,p.nm_pessoa "
            . "from gruporep as gr, com_pessoa_grupo_rep as pgr, gen_pessoa as p "
            . "where "
            . "p.nr_cpf_pessoa = '" . $_SESSION['funcionalBusca']['pessoa']['cpf'] . "' and "
            . "pgr.id_pessoa = p.id_pessoa and "
            . "pgr.id_grupo_rep = gr.id_grupo_rep";

    //print_p($sql);
    $result = pg_query($connect, $sql);

    ///teste sql
    if (!$result) {
        echo "Houve algum erro ao consultar a base da empresa.";
    }

    $listaGrupoREP = array();

    while ($row = pg_fetch_array($result)) {
        $grupoRep[idRep] = $row[id_grupo_rep];
        $grupoRep[nomeRep] = $row[ds_grupo_rep];
        $grupoRep[nomePessoa] = $row[nm_pessoa];
        array_push($listaGrupoREP, $grupoRep);
    }
    //print_p($listaGrupoREP);
}
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Grupo REP de <?= $_SESSION['funcionalBusca']['pessoa']['nome'] ?></h3>

        <div class="box-tools pull-right">
            <button onclick="document.getElementById('imprimir').innerHTML = '';" type="button" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <?php
            foreach ($listaGrupoREP as $item) {
                ?>
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><sup style="font-size: 20px">id:</sup><?= $item[idRep] ?></h3>

                            <p><?= $item[nomeRep] ?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            <?= $item[nomePessoa] ?> <i class="fa fa-user-circle"></i>
                        </a>
                    </div>
                </div>
                <!-- /.col -->

                <?php
            }
            ?>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>

