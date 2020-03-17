<?php 
    session_start();
    require_once '../func/fPhp.php';
    
//buscar
    if ($respGet['acao'] == "buscar") {
        $cBusc = array(
                'nome'=>$respGet['nome'],
                'dataPublicacao'=>$respGet['dataPublicacao']
              );
        $lista= getRest('portariaWs/getListaPortaria',$cBusc);
        //session_start();
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
    
    if(($respGet['acao'] == 'exibeServidores')){
        $cBusc = array(
            'id_portaria'=>$respGet['id_portaria']
        );
        $lista= getRest('portariaWs/getListaPortariaRelacao',$cBusc);
    }
//msn
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$exec);
//TESTE
if (($_SESSION["totalLista"] >= 1)AND($respGet['acao'] != 'exibeServidores')){?>

<div class="row">
    <div class="box-body">
        <div class="box">
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                                       <?=controleDePagina($_SESSION[lista] ,$respGet[pg],"pagUpDown","buscaResult");?> 
            </ul>
        </div>
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity"> 
                       <?php foreach (paginaAtual($_SESSION[lista],$respGet[pg]) as $valor) {?>
                            <!-- TO DO List -->
                            <div class="box box-primary">
                              <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                   <h3 class="box-title"><?=$valor['nome']?></h3>
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                                <ul class="todo-list">
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Data Publicação:</span> <?=dataBr($valor['dataPublicacao'])?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Data de início da portaria:</span> <?=dataBr($valor['dataInicio'])?>
                                  </li>
                                  <li>
                                    <!-- todo text -->
                                    <span class="text">Data de seção da portaria:</span> <?=dataBr($valor['dataFim'])?>
                                  </li>
                              </div>
                              <!-- /.box-body -->
                              <div class="box-footer clearfix no-border">
                                    <button class="btn btn-default pull-right" onclick="relatorioEmPortariaUser('exibePortaria','<?=$valor['nome']?>',true)" type="button">
                                         <img src="img/imprimir_ponto.png">
                                    </button>
                                    <button class="btn btn-default pull-right" onclick="relatorioEmPortariaIm('exibeServidores','<?=$valor['nome']?>','<?=$valor['id']?>')" type="button">
                                         <img src="img/historico.png">
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
                <?php exibePag($hrefPag, $respGet, $return); ?>
            </ul>
        </div>
        </div>
    </div>
</div>
<?php }else if(($respGet['acao'] == 'exibeServidores')){
    
    ?>
<div class="row">
    <div class="box-body">
        <div class="box">
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity"> 
                            <!-- TO DO List -->
                            <div class="box box-primary">
                              <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                   <h3 class="box-title"><?=$respGet['nome']?></h3>
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                                <ul class="pagination pagination-sm no-margin">
                                    <?php exibePag($hrefPag, $respGet, $return); ?>
                                </ul>
                                <ul class="todo-list">
                                    <?php foreach ($lista as $valor) {?>
                                    <li>
                                    <button class="link-button" onclick="buscarServidor('buscar','<?=$valor['matricula']?>')" type="button">
                                         <span class="text"><?=$valor['matricula']?></span> <?=$valor['nome']?>
                                    </button>
                                    </li>
                                   <?php }?>
                                </ul>
                              </div>
                              <!-- /.box-body -->
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}?>
