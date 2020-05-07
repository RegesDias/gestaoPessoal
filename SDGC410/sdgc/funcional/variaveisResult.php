<?php
    session_start();
    require_once '../func/fPhp.php';
    ////VARIAVEL------------------>
    if ($respGet['acao'] == "variavelRemover") {
            $variavel = array('idVariavel'=>$respGet['idVariavel']);
            $v = array($variavel);
            $executar = postRest('variaveis/postVariaveisExcluir',$v);
            $msnTexto = "ao alterar status para Cancelado.";
            $vPerfil = array('idFuncional' => $_SESSION["funcionalBusca"]['id']);
            $variaveisLancadas = getRest('variaveis/getListaVariaveisFuncionalPorId',$vPerfil);
            $_SESSION["variaveisLancadas"] = $variaveisLancadas;
    }
    if ($_SESSION["funcionalPerfil"] == '') {
        $ocorrenciaDesc = getRest('funcionalws/getListaOcorrenciaDesc');
    } else {
        $setoresAtivos = $_SESSION["funcionalPerfil"]["setoresAtivos"];
        $ocorrenciaDesc = $_SESSION["funcionalPerfil"]["ocorrenciaDesc"];
    }
    $variavelDesc = getRest('funcionalws/getListaOcorrenciaDesc');
    $respGet = dataHora24($respGet);
    if ($respGet['acao'] == "lancarVariaveis") {
        if($_SESSION["funcionalBusca"] == ''){
            $arrayJson2D= postJson2D($respGet['to'],'idFunc');
        }else{
            $to = array($_SESSION["funcionalBusca"]["id"]);
            $arrayJson2D= postJson2D($to,'idFunc');
        }
        if($respGet['diasOco'] == ''){
            $respGet['diasOco'] = '0';
        }
        if (count($arrayJson2D) == 0){
            $to = array('0000000000');
            $arrayJson2D = postJson2D($to ,'idFunc');
        }
        if($respGet['idQuantidadeVL']==''){$respGet['idQuantidadeVL']=0;}
        if($respGet['idValorVL']==''){$respGet['idValorVL']=0;}
        if(($respGet['idVariaveisDescVL'])<1){$respGet['idVariaveisDescVL']=0;}
        $lancarVariaveis = array(      
                                'idFuncs' => $arrayJson2D,
                                'idVariaveisDesc' => $respGet['idVariaveisDescVL'],
                                'idLotacaoSub' => $respGet['idSetorVL'],
                                'quantidade' => $respGet['idQuantidadeVL'],
                                'valor' => $respGet['valor']
                            );
        $LV = array($lancarVariaveis);
        $executar = postRest('variaveis/postVariaveisIncluirEmLote',$LV);
        $msnTexto = "ao lançar Variável. ".$executar['msn'].".";
        exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
        //buscaVariaveis
        $vPerfil = array('idFuncional' =>$_SESSION["funcionalBusca"]['id']);
        $variaveisLancadas = getRest('variaveis/getListaVariaveisFuncionalPorId',$vPerfil);
        $_SESSION["variaveisLancadas"] = $variaveisLancadas;
    }
?>
<div class="box box-info">
    

    
    <div class="box-header with-border">
      <h3 class="box-title">Lançamentos</h3>
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
                        <form>   
                            <button onclick="removeVariavel('variavelRemover', '<?=$VL[id]?>')" type="button" class="btn btn-box-tool">
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
  </div>
</div>

<script>
//Script para limpar os campos de lançamento de variaveis
//EXECUTA DEPOIS QUE CARREGA A PAGINA
$(document).ready(function () {
    //Fazer depois
});
</script>
<?php
    //incluirVariaveis

    $s1 = array('idBoxImprimir','addClass','hidden');
    $success= array ($s1);
    $dados = array('acao', 'idVariavel');
    //$dados = array('acao', 'idAvaliacao');
    postRestAjax('removeVariavel','buscaVariaveis','funcional/variaveisResult.php',$dados,'',$success);

?>