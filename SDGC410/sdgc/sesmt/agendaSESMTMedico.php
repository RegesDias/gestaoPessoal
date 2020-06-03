<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
$diasemana = array(1=>'Domingo', 2=>'Segunda', 3=>'Terça', 4=>'Quarta', 5=>'Quinta', 6=>'Sexta', 7=>'Sabado');
if($respGet[acao] == 'medicoSalvar'){

        $cadastrarMedico = array(      
                        'idHistFunc' => $respGet['idHistFunc'],
                        'CRM' => $respGet['CRM'],
                        'atendimentosManha' => $respGet['atendimentosManha'],
                        'atendimentosTarde' => $respGet['atendimentosTarde'],
                        'listDiaManha'=> $respGet['diaManha'],
                        'listDiaTarde'=> $respGet['diaTarde']
                    );
        
        
        $cadastrarMedico = array($cadastrarMedico);
        $executar = postRest('requerimento/postIncluirRequerimentoMedicos',$cadastrarMedico);
}
if($respGet[acao] == 'ativarMedico'){
    $statusAlterar = array('idRequerimentoMedico' => $respGet[idMedico]);
    $sa = array($statusAlterar);
    $executar = postRest('requerimento/postAtivarRequerimentoMedico',$sa);
}
if($respGet[acao] == 'desativarMedico'){
    $statusAlterar = array('idRequerimentoMedico'=> $respGet[idMedico]);
    $sa = array($statusAlterar);
    $executar = postRest('requerimento/postDesativarRequerimentoMedico',$sa);
}
if($respGet[acao] == 'editarMedico'){
    $e = array('idRequerimentoMedico'=> $respGet[idMedico]);
    $em = getRest('requerimento/getListarRequerimentoMedico',$e);
    $bdm = array($em[0][idRequerimentoMedico],'manha');
    $bdt = array($em[0][idRequerimentoMedico],'tarde');
    $listaEmm = getRest('requerimento/getListarRequerimentoMedicoDias',$bdm);
    $listaEmt = getRest('requerimento/getListarRequerimentoMedicoDias',$bdt);
}
exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
$listaMedico = getRest('requerimento/getListarRequerimentoMedico');

print_p($em);
?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Cadastro Médico</h3>
    </div>
    <div class="box-body">
        <?php if($respGet[acao] != 'editarMedico'){ ?>
        <div class="row" id="idBoxSelectSecretaria">
            <div id="carregaLot"></div>
            <div class="col-md-12">
                <label>Secretaria</label>
                <select size="1" onchange="getAJAX(<?= "'" . $ajurl . "'"; ?>, 'lotacao/getListaLotacaoSubUsuario/', this.value, selectSingleSetorAjax)" class="form-control select2" id='secretariaID' name="idSecretaria" style="width: 100%;">
                </select>
            </div>
        </div>
        <div class="row" id="idBoxSelectSetor">
            <div class="col-md-12">
                <label>Setor</label>
                <select onchange="getAJAX(<?="'" . $ajurl . "'"; ?>, 'funcionalws/getListaFuncionalPorIdSetor/', this.value, selectServidoresPorSetor);" name="idSetor"  size="1" class="form-control select2" id="setorID" style="width: 100%;">
                </select>
            </div>
        </div>
        <label for="exampleInputEmail1">Servidor</label>
        <div id="carregaFuncional"></div>
        <select  class="form-control select2" name='servidor' id='multiselect' style="width: 100%;">
        </select>
        <?php }else{?>
        <select  class="form-control select2" name='servidor' id='multiselect' style="width: 100%;">
            <option selected value = '<?=$em[0][idHistFunc]?>'><?=$em[0][nomeMedico]?></option>
        </select>      
        <?php }?>

        <label for="exampleInputEmail1">CRM</label>
             <input type='text' id='CRM' value='<?=$em[0][CRM]?>' class="form-control" style="width: 100%;">

        <div class="row" id="idBoxSelectDiaSemana">
            <div class="col-md-6">
                <label>Dia Semana Manhã</label>
                
                <select name="diaManha[]" id="idDiaManha" size="1" multiple="multiple" class="form-control select2"  style="width: 100%;">
                    <?php
                        foreach ($diasemana as $ds) {
                            $i++;
                            foreach ($listaEmm as $ldt){
                                if($ldt == $i){
                                   $sm = true;
                                   break;
                                }else{
                                   $sm =false;
                                }
                            }
                            echo '<br>';
                            if($sm == true){
                                echo "<option selected value = '$i'>$ds</option>";
                            }else{
                                echo "<option value = '$i'>$ds</option>";  
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label>Atendimentos Manhã</label>
                <input type='number' id='atendimentosManha' value='<?=$em[0][atendimentosManha]?>' class="form-control" style="width: 100%;">
            </div>
        </div>
        <div class="row" id="idBoxSelectDiaSemana">
            <div class="col-md-6">
                <label>Dia Semana Tarde</label>
                <select name="diaTarde[]"id="idDiaTarde" size="1" multiple="multiple" class="form-control select2"  style="width: 100%;">
                    <?php
                        foreach ($diasemana as $ds) {
                            $f++;
                            foreach ($listaEmt as $ldm){
                                if($ldm == $f){
                                   $st = true;
                                   break;
                                }else{
                                   $st =false;
                                }
                            }
                            if($st == true){
                                echo "<option selected value = '$f'>$ds</option>";
                            }else{
                                echo "<option value = '$f'>$ds</option>";  
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label>Atendimentos Tarde</label>
                <input type='number' id='atendimentosTarde' value='<?=$em[0][atendimentosTarde]?>' class="form-control" style="width: 100%;">
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?php if($respGet[acao] != 'editarMedico'){ ?>
            <button class="btn btn-success pull-right btn-sm" onclick="medicoSalvar('medicoSalvar',$('select#idDiaManha option:selected').map(function() {return $(this).val();}).get(),$('select#idDiaTarde option:selected').map(function() {return $(this).val();}).get(),$('#multiselect').val(),$('#atendimentosManha').val(),$('#atendimentosTarde').val(),$('#CRM').val())" type="button">
                   <i class="fa fa-save"></i> Salvar
            </button>
        <?php }else{?>
            <button class="btn btn-success pull-right btn-sm" onclick="medicoSalvar('medicoSalvar',$('select#idDiaManha option:selected').map(function() {return $(this).val();}).get(),$('select#idDiaTarde option:selected').map(function() {return $(this).val();}).get(),$('#multiselect').val(),$('#atendimentosManha').val(),$('#atendimentosTarde').val(),$('#CRM').val())" type="button">
                <i class="fa fa-edit"></i> Alterar
            </button>
        <?php }?>
        <button type="reset" class="btn btn-default" onclick="agendaSESMTMedico('Limpar')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
</div>
<div class="box-group" id="accordion">
    <?php foreach ($listaMedico as $value){
        $bdm = array($value[idRequerimentoMedico],'manha');
        $bdt = array($value[idRequerimentoMedico],'tarde');
        $listadiaManha = getRest('requerimento/getListarRequerimentoMedicoDias',$bdm);
        $listadiaTarde = getRest('requerimento/getListarRequerimentoMedicoDias',$bdt);
        ?>
          <div class="panel box box-primary">
            <div class="box-header with-border">
                  <div class="pull-right box-tools">
                      <div class="pull-right box-tools">
                          <button class="btn btn-primary btn-small" onclick="medicoStatus('editarMedico', '<?=$value[idHistFunc]?>')" id="perfil<?=$value['id']?>" type="button">
                              <i class="fa fa-edit"></i>
                          </button>
                          <?php if($value[ativo]){ ?>
                                <button class="btn btn-success btn-small" onclick="medicoStatus('desativarMedico', '<?=$value[idRequerimentoMedico]?>')" id="perfil<?=$value['id']?>" type="button">
                                    <i class="fa fa-toggle-on"></i>
                                </button>                    
                          <?php }else{ ?>
                            <button class="btn btn-danger btn-small" onclick="medicoStatus('ativarMedico', '<?=$value[idRequerimentoMedico]?>')" id="perfil<?=$value['id']?>" type="button">
                                <i class="fa fa-toggle-off"></i>
                            </button>                  
                         <?php }?>
                      </div>
                  </div>
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#abre<?=$value['idHistFunc']?>">
                    <?=$value[CRM]."-".$value[nomeMedico]?>
                  </a>
                </h4>
            </div>
            <div id="abre<?=$value['idHistFunc']?>" class="panel-collapse collapse <?=$in?>">
              <div class="box-body">
                  <button class="btn link-button-limpo inline" id="perfil2<?=$value['idHistFunc']?>" type="button">
                       <form action="#" method="post">
                         <div class="item">
                               <div>
                                   <div class="row">
                                       <div class="attachment">
                                           <p class="filename">
                                               <b>Atualizado em:</b> <?=dataHoraBr($value['data'])?><?=$in?>
                                           </p>
                                           <p class="filename">
                                              <b><h3>Manhã</h3></b>
                                           </p>
                                           <p class="filename">
                                              <b>Total Atendimentos</b> <?=$value[atendimentosManha]?><?=$in?>
                                           </p>
                                           <p class="filename">
                                               <b>Dias de Semana:</b> 
                                              <?php                                                       
                                                foreach ($listadiaManha as $dsm){
                                                    echo diaSemana($dsm)." ";
                                                    
                                                }
                                              ?>       
                                           </p>
                                           <p class="filename">
                                             <b><h3>Tarde</h3></b>
                                           </p>
                                           <p class="filename">
                                              <b>Total Atendimentos</b> <?=$value[atendimentosTarde]?><?=$in?>
                                           </p>
                                           <p class="filename">
                                              <b>Dias de Semana:</b> 
                                              <?php                                                       
                                                foreach ($listadiaTarde as $dsm){
                                                    echo diaSemana($dsm)." ";    
                                                }
                                              ?>
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
    <?php }?>
</div>
<script>
    configuraTela(); 
</script>

<?php
require_once '../javascript/fBoxSecretariaSetor.php';
?>
