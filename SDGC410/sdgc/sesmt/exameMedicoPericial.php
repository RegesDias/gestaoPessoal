<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $pst = 'sesmt';
    $arq = 'exameMedicoPericial';

?>
<h1 id="idTituloCarregarVariaveis">
    SESMT 
    <small>Exame Médico Pericial</small>
    <br><br>
</h1>

<div class="row">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Caixa de Entrada
        <small>12 Atendimentos Agendados</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> SESMT</a></li>
        <li class="active">Exame Médico</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Atendimentos</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a>
                        <form action="index.php" method="<?= $method ?>" class="inline">
                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                            <input type="hidden" name="file" value="atendimentosDia"/>
                            <input type="hidden" name="pg" value="1"/>
                            <input type="hidden" name="acao" value="destino6"/>
                            <button type="submit" class="link-button-limpo">
                                <i class="fa fa-inbox"></i>  De Hoje 
                            </button>
                            <span class="label label-primary pull-right">12</span>
                        </form>
                    </a>
                </li>
                <li>
                    <a>
                        <form action="index.php" method="<?= $method ?>" class="inline">
                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                            <input type="hidden" name="file" value="atendimentosDia"/>
                            <input type="hidden" name="pg" value="1"/>
                            <input type="hidden" name="acao" value="destino6"/>
                            <button type="submit" class="link-button-limpo">
                                <i class="fa fa-filter"></i> Da Semana
                            </button>
                            <span class="label label-warning pull-right">65</span>
                        </form>
                    </a> 
                </li>
                <li>
                    <a>
                        <form action="index.php" method="<?= $method ?>" class="inline">
                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                            <input type="hidden" name="file" value="atendimentosDia"/>
                            <input type="hidden" name="pg" value="1"/>
                            <input type="hidden" name="acao" value="destino6"/>
                            <button type="submit" class="link-button-limpo">
                                <i class="fa fa-map-pin"></i> Consulta
                            </button>
                        </form>
                    </a> 
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <?php 
                if(isset($respGet['file'])){
                    //require_once $respGet['pst']."/".$respGet['file'].'.php';
                }else{
                    //require_once $respGet['pst']."/atendimentosDia.php";
                }
            ?>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

</div>

   