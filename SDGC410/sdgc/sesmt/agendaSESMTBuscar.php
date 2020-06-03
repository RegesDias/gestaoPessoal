<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    autoComplete($_SESSION["nomePessoas"], '#nome', '1');
    print_p();
    if($respGet['acao'] ==  'buscaAtendimentos'){
        echo entrou;
        $cBusc = array($respGet[nome],$respGet[matricula],$respGet[cpf]);
        $listarBusca = getRest('requerimento/getListarRequerimentoPorNomeMatriculaCpf',$cBusc);
    }
?> 
<div class="box box-primary">
  <div class="box-header with-border">
    <div class="col-sm-12">
        <h3 class="box-title"><?=$respGet['tipo']?> <span class="label label-primary"><?=count($_SESSION[listaChamados])?></span></h3>
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
        <button class="btn btn-primary" onclick="buscaAtendimentos('buscaAtendimentos',$('#nome').val(),$('#matricula').val(),$('#cpf').val())" type="button">
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
      <table class="table table-hover table-striped">
          
        <tbody>
            <tr>
              <td class="mailbox-subject">
                    <b>Servidor</b>
              </td>
            </tr>
            <?php foreach ($listarBusca as $key => $value) {?>
                <tr> 
                  <td>
                      <a href="#" onclick="agendaSESMTBuscarResult('ler','<?=$v[id]?>')">
                        27437 - REGES FERNANDES DIAS
                      </a> 
                  </td>
                </tr>
            <?php }?>
        </tbody>
      </table>
    </div>
    <!-- /.mail-box-messages -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer no-padding">
    <div class="mailbox-controls">
    </div>
  </div>
</div>
<?php if (!count($_SESSION[listaChamados])){ ?>
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Vazio</h3>

              <p>Nenhum agendaSESMT encontrado</p>
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