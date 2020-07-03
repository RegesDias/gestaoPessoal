
<?php
    session_start();
    require_once '../func/fPhp.php';
    $nome = array($respGet[id]);
    if($respGet[acao] == 'cadastrar'){
        $ag = array('idCargoGeral' => $respGet[id],'descricaoAtribuicao' => $respGet[desAtribuicao]);
        $agendar = array($ag);
        $executar = postRest('cargo/postIncluirAtribuicoesCargo',$agendar);
        $msnTexto = "ao cadastrar atribuição. ".$executar['msn'].'.';
        $respGet[desAtribuicao] = '';
    }
    if($respGet[acao] == 'alterar'){
        $ag = array('idAtribuicao' => $respGet[idAtribuicao],'idCargoGeral' => $respGet[id],'descricaoAtribuicao' => $respGet[desAtribuicao]);
        $agendar = array($ag);
        $executar = postRest('cargo/postIncluirAtribuicoesCargo',$agendar);
        $msnTexto = "ao alterar atribuição. ".$executar['msn'].'.';
    }
    if($respGet[acao] == 'apagar'){
        $ag = array('idAtribuicao' => $respGet[idAtribuicao]);
        $agendar = array($ag);
        $executar = postRest('cargo/postRemoverAtribuicoesCargo',$agendar);
        $msnTexto = "ao remover atribuição. ".$executar['msn'].'.';
        $respGet[desAtribuicao] = '';
    }
    
    exibeMsn($msnExibe,$msnTexto,$msnTipo,$executar);
    $lista = getRest('cargo/getListAtribuicoesCargoPorIdCargoGeral',$nome);
?>
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$respGet[nome]?></h3>
  </div>
    <h4>Atribuições:</h4>
  <div class="box-body">
        <?php foreach ($lista as $value) {?>
        <div class="box box-primary collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">COD <?=$value[idAtribuicao]?></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" onclick="cadastraAtribuicao('editar','<?=$respGet[id]?>','<?=$respGet[nome]?>','<?=$value[descricaoAtribuicao]?>','<?=$value[idAtribuicao]?>')">
                    <i class="fa fa-pencil"></i>
                </button>
                <button class="btn btn-box-tool" onclick="cadastraAtribuicao('apagar','<?=$respGet[id]?>','<?=$respGet[nome]?>','<?=$value[descricaoAtribuicao]?>','<?=$value[idAtribuicao]?>')">
                    <i class="fa fa-times"></i>
                </button>
              </div>
            </div>
             <?=$value[descricaoAtribuicao]?>
        </div>
        <?php }?>
  </div>
  <div class="box-body">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Cadastrar Atribuições</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">nome</label>

                  <div class="col-sm-10">
                    <input type="text" value="<?=$respGet[desAtribuicao]?>" class="form-control" id="atribuicao">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <?php if(!isset($respGet[idAtribuicao])){ ?>
                    <button class="btn btn-info pull-right" onclick="cadastraAtribuicao('cadastrar','<?=$respGet[id]?>','<?=$respGet[nome]?>',$('#atribuicao').val())">
                        Cadastrar
                    </button>
                 <?php }else{ ?>
                    <button class="btn btn-info pull-right" onclick="cadastraAtribuicao('alterar','<?=$respGet[id]?>','<?=$respGet[nome]?>',$('#atribuicao').val(),'<?=$respGet[idAtribuicao]?>')">
                        Alterar
                    </button>
                 <?php }?>
              </div>
              <!-- /.box-footer -->
            </div>
          </div>
        
  </div>
  <!-- /.box-body -->
</div>