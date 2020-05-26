<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
if($respGet[acao] == 'ativar'){
    $cadChamado = array('id' => $respGet['id']);
    $salvarChamado = array($cadChamado);
    $executar = postRest('agendaSESMTws/postAtivarChamadosAcesso',$salvarChamado);
    $sesmtTexto = "ao ativar Chamado.";
    exibeMsn($sesmtExibe,$sesmtTexto,$sesmtTipo,$executar);
}
if($respGet[acao] == 'desativar'){
    $cadChamado = array('id' => $respGet['id']);
    $salvarChamado = array($cadChamado);
    $executar = postRest('agendaSESMTws/postDesAtivarChamadosAcesso',$salvarChamado);
    $sesmtTexto = "ao deativar Chamado.";
    exibeMsn($sesmtExibe,$sesmtTexto,$sesmtTipo,$executar);
}
if($respGet[acao] == 'acessoSalvar'){
    $cadChamado = array('idUserLogin' => $respGet['idUserLogin'], 'idChamadoCategoria' => $respGet['idChamadoCategoria']);
    print_p($cadChamado);
    $salvarChamado = array($cadChamado);
    $executar = postRest('agendaSESMTws/postSalvarChamadosAcesso',$salvarChamado);
    $sesmtTexto = "ao criar Chamado.";
    exibeMsn($sesmtExibe,$sesmtTexto,$sesmtTipo,$executar);
}

$idCategoria = array('Todos');
$respGet[lista]= getRest('agendaSESMTws/getChamadosAcesso',$idCategoria); 

if(isset($respGet[acao])){
    $_SESSION['Categoria'] = getRest('agendaSESMTws/listarChamadoCategoria');
    $_SESSION['UserLista'] = getRest('userloginws/getListaUserLogin');
}
?>

<div class="box box-primary">
    <div class="box-group" id="accordion">
       <div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#abrirAgenda" data-toggle="tab">Abrir</a></li>
              <li><a href="#alterarAgenda" data-toggle="tab">Alterar</a></li>
            </ul>
            <div class="tab-content">
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="abrirAgenda">
                    <div class="box-header with-border">
                        <h3 class="box-title">Abrir Agenda</h3>
                    </div>
                    <div class="box-body">
                        <label for="exampleInputEmail1">Médico</label>
                        <select  class="form-control select2" name='categoria' id='idChamadoCategoria' style="width: 100%;">
                             <option selected='selected' value='nulo'></option>
                            <?php foreach ($_SESSION['Categoria'] as $value) {?>
                                <option <?=$slc?> value='<?=$value[id]?>'><?=$value[nome]?></option>
                            <?php }?>
                        </select>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mês</label></label> 
                                <input type='month'  class="form-control" name='categoria' id='idUserLogin' style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" id='enviarChamado' class="pull-right btn btn-primary" onclick="acessoSalvar('acessoSalvar', $('#idUserLogin').val(), $('#idChamadoCategoria').val())">
                            <i class="fa fa-envelope-o"></i> Liberar
                        </button>
                        <button type="reset" class="btn btn-default" onclick="agendaSESMTModelo('Todos')">
                            <i class="fa fa-times"></i> Descartar
                        </button>
                    </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="alterarAgenda">
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
                                                       <b>Categoria:</b> <?=$valor[agendaSESMTCategoria][nome]?>
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
          </div>
</div>
<script>
    configuraTela(); 
</script>

