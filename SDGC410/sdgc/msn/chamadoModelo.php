<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
if($respGet[acao] == 'salvarChamado'){
    echo "salvando...";
    print_p();
}
$respGet[lista] = array(1,2,3,4,5,6,7,8,9,10,11,12)
?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Criar um Novo Modelo</h3>
    </div>
    <div class="box-body">
        <div class="form-group">
            <div class="form-group">
                <label for="exampleInputEmail1">Descreva em poucas palavras:</label> <i><sub class="caracteres">200</sub> <sub>Restantes </sub></i></label> 
                <textarea id="textoMsn" name='textoMsn' class="form-control"  maxlength="200" rows="4"></textarea>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" id='enviarChamado' class="pull-right btn btn-primary" onclick="chamadoSalvar('salvarChamado', $('#idCategoria').val(),$('#assunto').val(), $('#textoMsn').val())">
            <i class="fa fa-envelope-o"></i> Enviar
        </button>
        <button type="reset" class="btn btn-default" onclick="chamadoListar('Entrada')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
</div>
                  <div class="box-group" id="accordion">
                       <?=controleDePagina($respGet[lista] ,$respGet[pg],"pagUpDownCh","chamadoModelo");?> 
                       <?php foreach (paginaAtual($respGet[lista],$respGet[pg]) as $valor) {
                         //foreach ($_SESSION["lista"]  as $valor) {
                                if($valor['situacao'] == 'INATIVO'){
                                    $lable = 'label label-danger';
                                }else{
                                   $lable ='';
                                }?>
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            <div class="panel box box-primary">
                              <div class="box-header with-border">
                                    <div class="pull-right box-tools">
                                        <div class="pull-right box-tools">
                                            <button class="btn btn-facebook btn-small" id="perfil<?=$valor['matricula']?>" type="button"><i class="fa fa-edit"></i></button>
                                        </div>
                                    </div>
                                <h4 class="box-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#<?=$valor['matricula']?>">
                                    <?=$valor['matricula']." - ".$valor['nome']?>
                                  </a>
                                </h4>
                              </div>
                              <div id="<?=$valor['matricula']?>" class="panel-collapse collapse <?=$in?>">
                                <div class="box-body">
                                    <button class="btn link-button-limpo inline" id="perfil2<?=$valor['matricula']?>" type="button">
                                         <form action="#" method="post">
                                           <div class="item">
                                             <div class="inline img-lg-responsive img-rounded img-bordered-sm" style="margin: 5px">
                                                   <img src="<?=exibeFoto($valor['cpf'])?>" alt="Imagem do Usuário">
                                             </div>
                                                 <div>
                                                     <div class="row">
                                                         <div class="attachment">
                                                             <h4><?=$valor['cargo']?></h4>
                                                             <p class="filename">
                                                                 <b>Data de Admissão:</b> <?=dataBr($valor['dataAdmissao'])?><?=$in?>
                                                             </p>
                                                             <p class="filename">
                                                                 <span class="<?=$lable?>"><?=$valor['regime'].' '.$valor['situacao']?></span>
                                                             </p>
                                                             <div class="pull-right">
                                                             </div>
                                                         </div>
                                                    </div>
                                                 </div>
                                             </div>
                                         </form>
                                     </button>
                                </div>
                              </div>
                            </div>
                        <?php $in = ''; ?>
                            <script>
                                function perfil<?=$valor['matricula']?>(id){
                                    //O método $.ajax(); é o responsável pela requisição
                                    $.ajax
                                            ({
                                                //Configurações
                                                type: 'POST', //Método que está sendo utilizado.
                                                dataType: 'html', //É o tipo de dado que a página vai retornar.
                                                url: 'funcional/perfil.php', //Indica a página que está sendo solicitada.
                                                //função que vai ser executada assim que a requisição for enviada
                                                beforeSend: function () {
                                                    $("#idSpinAll").removeClass("hidden");
                                                    $("#idBoxResultado").addClass("collapsed-box");
                                                    $("#idBoxResultado").removeClass("hidden");
                                                   
                                                },
                                                data: {id: id}, //Dados para consulta
                                                //função que será executada quando a solicitação for finalizada.
                                                success: function (msg)
                                                {
                                                    $("#idSpinAll").addClass("hidden");
                                                    $("#dados").html(msg);
                                                    $("#idBoxResultado").removeClass("collapsed-box");
                                                    
                                                    configuraTela();
                                                    postBuscarOcorrencia();
                                                    buscaPlanejamento();
                                                    buscaAvaliacao();
                                                    buscaVariaveis();
                                                    buscaProntuario();
                                                }
                                            });
                                }
                                $('#perfil<?=$valor['matricula']?>').click(function () {
                                    perfil<?=$valor['matricula']?>("<?=$valor['matricula']?>");
                                });
                                $('#perfil2<?=$valor['matricula']?>').click(function () {
                                    perfil<?=$valor['matricula']?>("<?=$valor['matricula']?>");
                                });
                            </script>
                    <?php 
                                }?>
                  </div>
<script>
   $(document).on("keydown", "#textoMsn", function () {
       var caracteresRestantes = 149;
       var caracteresDigitados = parseInt($(this).val().length);
       var caracteresRestantes = caracteresRestantes - caracteresDigitados;
       $(".caracteres").text(caracteresRestantes);
   });
    configuraTela(); 
</script>

<?php 