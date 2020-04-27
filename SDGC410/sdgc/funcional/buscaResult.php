
<?php 
session_start();
require_once '../func/fPhp.php';
if (!isset($respGet['pg'])){
    $cBusc = array($respGet[nome],$respGet[matricula],$respGet[cpf]);
    $listar = getRest('funcionalws/getListarFuncionalPorNomeMatriculaCpf',$cBusc);
    $_SESSION["lista"] = $listar;
    $_SESSION["totalLista"] = count($_SESSION["lista"]);
    $_SESSION["totalBusca"] = count($listar);
    $msnExibe = true;
}
if(!isset($msnTexto)){
    $msnTexto = "ao Buscar. <br>Total de ".$_SESSION["totalLista"]." encontrado(s)";
}

$totalBusca = $_SESSION["totalBusca"];

if ($totalBusca == 0) {
    $executar['info'] = 400;
}else{
    $executar['info'] = 200;
}
$in = 'in';

if (!isset($respGet['pg'])){
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
}
?>
<?php if ($_SESSION["totalLista"] >= 1){?>
            <!--botões de controle-->
                            <!-- Post -->
<section class="col-lg-12 connectedSortable">
          <div class="row">
        <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
            </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="box-group" id="accordion">
                       <?=controleDePagina($_SESSION[lista] ,$respGet[pg],"pagUpDown","buscaResult");?> 
                       <?php foreach (paginaAtual($_SESSION[lista],$respGet[pg]) as $valor) {
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
                </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
              
</section>

<?php 
    //pg
    $dados = array('acao', 'pg');
    postRestAjax('pagUpDown','dados','funcional/buscaResult.php',$dados); 
}

if(count($listar) == 1){
         ?>
            <script>
                perfil<?=$valor['matricula']?>("<?=$valor['matricula']?>");
            </script>
        <?php 
}
?>
<script>
    
</script>