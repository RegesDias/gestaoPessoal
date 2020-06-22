<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    autoComplete($_SESSION["nomePessoas"], '#nome', '1');
    $_SESSION[listaMedicos] = getRest('requerimento/getListarRequerimentoMedicoAtivos');
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
</div>
<script>
    configuraTela(); 
</script>
<script>
    window.onload = limparResult('limpar');
</script>