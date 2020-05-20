<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
if($respGet[acao] == 'salvarChamado'){
    $cadChamado = array('titulo' => $respGet['assunto'], 'texto' => $respGet['texto'], 'idCategoria' => $respGet['categoria']);
    $salvarChamado = array($cadChamado);
    $executar = postRest('agendaSESMTws/postCriarChamado',$salvarChamado);
    $sesmtTexto = "ao criar Chamado.";
    exibeMsn($sesmtExibe,$sesmtTexto,$sesmtTipo,$executar);
}
$agendaSESMTsCategoria = getRest('agendaSESMTws/listarChamadoCategoria');
?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Criar um Novo Chamado</h3>
    </div>
    <div class="box-body">
        <label for="exampleInputEmail1">Categoria</label>
        <select  class="form-control select2" name='categoria' id='idCategoria' style="width: 100%;">
             <option selected='selected' value='nulo'></option>
            <?php foreach ($agendaSESMTsCategoria as $value) {?>
                <option value = '<?=$value[id]?>'><?=$value[nome]?></option>
            <?php }?>
        </select>
        <label for="exampleInputEmail1">Assunto</label>
        <div class="form-group">
            <input type="text" id='assunto' class="form-control" placeholder="Assunto:">
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="exampleInputEmail1">Descreva em poucas palavras:</label> <i><sub class="caracteres">200</sub> <sub>Restantes </sub></i></label> 
                <textarea id="textoMsn" name='textoMsn' class="form-control"  maxlength="200" rows="4"></textarea>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" id='enviarChamado' class="pull-right btn btn-primary" onclick="agendaSESMTSalvar('salvarChamado', $('#idCategoria').val(),$('#assunto').val(), $('#textoMsn').val())">
            <i class="fa fa-envelope-o"></i> Enviar
        </button>
        <button type="reset" class="btn btn-default" onclick="agendaSESMTListar('Entrada')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
</div>
<script>
   $(document).on("keydown", "#textoMsn", function () {
       var caracteresRestantes = 149;
       var caracteresDigitados = parseInt($(this).val().length);
       var caracteresRestantes = caracteresRestantes - caracteresDigitados;
       $(".caracteres").text(caracteresRestantes);
   });
    configuraTela(); 
</script>