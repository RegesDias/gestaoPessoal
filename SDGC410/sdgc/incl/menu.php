
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="sidebar-form">
            <div class="input-group">
                <input type="text" id="idNcm" name="nomeCPFMatricula" class="form-control" placeholder="Buscar ...">
                <span class="input-group-btn">
                        <button onclick="buscarNomeCPFMatricula('funcional', 'buscar', $('#idNcm').val())" class="btn btn-primary" type="button">
                                <i class="fa fa-search"></i>
                        </button>
                </span>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <!--<li class="header">HEADER</li>-->
            <!-- Optionally, you can add icons to the links -->
            <?php
            foreach ($_SESSION["menuLeft"] as $valor) {
                //fechaMenuSub
                if (($atualN2 != $valor['menuN2'])and ( $abreMenuSub == true)) {
                    $abreMenuSub = false;
                    echo '</ul></li>';
                }
                //fechaMenu
                if ($atualN1 != $valor['menuN1']) {
                    if ($abreMenu == true) {
                        $atualN1 = $valor['menuN1'];
                        echo '</ul></li>';
                    } else {
                        $abreMenu = true;
                        $atualN1 = $valor['menuN1'];
                    }
                }
                if ($valor['pasta'] == '') {
                    //abreMenu
                    if ($valor[menuN1] == $_SESSION[menuN1]) {
                        echo '<li class="active treeview menu-open">';
                    } else {
                        echo '<li class="treeview">';
                    }
                    ?>  
                    <a href="#"><i class="fa <?= $valor['icon'] ?>"></i> <span><?= $valor['menuN1'] ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php
                    } else {
                        if (($atualN2 != $valor['menuN2'])and ( $valor['menuN2'] != '')) {
                            $atualN2 = $valor['menuN2'];
                            $abreMenuSub = true;
                            if ($valor[menuN2] == $_SESSION[menuN2]) {
                                echo '<li class="active treeview menu-open">';
                            } else {
                                echo '<li class="treeview">';
                            }
                            ?>
                            <a href="#"><i class="fa fa-share"></i><?= $valor['menuN2'] ?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                            }
                            //abreMenu
                            if ($valor[menuN3] != '') {
                                $tag = $valor[link];
                                $valor[link] = $valor[menuN4];
                                $valor[menuN4] = $tag;
                                $valor[arquivo] = $valor[pasta];
                            }
                            if (($valor[menuN3] == $valorMenuN3Atual) AND ( $valor[menuN3] != '')) {
                                $valor['link'] = FALSE;
                            }
                            $valorMenuN3Atual = $valor[menuN3];
                            if ($valor['link'] != false) {
                                if (($valor[link] == $_SESSION[link]) AND ( $valor[menuN2] == $_SESSION[menuN3])) {
                                    ?>
                                    <font color="#3C8DBC"><li> <i class="fa <?= $valor['icon'] ?>"></i> <b><?= ' ' . $valor['link'] ?></b></font><?php
                                    } else {
                                        ?><li>
                                        <button id='id<?= $valor['id'] ?>' onclick="carregar('<?= $valor['pasta'] ?>', '<?= $valor['arquivo'] ?>', '<?= $valor['menuN1'] ?>','<?= $valor['menuN2'] ?>','<?= $valor['menuN3'] ?>','<?= $valor['menuN4'] ?>', '<?= $valor['link'] ?>', '#id<?=$valor['id']?>')" class="link-button-menu-left sidebar" type="button">
                                            <i class="fa <?= $valor['icon'] ?>"></i><?= ' ' . $valor['link'] ?>
                                        </button>
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
                        function carregar(pst, arq, menuN1, menuN2, menuN3, menuN4, link, obj) {
                            //O método $.ajax(); é o responsável pela requisição
                            console.log(pst);
                            console.log(arq);
                            
                            $.ajax
                                    ({
                                        //Configurações
                                        type: 'POST', //Método que está sendo utilizado.
                                        dataType: 'html', //É o tipo de dado que a página vai retornar.
                                        url: pst + '/' + arq + '.php', //Indica a página que está sendo solicitada.
                                        //função que vai ser executada assim que a requisição for enviada
                                        beforeSend: function () {
                                           
                                            $("#idSpinAll").removeClass("hidden");

                                        },
                                        data: {pst: pst, arq: arq, menuN1: menuN1, menuN2: menuN2, menuN3: menuN3, menuN4: menuN4, link: link, obj:obj}, //Dados para consulta
                                        //função que será executada quando a solicitação for finalizada.
                                        success: function (msg)
                                        {
                                            
                                            $("#corpo").html(msg);
                                            
                                            $("#idBoxImprimir").addClass("hidden");
                                            $("#idBoxResultado").addClass("hidden");
                                            $("#idBoxDados").addClass("hidden");
                                            configuraTela();
                                            $("#idSpinAll").addClass("hidden");
                                            $(".link-button-menu-left").removeClass("link-button-menu-select");
                                            $(obj).addClass("link-button-menu-select");
                                        }
                                    });
                        }
                        function buscarNomeCPFMatricula(pst, arq, nomeCPFMatricula) {
                            //O método $.ajax(); é o responsável pela requisição
                            console.log(pst);
                            console.log(arq);
                            console.log(nomeCPFMatricula);
                            $.ajax
                                    ({
                                        //Configurações
                                        type: 'POST', //Método que está sendo utilizado.
                                        dataType: 'html', //É o tipo de dado que a página vai retornar.
                                        url: pst + '/' + arq + '.php', //Indica a página que está sendo solicitada.
                                        //função que vai ser executada assim que a requisição for enviada
                                        beforeSend: function () {
                                            

                                        },
                                        data: {pst: pst, arq: arq, nomeCPFMatricula: nomeCPFMatricula}, //Dados para consulta
                                        //função que será executada quando a solicitação for finalizada.
                                        success: function (msg)
                                        {
                                            $("#corpo").html(msg);
                                            configuraTela();
                                            
                                        }
                                    });
                        }
                        
//------------------------Buscar por ENTER
                        $('#idNcm').keypress(function (e) {
                           if (e.keyCode == 13)
                           {
                               setTimeout(function(){ 
                                   $(this).trigger("enterKey");
                                   buscarNomeCPFMatricula('funcional', 'buscar', $('#idNcm').val());
                               }, 300);
                               
                           }
                       });
                    </script>
