<?php
if(($respGet['modal'] == 'consiguinadoCritica')or($respGet['modal'] == 'consiguinadoLiquidacao')){
    $respGet['mesAnoInicial'] = mesAno($respGet['mesAnoInicial']);
    $respGet['mesAnoFinal'] = mesAno($respGet['mesAnoFinal']);
    $cBusc = array($respGet['mesAnoInicial'],$respGet['mesAnoFinal']);
    $competencia = getRest('nsdWs/getListaReferenciaNsd',$cBusc);
}
if ($respGet['modal'] == 'consiguinadoCritica'){?>
    <script>
        jQuery(document).ready(function(){
            $('#consiguinadoCritica').modal('show');
        });
    </script>
<?php }
if ($respGet['modal'] == 'consiguinadoLiquidacao'){?>
    <script>
        jQuery(document).ready(function(){
            $('#consiguinadoLiquidacao').modal('show');
        });
    </script>
<?php }
modalInicoFimJavaScript('consiguinadoLiquidacao', 'Consiguinado Liquidação', 'print', 'info', 'consiguinadoLiquidacao','combo','contabil','externo');
modalInicoFimJavaScript('consiguinadoCritica', 'Consiguinado Crítica', 'print', 'info', 'consiguinadoCritica','combo','contabil','externo');
?>
<h1>
    Gerar
    <small>Dados para órgãos externos</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Contábil</a></li>
    <li class="active">Externo</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="exampleInputEmail1">Relatórios</label>
                        <div class="form-group">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#consiguinadoLiquidacao">
                                <i class="fa fa-download"></i><b> Consiguinado Liquidação</b>
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#consiguinadoCritica">
                                <i class="fa fa-download"></i><b> Consiguinado Crítica</b>
                            </button>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
