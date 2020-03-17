<h1>
    Relatório
    <small>Total de servidores por secretaria</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Relatórios</a></li>
    <li>Gestão</li>
    <li class="active">Total de servidores</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form action="index.php" method="<?=$method?>" name="formTemplate">
                <?php if($btnSoComissionados == true){ ?>
                    <div class="col-md-12">
                        <label>Exibir</label>
                        <div class="form-group">
                          <label>
                            <input type="radio" name="exibicao" value ='todos' class="flat-red" checked>
                             Todos
                          </label>
                          <label>
                            <input type="radio" name="exibicao" value ='so_comissionado' class="flat-red">
                             Só Comissionado
                          </label>
                        </div>                        
                    </div>
                <?php }?>
                <div id="carregaLot"> 
                <?php require_once 'boxSecretaria.php'; ?>
                </div>
                <div class="box-footer pull-right">
                    <input type="hidden" name="pg" value="1"/>
                    <input type="hidden" name="pst" value="print"/>
                    <input type="hidden" name="arq" value="info"/>
                    <input type="hidden" name="varq" value="secretariasComTotalServidores"/>
                    <input type="hidden" name="vpst" value="relat"/>
                    <input type="hidden" name="relat" value="SecretariasComTotalServidores"/>
                    <input type="hidden" name="acao" value="SecretariasComTotalServidores"/>
                    <button type="submit" class="btn btn-default">Gerar</button>
                </div>
                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
</div>