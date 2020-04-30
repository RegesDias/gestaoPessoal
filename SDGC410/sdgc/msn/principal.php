<?php
//configuração
$pst = 'msn';
$arq = 'principal';
//Cadastra
if($respGet['acao'] == 'cadastarMsn'){
    $novamensagem = array(
        'texto'=>$respGet['obsMsn'],
        'tipo'=>$respGet['tipoMsn'],
        'titulo'=>$respGet['tituloMsn']
    );
    $inclusao = postRest('mensagemws/postIncluirMensagem', $novamensagem);
}
//Editar
if($respGet['acao'] == "salvarEdicaoMsn"){
    $mensagemEditada = array(
        'id'=>intval($respGet['idMsn']),
        'texto'=>$respGet['obsMsn'],
        'tipo'=>$respGet['tipoMsn'],
        'titulo'=>$respGet['tituloMsn']
    );
    $inclusao = postRest('mensagemws/postAlterarMensagem', $mensagemEditada);
}
//Alterar
if($respGet['acao'] == "alterarStatusMsn"){
    if($respGet['statusMsn'] == 1){
        $respGet['statusMsn'] = true;
    }
    $mensagemEditada = array(
        'id'=>intval($respGet['idMsn']),
        'ativo'=>$respGet['statusMsn']
    );
    $inclusao = postRest('mensagemws/postStatusMensagem', $mensagemEditada);
}
//Excluir
if($respGet['acao'] == "excluirMsn"){
    $mensagemEditada = array(
        'id'=>intval($respGet['idMsn'])
    );
    $inclusao = postRest('mensagemws/postRemoverMensagem', $mensagemEditada);
}
$vetorMensagens = getRest("mensagemws/getListaMensagem");

//nivel de acesso
    $buscAcessoNivel = array("5");
    $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if ($valor['link'] == 'Mensagem'){ 
              $msnAcesso['listar'] = $valor['listar'];
              $msnAcesso['alterar'] = $valor['alterar'];
              $msnAcesso['buscar'] = $valor['buscar'];
              $msnAcesso['incluir'] = $valor['incluir'];
              $msnAcesso['excluir'] = $valor['excluir'];
        }
    }
//echo "<pre>";
//print_r($preArray);
//echo "</pre>";

?>
<section class="content-header">
    <h1>
        Mensagens
        <small>Ler</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Mensagens</a></li>
        <li class="active">Ler</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <!-- The time line -->
            <ul class="timeline">
                <!-- timeline time label -->
                
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <?php if($msnAcesso['incluir'] == True){?>
                <li>        
                        <form action="index.php" method="<?=$method?>" class="inline">
                            <input type="hidden" name="exibir" value="cadastrarMsn" />
                            <input type="hidden" name="pst" value="msn" />
                            <input type="hidden" name="arq" value="principal" />
                            <input type="hidden" name="pst" value="print"/>
                            <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i></button>
                        </form>
                        <br>
                        <?php if($respGet['exibir'] == 'cadastrarMsn'){?>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="#">Cadastrar Menssagem</a></h3>
                            <div class="timeline-body">
                                <form method="<?=$method?>" action="index.php">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Título</label>
                                                <input type="text" name="tituloMsn" class="form-control" <?php echo $respGet['acao'] == 'editarMsn' ? 'value="'. $respGet['tituloEditar'] . '"' : ""; ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tipo</label>
                                                <select  class="form-control select2" name='tipoMsn' style="width: 100%;">
                                                    <?php if($respGet['acao'] == 'editarMsn'){?>

                                                    <?php }?>
                                                    <option value='bg-blue'>Normal</option>
                                                    <option value='bg-green'>Sucesso</option>
                                                    <option value='bg-red'>Perigo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <script>
                                                $(document).on("keydown", "#obsMsn", function () {
                                                    var caracteresRestantes = 149;
                                                    var caracteresDigitados = parseInt($(this).val().length);
                                                    var caracteresRestantes = caracteresRestantes - caracteresDigitados;
                                                    $(".caracteres").text(caracteresRestantes);
                                                });
                                            </script>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Texto</label> <i><sub class="caracteres">400</sub> <sub>Restantes </sub></i></label> 
                                                <textarea id="obsMsn" name='obsMsn'class="form-control"  maxlength="400" rows="4"><?php echo $respGet['acao'] == 'editarMsn' ? $respGet['textoEditar'] : ""; ?></textarea>
                                            </div>
                                        </div>
                                    </div>                                 

                                    <div class="timeline-footer ">
                                        <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-save"></i></button>
                                        <input type="hidden" value="<?php echo $respGet['acao'] == 'editarMsn' ? 'salvarEdicaoMsn' : 'cadastarMsn' ; ?>" name="acao">
                                        <?php echo $respGet['acao'] == 'editarMsn' ? '<input type="hidden" name="idMsn" value="'.$respGet['idEditar'].'">' : '' ; ?>
                                        <input type="hidden" name="pst" value="msn">
                                        <input type="hidden" name="arq" value="principal">
                                    </div>

                                </form>
                        </div>
                    </div>
                   <?php }?>
                </li>

<?php
                }
foreach ($vetorMensagens as $Mensagem) {
        $corAlertIcon = $Mensagem['tipo'];
        $iconeMsn = "fa-comments ";
        if($Mensagem['ativo'] == false){
            $iconeMsn = "fa-eye-slash ";
            $corAlertIcon = "bg-yellow";
            $statusMsn = true;
        }else{
            $statusMsn = false;
        }

        $dataAnterior = $dataHora['data'];
        //Trata data e hora
        $dataHora = dataHoraMensagem($Mensagem['data']);
        //Escreve data na timeline se a data da mensagem for diferente da naterior
        if ($dataHora['data'] != $dataAnterior) {
            ?>
                <li class="time-label">
                    <span class="bg-red">
                        <?= $dataHora['data'] ?>
                    </span>
                </li>

                <?php
                $dataAnterior = $dataHora['data'];
            }
            if(($msnAcesso['incluir'] == true) OR (($msnAcesso['incluir'] == false)AND($statusMsn == false))){?>
                        <li>
                            <i class="fa <?= $iconeMsn ?> <?= $corAlertIcon ?>"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> <?= $dataHora['hora'] ?></span>
                                <h3 class="timeline-header"><a href="#"><?= $Mensagem['titulo'] ?></a> </h3>
                                <div class="timeline-body">
                                    <?= $Mensagem['texto'] ?>
                                </div>
                                <div class="timeline-footer">
                                    <?php if($msnAcesso['alterar'] == True){?>
                                    <div style="display:inline-block;">
                                        <form method="<?=$method?>" action="index.php">
                                            <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></button>
                                            <input type="hidden" name="idEditar" value="<?=$Mensagem['id']?>">
                                            <input type="hidden" name="tituloEditar" value="<?=$Mensagem['titulo']?>">
                                            <input type="hidden" name="textoEditar" value="<?=$Mensagem['texto']?>">
                                            <input type="hidden" name="acao" value="editarMsn">
                                            <input type="hidden" name="exibir" value="cadastrarMsn" >
                                            <input type="hidden" name="pst" value="msn">
                                            <input type="hidden" name="arq" value="principal">
                                        </form>
                                    </div>
                                    <?php }if($msnAcesso['alterar'] == True){?>
                                    <div style="display:inline-block;">
                                        <form method="<?=$method?>" action="index.php">
                                            <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-share-alt"></i></button>
                                            <input type="hidden" value="compartilharMsn" name="acao">
                                            <input type="hidden" name="idMsn" value="<?= $Mensagem['id'] ?>">
                                            <input type="hidden" name="statusMsn" value="<?=$statusMsn?>">
                                            <input type="hidden" name="acao" value="alterarStatusMsn">
                                            <input type="hidden" name="pst" value="msn">
                                            <input type="hidden" name="arq" value="principal">
                                        </form>
                                    </div>
                                    <?php } if($msnAcesso['excluir'] == True){?>
                                    <div style="display:inline-block;">
                                        <form method="<?=$method?>" action="index.php">
                                            <button value="apagar" type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                            <input type="hidden" name="acao" value="excluirMsn">
                                            <input type="hidden" name="idMsn" value="<?= $Mensagem['id'] ?>">
                                            <input type="hidden" name="pst" value="msn">
                                            <input type="hidden" name="arq" value="principal">
                                        </form>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </li><?php
                    }
                }
                ?>
                <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>
            </ul>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
        <script>
            $(document).ready(function(){
                    $("#idBoxDados").addClass("hidden");
                    $("#idBoxImprimir").addClass("hidden");            
            });

        </script>