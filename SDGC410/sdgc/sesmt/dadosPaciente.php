<?php
    print_p();
    modalInicoFim('macacoesInicioFim', 'Marcações', 'print', 'info', 'macacoesInicioFim', '', 'frequencia');

    $dados = array('dado','acao','ver');
    postRestAjax('relatorioEmGestao','imprimir','print/info.php',$dados);        
        
    $cBusc = array($respGet[nome],$respGet[matricula],$respGet[cpf]);
    $listarServidor = getRest('requerimento/getListarRequerimentoPorNomeMatriculaCpf',$cBusc);
?>
<div class="box-header with-border">
    <?php foreach ($listarServidor as $value){ 
        print_p($value);
        ?>
        <div class="user-block">
          <img class="img-circle" src="<?=exibeFoto($value[cpf])?>" alt="User Image">
          <span class="username"><a href="#"><?=$value[matriculaServidor]." - ".$value[nomeServidor]?></a></span>
          <span class="description"><?=$value[cargo]?></span>
        </div>
        <div class="box-body">
          <p><b>Nascimento:</b> <?=dataBr($value[nascimento])?> <b>Data Admissão: </b><?=dataBr($value[dataAdmissao])?></p>
          <p><b>Situação:</b> <?=$value[situacao]?>  <b>Hora/Semanal: </b> <?=$value[horaSemanal]?> </p>
        </div>
    <?php }?>
</div>
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#macacoesInicioFim">
    <i class="fa fa-print"></i> <b>Marcações</b>
</button>
<button class="btn btn-info" onclick="relatorioEmGestao('<?=$value['idHistFunc']?>','fichaFuncional',true)" type="button">
    <i class="fa fa-print"></i><b> Ficha Funcional</b>
</button>
<button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Histórico Médico</button>