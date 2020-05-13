<?php
foreach ($respData as $data) {
    if ($data[id] == 300){
         $dataPeriodoFolha = $data[dataFrequencia];
         break;
    }
}
//echo "Data: ".$dataPeriodoFolha;
$_SESSION['dataPeriodoFolha'] = $dataPeriodoFolha;
?>
<div class="tab-pane <?= tabId('variaveis', $respGet['tab']) ?>" id="variaveis">
    <div class="post clearfix">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
                        <form action="index.php" method="<?=$method?>" class="inline">
                                <input type="hidden" name="pst" value="print"/>
                                <input type="hidden" name="arq" value="info"/>
                                <input type="hidden" name="varq" value="perfil"/>
                                <input type="hidden" name="vpst" value="funcional"/>
                                <input type="hidden" name="vtab" value="variaveis"/>
                                <input type="hidden" name="relat" value="VariaveisLancamentos"/>
                                <input type="hidden" name="acao" value="VariaveisLancamentos"/>
                                <input type="hidden" name="idhistfunc" value="<?=$_SESSION['funcionalBusca']['id']?>"/>
                                <input type="hidden" name="periodofolha" value="<?=$_SESSION['dataPeriodoFolha']?>"/>
                                <input type="hidden" name="pg" value="1"/>
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-print"></i><b> Lançamentos</b>
                                </button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>
        <div>
        <form action="index.php" method="<?=$method?>">
            <div class="box">
                <div class="box-body">
                    <?php require_once 'lancaVariaveisLote.php'; ?>
                    <input type="hidden" name="tab" value="variaveis">
                    <input type="hidden" name="acao" value="lancarVariaveis">
                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                    <button <?=$inativo?> type="submit" class="btn btn-info pull-right  btn-sm"><i class="fa fa-edit"></i> Lançar</button>
                </div>
            </div>
        </form>

        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title" id="idLancamentos">Lançamentos</h3>
            <div class="box-body">
                
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Item</th>
                    <th>Status</th>
                    <th>Quantidade/Valor</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                      foreach($_SESSION["variaveisLancadas"] as $VL){
                        $lable = statusVariaveis($VL[status]);
                        if($VL[quantidade] == 0){$VL[quantidade] = ' - ';}
                        ?>
                        <tr>
                          <td><?=$VL[item]?></td>
                          <td><span class="<?=$lable?>"><?=$VL[status]?></span></td>
                          <td>
                            <div class="sparkbar" data-color="#00a65a" data-height="20"><?=$VL[quantidade]?></div>
                          </td>
                          <td>
                            <?php if($VL[status] == 'Lançado'){?>
                                <form action="index.php" method="<?=$method?>" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="tab" value="variaveis"/>
                                    <input type="hidden" name="pg" value="1"/>
                                    <input type="hidden" name="idVariavel" value="<?=$VL[id]?>"/>
                                    <input type="hidden" name="acao" value="variavelRemover"/>
                                    <button type="submit" class="btn btn-box-tool">
                                        <span class="label label-default"><i class="fa fa-times"></i></span>
                                    </button>
                                </form>                    
                            <?php }else{?>
                                <button type="button" class="btn btn-box-tool" disabled="disabled"><i class="fa fa-ban"></i></button>
                            <?php }?>
                           </td>
                        </tr>
                      <?php }?>
                  </tr>
                  </tbody> 
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
          </div></div></div>
          <!-- /.box -->          
            </div>
            <!-- /.post -->
        </div>
<?php 
require_once 'javascript/fLancaVariaveisLote.php';
?>