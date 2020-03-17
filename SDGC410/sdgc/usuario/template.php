<?php
//configuração
    $pst = 'usuario';
    $arq = 'template';
//LIMPAR
    if ($respGet['acao'] == "limparSessao") {
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
//TEMPLATE INCLUIR 
    if ($respGet['acao'] == "incluirPerfil") {
        $idTemplate = array('idAppVersao' => $respGet['idappversao'],'nome' => $respGet['nome']);
        $msnTexto = "ao cadastrar o template.";
        $executar= postRest('userMenu/postIncluirTemplate',$idTemplate);
        $respGet['acao'] = "buscar";
        $respGet['closeResult'] = 1;
        $respGet['closeAcesso'] = 0;
    }
//TEMPLATE REMOVER 
        if ($respGet['acao'] == "removerTemplate") {
            $idTemplate = array('id' => $respGet['idTemplate']);
            $executar= postRest('userMenu/postDesativarTemplate',$idTemplate);
            $msnTexto = "ao remover menu.";
            $respGet['acao'] = "buscar"; 
            $respGet['nome'] = ""; 
        }
//ACESSO INCLUIR
    if ($respGet['acao'] == "incluirTemplate") {
        $variavel = array('excluir','alterar','listar','buscar','incluir');
        $respGet = trueFalse($respGet, $variavel);
        $arrayJson2D= postJson2D($respGet['idsUserMenu'],'idUserMenu');
        $acessoNivel = array(
                    'idUserTemplate' => $_SESSION['template']['id'],
                    'excluir' => $respGet['excluir'],
                    'alterar' => $respGet['alterar'],
                    'listar' => $respGet['listar'],
                    'buscar' => $respGet['buscar'],
                    'incluir' => $respGet['incluir'],
                    'idsUserMenu' => $arrayJson2D
                );
        $msnTexto = "ao cadastrar menu.";
        $executar = postRest('userMenu/postAdicionarTemplatePermissaoAcesso',$acessoNivel);
        $buscaAcessoTemplate = array('id' => $_SESSION['template']['id']);
        $_SESSION['verTemplate']= getRest('userMenu/getListaTemplatePermissaoAccesso',$buscaAcessoTemplate);
    }
//ACESSO REMOVER
    if ($respGet['acao'] == "removeAcesso") {
        $idTemplate = array('idUserTemplate' => $respGet['idUserTemplate'],'idUserMenu' => $respGet['idUserMenu']);
        $msnTexto = "ao remover menu.";
        $executar= postRest('userMenu/postExcluirTemplatePermissaoAcesso',$idTemplate);
        $buscaAcessoTemplate = array('id' => $_SESSION['template']['id']);
        $_SESSION['verTemplate']= getRest('userMenu/getListaTemplatePermissaoAccesso',$buscaAcessoTemplate);
    }
//ACESSOS EXIBIR 
    if ($respGet['acao'] == "exibirAcesso") {
        $buscaMenu = array('id' => $respGet['idappversao']);
        $_SESSION['verMenu']= getRest('userMenu/getListaMenuItem',$buscaMenu);
        $buscaAcessoTemplate = array('id' => $respGet['idTemplate']);
        $_SESSION['verTemplate']= getRest('userMenu/getListaTemplatePermissaoAccesso',$buscaAcessoTemplate);
        $_SESSION['template']= array('id'=>$respGet['idTemplate'],'nome'=>$respGet['nometemplate']);
    }
//BUSCAR
    if ($respGet['acao'] == "buscar") {
        $_SESSION['verTemplate'] = '';
        if($respGet['idappversao']==null){
            $msnTexto = "ao buscar Template! É necessario informar o app.";
            $executar['info'] = 400;
        }else{
            $cBusca = array('id' => $respGet['idappversao'], 'nome' => $respGet['nome']);
            $result= getRest('appversao/getListaUserTemplatePorAppVersao',$cBusca);
            $msnTexto = "ao buscar Template.";
            $executar['info'] = 200;
        }
    }
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
//echo "<pre>";
//print_r($cBusca);
//echo "</pre>";
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
                <form action="index.php" method="<?=$method?>">
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
                                    <select name="idappversao" size="1" class="form-control select2" id='ocorrencia' style="width: 100%;">
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
                        <input type="hidden" name="pg" value="1"/>
                        <input type="hidden" name="pst" value="<?= $pst ?>"/>
                        <input type="hidden" name="arq" value="<?= $arq ?>"/>
                        <input type="hidden" name="closeResult" value='1' />
                        <input type="hidden" name="tabela" value="buscar" />
                        <input type="hidden" name="acao" value="buscar" />
                        <button type="submit" class="btn btn-default">Buscar</button>
                    </div>
                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-primary <?php if(!$respGet['closeResult']){?> collapse <?php }?>">
         <div class="box-header with-border">
           <h3 class="box-title">Resultado</h3>

           <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-<?php if(!$respGet['closeResult']){?>plus<?php }else{?>minus<?php }?>"></i>
             </button>
           </div>
         </div>
         <div class="box-footer">
           <?php if((count($result) == 0)and($executar['info'] == 200)){?>
                    <form method="<?=$method?>" action="index.php" class="inline">
                        <input type="hidden" name="pst" value="<?=$pst?>"/>
                        <input type="hidden" name="arq" value="<?=$arq?>"/>
                        <input type="hidden" name="closeAcesso" value="1" />
                        <input type="hidden" name="closeBusca" value="1" />
                        <input type="hidden" name="acao" value="incluirPerfil" />
                        <input type="hidden" name="idappversao" value="<?=$respGet['idappversao']?>"/>
                        <input type="hidden" name="nome" value="<?=$respGet['nome']?>"/>
                        <input type="hidden" name="pg" value="1"/>
                        <button type="submit" class="btn btn-primary btn-block">
                          Criar novo perfil: '<?=$respGet['nome']?>'
                        </button>
                    </form>
           <?php }?>
         </div>
         <div class="box-body">
           <ul class="products-list product-list-in-box">
            <?php foreach ($result as $ArrEsp){?>
                 <li class="item">
                   <div class="product-img">
                       <?php modalClonarTemplate($ArrEsp['id'], 'Clonar Acesso', $pst, $arq,'clonarTemplate',$respGet);?>
                        <form method="<?=$method?>" action="index.php" class="inline">
                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                            <input type="hidden" name="closeResult" value="1" />
                            <input type="hidden" name="acao" value="removerTemplate" />
                            <input type="hidden" name="idappversao" value="<?=$respGet['idappversao']?>"/>
                            <input type="hidden" name="idTemplate" value="<?=$ArrEsp['id']?>"/>
                            <button type="submit" class="btn btn-small btn-danger">
                              <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        <form method="<?=$method?>" action="index.php" class="inline">
                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                            <input type="hidden" name="closeAcesso" value="1" />
                            <input type="hidden" name="closeBusca" value="1" />
                            <input type="hidden" name="acao" value="exibirAcesso" />
                            <input type="hidden" name="idappversao" value="<?=$respGet['idappversao']?>"/>
                            <input type="hidden" name="idTemplate" value="<?=$ArrEsp['id']?>"/>
                            <input type="hidden" name="nometemplate" value="<?=$ArrEsp['nome']?>"/>
                            <button type="submit" class="btn btn-small btn-primary">
                              <i class="fa fa-edit"></i>
                            </button>
                        </form>
                       
                        <a href="" type="button" class="btn btn-small btn-success espaco-direita" data-toggle="modal" data-target="#<?=$ArrEsp['id']?>">
                           <i class="fa fa-clone"></i>
                       </a>                
                   </div>
                   <div class="product-info">
                        <b><?=$ArrEsp['nome']?></b>
                   </div>
                 </li>
             <?php }?>
           </ul>
         </div>
       </div>
    </div>
    <?php 
        $addAcessoTemplateTitulo = 'Adicionar Acessos ao Template';
        require_once 'usuario/addAcessoTemplate.php';
        require_once 'usuario/showAcessoTemplate.php';
    ?>

</div>