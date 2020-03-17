
<aside class="main-sidebar">
    <section class="sidebar">
        <!-- search form (Optional) -->
        <form action="index.php" method="<?=$method?>" class="sidebar-form">
            <div class="input-group">
                <input type="hidden" name="pst" value="funcional"/>
                <input type="hidden" name="arq" value="buscar"/>
                <input type="hidden" name="pg" value="1"/>
                <input type="hidden" name="tabela" value="buscar" />
                <input type="hidden" name="acao" value="buscar" />
                <input type="text" name="nome" class="form-control" placeholder="Buscar ...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <ul class="sidebar-menu" data-widget="tree">
            <!--<li class="header">HEADER</li>-->
            <!-- Optionally, you can add icons to the links -->
            <?php
            foreach ($_SESSION["menuLeft"] as $valor) {
                //fechaMenuSub
                if (($atualN2!=$valor['menuN2'])and($abreMenuSub == true)){
                    $abreMenuSub = false;
                    echo '</ul></li>';
                }
                //fechaMenu
                if ($atualN1!=$valor['menuN1']){
                    if($abreMenu == true){
                        $atualN1=$valor['menuN1'];
                        echo '</ul></li>';
                    }else{
                         $abreMenu = true;
                         $atualN1=$valor['menuN1'];
                    }
                }
                if ($valor['pasta']== ''){
                        //abreMenu
                        if($valor[menuN1] == $_SESSION[menuN1]){
                            echo '<li class="active treeview menu-open">';
                        }else{
                            echo '<li class="treeview">'; 
                        }?>  
                        <a href="#"><i class="fa <?=$valor['icon']?>"></i> <span><?=$valor['menuN1']?></span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                    <?php
                }else{
                    if (($atualN2!=$valor['menuN2'])and($valor['menuN2']!= '')){
                        $atualN2=$valor['menuN2'];
                        $abreMenuSub = true;
                        if($valor[menuN2] == $_SESSION[menuN2]){
                            echo '<li class="active treeview menu-open">';
                        }else{
                            echo '<li class="treeview">'; 
                        }?>
                            <a href="#"><i class="fa fa-share"></i><?=$valor['menuN2']?>
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                    <?php }
                        //abreMenu
                        if($valor[menuN3] != ''){
                            $tag = $valor[link];
                            $valor[link] = $valor[menuN4];
                            $valor[arquivo] = $valor[pasta];
                        }
                        if(($valor[menuN3] == $valorMenuN3Atual) AND ($valor[menuN3] != '')){
                            $valor['link'] = FALSE;
                        }
                        $valorMenuN3Atual = $valor[menuN3];
                        if($valor['link'] != false){
                            if(($valor[link] == $_SESSION[link]) AND ($valor[menuN2] == $_SESSION[menuN3])){?>
                                <font color="#3C8DBC"><li> <i class="fa <?=$valor['icon']?>"></i> <b><?=' '.$valor['link']?></b></font><?php 
                            }else{ 
                                ?><li>
                                     <form method="<?=$method?>" action="index.php" class="inline">
                                         <input type="hidden" name="pst" value="<?=$valor['pasta']?>">
                                         <input type="hidden" name="arq" value="<?=$valor['arquivo']?>">
                                         <input type="hidden" name="menuN1" value="<?=$valor['menuN1']?>">
                                         <input type="hidden" name="menuN2" value="<?=$valor['menuN2']?>">
                                         <input type="hidden" name="menuN3" value="<?=$valor['menuN3']?>">
                                         <input type="hidden" name="menuN4" value="<?=$tag?>">
                                         <input type="hidden" name="link" value="<?=$valor['link']?>">
                                         <input type="hidden" name="pg" value='1'>
                                         <input type="hidden" name="acao" value='limparSessao'>
                                         <input type="hidden" name="leftmenu" value='2'>
                                         <input type="hidden" name="rightmenu" value='2'>
                                         <button type="submit" class="link-button-menu-left sidebar">
                                           <i class="fa <?=$valor['icon']?>"></i><?=' '.$valor['link']?>
                                         </button>
                                     </form>
                                 </li><?php 
                            }
                        }
                        
                }
            }
            ?>
    </section>
    <!-- /.sidebar -->
</aside>
<script>

.colorLink{ 
    color: #ff00ff; 
}
</script>