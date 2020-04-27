<?php
    session_start();
    require_once '../func/fPhp.php';
?>
<h1>
    Relatório
    <small> Usuários Acesso</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Relatórios</a></li>
    <li class="active">Usuários e acessos</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-md-12">
                    <h3 class="box-title">Ordenar por</h3>          
                </div>
            </div>
            <!--botões de controle-->

            <div class="box-body">
                <form action="index.php" method="<?= $method ?>" name="formTemplate">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                <input id="idRadioNome" type="radio" name="orby" value ='nome' class="flat-red" checked>
                                Nome
                            </label>
                            <label>
                                <input id="idRadioCpf" type="radio" name="orby" value ='cpf' class="flat-red">
                                CPF
                            </label>
                            <label>
                                <input id="idRadioLogin" type="radio" name="orby" value ='login' class="flat-red">
                                Login(Chave de Usuário)
                            </label>
                            <label>
                                <input id="idRadioNomeDoAcesso" type="radio" name="orby" value ='nomeacesso' class="flat-red">
                                Nome do Acesso
                            </label>
                        </div>                        
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="carregaLot"> 
                                        <?php require_once '../relat/boxSecretaria.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="box-footer pull-right">
                        <input type="hidden" name="pg" value="1"/>
                        <input type="hidden" name="pst" value="print"/>
                        <input type="hidden" name="arq" value="info"/>
                        <input type="hidden" name="relat" value="usuariosAcesso"/>
                        <input type="hidden" name="varq" value="usuariosAcesso"/>
                        <input type="hidden" name="vpst" value="relat"/>
                        <button class="btn btn-danger pull-right">
                            <i class="fa fa-print"></i> Imprimir
                        </button>
                    </div>-->
                    <div class="box-footer pull-right">
                        
                        <script>
                            var inputOrby = document.querySelector('#idOrby');
                            
                            $('#idRadioNome').on('ifChecked', function () {
                                inputOrby.value = "nome";
                            });
                            $('#idRadioCpf').on('ifChecked', function () {
                                inputOrby.value = "cpf";
                            });
                            $('#idRadioLogin').on('ifChecked', function () {
                                inputOrby.value = "login";
                            });
                            $('#idRadioNomeDoAcesso').on('ifChecked', function () {
                                inputOrby.value = "nomeacesso";
                            });
                            
                        </script>

                        <input type="hidden" id="idOrby" value="nome"/>
                        
                        <button  class="btn btn-info pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('usuariosAcesso',$('#secretariaID').val(), $('#idOrby').val())" type="button">
                             <i class="fa fa-print"></i> Imprimir
                        </button>

                        <button class="btn btn-facebook pull-right btn-sm espaco-direita" onclick="relatorioEmRelatorio('usuariosAcesso', $('#secretariaID').val(), $('#idOrby').val(),true)" type="button">
                             <i class="fa fa-eye"></i> Visualizar
                        </button>
                    </div>
                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
</div>
    <?php
        //relatorioEmRelatorio

        $dados = array('acao','idSecretaria','orby', 'ver');
        postRestAjax('relatorioEmRelatorio','imprimir','print/info.php',$dados);
    ?>