<?php
modalComp('empenhoSintetico', 'Empenho  Sintético', 'print', 'info', 'empenhoSinteticoMacprev','','contabil','macprev');
modalComp('empenhoAnalitico', 'Empenho  Analítico', 'print', 'info', 'empenhoAnaliticoMacprev','','contabil','macprev');
modalComp('ddoSintetico', 'DDO  Sintético', 'print', 'info', 'ddoSinteticoMacprev','','contabil','macprev');
modalComp('ddoAnalitico', 'DDO  Analítico', 'print', 'info', 'ddoAnaliticoMacprev','','contabil','macprev');
modalInicio('exportMACPREV', 'Exportar dados MACPREV', 'print', 'info', 'exportarMacprevNsd','','contabil','macprev');
?>
<h1>
    Gerar
    <small>Dados para o Instituto de Previdência dos Servidores do Município de Macaé</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Contábil</a></li>
    <li class="active">MACAEPREV</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="exampleInputEmail1">Relatórios</label>
                        <div class="form-group">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#empenhoSintetico">
                                <i class="fa fa-print"></i><b> Empenho  Sintético</b>
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#empenhoAnalitico">
                                <i class="fa fa-print"></i><b> Empenho  Analítico</b>
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ddoSintetico">
                                <i class="fa fa-print"></i><b> DDO  Sintético</b>
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ddoAnalitico">
                                <i class="fa fa-print"></i><b> DDO  Analítico</b>
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exportMACPREV">
                                <i class="fa fa-download"></i><b> Exportar</b>
                            </button>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
