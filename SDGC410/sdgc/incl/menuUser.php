<div id="fechaMenuUser">
<aside class="control-sidebar control-sidebar-dark active">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <?php
        $ativadoMenu;
        $respGet['tabMenuAtivo'];
        if(isset($respGet['tabMenuAtivo'])){
            $_SESSION['tabMenuAtivo'] = $respGet['tabMenuAtivo'];
        }
        foreach ($_SESSION["menuRight"] as $valorTop) {
            if ($valorTop['pasta']== ''){
                if ($valorTop['menuN1'] == $_SESSION['tabMenuAtivo']){
                    $ativadoMenu = "active";
                }else{
                    $ativadoMenu = '';
                }?>
              <li class="<?=$ativadoMenu?>"><a href="#<?=$valorTop['link']?>" aria-expanded="true" data-toggle="tab"><i class="fa <?=$valorTop['icon']?>"></i></a></li>
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
                                }?>
                                <button data-toggle="control-sidebar" class="link-button-menu-left" onclick="carregar('<?= $valorSub['pasta'] ?>', '<?= $valorSub['arquivo'] ?>', '<?= $valorSub['menuN1'] ?>','<?= $valorSub['menuN2'] ?>','<?= $valorSub['menuN3'] ?>','<?= $valorSub['menuN4'] ?>', '<?= $valorSub['link'] ?>', '#id<?=$valorSub['id']?>')"  type="button">
                                  <i class="fa <?=$valorSub['icon']?>"></i> <b><?=$valorSub['link']?></b>
                                </button>
                        <?php
                            }
                           }
                        ?>
                    </div>
            <?php }
            }?>
    </div>
  </aside>
</div>