<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    if($respGet[acao] == 'CarregarCalendario'){
        $dp = $respGet[inicio];
        $du = $respGet[fim];
    }else{
        $dp = $respGet[mes]."-01";
        $du = date("Y-m-d", strtotime( "+1 month,-1 day", strtotime( $dp))); 
    }
    $bdm= array($dp,$du,$respGet[idMedico]);  

    $listaEmm = getRest('requerimento/getFolhaPorIdReqMedicoPeriodo',$bdm);
?>
<link href='calendario/core/main.css' rel='stylesheet' />
<link href='calendario/daygrid/main.css' rel='stylesheet' />
<script src='calendario/core/main.js'></script>
<script src='calendario/interaction/main.js'></script>
<script src='calendario/daygrid/main.js'></script>
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }
</style>
<script>

    $(document).ready(function () {

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid'],
            header: {
                left: 'prevYear,prev,next,nextYear today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            defaultDate: '<?=$dp?>',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                <?php foreach ($listaEmm as $folha) {
                    if($folha[periodo] == 'tarde'){
                        $backgroundColor = '#DD4B39';
                        $borderColor = '#DD4B39';
                    }else{
                        $backgroundColor = '#3C8DBC';
                        $borderColor = '#3C8DBC';                        
                    }
                    if($folha[periodo] == 'manha'){$folha[periodo] = 'Manhã';}
                    if($folha[periodo] == 'tarde'){$folha[periodo] = 'Tarde';}
                    $folha[data] = substr($folha[data], 0, -6);
                    ?>
                    {
                        title: '<?=$folha[periodo]?>',
                        start: '<?=$folha[data]?>',
                        backgroundColor: '<?=$backgroundColor?>',
                        borderColor: '<?=$borderColor?>'
                    },
                <?php }?>

            ]
        });
        console.log(calendar);
        calendar.render();

    });


</script>

<div id='calendar'>
    
</div>
<?php if($respGet[acao] == 'CarregarCalendario'){?>
<div class="box-footer">
    <button type="submit" id='enviarChamado' class="pull-right btn btn-primary" onclick="agendaSESMTAgendaSalvar('AbrirAgenda', $('#inicio').val(), $('#fim').val(), $('#idMedico').val(),$('#periodo').val())">
        <i class="fa fa-envelope-o"></i> Liberar
    </button>
    <button type="reset" class="btn btn-default" onclick="agendaSESMTAgendaEditar('limpar')">
        <i class="fa fa-times"></i> Descartar
    </button>
</div>
<?php }?>