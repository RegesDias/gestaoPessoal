<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestão Compartilhada</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
    <!-- Menssagem -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="jquery.bootstrap-growl.js"></script>
    <!--AutoComplete-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- daterange picker -->
    <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <!-- fullCalendar -->

    <!--  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
      <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">-->
    <!-- Inclusao Da biblioteca de Impressao-->
    <script src="javascript/print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="javascript/print.min.css">
    <!-- Page script -->
    <script>

        function configuraTela() {
            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2();

                //Datemask dd/mm/yyyy
                $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
                //Datemask2 mm/dd/yyyy
                $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'});
                //Money Euro
                $('[data-mask]').inputmask();

                //Date range picker
                $('#reservation').daterangepicker({
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    startDate: "<?= $periodoMes[0] ?> 8:00",
                    endDate: "<?= $periodoMes[1] ?> 8:00"
                });
                //Date range picker with time picker
                //$('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
                $('input[name="datetimes"]').daterangepicker({
                    timePicker: true,
                    timePicker24Hour: true,
                    maxSpan: "1",
                    singleDatePicker: false,
                    startDate: "<?= $periodoMes[0] ?> 8:00",
                    endDate: "<?= $periodoMes[0] ?> 8:00",
                    minDate: "<?= $periodoMes[0] ?>",
                    maxDate: "<?= $periodoMes[1] ?> 23:59",
                    locale: {
                        format: 'DD/MM/YYYY HH:mm'
                    }
                });
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                        {
                            ranges: {
                                'Hoje': [moment(), moment()],
                                'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                                'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                                'Este Mês': [moment().startOf('month'), moment().endOf('month')],
                                'Mês passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                            },
                            startDate: moment(),
                            endDate: moment()
                        },
                        function (start, end) {
                            $('#daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                        }
                );

                //Date picker
                $('#datepicker').datepicker({
                    autoclose: true
                });

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                });
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });

                //Colorpicker
                $('.my-colorpicker1').colorpicker();
                //color picker with addon
                $('.my-colorpicker2').colorpicker();

                //Timepicker
                $('.timepicker').timepicker({
                    showInputs: false,
                    defaultTime: '0:00',
                    minuteStep: 1,
                    showMeridian: false
                });
            });
            //multselect
            $(document).ready(function () {
                // make code pretty
                window.prettyPrint && prettyPrint();

                // hack for iPhone 7.0.3 multiselects bug
                if (navigator.userAgent.match(/iPhone/i)) {
                    $('select[multiple]').each(function () {
                        var select = $(this).on({
                            "focusout": function () {
                                var values = select.val() || [];
                                setTimeout(function () {
                                    select.val(values.length ? values : ['']).change();
                                }, 1000);
                            }
                        });
                        var firstOption = '<option value="" disabled="disabled"';
                        firstOption += (select.val() || []).length > 0 ? '' : ' selected="selected"';
                        firstOption += '>Select ' + (select.attr('title') || 'Options') + '';
                        firstOption += '</option>';
                        select.prepend(firstOption);
                    });
                }

                $('#multiselect').multiselect();
            });
        }

        configuraTela();

    </script>

</head>
