<?php
session_start();
require_once '../func/fPhp.php';

//PRONTUARIO
if(count($_SESSION["enderecoSESMIT"])>0){
    $enSES=true;
    $buscaR = array('idInfo' => $_SESSION["enderecoSESMIT"][0]['cepLogradouro']);
    $bce = getRest('logradouro/getListaLogradouroPorCEP',$buscaR,true);
}
//lançarProntuario
if ($respGet['acao'] == "lancarProntuario") {
    $vowels = array(")", "(", " ", "-");
    $respGet['teletone'] = str_replace($vowels, "", $respGet['teletone']);
    $respGet['celular'] = str_replace($vowels, "", $respGet['celular']);
    $respGet['cep'] = str_replace($vowels, "", $respGet['cep']);
    if($respGet[idRequerimentoSolicitacao] == ''){$respGet[idRequerimentoSolicitacao]=0;}
    $lancarPlan = array(
                    'idHistFunc' => $_SESSION["funcionalBusca"]['id'],      
                    'idPessoa' => $_SESSION["funcionalBusca"]['pessoa']['id'],
                    'idRequerimentoSolicitacao' => $respGet['idRequerimentoSolicitacao'],
                    'cepLogradouro' => $respGet['cep'],
                    'idEstado' => $respGet['estado'],
                    'idCidade' => $respGet['cidade'],
                    'idBairro' => $respGet['bairro'],
                    'endereco' => $respGet['logradouro'],
                    'numero' => $respGet['numero'],
                    'complemento' => $respGet['complemento'],
                    'celular' => $respGet['celular'],
                    'telefone' => $respGet['teletone'],
                    'email' => $respGet['email']
                        );
    $arquivoPlan = array($lancarPlan);
    
    
    
    $msnTexto = "ao cadastrar prontuário.";
    $executar = postRest('requerimento/postIncluirRequerimentoInfo',$arquivoPlan);
    

    
    $buscaR = array('idInfo' => $_SESSION["funcionalBusca"]['pessoa']['id']);
    $_SESSION["enderecoSESMIT"] = getRest('requerimento/getListarRequerimentoInfoPorIdPessoa',$buscaR);
    $requiSesmt = array('idInfo' => $_SESSION["funcionalBusca"]['id']);
    $_SESSION["requiSesmt"] = getRest('requerimento/getListaRequerimentoPorFuncional',$requiSesmt);
}
//lancar prontuario
if ($respGet['acao'] == "lancarProntuarioProtocolo") {

    $lancarPlan = array(
                        'id' => $respGet['id'],    
                        'protocolo' => $respGet['numProtocolo'].$respGet['anoProtocolo']
                     );
    $lp = array($lancarPlan);
    
    
    $executar = postRest('requerimento/postIncluirProtocoloEmRequerimento',$lp);
    
    $msnTexto = "ao cadastrar protocolo ".$executar['msn'].'.';
    
    $buscaR = array('idInfo' => $_SESSION["funcionalBusca"]['pessoa']['id']);
    
    $_SESSION["enderecoSESMIT"] = getRest('requerimento/getListarRequerimentoInfoPorIdPessoa',$buscaR);
    
    $requiSesmt = array('idInfo' => $_SESSION["funcionalBusca"]['id']);
    
    $_SESSION["requiSesmt"] = getRest('requerimento/getListaRequerimentoPorFuncional',$requiSesmt);

}
//excluir prontuario
if ($respGet['acao'] == "excluirRequisicaoProntuario") {
    $lancarPlan = array(
                        'id' => $respGet['id']
                     );
    $lp = array($lancarPlan);
    $executar = postRest('requerimento/postExcluirRequerimento',$lp);
    $msnTexto = "ao anular requisição ".$executar['msn'].'.';
    $requiSesmt = array('idInfo' => $_SESSION["funcionalBusca"]['id']);
    $_SESSION["requiSesmt"] = getRest('requerimento/getListaRequerimentoPorFuncional',$requiSesmt);
}
//concluir prontuario
if ($respGet['acao'] == "concluirRequisicaoProntuario") {
    $lancarPlan = array(
                        'id' => $respGet['id']
                     );
    $lp = array($lancarPlan);
    $executar = postRest('requerimento/postAlterarRequerimentoEncaminhado',$lp);
    $msnTexto = "ao  concluir requisição ".$executar['msn'].'.';
    $requiSesmt = array('idInfo' => $_SESSION["funcionalBusca"]['id']);
    $_SESSION["requiSesmt"] = getRest('requerimento/getListaRequerimentoPorFuncional',$requiSesmt);
}
exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar, 6000);
?>
    <div class="box">
        
        
        <div class="box-body ">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <!-- /.box-header -->
                        <div>

                            <div class="box-group" id="ocorrencia">                               
                                
                                <?php foreach (paginaAtual($_SESSION["requiSesmt"],$respGet[pg]) as $value) {
                                           if($value[protocolo] != ''){
                                                $codP = substr("$value[protocolo]", 0, -4);
                                                $anoP = substr("$value[protocolo]", -4, 4);
                                                $protocolo=$codP.'/'.$anoP;
                                           }else{
                                               $protocolo =' não entregue';
                                           }
                                ?>
                                <div class="panel box box-success">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#requiSesmt" href="#analizar<?=$value[id]?>">
                                                <i class="fa fa-sort-down"></i> <?=$value[id] .'-'. $value[solicitacao]?>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="analizar<?=$value[id]?>" class="panel-collapse collapse">                                                 
                                        <div class="box-body">
                                            <b>Status: </b><i><?=$value[status]?></i><br>
                                            <b>Protocolo: </b><i><?=$protocolo?></i><br>
                                            <?php if($value[idStatus] == 2){?>
                                            <button class="btn btn-primary pull-right espaco-direita" onclick="concluirRequisicaoProntuario('concluirRequisicaoProntuario', '<?=$value['id']?>')" type="button">
                                                 <i class="fa fa-check-square-o"></i><b> Concluir</b>
                                            </button>
                                                <button type="submit" <?=$dsb?> class="btn btn-success pull-right espaco-direita" data-toggle="modal" data-target="#carregar<?=$value['id']?>">
                                                    <i class="fa fa-print"></i> Gerar Guias
                                                </button>
                                                <div class="modal fade" id="carregar<?=$value['id']?>" role="dialog">
                                                  <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                                                                           
                                                      <div class="modal-body">
                                                          <h4> Selecone as guias Desejadas</h4>
                                                          
                                                           <p> <input type="checkbox" checked  id="idReadaptacao<?=$value['id']?>" name="redap"> Readaptação</p>
                                                           <p> <input type="checkbox" checked  id="idResExm4<?=$value['id']?>" name="red1"> Resultado de Exame Destino 4 </p>
                                                           <p> <input type="checkbox" checked  id="idResExm5<?=$value['id']?>" name="red2"> Resultado de Exame Destino 5 </p>
                                                           <p> <input type="checkbox" checked  id="idResExm6<?=$value['id']?>" name="red3"> Resultado de Exame Destino 6</p>
                                                           <p> <input type="checkbox" checked  id="idSolLicidResExm4<?=$value['id']?>" name="sol"> Solicitacao de Licenca </p>
                                                           <p> <input type="checkbox" checked  id="idLEMPidResExm4<?=$value['id']?>" name="lemp"> Laudo Exame Medico Pericial </p>
                                                      </div>
                                                      <div class="modal-footer">
                                                                    
                                                          <button data-dismiss="modal" onclick="gerarGuia('todosProntuario', '<?= $_SESSION['funcionalBusca']['matricula'] ?>', '<?=$value[id]?>', $('#idReadaptacao<?=$value['id']?>').is(':checked'), $('#idResExm4<?=$value['id']?>').is(':checked'), $('#idResExm5<?=$value['id']?>').is(':checked'), $('#idResExm6<?=$value['id']?>').is(':checked'), $('#idSolLicidResExm4<?=$value['id']?>').is(':checked'), $('#idLEMPidResExm4<?=$value['id']?>').is(':checked'), true)" class="btn btn-primary ">
                                                              <i class="fa fa-eye"></i><b> Exibir</b>
                                                          </button>
                                                          
                                                          <button data-dismiss="modal" onclick="gerarGuia('todosProntuario', '<?= $_SESSION['funcionalBusca']['matricula'] ?>', '<?=$value[id]?>', $('#idReadaptacao<?=$value['id']?>').is(':checked'), $('#idResExm4<?=$value['id']?>').is(':checked'), $('#idResExm5<?=$value['id']?>').is(':checked'), $('#idResExm6<?=$value['id']?>').is(':checked'), $('#idSolLicidResExm4<?=$value['id']?>').is(':checked'), $('#idLEMPidResExm4<?=$value['id']?>').is(':checked'), false)" class="btn btn-danger ">
                                                              <i class="fa fa-print"></i><b> Imprimir</b>
                                                          </button>

                                                          <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            <?php }?>
                                            <?php if($value[idStatus] == 1){?>

                                            <button class="btn btn-danger pull-right btn-sm espaco-direita" onclick="excluirRequisicaoProntuario('excluirRequisicaoProntuario', '<?=$value['id']?>')" type="button">
                                                 <i class="fa fa-trash"></i><b> Excluir</b>
                                            </button>
                                            <button class="btn btn-primary pull-right espaco-direita" onclick="requerimentoProtocoloGeral('requerimentoProtocoloGeral', '<?=$_SESSION['funcionalBusca']['pessoa']['cpf']?>', '<?=$_SESSION[enderecoSESMIT][0][endereco].$_SESSION[enderecoSESMIT][0][numero].$_SESSION[enderecoSESMIT][0][complemento]?>', '<?=$bce[0][cidade]?>','<?=$bce[0][bairro]?>','<?=$_SESSION[enderecoSESMIT][0][celular]?>','<?=$_SESSION[enderecoSESMIT][0][email]?>', true)" type="button">
                                                <i class="fa fa-print"></i><b> Requerimento</b>
                                            </button>
                                                
                                            <button type="submit" <?=$disable?>  class="btn btn-success pull-right espaco-direita" data-toggle="modal" data-target="#remover<?=$value['id']?>">
                                                <i class="fa fa-info-circle"></i><b> Entrada de Protocolo</b>
                                            </button>
                                            <div class="modal fade" id="remover<?=$value['id']?>" role="dialog">
                                              <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                  <div class="modal-body">
                                                        <p> Inserir código do protocolo. Deseja realmente fazer esta ação?</p>
                                                  </div>
                                                  <div class="modal-footer">
                                             
                                                            <div class="col-xs-5">
                                                             <input type="number" class="form-control" name="protocolo" id='numProtocolo<?=$value['id']?>'/>
                                                            </div>
                                                            <div class="col-xs-1">
                                                              /
                                                            </div>
                                                            <div class="col-xs-5">
                                                                <select name='anoProtocolo' id='anoProtocolo<?=$value['id']?>' class="form-control">
                                                                  <option value="<?=date('Y')?>" selected><?=date('Y')?></option> 
                                                                  <option value="<?=date('Y')-1?>"><?=date('Y')-1?></option>
                                                                </select>
                                                            </div>
                                                            <div class="col-xs-1">
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <br>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <button type="button" data-dismiss="modal" class="btn btn-primary" onclick="lancarProtocolo('lancarProntuarioProtocolo', '<?=$value['id']?>', $('#numProtocolo<?=$value['id']?>').val(), $('#anoProtocolo<?=$value['id']?> option:selected').val())">Confirmar</button>
<!--                                                                <button type="button" data-dismiss="modal" class="btn btn-primary" onclick="lancarProtocolo()">Confirmar</button>-->
    
                                                                <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                                                        </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                           <?php }?>
                                        </div>
                                    </div>

                                </div>
                                <?php }?>
                                <?=controleDePagina($_SESSION[requiSesmt] ,$respGet[pg],"pagUpDown","prontuario");?> 
                            </div>
                        </div>
                        <!-- /.box-body -->

                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.box-body -->
    </div>
<?php
    //pg
    $dados = array('acao', 'pg');
    postRestAjax('pagUpDown','buscaProntuario','funcional/prontuarioResult.php',$dados); 
    $s1 = array('idBoxImprimir','addClass','hidden');
    $success= array ($s1);
    //excluirRequisicaoProntuario
    $dados = array('acao', 'id');
    postRestAjax('excluirRequisicaoProntuario','buscaProntuario','funcional/prontuarioResult.php',$dados, '', $success);
    
    //concluirRequisicaoProntuario
    $dados = array('acao', 'id');
    postRestAjax('concluirRequisicaoProntuario','buscaProntuario','funcional/prontuarioResult.php',$dados, $beforeSend, $success);
    
    //lancarProtocolo
//    $dados = array('acao','id', 'numProtocolo','anoProtocolo');
//    postRestAjax('lancarProtocolo','buscaProntuario','funcional/prontuarioResult.php',$dados);    
    
    //imprimirRequerimentoProtocoloGeral
    $dados = array('acao','cpf', 'endereco','cidade','bairro','telefone','email', 'ver');
    postRestAjax('requerimentoProtocoloGeral','imprimir','print/info.php',$dados);
    
    //GerarGuia
    $dados = array('acao','matricula', 'dado', 'redap', 'red1', 'red2', 'red3', 'sol', 'lemp', 'ver');
    postRestAjax('gerarGuia','imprimir','print/info.php',$dados);
    
    
?>
<script>
function lancarProtocolo(acao,id,numProtocolo,anoProtocolo){   
        $.ajax
        ({
            //Configurações
            type: 'POST', //Método que está sendo utilizado.
            dataType: 'html', //É o tipo de dado que a página vai retornar.
            url:  'funcional/prontuarioResult.php', //Indica a página que está sendo solicitada.
            //função que vai ser executada assim que a requisição for enviada
            beforeSend: function () {
                //executar antes de enviar
            },
            data: {acao:acao,id:id,numProtocolo:numProtocolo,anoProtocolo:anoProtocolo}, //Dados para consulta
            //função que será executada quando a solicitação for finalizada.
            success: function (msg)
            {   
                setTimeout(function(){ 
                    $("#buscaProntuario").html(msg);
                },1000);
            }
        });
        
}
</script>

