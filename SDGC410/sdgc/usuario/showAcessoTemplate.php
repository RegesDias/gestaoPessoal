    <div class="col-md-12">
        <div class="box box-primary <?php if(!$respGet['closeAcesso']){?> collapsed-box <?php }?>">
         <div class="box-header with-border">
           <h3 class="box-title">Acessos</h3>

           <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-<?php if(!$respGet['closeAcesso']){?>plus<?php }else{?>minus<?php }?>"></i>
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
                <form method="<?=$method?>" action="index.php" class="inline">
                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                    <input type="hidden" name="closeAcesso" value="1" />
                    <input type="hidden" name="closeBusca" value="1" />
                    <input type="hidden" name="acao" value="removeAcesso" />
                    <input type="hidden" name="idUserTemplate" value="<?=$ArrEsp['idUserTemplate']?>"/>
                    <input type="hidden" name="idUserMenu" value="<?=$ArrEsp['idUserMenu']?>"/>
                    <button type="submit" class="btn btn-small btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>
                </form>
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