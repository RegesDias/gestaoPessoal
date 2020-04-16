 <aside class="control-sidebar control-sidebar-dark active2">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <?php
        $ativadoMenu;
        $respGet['tabMenuAtivo'];
        if(isset($respGet['tabMenuAtivo'])){
            $_SESSION['tabMenuAtivo'] = $respGet['tabMenuAtivo'];
        }
        foreach ($_SESSION["menuRight"] as $valor) {
            if ($valor['pasta']== ''){
                if ($valor['menuN1'] == $_SESSION['tabMenuAtivo']){
                    $ativadoMenu = "active";
                }else{
                    $ativadoMenu = '';
                }?>
              <li class="<?=$ativadoMenu?>"><a href="#<?=$valor['link']?>" aria-expanded="true" data-toggle="tab"><i class="fa <?=$valor['icon']?>"></i></a></li>
            <?php }
         }?>
    </ul>
    <div class="tab-content">
        <?php  
            foreach ($_SESSION["menuRight"] as $valor) {
                if ($valor['pasta'] == ''){
                    $menuN1SubMenu = $valor['menuN1'];
                    if ($valor['menuN1'] == $_SESSION['tabMenuAtivo']){
                        $ativadoMenu = 'active';
                    }else{
                        $ativadoMenu = '';
                    }?>
                    <div class="tab-pane <?=$ativadoMenu?>" id="<?=$valor['link']?>">
                      <h3 class="control-sidebar-heading"><?=$valor['menuN1']?></h3>
                        <?php       
                            foreach ($_SESSION["menuRight"] as $valorSub) {
                              if (($valorSub['pasta']!='')and($menuN1SubMenu == $valorSub['menuN1'])){
                                if($valorSub[link] == 'Acesso - Editar/Cadastrar'){
                                    $_SESSION[usuario] = true;
                                }
                                if($valorSub[link] == $_SESSION[link]){?>
                                    <a href="#"><i class="fa fa-edit"></i> <b><?=' '.$valorSub['link']?></b></a><?php 
                                }else{?>
                                <button class="link-button-menu-right" onclick="carregar('<?= $valorSub['pasta'] ?>', '<?= $valorSub['arquivo'] ?>', '<?= $valorSub['menuN1'] ?>','<?= $valorSub['menuN2'] ?>','<?= $valorSub['menuN3'] ?>','<?= $valorSub['menuN4'] ?>', '<?= $valorSub['link'] ?>', '#id<?=$valorSub['id']?>')" class="link-button-menu-left sidebar" type="button">
                                    <i class="fa fa-edit"></i> <?=$valorSub['link']?>
                                </button>
<!--                                <form method="<?=$method?>" action="index.php" class="inline">
                                     <input type="hidden" name="pst" value="<?=$valorSub['pasta']?>">
                                     <input type="hidden" name="arq" value="<?=$valorSub['arquivo']?>">
                                     <input type="hidden" name="acao" value='limparSessao'>
                                     <input type="hidden" name="link" value='<?=$valorSub['link']?>'>
                                     <input type="hidden" name="menuN1" value='<?=$valorSub['menuN1']?>'>
                                     <input type="hidden" name="menuN2" value='<?=$valorSub['menuN2']?>'>
                                     <input type="hidden" name="tabMenuAtivo" value='<?=$valorSub['menuN1']?>'>
                                     <input type="hidden" name="leftmenu" value='1'>
                                     <input type="hidden" name="rightmenu" value='1'>
                                    <button class="link-button-menu-right" type="submit">
                                         <i class="fa fa-edit"></i> <?=$valorSub['link']?>
                                    </button>
                                 </form><br>-->
                            <?php
                            }}
                           }
                        ?>
                    </div>
            <?php }
            }?>
    </div>
  </aside>