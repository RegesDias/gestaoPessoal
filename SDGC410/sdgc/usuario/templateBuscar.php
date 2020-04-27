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
            exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
        }

//ACESSO REMOVER
    if ($respGet['acao'] == "removeAcesso") {
        $idTemplate = array('idUserTemplate' => $respGet['idUserTemplate'],'idUserMenu' => $respGet['idUserMenu']);
        $msnTexto = "ao remover menu.";
        $executar= postRest('userMenu/postExcluirTemplatePermissaoAcesso',$idTemplate);
        $buscaAcessoTemplate = array('id' => $_SESSION['template']['id']);
        $_SESSION['verTemplate']= getRest('userMenu/getListaTemplatePermissaoAccesso',$buscaAcessoTemplate);
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
    print_p();
?>
    <div class="col-md-12">
        <div class="box box-primary">
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
                        <button class="btn btn-small btn-danger" onclick="templateRemover('removerTemplate','<?=$respGet['idappversao']?>','<?=$ArrEsp['id']?>')" type="button">
                            <i class="fa fa-trash"></i>
                        </button>
                        <button class="btn btn-small btn-primary" onclick="templateEditar('exibirAcesso','<?=$respGet['idappversao']?>','<?=$ArrEsp['id']?>','<?=$ArrEsp['nome']?>')" type="button">
                            <i class="fa fa-edit"></i>
                        </button>
                       
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