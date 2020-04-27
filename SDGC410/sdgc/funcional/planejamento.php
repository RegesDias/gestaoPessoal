
<div class="tab-pane <?= tabId('planejamento', $respGet['tab']) ?>" id="planejamento">
<?php
    foreach ($_SESSION["funcionalPerfil"]['permissoes'] as $valor) {
        if (($valor['pasta'] == 'funcional') AND ($valor['arquivo'] == 'planejamento')){ 
             $prmPlanejamento = $valor;
              break;
        }
    }
?>



    <div class="post clearfix">
        <div class="<?=permissaoAcesso($prmPlanejamento["incluir"],'hide')?> box box-primary">
    
                 <div class="box-header">
                   <h3 class="box-title">Lançar Planejamento</h3>
                 </div>
            <div class="box-body">

                <form action="index.php" method="<?=$method?>" class="form-horizontal" >
                    <div class="col-md-12">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Local da Planejamento</label>
                            <select <?=$inativo?> name="setorPlan" <?php if($lote){ ?> onchange="loadList(this.value)" <?php }?> size="1" class="form-control select2" id='idSetorPlan' style="width: 100%;">
                                  <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp){?>
                                          <option value="<?=$ArrEsp['idSetor']?>"><?=$ArrEsp['nome']?></option>
                                   <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group margin-bottom-none">
                        <div class="col-sm-9">
                            <label for="exampleInputEmail1">Tipo Planejamento</label>
                            <select <?=$inativo?> name='idTpPlan'id='idTpPlan' class="form-control select2" style="width: 100%;">
                              <?php foreach ($_SESSION["planejamentoPerfil"] as $ArrEspPlan){
                                  ?>
                                <option value="<?=$ArrEspPlan['id']?>"><?=$ArrEspPlan['nome']?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="exampleInputEmail1"></label>
                            <div class="form-group">
                                <div class="input-group ">
                                    <input <?=$inativo?> type="checkbox" name='pontoFacult' id='idpontoFacult'>Ponto Facultativo
                                </div>
                                <div class="input-group ">
                                    <input <?=$inativo?> type="checkbox" name='feriado' id='idFeriado'>Feriado
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Dia</label>
                                    <select id='idDiaSemana' name="diaSemana" <?=$inativo?> class="form-control select2" id="instrumento" style="width: 100%;">
                                        <option value="1">Domingo</option>
                                        <option value="2">Segunda</option>
                                        <option value="3">Terça</option>
                                        <option value="4">Quarta</option>
                                        <option value="5">Quinta</option>
                                        <option value="6">Sexta</option>
                                        <option value="7">Sábado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Inicial</label>
                                    <div class="input-group ">
                                        <input <?=$inativo?> type="text" name='hInicial' id='idhInicial'  class="form-control timepicker">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Final</label>
                                    <div class="input-group ">
                                        <input <?=$inativo?> type="text" name='hFinal' id='idhFinal' class="form-control timepicker">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                         <button <?=$inativo?>  class="btn btn-success pull-right  btn-sm" onclick="postLancarPlanejamento('lancarPlanejamento', $('#idDiaSemana').val(), $('#idhInicial').val(), $('#idhFinal').val(), $('#idTpPlan').val(), $('#idSetorPlan').val(), $('#idFeriado').is(':checked'), $('#idpontoFacult').is(':checked'))" type="button">
                                <i class="fa fa-edit"></i> Lançar
                         </button>
                    </div>

                </form>
            </div>
            <!-- /.post -->
        </div>
        <div id="buscaPlanejamento">
            
        </div>

    </div>
</div>
<?php
    //lancar

    $s1 = array('idBoxImprimir','addClass','hidden');
    $success= array ($s1);
    $funcao = array('buscaPlanejamento');
    $dados = array('acao','diaSemana','hInicial','hFinal','tipoPlan','setorPlan','feriado','pontoFacult');
    postRestAjax('postLancarPlanejamento','buscaPlanejamento','funcional/planejamentoResult.php',$dados,'',$success);
    
    
    //exibir
    $s1 = array('idBoxImprimir','addClass','hidden');
    $success= array ($s1);
    postRestAjax('buscaPlanejamento','buscaPlanejamento','funcional/planejamentoResult.php',$dados,'',$success);


?>
