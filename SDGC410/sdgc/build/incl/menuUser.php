 <aside id="idUserMenu" class="control-sidebar control-sidebar-dark active2" >
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
                      <ul class="control-sidebar-menu">
                        <li>
<!--                          <a href="index.php?pst=<?=$pst?>&arq=<?=$arq?>&pg=1&rightmenu=<?=$rm?>">
                            <i class="menu-icon fa <?=$rMenuLock?> bg-red"></i>

                            <div class="menu-info">
                              <h4 class="control-sidebar-subheading">Atenção Área Restrita</h4>

                              <p>Seu acesso controlado</p>
                            </div>
                          </a>-->
                        <form method="<?=$method?>" action="index.php" class="inline">
                            <input type="hidden" name="pst" value="<?=$respGet['pst']?>"/>
                            <input type="hidden" name="arq" value="<?=$respGet['arq']?>"/>
                            <input type="hidden" name="idSecretaria" value="<?=$respGet['idSecretaria']?>"/>
                            <input type="hidden" name="varq" value="<?=$respGet['varq']?>"/>
                            <input type="hidden" name="vpst" value="<?=$respGet['vpst']?>"/>
                            <input type="hidden" name="relat" value="<?=$respGet['relat']?>"/>
                            <input type="hidden" name="leftmenu" value="1"/>
                            <input type="hidden" name="rightmenu" value="<?=$rm?>"/>
                            <input type="hidden" name="orby" value="<?=$respGet['orby']?>"/>
                            <input type="hidden" name="pg" value="1"/>
                            <button type="submit" class="logo link-button">
                                <i class="menu-icon fa <?=$rMenuLock?> bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Atenção Área Restrita</h4>
                                    <p>Seu acesso controlado</p>
                                </div>
                            </button>
                        </form>
                        </li>
                      </ul>
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
                              if (($valorSub['pasta']!='')and($menuN1SubMenu == $valorSub['menuN1'])){?>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                     <input type="hidden" name="pst" value="<?=$valorSub['pasta']?>">
                                     <input type="hidden" name="arq" value="<?=$valorSub['arquivo']?>">
                                     <input type="hidden" name="acao" value='limparSessao'>
                                     <input type="hidden" name="tabMenuAtivo" value='<?=$valorSub['menuN1']?>'>
                                     <input type="hidden" name="leftmenu" value='1'>
                                     <input type="hidden" name="rightmenu" value='1'>
                                    <button class="link-button-menu-right" type="submit">
                                         <i class="fa fa-edit"></i> <?=$valorSub['link']?>
                                    </button>
                                 </form><br>
                            <?php
                              }
                           }
                        ?>
                    </div>
            <?php }
            }?>
    </div>
  </aside>