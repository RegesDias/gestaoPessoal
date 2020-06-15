<?php
    session_start();
    require_once 'func/fPhp.php';
    require_once 'func/fModal.php';
?>
<!DOCTYPE html>
<html>
    <?php require_once 'incl/head.php';?>
    <body id='bobyPrincipal' class="hold-transition skin-blue sidebar-mini "  oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='SDGC'; return true;">
         <?php 
            require_once 'javascript/fJavaScript.php';
            require_once 'javascript/fAjax.php';
         ?>
        <div class="wrapper">
            <?php 
               require_once 'incl/topo.php';
               require_once 'incl/menu.php';
            ?>
            <div class="content-wrapper">
                <div class="row box espaco-esquerda">
                    <div class="overlay hidden" id="idSpinAll">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <div class="col-md-12 bg-gray-light">
                        <div id="corpo">
                            <?php require_once "msn/principal.php"; ?>
                        </div>
                    </div>
                    <div class="col-md-12 bg-gray-light" id='idBoxImprimir'>
                        <div id='idBoxInfoImprimir'>
                            <div id="imprimir">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 bg-gray-light" id='idBoxDados'>
                        <div id='idBoxInfoDados'>
                            <div id="dados">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                //limpar ListarAcesso
                if ($limparAcesso != "nao") {
                    $_SESSION['cadAcesso'] = '';
                    $_SESSION["menuModulos"] = '';
                    $_SESSION['moduloV'] = '';
                }
                require_once 'incl/rodape.php';
                require_once 'incl/menuUser.php';
            ?>
        <script>
            $(document).ready(function(){
                $('#idIconBtnCloseDados').click(function () {
                    $("#idBoxInfoDados").removeClass("collapsed-box");
                    $("#idBoxDados").addClass("hidden");
                    
                    
                });
                $('#idIconBtnCloseImprimir').click(function () {
                    $("#idBoxInfoImprimir").removeClass("collapsed-box");
                    $("#idBoxImprimir").addClass("hidden");
                    
                });
                $('#idIconBtnCloseCorpo').click(function () {
                    $("#idBoxInfoCorpo").removeClass("collapsed-box");
                    $("#idBoxCorpo").addClass("hidden");
                    
                });
            });
           
        </script>
        <div class="control-sidebar-bg"></div>
        </div>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="dist/js/adminlte.min.js"></script>
        <!-- Select2 -->
        <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
        <!-- InputMask -->
        <script src="plugins/input-mask/jquery.inputmask.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- date-range-picker -->
        <script src="bower_components/moment/min/moment.min.js"></script>
        <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <!-- bootstrap color picker -->
        <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <!-- bootstrap time picker -->
        <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!-- SlimScroll -->
        <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <!-- FastClick -->
        <script src="bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
        <script>
          $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard.js"></script>

    </body>
</html>
