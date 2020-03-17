<?php
    $buscAcessoNivel = array("4");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'soComissionados') AND ($valor['buscar'] == '1')){ 
             $btnSoComissionados = true;
             break;
        }
    }
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'biometria') AND ($valor['buscar'] == '1')){ 
             $btnBiometria = true;
             break;
        }
    }
    $listaCargosGeral = getRest('cargo/getListaCargoGeralUsuario');
?>
<h1>
    Relatório
    <small>Lotados por secretaria</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Relatórios</a></li>
    <li>Gestão</li>
    <li class="active">Lotados por secretaria</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form action="index.php" method="<?=$method?>" name="formTemplate">   
                    <div class="box-body">
                        <div class="row">
                            <div>
                                <div class="col-md-12">
                                    <label>Cargo</label>
                                    <select name="idCargoGeral" size="1"  class="form-control select2" id='cargoGeralID' style="width: 100%;">
                                        <?php foreach ($listaCargosGeral as $valor) { ?>
                                        <option value="<?=$valor['id']?>"><?=$valor['nome']?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer pull-right">
                        <input type="hidden" name="pg" value="1"/>
                        <input type="hidden" name="pst" value="print"/>
                        <input type="hidden" name="arq" value="info"/>
                        <input type="hidden" name="varq" value="servidoresPorCargo"/>
                        <input type="hidden" name="vpst" value="relat"/>
                        <input type="hidden" name="relat" value="ServidoresPorCargo"/>
                        <input type="hidden" name="acao" value="ServidoresPorCargoGeral"/>
                        <button class="btn btn-danger pull-right">
                            <i class="fa fa-print"></i> Imprimir
                        </button>
                    </div>
                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
</div>
