<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
//LIMPAR
    if (!isset($respGet['acao'])) {
        $_SESSION['appv'] = getRest('appversao/getListaAppVersao');
        $_SESSION['template'] = '';
        $_SESSION['verTemplate'] = '';
    }
//TEMPLATE CLONAR 
    if ($respGet['acao'] == "clonarTemplate") {
        $idTemplate = array('idAppVersao' => $respGet['idappversao'],'id' => $respGet['idClone'],'nome' => $respGet['nomeTemplate']);
        $msnTexto = "ao clonar o template.";
        $executar= postRest('userMenu/postClonarTemplate',$idTemplate);
        $respGet['acao'] = "buscar";
        $respGet['closeResult'] = 1;
        $respGet['closeAcesso'] = 0;
    }

//ACESSOS EXIBIR 
    if ($respGet['acao'] == "exibirAcesso") {
        $buscaMenu = array('id' => $respGet['idappversao']);
        $_SESSION['verMenu']= getRest('userMenu/getListaMenuItem',$buscaMenu);
        $buscaAcessoTemplate = array('id' => $respGet['idTemplate']);
        $_SESSION['verTemplate']= getRest('userMenu/getListaTemplatePermissaoAccesso',$buscaAcessoTemplate);
        $_SESSION['template']= array('id'=>$respGet['idTemplate'],'nome'=>$respGet['nometemplate']);
    }

?>
<h1>
    Template
    <small>Editar/Cadastrar</small>
    <br><br>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Usuário</a></li>
    <li class="active">Template - Editar/Cadastrar</li>
</ol>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary <?php if($respGet['closeBusca']){?> collapsed-box <?php }?>">
            <div class="box-header with-border">
              <h3 class="box-title">Buscar </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-<?php if(!$respGet['closeResult']){?>plus<?php }else{?>minus<?php }?>"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome</label>
                                    <input type="text" name="nome" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <label for="exampleInputEmail1">APP</label>
                                    <select name="idappversao" id='idappversao' size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
                                        <?php foreach ($_SESSION['appv'] as $ArrEsp){?>
                                          <option value="<?=$ArrEsp['id']?>" <?php if ($ArrEsp['ativo'] == 1){echo "selected='selected'"; $lotAtivo=true;}?>><?=$ArrEsp['nome']." ".$ArrEsp['versao']?></option>
                                        <?php }
                                        if($lotAtivo != true){
                                            echo "<option selected='selected'></option>";
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer pull-right">
                        <button class="btn btn-primary" onclick="templateBuscar('buscar',$('#idappversao').val())" type="button">
                            Buscar
                        </button>
                    </div>
            </div>
        </div>
    </div>
    <div id='addAcessoTemplate'>
    </div>
    <div id='showAcessoTemplate'>
    </div>
    

</div>
<?php
    $dados = array('acao', 'idappversao' );
    postRestAjax('templateBuscar','addAcessoTemplate','usuario/templateBuscar.php',$dados);  
    
    $dados = array('acao', 'idappversao','idTemplate' );
    postRestAjax('templateRemover','addAcessoTemplate','usuario/templateBuscar.php',$dados);  

    $dados = array('acao', 'idappversao','idTemplate','nometemplate' );
    postRestAjax('templateEditar','addAcessoTemplate','usuario/templateAddAcesso.php',$dados); 
    
    $dados = array('acao', 'idsUserMenu','incluir','excluir','alterar','listar','buscar' );
    postRestAjax('templateAlterar','addAcessoTemplate','usuario/templateAddAcesso.php',$dados); 

    $dados = array('acao', 'idUserTemplate','idUserMenu');
    postRestAjax('removeAcesso','addAcessoTemplate','usuario/templateAddAcesso.php',$dados);     
    
    $dados = array('acao', 'closeResult', 'idClone', 'idappversao','nomeTemplate');
    postRestAjax('modalClonarTemplate', 'addAcessoTemplate', 'usuario/templateAddAcesso.php', $dados);
?>