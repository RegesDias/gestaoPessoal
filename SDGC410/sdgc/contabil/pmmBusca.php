<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
     if ($respGet['acao'] == "buscar") {
        $_SESSION["buscaReferencia"] =  array(
                        'dataPrevia'=>$respGet['dataNSD'],
                        'lotacaoPrevia'=>$respGet['lotacaoNSD']
        );
        $cBusc = array(
                'mes'=>substr($respGet['dataNSD'], -2),
                'ano'=>substr($respGet['dataNSD'], 0, -3),
                'numeroNota'=>$respGet['numeroNSD'],
                'secretaria'=>$respGet['lotacaoNSD'],
              );
        $lista= getRest('nsdWs/getListaNsd',$cBusc);
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
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
?>
<div class="row">
    <div class="box-body">
        <div class="box">
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <?=controleDePagina($_SESSION[lista] ,$respGet[pg],"pagUpDown","prontuario");?> 
            </ul>
        </div>
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity"> <?php
                        foreach (paginaAtual($_SESSION["lista"],$respGet[pg]) as $valor) {
                            $valor[1] = dataBr($valor[1]);
                            $valor[1] = substr($valor[1], 3);
                            if($respGet['pg'] ==''){
                                $pg=1;
                            }else{
                                $pg=$respGet['pg'];
                            }?>
                            <!-- TO DO List -->
                            <div class="box box-primary">
                              <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                   <h3 class="box-title"><?=$valor[0]?></h3>
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                                <ul class="todo-list">
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Referência:</span> <?=$valor[1]?> <span class="text">Emissão:</span> <?=dataBr($valor[4])?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Destino:</span> <?=$valor[2]?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Origem:</span> <?=$valor[3]?>
                                  </li>
                              </div>
                              <!-- /.box-body -->
                              <div class="box-footer clearfix no-border">
                                    <button data-dismiss="modal" onclick="gerarNSD('getRelNsda', '<?=$valor[0]?>',true)" class="btn btn-default pull-right">
                                        <img src="img/nsda.png">
                                    </button>
                                    <button data-dismiss="modal" onclick="gerarNSD('getRelNsds', '<?=$valor[0]?>',true)" class="btn btn-default pull-right">
                                        <img src="img/nsds.png">
                                    </button>
                                    <button data-dismiss="modal" onclick="gerarNSD('getRelNsd', '<?=$valor[0]?>',true)" class="btn btn-default pull-right">
                                        <img src="img/nsd.png">
                                    </button>
                              </div>
                            </div><?php
                            }?>
                         </div>
                    </div>
                </div>
            </div>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <?=controleDePagina($_SESSION[lista] ,$respGet[pg],"pagUpDown","prontuario");?> 
            </ul>
        </div>
        </div>
    </div>
</div>