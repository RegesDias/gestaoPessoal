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
                            <select <?=$inativo?> name="setorPlan" <?php if($lote){ ?> onchange="loadList(this.value)" <?php }?> size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                                  <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp){?>
                                          <option value="<?=$ArrEsp['idSetor']?>"><?=$ArrEsp['nome']?></option>
                                   <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group margin-bottom-none">
                        <div class="col-sm-9">
                            <label for="exampleInputEmail1">Tipo Planejamento</label>
                            <select <?=$inativo?> name='idTpPlan'class="form-control select2" id='ocorrencia' style="width: 100%;">
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
                                    <input <?=$inativo?> type="checkbox" value ='1' name='pontoFacult'>Ponto Facultativo
                                </div>
                                <div class="input-group ">
                                    <input <?=$inativo?> type="checkbox" value ='1' name='feriado'>Feriado
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Dia</label>
                                    <select name="diaSemana" <?=$inativo?> class="form-control select2" id="instrumento" style="width: 100%;">
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
                                        <input <?=$inativo?> type="text" name='hInicial' class="form-control timepicker">
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
                                        <input <?=$inativo?> type="text" name='hFinal' class="form-control timepicker">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                        <input type="hidden" name="tab" value="planejamento">
                        <input type="hidden" name="acao" value="lancarPlanejamento">
                        <input type="hidden" name="pst" value="<?=$pst?>">
                        <input type="hidden" name="arq" value="<?=$arq?>">
                         <button <?=$inativo?> type="submit" class="btn btn-success pull-right  btn-sm"><i class="fa fa-edit"></i> Lançar</button>
                    </div>

                </form>
            </div>
            <!-- /.post -->
        </div>
        <div class="<?=permissaoAcesso($prmPlanejamento["buscar"],'hide')?> box box-primary">
            <div class="box-header">
              <h3 class="box-title">Planejamento Consolidado</h3>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="box box-solid">
                              <!-- /.box-header -->
                              <div class="box-body">
                                <div class="box-group" id="planejamento">
                                    <?php
                                    if(count ($_SESSION["planLancados"])==0){
                                        echo "O servidor não possui planejamento consolidado";
                                    }
                                    ?>
                                  <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                 <?php foreach ($_SESSION["planLancados"] as $ArrEsp) 
                                     {?>
                                    <div class="box-group" id="planejamento">
                                        <div class="panel box box-success">
                                          <div class="box-header with-border">
                                            <h4 class="box-title">
                                              <a data-toggle="collapse" data-parent="#planejamento" href="#collapse<?=$ArrEsp['idPlanejamentoAuxiliar']?>">
                                                  <i class="fa fa-sort-down"></i> Em <?=$ArrEsp['mesAno']?> todo <?=diaSemana($ArrEsp['diaSemana'])?> de <?=$ArrEsp['hInicial']?> até <?=$ArrEsp['hFinal']?>
                                              </a>
                                            </h4>
                                          </div>
                                          <div id="collapse<?=$ArrEsp['idPlanejamentoAuxiliar']?>" class="panel-collapse collapse">
                                            <div class="box-body">
                                              <b><?=$ArrEsp['nomeSetor']?></b><br>
                                              <?=$ArrEsp['planejamentoTipo']?>
                                                <form action="index.php" method="<?=$method?>"name="formTemplate" class="<?=permissaoAcesso($prmPlanejamento["excluir"],'hide')?>">
                                                   <button class="btn btn-danger pull-right espaco-direita">
                                                       <i class="fa fa-trash"></i>
                                                   </button>
                                                   <input type='hidden' name='idPlanejamentoAuxiliar' value='<?=$ArrEsp['idPlanejamentoAuxiliar']?>'>
                                                   <input type='hidden' name='cpf' value='<?=$ArrEsp['cpf']?>'>
                                                   <input type='hidden' name='tab' value='planejamento'>
                                                   <input type='hidden' name='acao' value='excluirPlanejamento'>
                                                   <input type="hidden" name="pst" value="<?=$pst?>">
                                                   <input type="hidden" name="arq" value="<?=$arq?>">
                                                   <input type="hidden" name="pg" value="1">
                                               </form>
                                                &nbsp;<input type="checkbox" disabled="disabled" <?php if($ArrEsp['feriado'] == 1){ echo 'checked'; }?>>Feriado
                                                <input type="checkbox" disabled="disabled" <?php if($ArrEsp['pontoFacult'] == 1){ echo 'checked'; }?>>Ponto Facultativo
                                            </div>
                                          </div>
                                        </div>
                                     </div>
                                  <?php } ?>
                                </div>
                              </div>
                              <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                          </div>
                          <!-- /.col -->
                    </div>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>
    </div>
</div>
