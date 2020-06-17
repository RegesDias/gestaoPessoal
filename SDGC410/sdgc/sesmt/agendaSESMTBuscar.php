<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    autoComplete($_SESSION["nomePessoas"], '#nome', '1');
    if($respGet['acao'] ==  'buscaAtendimentos'){
        $cBusc = array($respGet[nome],$respGet[matricula],$respGet[cpf]);
        $listarBusca = getRest('requerimento/getListarRequerimentoPorNomeMatriculaCpf',$cBusc);
    }
?> 
<div class="box box-primary">
  <div class="box-header with-border">
    <div class="col-sm-12">
        <h3 class="box-title"> <i class="fa fa-search"></i> Buscar</h3>
    </div>
    <div class="col-sm-12"><br></div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>
                    <input type="text" id="nome" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Matrícula</label>
                    <input type="text" id="matricula"  class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">CPF</label>
                    <input type="text" id="cpf" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12"><br></div>
    <div class="modal-footer">
        <button class="btn btn-success" onclick="buscaServidor('buscaAtendimentos',$('#nome').val(),$('#matricula').val(),$('#cpf').val())" type="button">
            <i class="fa fa-search"></i> Buscar
        </button>
    </div>
    <!-- /.box-tools -->
  </div>
  <!-- /.box-header -->
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
         </div>
  <!-- /.box-body -->
  <div class="box-footer no-padding">
    <div class="mailbox-controls">
    </div>
  </div>
</div>
<?php if ((count($listarBusca) == 0) and ($respGet['acao'] ==  'buscaAtendimentos')){ ?>
        <div class="col-lg-12 col-xs-6">
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
<script>
    configuraTela(); 
</script>
<script>
    window.onload = limparResult('limpar');
</script>