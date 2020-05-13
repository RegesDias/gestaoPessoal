<?php
    session_start();
    require_once '../func/fPhp.php';
    if($respGet[acao] == 'incluirAvaliacao'){
        $excluirAvaliacao = array(
                                    'idHistFuncional'=>$_SESSION["funcionalBusca"]['id'],
                                    'idLotacaoSub'=>$respGet[idLotacaoSub],
                                    'adaptacao'=>$respGet[adaptacao],
                                    'comprometimento'=>$respGet[comprometimento],
                                    'conhecimento'=>$respGet[conhecimento],
                                    'iniciativa'=>$respGet[iniciativa],
                                    'qualidade'=>$respGet[qualidade],
                                    'relacionamentos'=>$respGet[relacionamentos],
                                    'resolucao'=>$respGet[resolucao],
                                    'responsabilidade'=>$respGet[responsabilidade]

                                );
        $ea = array($excluirAvaliacao);
        $executar = postRest('avaliacao/postIncluirAvaliacao',$ea);
        $msnTexto = "ao avaliar. ".$executar['msn'].'.';
        $buscaAvaliacao = array('idFuncional' => $_SESSION["funcionalBusca"]['id'],$respGet[idLotacaoSub]);
        $aNota = getRest('avaliacao/getAvaliacaoIdhistFuncPeriodo',$buscaAvaliacao);

    }
    if($respGet[acao] == 'anularAvaliacao'){
        $respGet[idAvaliacao];
        $removerId = array(id=>$respGet[idAvaliacao]);
        $ri = array($removerId);
        $executar = postRest('avaliacao/postExcluirOcorrencia',$ri);
        $msnTexto = "ao avaliar. ".$executar['msn'].'.';
    }
?>
<form action="index.php" method="<?= $method ?>" class="form-horizontal">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="idLotSubAvaliacao">Local da Avaliacao</label>
                    <select <?= $inativo ?> id="idLotSubAvaliacao" name="idLotacaoSub" <?php if ($lote) { ?> onchange="loadList(this.value)" <?php } ?> size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                        <?php foreach ($_SESSION["lotacoesSubAtivos"] as $ArrEsp) { ?>
                            <option value="<?= $ArrEsp['idSetor'] ?>"><?= $ArrEsp['nome'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Lançar Avaliação</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped">
                                        <tr>
                                            <td colspan="6" align="right">
                                                <h3 class="box-title">NOTA: <label id="idLabelNota">(ERRO)</label></h3>
                                            </td>
                                        </tr>
                                    <tr>
                                        <th>Fatores</th>
                                        <?php foreach ($_SESSION["pesoAvaliacao"] as $pa) { ?>
                                            <th><?= $pa[nome] . " (" . $pa[valor] . ")" ?></th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <th>Conhecimento do trabalho</th>
                                        <td><input id="idConhecimento5" type="radio" name="conhecimento" value="5">
                                            Conhece perfeitamente seu trabalho e procura aumentar seu conhecimento.
                                        </td>
                                        <td><input  id="idConhecimento4" type="radio" name="conhecimento" value="4" >
                                            Conhece bem o seu trabalho.
                                        </td>
                                        <td><input  id="idConhecimento3" type="radio" name="conhecimento" value="3" >
                                            Conhece bem o suficiente.
                                        </td>
                                        <td><input  id="idConhecimento2" type="radio" name="conhecimento" value="2" >
                                            Apresenta lacunas no conhecimento do trabalho. Alguams vezes precisa ser ajudado.
                                        </td>
                                        <td><input  id="idConhecimento1" type="radio" name="conhecimento" value="1" >
                                            Não Conhece bem o trabalho. Recorre frequentemente ao chefe e aos colegas.
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Iniciativa e Criatividade</th>
                                        <td><input id="idIniciativa5" type="radio" name="iniciativa" value="5" >
                                            Ultrapassa sempre o nivel exigido.
                                        </td>
                                        <td><input id="idIniciativa4" type="radio" name="iniciativa" value="4" >
                                            Corresponde sempre ao nivel requirido.
                                        </td>
                                        <td><input id="idIniciativa3" type="radio" name="iniciativa" value="3" >
                                            Satisfaz às exigências minimas.
                                        </td>
                                        <td><input id="idIniciativa2" type="radio" name="iniciativa" value="2" >
                                            Ás vezes fica abaixo do nivel exigido.
                                        </td>
                                        <td><input id="idIniciativa1" type="radio" name="iniciativa" value="1" >
                                            Esta sempre abaixo do nível exigido.
                                        </td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <th>Resolução de Problemas</th>
                                        <td><input id="idResolucao5" type="radio" name="resolucao" value="5" >
                                            Resolve sozinho todos os problemas.
                                        </td>
                                        <td><input id="idResolucao4" type="radio" name="resolucao" value="4" >
                                            Resolve sozinho a maioria dos problemas.
                                        </td>
                                        <td><input id="idResolucao3" type="radio" name="resolucao" value="3">
                                            Resolve sozinho os problemas mais simples.
                                        </td>
                                        <td><input id="idResolucao2" type="radio" name="resolucao" value="2">
                                            A maioria das vezes precisa ser ajudado por chefes ou colegas.
                                        </td>
                                        <td><input id="idResolucao1" type="radio" name="resolucao" value="1" >
                                            Recorre sempre ao chefe e aos colegas.
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Adaptação a novas tarefas</th>
                                        <td><input id="idAdaptacao5" type="radio" name="adaptacao" value="5" >
                                            Adapta-se facilmente as novas taferas, executando-as satisfatoriamente desde o início.
                                        </td>
                                        <td><input id="idAdaptacao4" type="radio" name="adaptacao" value="4" >
                                            Não apresenta problemas ao execurar uma nova tarefa.
                                        </td>
                                        <td><input id="idAdaptacao3" type="radio" name="adaptacao" value="3">
                                            Após algum tempo passa a executar satisfatoriamente as novas tarefas.
                                        </td>
                                        <td><input id="idAdaptacao2" type="radio" name="adaptacao" value="2" >
                                            Apresenta algumas dificuldades ao executar novas tarefas.
                                        </td>
                                        <td><input id="idAdaptacao1" type="radio" name="adaptacao" value="1" >
                                            Só consegue executar uma nova tarefa às custas de grande esforço.
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Qualidade no Trabalho</th>
                                        <td><input id="idQualidade5" type="radio" name="qualidade" value="5" >
                                            Seu Trabalho é sempre perfeito e sempre apresenta qualidade superior.
                                        </td>
                                        <td><input id="idQualidade4" type="radio" name="qualidade" value="4" >
                                            Seu trabalho é bom e algumas vezes apresenta qualidade superior.
                                        </td>
                                        <td><input id="idQualidade3" type="radio" name="qualidade" value="3" >
                                            A qualidade do seu trabalho é satisfatoria.
                                        </td>
                                        <td><input id="idQualidade2" type="radio" name="qualidade" value="2">
                                            Seu trabalho algumas vezes apresenta imperfeições.
                                        </td>
                                        <td><input id="idQualidade1" type="radio" name="qualidade" value="1">
                                            Seu trabalho de modo geral é insatisfatório. Apresenta muitos erros
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Responsabilidade pelo Patrimônio</th>
                                        <td><input id="idResponsabilidade5" type="radio" name="responsabilidade" value="5" >
                                            Ultrapassa sempre o nível exigido.
                                        </td>
                                        <td><input id="idResponsabilidade4" type="radio" name="responsabilidade" value="4" >
                                            Corresponde sempre ao nível requerido.
                                        </td>
                                        <td><input id="idResponsabilidade3" type="radio" name="responsabilidade" value="3" >
                                            Satisfaz às exigencias mínimas.
                                        </td>
                                        <td><input id="idResponsabilidade2" type="radio" name="responsabilidade" value="2" >
                                            Ás vezes fica abaixo do nível exigido.
                                        </td>
                                        <td><input id="idResponsabilidade1" type="radio" name="responsabilidade" value="1" >
                                            Está sempre abaixo do nível exigido
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Comprometimento com Prazos</th>
                                        <td><input id="idComprometimento5" type="radio" name="comprometimento" value="5">
                                            Cumpre sempre o prazo exigido e com muita antecedência.
                                        </td>
                                        <td><input id="idComprometimento4" type="radio" name="comprometimento" value="4" >
                                            Cumpre sempre o prazo exigido com uma certa antecedência.
                                        </td>
                                        <td><input id="idComprometimento3" type="radio" name="comprometimento" value="3">
                                            Satisfaz às exigencias mínimas.
                                        </td>
                                        <td><input id="idComprometimento2" type="radio" name="comprometimento" value="2" >
                                            Ás vezes cumpre o prazo exigido, mas com cobrança.
                                        </td>
                                        <td><input id="idComprometimento1" type="radio" name="comprometimento" value="1" >
                                            Nunca respeita o prazo exigido
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Relacionamentos (Inclusive em Equipe)</th>
                                        <td><input class="teste" id="idRelacionamentos5" type="radio" name="relacionamentos" value="5" >
                                            Tem grande facilidade para se relacionar com as pessoas.
                                        </td>
                                        <td><input id="idRelacionamentos4" type="radio" name="relacionamentos" value="4">
                                            Relaciona-se bem com as pessoas. Possui espírito de colaboração.
                                        </td>
                                        <td><input id="idRelacionamentos3" type="radio" name="relacionamentos" value="3">
                                            Seu relacionamento com as pessoas geralmente é bom.
                                        </td>
                                        <td><input id="idRelacionamentos2" type="radio" name="relacionamentos" value="2" >
                                            Seu relacionamento com as pessoas apresenta algumas falhas.
                                        </td>
                                        <td><input id="idRelacionamentos1" type="radio" name="relacionamentos" value="1" >
                                            Em contato com as pessoas frequentemente cria problemas de relaconamento
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="pull-right">
                
                <input type="hidden" name="tab" value="avaliacao">
                <input type="hidden" name="acao" value="incluirAvaliacao">
                <input type="hidden" name="pst" value="<?= $pst ?>">
                <input type="hidden" name="arq" value="<?= $arq ?>">
             
                <button id="idBtnAvaliar" class="btn btn-success pull-right  btn-sm espaco-direita" onclick="incluirAvaliacao('acao', $('#idLotSubAvaliacao').val() , $('input[name=adaptacao]:radio:checked').val(), $('input[name=comprometimento]:radio:checked').val(), $('input[name=conhecimento]:radio:checked').val(), $('input[name=iniciativa]:radio:checked').val(), $('input[name=qualidade]:radio').val(), $('input[name=relacionamentos]:radio:checked').val(), $('input[name=resolucao]:radio:checked').val(), $('input[name=responsabilidade]:radio:checked').val())" type="button">
                    <i class="fa fa-edit"></i> Avaliar
                </button>
                
        </form>

    </div>
<?php if ($_SESSION["AvaliacaoAnularBotao"] == TRUE) { ?>
        <form action="index.php" method="<?= $method ?>">
            <div class="pull-left">
                <input type="hidden" id="idInputIdNota" value="0"/>
                <button id="idBtnAnular" class="btn btn-danger pull-right  btn-sm espaco-direita" onclick="anularAvaliacao('anularAvaliacao', $('#idInputIdNota').val())" type="button">
                    <i class="fa fa-trash"></i> Anular                                                                                        
                </button>
            </div>
        </form>
<?php } ?>
            <div class="pull-left">
                <button id="idBtnver"  class="btn btn-facebook pull-right btn-sm espaco-direita" onclick="relatorioEmAvaliacao('avaliacaoFicha',$('#idLotSubAvaliacao').val(),'<?= $_SESSION['funcionalBusca']['id'] ?>',true)" type="submit">
                    <i class="fa fa-eye"></i> Visualizar</button>
                </button>
                <button id="idBtnImprimir"  class="btn btn-primary pull-right btn-sm espaco-direita" onclick="relatorioEmAvaliacao('avaliacaoFicha',$('#idLotSubAvaliacao').val(),'<?= $_SESSION['funcionalBusca']['id']?>')" type="submit">
                    <i class="fa fa-print"></i> Imprimir</button>
                </button>
            </div>
<?php
    require_once '../javascript/fAvaliacao.php';
    
    //anularAvaliacao

    $s1 = array('idBoxImprimir','addClass','hidden');
    $success= array ($s1);
    $dados = array('acao', 'idAvaliacao');
    postRestAjax('anularAvaliacao','buscaAvaliacao','funcional/avaliacaoResult.php',$dados,'',$success);
    
    //incluirAvaliacao
    $s1 = array('idBoxImprimir','addClass','hidden');
    $success= array ($s1);
    $dados = array('acao', 'idLotacaoSub','adaptacao','comprometimento','conhecimento','iniciativa','qualidade','relacionamentos','resolucao','responsabilidade');
    //$dados = array('acao', 'idAvaliacao');
    postRestAjax('incluirAvaliacao','buscaAvaliacao','funcional/avaliacaoResult.php',$dados,'',$success);

    //imprimir Avaliacao


    $dados = array('acao','idLotacaoSub','idHistorioFunc','ver');
    postRestAjax('relatorioEmAvaliacao','imprimir','print/info.php',$dados);
?>
<script>
    carregaAvaliacao();
</script>                    