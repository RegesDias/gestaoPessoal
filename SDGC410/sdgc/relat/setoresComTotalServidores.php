<h1>
    Relatório
    <small>Setores com total de servidores</small>
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
            <div class="box-header with-border">
                <div class="col-md-12">
                    <h3 class="box-title">Selecionar Secretaria</h3>          
                </div>
            </div>
            <div class="box-body">
                <form action="index.php" method="<?= $method ?>" name="formTemplate">
                    <div id="carregaLot"> 
                        <?php require_once 'boxSecretaria.php'; ?>
                    </div>
                    <div class="box-footer pull-right">
                        <input type="hidden" name="pg" value="1"/>
                        <input type="hidden" name="pst" value="print"/>
                        <input type="hidden" name="arq" value="info"/>
                        <input type="hidden" name="varq" value="setoresComTotalServidores"/>
                        <input type="hidden" name="vpst" value="relat"/>
                        <input type="hidden" name="relat" value="SetoresComTotalServidores"/>
                        <input type="hidden" name="acao" value="SetoresComTotalServidores"/>
                        <button type="submit" class="btn btn-default">Gerar</button>
                    </div>
                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
</div>