    <div class="col-md-12">
        <div class="box box-primary <?php if(!$respGet['closeAcesso']){?> collapsed-box <?php }?>">
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
                                    <select name="idsUserMenu[]" size="1" multiple="multiple" class="form-control select2" id='ocorrencia' style="width: 100%;">
                                        <?php foreach ($_SESSION['verMenu'] as $ArrEsp){?>
                                        <option value="<?=$ArrEsp['id']?>"><?=$ArrEsp['menuN1'].' - '.$ArrEsp['menuN2'].' - '.$ArrEsp['link']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Operação</label><br>
                                        <ul class="pagination pagination-sm inline">
                                           <i class="fa fa-pencil"></i> <input type="checkbox" name="incluir" value ='1' class="flat-red">
                                           <i class="fa fa-eraser"></i> <input type="checkbox" name="excluir" value ='1' class="flat-red">
                                           <i class="fa fa-exchange"></i> <input type="checkbox" name="alterar" value ='1' class="flat-red">
                                           <i class="fa fa-list-ol"></i> <input type="checkbox" name="listar" value ='1' class="flat-red">
                                           <i class="fa fa-search"></i> <input type="checkbox" name="buscar" value ='1' class="flat-red">
                                       </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer pull-right">
                        <input type="hidden" name="pg" value="1"/>
                        <input type="hidden" name="pst" value="<?= $pst ?>"/>
                        <input type="hidden" name="arq" value="<?= $arq ?>"/>
                        <input type="hidden" name="tabela" value="buscar" />
                        <input type="hidden" name="tabela" value="buscar" />
                        <input type="hidden" name="closeAcesso" value="1" />
                        <input type="hidden" name="closeBusca" value="1" />
                        <input type="hidden" name="acao" value="incluirTemplate" />
                        <button type="submit" class="btn btn-default">Cadastrar</button>
                    </div>
                </form>
                <!--Fim do formulario-->
                <!--Tabela que mostra valores buscados-->
            </div>
        </div>
    </div>