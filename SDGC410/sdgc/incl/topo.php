<?php 
    if ($_SESSION['leftmenu'] == 'sidebar-collapse'){
        $lm = 2;
        $lMenuLock = "fa-unlock-alt";
    }else{
        $lm = 1;
        $lMenuLock = "fa-lock";
    }
    if ($_SESSION['rightmenu'] == 'control-sidebar-open'){
        $rm = 2;
        $rMenuLock = "fa-lock";
    }else{
        $rm = 1;
        $rMenuLock = "fa-unlock-alt";
    }
?>
<header class="main-header">
    <?php
    if (!isset($respGet['pst'])){
        $logoPst = 'msn';
        $logoArq = 'principal';
    }else{
        $logoPst = $respGet['pst'];
        $logoArq = $respGet['arq'];
    }
    
    ?>
    <form method="<?=$method?>" action="index.php" class="inline">
        <input type="hidden" name="pst" value="<?=$logoPst?>"/>
        <input type="hidden" name="arq" value="<?=$logoArq?>"/>
        <input type="hidden" name="idSecretaria" value="<?=$respGet['idSecretaria']?>"/>
        <input type="hidden" name="varq" value="<?=$respGet['varq']?>"/>
        <input type="hidden" name="vpst" value="<?=$respGet['vpst']?>"/>
        <input type="hidden" name="relat" value="<?=$respGet['relat']?>"/>
        <input type="hidden" name="leftmenu" value="<?=$lm?>"/>
        <input type="hidden" name="rightmenu" value="2"/>
        <input type="hidden" name="orby" value="<?=$respGet['orby']?>"/>
        <input type="hidden" name="pg" value="1"/>
        <button type="submit" class="logo link-button">
            <span class="logo-mini"><img src="img/logoMenu.png" class="img-rounded"></span>
            <span class="logo-sdgc"><img src="img/logoMenu.png" class="img-rounded"><strong class="fontLogo">SDGC</strong><sub><i><?=$versaoSDGC?></i></sub></span>
        </button>
    </form>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="<?=$_SESSION['foto']?>" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?=$_SESSION['user']['nome']?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="<?=$_SESSION['foto']?>" class="img-circle" alt="User Image">

                            <p>
                                <?=$_SESSION['user']['nome']?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#"></a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#"></a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#"></a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="trocasenha.php" class="btn btn-default btn-flat">Trocar Senha</a>
                            </div>
                            <div class="pull-right">
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="sessionDestroy" value="1"/>
                                    <button type="submit" class="btn btn-default btn-flat">
                                          Sair
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Messages: style can be found in dropdown.less-->
                <!-- /.messages-menu -->

                <li class="dropdown messages-menu">
                    <a>
                    <form method="<?=$method?>" action="index.php" class="inline">
                        <input type="hidden" name="menuN1" value="">
                        <input type="hidden" name="link" value="">
                        <input type="hidden" name="pst" value="msn">
                        <input type="hidden" name="arq" value="principal">
                        <input type="hidden" name="acao" value='limparSessao'>
                        <button type="submit" class="link-button-limpo">
                           <i class="fa fa-envelope-o"></i>
                        </button>
                    </form>
                    </a>
                </li>

                <?php if (count($_SESSION["menuRight"])>0){?>
                    <li>
                        <a href="#" onclick="carregar('msn', 'chamado')" id="btnMenuUser"><img src="img/helpDesk.png" class="img-rounded"></a>
                    </li>
                    <li>
                        <a href="#" data-toggle="control-sidebar" id="btnMenuUser"><img src="img/vFox.png" class="img-rounded"></a>
                    </li>
                <?php }?>
            </ul>
        </div>
    </nav>
</header>

