<?php
//declare(strict_types=1)
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
//acesso
    $buscAcessoNivel = array("4");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'BuscaPrevia') AND ($valor['buscar'] == '1')){ 
             $btnBuscaPrevia = true;
             break;
        }
    }
//configuração
    $pst = 'contabil';
    $arq = 'previa';
    $n0 = 'id';             $c0 = $respGet['id'];
    $n1 = 'nome';           $c1 = $respGet['nome'];
    $n2 = 'matricula';      $c2 = $respGet['matricula'];
    $n3 = 'cpf';            $c3 = $respGet['cpf'];
    $cBusc = array($c1,$c2,$c3);
    $cData = array($n0 => $c0, $n1 => $c1, $n2 => $c2);
    $cExcl = array($n0 => $c0);
    $rest = ucfirst($arq);
//paginacao
    $hrefPag= array(
                "<input type='hidden' name='pst' value ='".$pst."'/>",
                "'arq' value='".$arq."'/>",
                "'orby' value='".$respGet['orby']."'/>",
                "'dir' value='".$respGet['dir']."'/>",
                "'$n1' value='".$c1."'/>",
                "'$n2' value='".$c2."'/>"
    );
    session_start();
    $_SESSION["lotacao"] = getRest('lotacao/getListLotacaoUsuarioFolhaPrevia');
if($respGet['modal'] == 'exportAcomOrcamentario'){?>
    <script>
        jQuery(document).ready(function(){
            $('#exportAcomOrcamentario').modal('show');
        });
    </script>
<?php
    $respGet['mesAnoInicial'] = mesAno($respGet['mesAnoInicial']);
    $respGet['mesAnoFinal'] = mesAno($respGet['mesAnoFinal']);
    $cBusc = array($respGet['mesAnoInicial'],$respGet['mesAnoFinal']);
    $competencia = getRest('nsdFolhaPrevia/getListaPrevia',$cBusc);
}
    $dataFolhaPrevia = getRest('dataFrequenciaWs/getListaFolhaPreviaDataAtivas');
?>
<h1>
    Gerar 
    <small>Prévia da Folha de Pagamento</small>
    <br><br>
</h1>

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Contábil</a></li>
    <li class="active">Prévia</li>
</ol>
<?php
 $key = array_search($_SESSION["buscaReferencia"]["lotacaoPrevia"], array_column($_SESSION["lotacao"], 'id'));
if($btnBuscaPrevia == true){ ?>
    <div class="row">
            <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="exampleInputEmail1">Buscar Prévia</label>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <script>
                                                    var isFirefox = typeof InstallTrigger !== 'undefined';
                                                    if(isFirefox){
                                                        alert("Prefira utilizar o navegador Google Chrome");
                                                    }
                                                </script>
                                                <label for="exampleInputEmail1">Referência</label>
                                                <select id="idDataPrevia" class="form-control select2" name='dataPrevia' style="width: 100%;">
                                                    <?php foreach ($dataFolhaPrevia as $ArrEsp){
                                                        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                        date_default_timezone_set('America/Sao_Paulo');  
                                                        $mes = strftime('%B', strtotime($ArrEsp['data']));
                                                        $ano = date('Y', strtotime($ArrEsp['data']));
                                                        $data = $ano.' / '.$mes;
                                                        $rest = substr($ArrEsp['data'], 0, -3);
                                                    ?>
                                                    <option selected="selected" value="<?=$rest?>"><?=$data?></option>
                                                    <?php } ?>
                                                </select>
                                                <!--<input id="referenciaID" name="dataPrevia" class="form-control" type="month" max="<?= date('Y-m') ?>" value="<?=$_SESSION["buscaReferencia"]["dataPrevia"]?>">-->
                                            </div>
                                            <?php
                                                setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                date_default_timezone_set('America/Sao_Paulo');  
                                                $data = strftime('%B', strtotime($ArrEsp['data']));
                                            ?>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Secretaria</label>
                                                <select id="idLotacaoPrevia" name='lotacaoPrevia' class="form-control select2" style="width: 100%;">
                                                    <?php     
                                                        if(count ($_SESSION["lotacao"])>=40){ 
                                                            if(isset ($_SESSION["buscaReferencia"]["lotacaoPrevia"])){?>
                                                                <option selected="selected" value='<?=$_SESSION["buscaReferencia"]["lotacaoPrevia"]?>'> <?=$_SESSION["lotacao"][$key]['nome']?> </option><?php 

                                                            }else{ 
                                                                ?><option selected="selected" value=''> ------- </option><?php
                                                            }
                                                        }
                                                    
                                                    ?>
                                                    <?php foreach ($_SESSION["lotacao"] as $ArrEsp){?>
                                                        <option value='<?=$ArrEsp[id]?>'><?=$ArrEsp[nome]?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer pull-right">
                            <input type="hidden" name="acao" value="buscar" />
                            <button type="button" onclick="buscarPrevia('buscar', $('#idDataPrevia').val(), $('#idLotacaoPrevia').val())" class="btn btn-default">Buscar</button>
                        </div>
                    </form>
                    <!--Fim do formulario-->
                    <!--Tabela que mostra valores buscados-->
                </div>
            </div>
        </div>
    </div>
  
    <div id="previaBusca">
        
    </div>
<?php }
    $dados = array('acao', 'dataPrevia','lotacaoPrevia');
    postRestAjax('buscarPrevia','previaBusca','contabil/previaBusca.php', $dados);  

?>