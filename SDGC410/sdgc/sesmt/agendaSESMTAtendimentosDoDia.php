<?php
session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
?> 
<div class="box box-primary">
  <div class="box-header with-border">
    <div class="col-sm-12">
        <h3 class="box-title"><i class="fa fa-medkit"></i> Atendimentos</h3>
    </div>
   </div>
    <div class="col-sm-12">
        <div class="col-sm-6">
            <label for="exampleInputEmail1">Início</label>
            <div class="form-group">
                <div class="form-group">
                    <input type='date'   class="form-control" name='mes' id='inicio' style="width: 100%;">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <label for="exampleInputEmail1">Fim</label>
            <div class="form-group">
                <div class="form-group">
                    <input type='date'   class="form-control" name='mes' id='fim' style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12"><br></div>
    <div class="modal-footer">
        <button class="btn btn-primary" onclick="buscaAtendimentosDoDia('buscaAtendimento',$('#inicio').val(),$('#fim').val())" type="button">
            <i class="fa fa-search"></i> Exibir
        </button>
    </div>
    <!-- /.box-tools -->
  </div>
  <!-- /.box-header -->
  <div id="abrirAgenda">
  </div>

<script>
    configuraTela(); 
</script>