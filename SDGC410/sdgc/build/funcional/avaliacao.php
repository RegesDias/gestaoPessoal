<div class="tab-pane <?= tabId('avaliacao', $respGet['tab']) ?>" id="avaliacao">
    <div class="post clearfix">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-md-12">
                        <form action="index.php" method="<?=$method?>" class="inline">
                                <input type="hidden" name="pst" value="<?=$pst?>"/>
                                <input type="hidden" name="arq" value="<?=$arq?>"/>
                                <input type="hidden" name="tab" value="avaliacao"/>
                                <input type="hidden" name="pg" value="1"/>
                                <input type="hidden" name="acao" value="avaliacao"/>
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-print"></i><b> Nota</b>
                                </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.post -->
        </div>        
        <div class="box box-primary">
                 <div class="box-header">
                   <h3 class="box-title">Lançar Avaliação</h3>
                 </div>
            <div class="box-body">
                    <h1>Não é para janeiro</h1>
                    <div class="pull-right">
                        <form action="index.php" method="<?=$method?>" class="inline">
                            <input type="hidden" name="tab" value="avaliacao">
                            <input type="hidden" name="acao" value="savePlan">
                            <input type="hidden" name="pst" value="<?=$pst?>">
                            <input type="hidden" name="arq" value="<?=$arq?>">
                             <button type="submit" class="btn btn-success pull-right  btn-sm"><i class="fa fa-edit"></i> Lançar</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>