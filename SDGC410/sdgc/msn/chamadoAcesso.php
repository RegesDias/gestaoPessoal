<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
if($respGet[acao] == 'ativar'){
    $cadChamado = array('id' => $respGet['id']);
    $salvarChamado = array($cadChamado);
    $executar = postRest('chamadows/postAtivarChamadosAcesso',$salvarChamado);
    $msnTexto = "ao ativar Chamado.";
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
}
if($respGet[acao] == 'desativar'){
    $cadChamado = array('id' => $respGet['id']);
    $salvarChamado = array($cadChamado);
    $executar = postRest('chamadows/postDesAtivarChamadosAcesso',$salvarChamado);
    $msnTexto = "ao deativar Chamado.";
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
}
if($respGet[acao] == 'acessoSalvar'){
    $cadChamado = array('idUserLogin' => $respGet['idUserLogin'], 'idChamadoCategoria' => $respGet['idChamadoCategoria']);
    print_p($cadChamado);
    $salvarChamado = array($cadChamado);
    $executar = postRest('chamadows/postSalvarChamadosAcesso',$salvarChamado);
    $msnTexto = "ao criar Chamado.";
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
}

$idCategoria = array('Todos');
$respGet[lista]= getRest('chamadows/getChamadosAcesso',$idCategoria); 

if(isset($respGet[acao])){
    $_SESSION['Categoria'] = getRest('chamadows/listarChamadoCategoria');
    $_SESSION['UserLista'] = getRest('userloginws/getListaUserLogin');
}
?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Criar Acesso</h3>
    </div>
    <div class="box-body">
        <label for="exampleInputEmail1">Categoria</label>
        <select  class="form-control select2" name='categoria' id='idChamadoCategoria' style="width: 100%;">
             <option selected='selected' value='nulo'></option>
            <?php foreach ($_SESSION['Categoria'] as $value) {?>
                <option <?=$slc?> value='<?=$value[id]?>'><?=$value[nome]?></option>
            <?php }?>
        </select>
        <div class="form-group">
            <div class="form-group">
                <label for="exampleInputEmail1">Chave do Usuário</label></label> 
                <select  class="form-control select2" name='categoria' id='idUserLogin' style="width: 100%;">
                     <option selected='selected' value='nulo'></option>
                    <?php foreach ($_SESSION['UserLista'] as $value) {?>
                        <option <?=$slc?> value='<?=$value[id]?>'><?=$value[login]." - ".$value[nomeCompleto]?></option>
                    <?php }?>
                </select>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" id='enviarChamado' class="pull-right btn btn-primary" onclick="acessoSalvar('acessoSalvar', $('#idUserLogin').val(), $('#idChamadoCategoria').val())">
            <i class="fa fa-envelope-o"></i> Enviar
        </button>
        <button type="reset" class="btn btn-default" onclick="chamadoModelo('Todos')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
</div>
<div class="box-group" id="accordion">
     <?=controleDePagina($respGet[lista] ,$respGet[pg],"pagUpDownCh","chamadoModelo");?> 
     <?php foreach (paginaAtual($respGet[lista],$respGet[pg]) as $valor) {
       //foreach ($_SESSION["lista"]  as $valor) {
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
                          <button class="btn <?=$lable?> btn-small" onclick="alterarStatusAcesso('<?=$acao?>', '<?=$valor['id']?>')" id="perfil<?=$valor['id']?>" type="button">
                              <i class="fa <?=$btnAction?>"></i>
                          </button>
                      </div>
                  </div>
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?=$valor['id']?>">
                  <?=$valor['id']." - ".$valor[userLogin][nome]?>
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
                                               <b>Categoria:</b> <?=$valor[chamadoCategoria][nome]?>
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
    configuraTela(); 
</script>