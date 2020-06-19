
<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    if($respGet['acao'] ==  'buscaAtendimentos'){
        $cBusc = array($respGet[nome],$respGet[matricula],$respGet[cpf]);
        $listarBusca = getRest('requerimento/getListarRequerimentoPorNomeMatriculaCpf',$cBusc);
    }
?>
<div class="box box-primary">
    <div class="box-body no-padding">
        <div class="mailbox-controls">
        </div>
            <div class="table-responsive mailbox-messages">
                <div class="box-body chat" id="chat-box">
                    <?php foreach ($listarBusca as $key => $value) {
                        ?>
                      <div class="item">
                            <img src="<?=exibeFoto($value[cpf])?>" alt="user image" class="online">

                            <p class="message">
                              <a href="#" class="name">
                                <?=$value['matriculaServidor']?> - <?=$value['nomeServidor']?>
                              </a>
                            </p>
                            <div class="pull-right">
                                  <button type="button" onclick="agendaSESMTEntradaResult('ler','<?=$value[cpf]?>')" class="btn btn-primary btn-sm">
                                      <i class="fa fa-search"></i> Abrir
                                  </button>
                            </div>
                        </div>
                    <?php }?>
            <?php if ((count($listarBusca) == 0) and ($respGet['acao'] ==  'buscaAtendimentos')){ ?>
                     <div class="item">
                      <!-- small box -->
                      <div class="small-box bg-aqua">
                        <div class="inner">
                          <h3>Vazio</h3>

                          <p>Nenhum servidor encontrado</p>
                        </div>
                        <div class="icon">
                          <i class="fa   fa-check-square-o"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            <br>
                        </a>
                      </div>
                    </div>
            <?php } ?>
                 </div>
                <div class="box-footer no-padding">
                      <div class="mailbox-controls">
                      </div>
                </div>
        </div>
    </div>
</div>
<script>
    configuraTela(); 
</script>