<?php
    $pst = 'funcional';
    $arq = 'imprimirCrachas';
    $lote = true;
    $_SESSION["funcionalPerfil"] = '';
    $_SESSION["funcionalBusca"] = '';
    if ($respGet['acao'] == "crachaImpresso") {
            $cracha = array('id'=>$respGet['idCrachaRequisicao']);
            $c = array($cracha);
            $executar = postRest('cracha/postCrachaImpresso',$c);
            $msnTexto = "ao alterar status para impresso.";
    }
    if ($respGet['acao'] == "crachaCancelado") {
            $cracha = array('id'=>$respGet['idCrachaRequisicao']);
            $c = array($cracha);
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
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
                            <form action="index.php" method="<?=$method?>" class="inline">
                                    <input type="hidden" name="vpst" value="<?=$pst?>" />
                                    <input type="hidden" name="varq" value="<?=$arq?>" />
                                    <input type="hidden" name="vtab" value="gestao" />
                                    <input type="hidden" name="pst" value="print"/>
                                    <input type="hidden" name="arq" value="info"/>
                                    <input type="hidden" name="pg" value="1"/>
                                    <input type="hidden" name="acao" value="crachaImpressos"/>
                                    <button type="submit" class="btn btn-info"><i class="fa fa-print"></i><b> Para entrega </b></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>
    <div class="row">
                <div class="box-body">
              <!-- USERS LIST -->
              <div class="box box-danger">
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
                  <ul class="users-list clearfix"><?php
                      foreach ($cracharequisicao as $cr){  
                            $dataHora = dataHoraBr ($cr[dataHora]);
                            $status =  $cr[status];
                            $idCrachaRequisicao =  $cr[id];
                            $nome = $cr[funcional][pessoa][nome];
                            $cpf = $cr[funcional][pessoa][cpf];
                            $idHistFunc = $cr[funcional][id];
                            modalEnviaSetorInicioCracha('modalEnviaSetorInicioCracha'.$idCrachaRequisicao, 'Requisitar Crachá', 'funcional', 'imprimirCrachas', 'folhapontoInicio', 'funcional', 'imprimirCrachas','',$cr, $crachaAdm);
                            ?>
                            <li>
                                <a type="button" data-toggle="modal" data-target="<?='#modalEnviaSetorInicioCracha'.$idCrachaRequisicao?>">
                                    <img src="<?=exibeFoto($cpf)?>" width="128" height="128" class="profile-user-img img-responsive img-bordered-sm" alt="Imagem do Usuário">
                                </a>
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