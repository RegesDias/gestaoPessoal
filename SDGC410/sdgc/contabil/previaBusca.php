<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    if ($respGet['acao'] == "buscar") {
        $_SESSION["buscaReferencia"] =  array(
                        'dataPrevia'=>$respGet['dataPrevia'],
                        'lotacaoPrevia'=>$respGet['lotacaoPrevia']
        );
        $cBusc = array(
                'anoMes'=>$respGet['dataPrevia'].'-01',
                'secretaria'=>$respGet['lotacaoPrevia'],
              );
        $lista= getRest('previaWs/getListFolhaPrevia',$cBusc);
        session_start();
        $_SESSION["lista"] = $lista;
        $_SESSION["totalLista"] = count($_SESSION["lista"]);
        if(!isset($msnTexto)){
            $msnTexto = "ao Buscar. <br>Total de ".$_SESSION["totalLista"]." encontrado(s)";
        }
        $totalBusca = count($lista);
            if ($totalBusca == 0) {
                $exec['info'] = 400;
            }else{
                $exec['info'] = 200;
            }
    }
//ordenar
    $campo = $respGet['orby'];
    $sinal = 'up';
    $return = ordernarPor($_SESSION['lista'], $respGet);
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
//Auto complete
    autoComplete($_SESSION["nomePessoas"],'#compNome','1');
//    echo"<pre>";
//    print_r($lista);
//    echo"</pre>";
    
if ($_SESSION["totalLista"] >= 1){?>
<div class="row">
    <div class="box-body">
        <div class="box">
            
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <?php exibePag($hrefPag, $respGet, $return); ?>
            </ul>
        </div>
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity"> <?php
                        foreach ($return['pgExb'] as $valor) {
                            $dataCompleta= $valor[1];
                            $valor[1]= dataBr($valor[1]);
                            $valor[1] = substr($valor[1], 3);
                            if($respGet['pg'] ==''){
                                $pg=1;
                            }else{
                                $pg=$respGet['pg'];
                            }
                            $vaiPerfil = "acao=buscar&pst=$pst&arq=$arq&id=$valor[2]&pg=$pg";?>
                            <!-- TO DO List -->
                            <div class="box box-primary">
                              <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                   <h3 class="box-title">Prévia da Folha de Pagamento</h3>
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                                <ul class="todo-list">
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Referência:</span> <?=$valor[1]?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Secretaria:</span> <?=$valor[2]?>
                                  </li>
                              </div>
                              <!-- /.box-body -->
                              <div class="box-footer clearfix no-border">
                                    <button type="button" onclick="gerarRelPrevia('getRelRevia','<?=$dataCompleta?>', '<?=$valor[0]?>', false)" class='btn btn-default pull-right' value="Voltar">
                                        <img src="img/imprimir.png">
                                    </button>
                                    <button type="button" onclick="gerarRelPrevia('getRelRevia','<?=$dataCompleta?>', '<?=$valor[0]?>', true)" class='btn btn-default pull-right' value="Voltar">
                                        <img src="img/imprimir_ponto.png">
                                    </button>
                                    <button id="idBtnExportarXlsPreviaFolha" type="button" class='btn btn-default pull-right' value="Voltar">
                                        <img width="50" height="50" src="img/xls_icon.svg">
                                    </button>
                                
                              </div>
                            </div><?php
                                $meAnoInicial = $dataCompleta;
                                $idSecretaria = $valor[0];
                            }?>
                         </div>
                    </div>
                </div>
            </div>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <?php exibePag($hrefPag, $respGet, $return); ?>
            </ul>
        </div>
        </div>
    </div>
</div>
<?php }

    $dados = array('acao','mesAnoInicial','idSecretaria', 'ver');
    postRestAjax('gerarRelPrevia','imprimir','print/info.php',$dados);

?>

 <?php
    //Obtem a URL do exel
    $tipo = "xls";
    $data = $meAnoInicial;
    $idLotacao = $idSecretaria;
    $cBusc = array($idLotacao, $data, $tipo);
    $lista = getRest('relatorio/getRelFolhaPrevia',$cBusc);
    //$btnExportarCSV = true;
    //$btnExportar = true;
    $_SESSION['listaUrl'] = $lista;
    
    //Obtem o base64 do XLS
    $url = $_SESSION['listaUrl']['url'];
    $arrFrom = array(".html?");
    $arrTo = array(".xls?");
    $url = str_replace($arrFrom, $arrTo, $url);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $data = curl_exec($curl);
    $base64Data = base64_encode($data);
    curl_close($curl);
    
    session_start();
?>

<script>
    $('#idBtnExportarXlsPreviaFolha').click(function (e) {
        //defineFormato('xls');
        
        
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel;base64';
        //var table_div = document.getElementById('dvData');
        var table_html = '<?=$base64Data?>';
        a.href = data_type + ',' + table_html;
        a.download = 'Relatorio.xls';
        a.click();
        e.preventDefault();
        

    });
</script>