<?php
session_start();
require_once '../func/fPhp.php';
autoComplete($_SESSION["nomePessoas"], '#nome', '1');
?>
<h1>
    Buscar
    <small>Servidor</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servidor</a></li>
    <li class="active">Buscar</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary" id="idBoxPrimary">
            
            <!--botões de controle-->
            <div class="box-header with-border">
                <div class="col-md-12">
                    <h3 class="box-title">Ordenar por</h3>          
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>
                            <input type="radio" name="orby" value ='nome' class="flat-red" checked>
                            Nome
                        </label>
                        <label>
                            <input type="radio" name="orby" value ='matricula' class="flat-red">
                            Matrícula
                        </label>
                        <label>
                            <input type="radio" name="orby" value ='dataAdmissao' class="flat-red">
                            Data de Admissão
                        </label>
                        <label>
                            <input type="radio" name="orby" value ='cargo' class="flat-red">
                            Cargo
                        </label>
                    </div>                        
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome</label>
                                <input type="text" id="nome" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Matrícula</label>
                                <input type="text" id="matricula"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">CPF</label>
                                <input type="text" id="cpf" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer pull-right">
                     <button class="btn btn-primary" id="buscar" type="button">Buscar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function buscar(nome, cpf, matricula)
    {
        //O método $.ajax(); é o responsável pela requisição
        $.ajax
                ({
                    //Configurações
                    type: 'POST', //Método que está sendo utilizado.
                    dataType: 'html', //É o tipo de dado que a página vai retornar.
                    url: 'funcional/buscaResult.php', //Indica a página que está sendo solicitada.
                    //função que vai ser executada assim que a requisição for enviada
                    beforeSend: function () {
                        $("#idSpinAll").removeClass("hidden");
                        $("#idBoxResultado").addClass("collapsed-box");
                        $("#idBoxResultado").removeClass("hidden");
                    },
                    data: {nome: nome, cpf: cpf, matricula: matricula}, //Dados para consulta
                    //função que será executada quando a solicitação for finalizada.
                    success: function (msg)
                    {
                        $("#dados").html(msg);
                        
                        $("#idSpinAll").addClass("hidden");
                        $("#idBoxImprimir").addClass("hidden");
                        $("#idBoxResultado").removeClass("collapsed-box");
                        $("#idBoxDados").removeClass("hidden");
                        $("#idBoxCorpo").removeClass("hidden");
                        configuraTela();
                    }
                });
    }
    //Captura evento do botão
    $('#buscar').click(function () {
        buscar($("#nome").val(), $("#cpf").val(), $("#matricula").val());
    });
    //Captura evento do input
//    $('input').keyup(function (e) {
//        if (e.keyCode == 13)
//        {
//            $(this).trigger("enterKey");
//            buscar($("#nome").val(), $("#cpf").val(), $("#matricula").val());
//        }
//    });
    //Captura o carregamento da pagina
    $(document).ready(function () {
        <?php
        if (isset($respGet['nomeCPFMatricula'])){
            if(is_numeric($respGet['nomeCPFMatricula']) == true ){
                if(strlen($respGet['nomeCPFMatricula'])==11){
                    $respGet['cpf'] = $respGet['nomeCPFMatricula']; 
                }else{
                    $respGet['matricula'] = str_pad($respGet['nomeCPFMatricula'] , 6 , '0' , STR_PAD_LEFT);
                }
            }else{
                $respGet['nome'] = $respGet['nomeCPFMatricula'];
            }
        } 
        if(isset($respGet['nome']) or isset($respGet['cpf']) or isset($respGet['matricula'])){
        ?>
            buscar("<?=$respGet['nome']?>", "<?=$respGet['cpf']?>", "<?=$respGet['matricula']?>");
        <?php   
        }
        ?>
         
    });
</script>