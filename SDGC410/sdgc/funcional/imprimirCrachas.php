<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    autoComplete($_SESSION["nomePessoas"], '#nome', '1');
    $pst = 'funcional';
    $arq = 'imprimirCrachas';
    $lote = true;
    $_SESSION["funcionalPerfil"] = '';
    $_SESSION["funcionalBusca"] = '';
    if ($respGet['acao'] == "crachaImpresso") {
            $crachaDados = array('id'=>$respGet['idCrachaRequisicao']);
            $c = array($crachaDados);
            $executar = postRest('cracha/postCrachaImpresso',$c);
            $msnTexto = "ao alterar status para impresso.";
    }
    if ($respGet['acao'] == "crachaCancelado") {
            $crachaDados = array('id'=>$respGet['idCrachaRequisicao']);
            $c = array($crachaDados);
            $executar = postRest('cracha/postCrachaNegado',$c);
            $msnTexto = "ao alterar status para Cancelado.";
    }    
    $cracharequisicao = getRest('cracha/getListaCrachaEnviado');
    $total = count($cracharequisicao);
    $crachaTipo = getRest('cracha/getListaCrachaTipo');
    $buscAcessoNivel = array("8");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'CrachaAdministrar') AND ($valor['buscar'] == '1')){ 
             $crachaAdm = true;
             break;
        }
    }
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?>
<h1>
    Lançar
    <small>Variáveis em lote</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li class="active">Imprimir Crachás</li>
</ol>
<section class="content">
        <div class="box box-primary">
            
             <div class="overlay hidden" id="idSpinLoaderImprimeParaEntrega">
                        <i class="fa fa-refresh fa-spin"></i>
             </div>
            
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
                            <form>    
                                <button onclick="relatorioParaEntrega('crachaImpressos', true)" type="button" class="btn btn-info"><i class="fa fa-print"></i>
                                    <b> Para entrega </b>
                                </button>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>
        <div class="box-body">
            <div class="form-horizontal">
                <div class="col-md-12">
                    <div class="form-group">
                        <div id="cracha" >

                        </div>              
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
                <div class="box-body">
              <!-- USERS LIST -->
              <div class="box box-danger">
                  
                  <div class="overlay hidden" id="idSpinLoaderImprimeCracha">
                        <i class="fa fa-refresh fa-spin"></i>
                  </div>
                  
                <div class="box-header with-border">
                  <h3 class="box-title">Pedidos de Impressão de crachas</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger"><?=$total?> Pedidos</span>
                    <button type="button" class="btn btn-box-tool"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                                
                  <ul class="users-list clearfix">
                      <?php
                      foreach ($cracharequisicao as $cr){  
                            $dataHora = dataHoraBr ($cr[dataHora]);
                            $status =  $cr[status];
                            $idCrachaRequisicao =  $cr[id];
                            $nome = $cr[funcional][pessoa][nome];
                            $cpf = $cr[funcional][pessoa][cpf];
                            $idHistFunc = $cr[funcional][id];
                            //modalEnviaSetorInicioCracha('modalEnviaSetorInicioCracha'.$idCrachaRequisicao, 'Requisitar Crachá', 'funcional', 'imprimirCrachas', 'folhapontoInicio', 'funcional', 'imprimirCrachas','',$cr, $crachaAdm);
                            ?>
                            <li>
                                <button type="button" class="profile-user-img img-responsive img-bordered-sm" onclick="buscaCracha('abrir', '<?=$idHistFunc?>','<?=$crachaAdm?>','<?=$nome?>')">
                                    <img src="<?=exibeFoto($cpf)?>" width="128" height="128" class="profile-user-img img-responsive img-bordered-sm" alt="Imagem do Usuário">
                                </button>
<!--                                <a type="button" data-toggle="modal" data-target="<?='#modalEnviaSetorInicioCracha'.$idCrachaRequisicao?>">
                                    <img src="<?=exibeFoto($cpf)?>" width="128" height="128" class="profile-user-img img-responsive img-bordered-sm" alt="Imagem do Usuário">
                                </a>-->
                                <a class="users-list-name" href="#"><?=$nome?></a>
                                  <span class="users-list-date"><?=$dataHora?></span>
                            </li>
                    <?php }?>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
<!--                  <a href="javascript:void(0)" class="uppercase">View All Users</a>-->
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
         </div>
    </div>
</section>
<?php
            //buscaCracha
            $be = array('idSpinLoaderImprimeCracha','removeClass','hidden');
            $beforeSend= array ($be);
            $s2 = array('idSpinLoaderImprimeCracha','addClass','hidden');
            $s1 = array('cracha','removeClass','hidden');
            $success= array ($s1,$s2);
            $dados = array('acao', 'idHistFunc','crachaAdm');
            postRestAjax('buscaCracha','cracha','funcional/cracha.php',$dados, $beforeSend,  $success);
            
            //postEmCrachaIncluir
            $be = array('idSpinLoaderBoxCracha','removeClass','hidden');
            $s = array('idSpinLoaderBoxCracha','addClass','hidden');
            $beforeSend= array ($be);
            $success= array ($s);      
            $dados = array('acao','idHistFunc','idCrachaTipo','crachaAdm');
            postRestAjax('postEmCrachaIncluir','cracha','funcional/cracha.php',$dados,$beforeSend,$success);
            
            //postEmCrachaStatus
            $be = array('idSpinLoaderBoxCracha','removeClass','hidden');
            $s = array('idSpinLoaderBoxCracha','addClass','hidden');
            $beforeSend= array ($be);
            $success= array ($s);      
            $dados = array('acao','idCrachaRequisicao', 'idHistFunc','crachaAdm');
            postRestAjax('postEmCrachaStatus','cracha','funcional/cracha.php',$dados,$beforeSend,$success);
            
            
            //postEmCrachaPrint
            $be = array('idSpinLoaderBoxCracha','removeClass','hidden');
            $s = array('idSpinLoaderBoxCracha','addClass','hidden');
            $beforeSend= array ($be);
            $success= array ($s);            
            $dados = array('acao','idCrachaTipo','nome', 'cpf','matricula','crachaAdm','idImagem', 'ver');
            postRestAjax('relatorioEmCracha','imprimir','print/info.php',$dados,$beforeSend,$success); 
            
            //postEmCrachaPrint
            $be = array('idSpinLoaderImprimeParaEntrega','removeClass','hidden');
            $s = array('idSpinLoaderImprimeParaEntrega','addClass','hidden');
            $beforeSend= array ($be);
            $success= array ($s);            
            $dados = array('acao','ver');
            postRestAjax('relatorioParaEntrega','imprimir','print/info.php',$dados,$beforeSend,$success);     
            
            
        
?>