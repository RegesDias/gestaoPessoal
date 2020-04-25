<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
print_p();
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
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
?>
<div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$addAcessoTemplateTitulo.' '.$_SESSION['template']['nome']?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-<?php if(!$respGet['closeAcesso']){?>plus<?php }else{?>minus<?php }?>"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
                <form action="index.php" method="<?=$method?>">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                    <label for="exampleInputEmail1">Menu</label>
                                    <select name="idsUserMenu[]" size="1" multiple="multiple" class="form-control select2" id='idsUserMenu' style="width: 100%;">
                                        <?php foreach ($_SESSION['verMenu'] as $ArrEsp){?>
                                        <option value="<?=$ArrEsp['id']?>"><?=$ArrEsp['menuN1'].' - '.$ArrEsp['menuN2'].' - '.$ArrEsp['link']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Operação</label><br>
                                        <ul class="pagination pagination-sm inline">
                                           <i class="fa fa-pencil"></i>     <input type="checkbox" id="incluir" value ='1' class="flat-red">
                                           <i class="fa fa-eraser"></i>     <input type="checkbox" id="excluir" value ='1' class="flat-red">
                                           <i class="fa fa-exchange"></i>   <input type="checkbox" id="alterar" value ='1' class="flat-red">
                                           <i class="fa fa-list-ol"></i>    <input type="checkbox" id="listar" value ='1' class="flat-red">
                                           <i class="fa fa-search"></i>     <input type="checkbox" id="buscar" value ='1' class="flat-red">
                                       </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer pull-right">
                        <button class="btn btn-default" onclick="templateAlterar('incluirTemplate', $('#idsUserMenu').val(),$('#incluir').is(':checked'),$('#excluir').is(':checked'),$('#alterar').is(':checked'),$('#listar').is(':checked'),$('#buscar').is(':checked'))" type="button">
                            Cadastrar
                        </button>
                    </div>

                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>
<div class="col-md-12">
        <div class="box box-primary">
         <div class="box-header with-border">
           <h3 class="box-title">Acessos</h3>
           <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse">
                 <i class="fa fa-<?php if(!$respGet['closeAcesso']){?>plus<?php }else{?>minus<?php }?>"></i>
             </button>
           </div>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
           <ul class="products-list product-list-in-box">
             <!-- /.item -->
             <?php foreach ($_SESSION['verTemplate'] as $ArrEsp){?>
             <li class="item">
               <div class="product-img <?=$classAcessos?>">
                    <button class="btn btn-small btn-danger" onclick="removeAcesso('removeAcesso', '<?=$ArrEsp['idUserTemplate']?>','<?=$ArrEsp['idUserMenu']?>')" type="button">
                        <i class="fa fa-trash"></i>
                    </button>
               </div>
               <div class="product-info">
                 <span class="product-description">
                       <?=$ArrEsp['menuN1']?> <?=$ArrEsp['menuN2']?>
                 </span>
                        <b><?=$ArrEsp['link']?></b>
                 <a href="javascript:void(0)" class="product-title pull-right">
                    <?php
                        if($ArrEsp['incluir']==1){$iconI = 'fa fa-pencil';}else{$iconI = '';}
                        if($ArrEsp['excluir']==1){$iconE = 'fa fa-eraser';}else{$iconE = '';}
                        if($ArrEsp['alterar']==1){$iconA = 'fa fa-exchange';}else{$iconA = '';}
                        if($ArrEsp['listar']==1){$iconL = 'fa fa-list-ol';}else{$iconL = '';}
                        if($ArrEsp['buscar']==1){$iconB = 'fa fa-search';}else{$iconB = '';}
                    ?>
                     
                     <i class="<?=$iconI?>"></i>
                     <i class="<?=$iconE?>"></i> 
                     <i class="<?=$iconA?>"></i> 
                     <i class="<?=$iconL?>"></i>
                     <i class="<?=$iconB?>"></i> 
                 </a><br>
               </div>
             </li>
             <?php
                        }?>
           </ul>
         </div>
       </div>
    </div>
<script>
   configuraTela(); 
</script>