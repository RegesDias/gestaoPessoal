<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $pst = 'folhaOn';
    $arq = 'validarVariaveis';
    //servidor----------->---
    //Alterar Status Aprovar Variavel Servidor
    if ($respGet['acao'] == "variavelRemover") {
            $variavel = array('idVariavel'=>$respGet['idVariavel']);
            $v = array($variavel);
            $executar = postRest('variaveis/postVariaveisExcluir',$v);
            if (count($_SESSION[lotacaoSubVariavel]) == 1){
               if(($executar['info'] >= 200) AND ( $executar['info'] <= 299)) {
                    $Array = $_SESSION[servidorVariavel];
                    $p =  array_search($respGet[idVariavel], array_column($Array, 'idVariavel')).'<br />';
                    $p = intval($p);
                    unset($Array[$p]);
                    sort($Array);         
                    $_SESSION[servidorVariavel] =$Array;
                }
            }else{
                $respGet[acao]='selecionarSetor'; 
            }
            $msnTexto = "ao alterar variavel. ".$executar['msn'];
    }
    if($respGet[acao]=='aprovarVariavelServidor'){
        $v = array('id'=>$respGet[idVariavel]);
        $aVariaveis = array($v);
        $executar = postRest('variaveis/postAprovarVariaveisPorId',$aVariaveis);
        if(isset($respGet[nomeMatriculaPessoa])){
            $respGet[acao]='buscarVariavelServidor';
        }else{
            $respGet[acao]='selecionarSetor';
        }
        if($respGet[status] == 'Negado'){
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] = $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] + 1;
        }
        $msnTexto = "ao alterar variavel. ".$executar['msn'];
    }
    //Alterar Status Negar Variavel Servidor
    if($respGet[acao]=='negarVariavelServidor'){
        $v = array('id'=>$respGet[idVariavel]);
        $aVariaveis = array($v);
        $executar = postRest('variaveis/postNegarVariaveisPorId',$aVariaveis);
        if(isset($respGet[nomeMatriculaPessoa])){
            $respGet[acao]='buscarVariavelServidor';
        }else{
            $respGet[acao]='selecionarSetor';
        }
        if($respGet[status] == 'Aprovado'){
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] = $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] - 1;
        }
        $msnTexto = "ao alterar variavel. ".$executar['msn'];
    }
    //Alterar Status Lançar Variavel Servidor
    if($respGet[acao]=='lancarVariavelServidor'){
        $v = array('id'=>$respGet[idVariavel]);
        $aVariaveis = array($v);
        $executar = postRest('variaveis/postLancarVariaveisPorId',$aVariaveis);
        if(isset($respGet[nomeMatriculaPessoa])){
            $respGet[acao]='buscarVariavelServidor';
        }else{
            $respGet[acao]='selecionarSetor';
        }
        if($_SESSION[servidorVariavel][0][status] == 'Aprovado'){
            $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] = $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado] - 1;
        }
        $msnTexto = "ao alterar variavel. ".$executar['msn'];
    }
    //selecionarSetor
    if($respGet[acao]=='buscarVariavelServidor'){
        if(is_numeric($respGet[nomeMatriculaPessoa]) == true ){
            $matricula = $respGet[nomeMatriculaPessoa];
            $respGet[nomeMatriculaPessoa] = '';
        }
        $sv = array($_SESSION[idLotacaoSub],$_SESSION[idVariavelDesc],$respGet[nomeMatriculaPessoa],$matricula);
        $encontrados = getRest('variaveis/getListaVariaveisPorSetorPorVariavelDescPorNomePorMatricula',$sv);
        if (count($encontrados) >= 1){
            $executar['info'] = 200;
            $_SESSION[servidorVariavel] = $encontrados;
            $msnTexto = "ao buscar servidor. ";
        }else{
            $executar['info'] = 400;
            $msnTexto = "! Servidor não encontrado. ";
        }

        
    }
    if(($respGet[acao]=='selecionarSetor') OR ($respGet[acao]=='aprovarVariavelSetor')){
        if($respGet[idLotacaoSub] != ""){$_SESSION[idLotacaoSub] = $respGet[idLotacaoSub];}
        if($respGet[idVariavelDesc] != ""){$_SESSION[idVariavelDesc] = $respGet[idVariavelDesc];}
        if($respGet[nomeLotacaoSub] != ""){$_SESSION[nomeLotacaoSub] = $respGet[nomeLotacaoSub];}
        $sv = array($_SESSION[idLotacaoSub],$_SESSION[idVariavelDesc]);
        $_SESSION[servidorVariavel] = getRest('variaveis/getListaVariaveisPorSetorPorVariavelDesc',$sv);
        $i=0;
        $f=0;
        foreach ($_SESSION[servidorVariavel] as $t){
            if($_SESSION[servidorVariavel][$i][status] == 'Aprovado'){
                $f++;
            }
            $i++;
        }
        $_SESSION[lotacaoSubVariavel][0][quantidadeAprovado]=$f;
        $respGet[acao]='buscarVariavelLotacaoSub';
        $respGet[pgServidor] = 1;
    }
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
if(count($_SESSION[servidorVariavel])>0){?>
     <div class="row">
        <div class="col-xs-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Servidor</h3>
              <div class="box-tools">
                <?php if(($respGet[nomeMatriculaPessoa])!=""){?>
                    <input type="hidden" name="idVariavelDesc" value="<?=$_SESSION[idVariavelDesc]?>"/>
                    <input type="hidden" name="acao" value="selecionarSetor"/>
                    <button class="btn btn-primary" onclick="buscaVServidor('selecionarSetor','<?=$_SESSION[idVariavelDesc]?>')" type="button">
                        <i class="fa fa-mail-reply"></i>
                    </button>
                <?php }else{ ?>
                        <div class="input-group input-group-sm" style="width: 200px;">
                          <input type="text" name="nomeMatriculaPessoa" id="nomeMatriculaPessoa" class="form-control pull-right" placeholder="Procurar...">
                          <div class="input-group-btn">
                              <button class="btn btn-default" onclick="buscarServidorNomeMatricula('buscarVariavelServidor',$('#nomeMatriculaPessoa').val())" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </div>

                <?php }?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Matrícula</th>
                  <th>Nome</th>
                  <th>Quantidade/Valor</th>
                  <th>Data</th>
                  <th>Status</th>
                  <th>Ação</th>
                </tr>
                <?php foreach (paginaAtual($_SESSION[servidorVariavel],$respGet[pgServidor]) as $ArrEspServidor){
                    $lable = statusVariaveis($ArrEspServidor[status]);
                    if(1== $_SESSION['setorFechado']){
                        $disablelotacaoSubFechado = "disabled='disabled'";
                    }
                    ?>
                    <tr>
                      <td><?=$ArrEspServidor[matricula]?></td>
                      <td><?=$ArrEspServidor[nome]?></td>
                       <td><?=$ArrEspServidor[quantidadeValor]?></td>
                      <td><?=dataHoraBr($ArrEspServidor[data])?></td>
                      <td><span class="<?=$lable?>"><?=$ArrEspServidor[status]?></span></td>
                      <td>
                            <button title="Aprovar lançamento" <?=$disablelotacaoSubFechado?> class="btn btn-success" onclick="acaoServidor('aprovarVariavelServidor','<?=$ArrEspServidor[idVariavel]?>','<?=$respGet[idVariavelDesc]?>','<?=$respGet[nomeMatriculaPessoa]?>','<?=$respGet[idLotacaoSub]?>','<?=$respGet[nomeLotacaoSub]?>','<?=$respGet[pgServidor]?>','<?=$ArrEspServidor[status]?>')" type="button">
                                <i class="fa fa-check-circle"></i>
                            </button>
                            <button title="Negar lançamento" <?=$disablelotacaoSubFechado?> class="btn btn-danger" onclick="acaoServidor('negarVariavelServidor','<?=$ArrEspServidor[idVariavel]?>','<?=$respGet[idVariavelDesc]?>','<?=$respGet[nomeMatriculaPessoa]?>','<?=$respGet[idLotacaoSub]?>','<?=$respGet[nomeLotacaoSub]?>','<?=$respGet[pgServidor]?>','<?=$ArrEspServidor[status]?>')" type="button">
                                <i class="fa fa-ban"></i>
                            </button>
                            <button title="Aprovar Liberar lançamento para alteração" <?=$disablelotacaoSubFechado?> class="btn btn-primary" onclick="acaoServidor('lancarVariavelServidor','<?=$ArrEspServidor[idVariavel]?>','<?=$respGet[idVariavelDesc]?>','<?=$respGet[nomeMatriculaPessoa]?>','<?=$respGet[idLotacaoSub]?>','<?=$respGet[nomeLotacaoSub]?>','<?=$respGet[pgServidor]?>','<?=$ArrEspServidor[status]?>')" type="button">
                                <i class="fa fa-sort-amount-desc"></i>
                            </button>
                            <button title="Apagar Lançamento" <?=$disablelotacaoSubFechado?> class="btn btn-default" onclick="acaoServidor('variavelRemover','<?=$ArrEspServidor[idVariavel]?>','<?=$respGet[idVariavelDesc]?>','<?=$respGet[nomeMatriculaPessoa]?>','<?=$respGet[idLotacaoSub]?>','<?=$respGet[nomeLotacaoSub]?>','<?=$respGet[pgServidor]?>','<?=$ArrEspServidor[status]?>')" type="button">
                                <i class="fa fa-close"></i>
                            </button>
                      </td>
                    </tr>
                <?php }?>
              </table>
            </div>
            <!-- /.box-body -->
            <?=controleDePagina($_SESSION[servidorVariavel],$respGet[pgServidor],"pgServidor");?> 
          </div>
          <!-- /.box -->
        </div>
      </div>
<?php }else{?>
            <div class="box-body">
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check-circle"></i> Atenção!</h4>
                 Não foram encontrados lançamentos. 
              </div>
                </div>
<?php }?>
<script>
   configuraTela(); 
</script>