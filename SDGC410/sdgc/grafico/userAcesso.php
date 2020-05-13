<?php
$pst = 'grafico';
$arq = 'userAcesso';
modalInicoFimData('graficoAcesso', 'Grafico de Acessos', 'grafico', 'userAcesso', 'userAcesso', $padrao, $pst, $arq,'',$respGet[user]);
//busca biometria
    $usuario = array($respGet[cpf], $respGet[mesAnoInicial], $respGet[mesAnoFinal]);
    $ponto = getRest('ponto/getServidorPontoMarcacao',$usuario);
    
//fim teste
if($respGet[acao] == 'userAcesso'){
    $usuario = array($respGet[user], $respGet[mesAnoInicial], $respGet[mesAnoFinal]);
    $acessos = getRest('userlogws/getGraficoAcessosUsuario',$usuario);
}
$mesAnoInicial =dataBr($respGet[mesAnoInicial]);
$mesAnoFinal =dataBr($respGet[mesAnoFinal]);
?>
<h1>
    Gerar 
    <small>Gráficos </small>
    <br><br>
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Folha Online</a></li>
    <li class="active">Carregar Variáveis</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Filtrar por Tipo de Acesso</label> <sup><div id="lotacao" class="hide">!</div></sup>
                        <div class="form-group">
                            <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#graficoAcesso">
                                <i class="fa fa-calendar"></i> Redefinir Período
                            </button>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
            <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs pull-right">
                          <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                          <li class="pull-left header"><i class="fa fa-inbox"></i> Acompanhamento de Acessos de <?=$mesAnoInicial?> à <?=$mesAnoFinal?></li>
                        </ul>
                        <div class="tab-content no-padding">
                          <!-- Morris chart - Sales -->
                          <div class="chart tab-pane active" id="myfirstchart" style="position: relative; height: 300px;"></div>
                          <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                        </div>
                    </div>
                        <!-- /.nav-tabs-custom -->
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
<?php   if((count($ponto) < 32)and((count($ponto) > 0))){?>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Marcações por período</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">Dia</th>
                  <th>Marcação 01</th>
                  <th>Marcação 02</th>
                  <th>Marcação 03</th>
                  <th>Marcação 04</th>
                  <th>Marcação 05</th>
                  <th>Marcação 06</th>
                  <th>Marcação 07</th>
                  <th>Marcação 08</th>
                  <th>Marcação 09</th>
                  <th>Marcação 10</th>
                </tr>
                <?php 
                    foreach ($ponto as $p){
                        $databr = dataBr($p[data]);
                        if($databr != $databrAtual){
                            if($cont >= 1){
                                $cont = 10 - $cont;
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
                    $cont = 10 - $cont;
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
    <section>
<?php
}
    if($acessos[0][flag] == 'Mes'){
        $morris = 'Bar';
    }else{
        $morris = 'Line';
    }
?>
<!-- Morris.js charts -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
    new Morris.<?=$morris?>({
            element: 'myfirstchart',
            data: [
                    <?php
                    foreach ($acessos as $value) {
                        echo "{ x: '$value[xPeriodo]', y: $value[yQuantidade]},";
                    }
                    ?>
            ],
            
            xkey: 'x',
            ykeys: 'y',

            labels: ['Quantidade'],
            <?php if($acessos[0][flag] == 'Dia'){ ?>
                        xLabelFormat: function (x) {
                                                    return x.getDate();
                                                }
            <?php }?>

            });
    </script>
</div>
