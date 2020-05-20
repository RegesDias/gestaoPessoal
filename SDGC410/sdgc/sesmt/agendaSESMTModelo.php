<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
if($respGet[acao] == 'ativar'){
    $cadChamado = array('id' => $respGet['id']);
    $salvarChamado = array($cadChamado);
    $executar = postRest('agendaSESMTws/postAtivarChamadoMsnModelo',$salvarChamado);
    $sesmtTexto = "ao ativar Chamado.";
    exibeMsn($sesmtExibe,$sesmtTexto,$sesmtTipo,$executar);
}
if($respGet[acao] == 'desativar'){
    $cadChamado = array('id' => $respGet['id']);
    $salvarChamado = array($cadChamado);
    $executar = postRest('agendaSESMTws/postDesativarChamadoMsnModelo',$salvarChamado);
    $sesmtTexto = "ao deativar Chamado.";
    exibeMsn($sesmtExibe,$sesmtTexto,$sesmtTipo,$executar);
}
if($respGet[acao] == 'modeloSalvar'){
    $cadChamado = array('idCategoria' => $respGet['categoria'], 'texto' => $respGet['texto']);
    $salvarChamado = array($cadChamado);
    $executar = postRest('agendaSESMTws/postInserirChamadoMsnModelo',$salvarChamado);
    $sesmtTexto = "ao criar Chamado.";
    exibeMsn($sesmtExibe,$sesmtTexto,$sesmtTipo,$executar);
}
if($respGet[acao] == 'modeloEditar'){
    $cadChamado = array('id' => $respGet['id'], 'idCategoria' => $respGet['idCategoria'], 'texto' => $respGet['texto']);
    $salvarChamado = array($cadChamado);
    $executar = postRest('agendaSESMTws/postAlterarChamadoMsnModelo',$salvarChamado);
    $sesmtTexto = "ao criar Chamado.";
    exibeMsn($sesmtExibe,$sesmtTexto,$sesmtTipo,$executar);
}
if($respGet[acao] == 'buscarId'){
    $cadChamado = array('id' => $respGet['id']);
    $editarModelo = getRest('agendaSESMTws/getChamadoMsnModeloPorId',$cadChamado);
}
$agendaSESMTsCategoria = getRest('agendaSESMTws/listarChamadoCategoria');
$idCategoria = array('Todos');
$respGet[lista]= getRest('agendaSESMTws/getListarChamadoMsnModelo',$idCategoria); 
?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Criar um Novo Modelo</h3>
    </div>
    <div class="box-body">
        <label for="exampleInputEmail1">Categoria</label>
        <select  class="form-control select2" name='categoria' id='idCategoria' style="width: 100%;">
             <option selected='selected' value='nulo'></option>
            <?php foreach ($agendaSESMTsCategoria as $value) {
                if($value[id] == $editarModelo[0][agendaSESMTCategoria][id]){
                    $slc = 'selected';
                }else{
                    $slc = '';
                }
                ?>
                <option <?=$slc?> value='<?=$value[id]?>'><?=$value[nome]?></option>
            <?php }?>
        </select>
        <div class="form-group">
            <div class="form-group">
                <label for="exampleInputEmail1">Descreva em poucas palavras:</label> <i><sub class="caracteres">200</sub> <sub>Restantes </sub></i></label> 
                <textarea id="textoMsn" name='textoMsn' class="form-control"  maxlength="200" rows="4"><?=$editarModelo[0][texto]?></textarea>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?php if($respGet[acao] != 'buscarId'){ ?>
            <button type="submit" id='enviarChamado' class="pull-right btn btn-primary" onclick="modeloSalvar('modeloSalvar', $('#idCategoria').val(), $('#textoMsn').val())">
                <i class="fa fa-envelope-o"></i> Enviar
            </button>
        <?php }else{?>
            <button type="submit" id='enviarChamado' class="pull-right btn" onclick="modeloEditar('modeloEditar', $('#idCategoria').val(), $('#textoMsn').val(),<?=$editarModelo[0][id]?>)">
                <i class="fa fa-edit"></i> Alterar
            </button>
        <?php }?>
        <button type="reset" class="btn btn-default" onclick="agendaSESMTModelo('Todos')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
</div>
<div class="box-group" id="accordion">
     <?=controleDePagina($respGet[lista] ,$respGet[pg],"pagUpDownCh","agendaSESMTModelo");?> 
     <?php foreach (paginaAtual($respGet[lista],$respGet[pg]) as $valor) {
              if($valor['ativo'] == false){
                  $lable = 'btn-danger';
                  $btnAction = 'fa-remove';
                  $acao = 'ativar';
              }else{
                  $lable = 'btn-success';
                  $btnAction = 'fa-check';
                  $acao = 'desativar';
              }?>
      <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
          <div class="panel box box-primary">
            <div class="box-header with-border">
                  <div class="pull-right box-tools">
                      <div class="pull-right box-tools">
                          <button class="btn primary btn-small" onclick="alterarStatusModelo('buscarId', '<?=$valor['id']?>')" id="perfil<?=$valor['id']?>" type="button">
                              <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn <?=$lable?> btn-small" onclick="alterarStatusModelo('<?=$acao?>', '<?=$valor['id']?>')" id="perfil<?=$valor['id']?>" type="button">
                              <i class="fa <?=$btnAction?>"></i>
                          </button>
                      </div>
                  </div>
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?=$valor['id']?>">
                  <?=$valor['id']." - ".$valor[agendaSESMTCategoria][nome]?>
                </a>
              </h4>
            </div>
            <div id="<?=$valor['id']?>" class="panel-collapse collapse <?=$in?>">
              <div class="box-body">
                  <button class="btn link-button-limpo inline" id="perfil2<?=$valor['id']?>" type="button">
                       <form action="#" method="post">
                         <div class="item">
                               <div>
                                   <div class="row">
                                       <div class="attachment">
                                           <p class="filename">
                                               <b>Atualizado em:</b> <?=dataHoraBr($valor['dataHora'])?><?=$in?>
                                           </p>
                                           <p class="filename">
                                               Texto: <?=$valor['texto']?>
                                           </p>
                                       </div>
                                  </div>
                               </div>
                           </div>
                       </form>
                   </button>
              </div>
            </div>
          </div>
  <?php 
              }?>
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

<?php 