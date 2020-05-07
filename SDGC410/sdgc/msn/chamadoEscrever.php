<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
?> 
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Criar um Novo Chamado</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <input class="form-control" placeholder="Assunto:">
        </div>
        <div class="form-group">
            <textarea id="compose-textarea" class="form-control" style="height: 300px">
            </textarea>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="pull-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar</button>
        </div>
        <button type="reset" class="btn btn-default" onclick="caixaEntrada('entrada')">
            <i class="fa fa-times"></i> Descartar
        </button>
    </div>
    <!-- /.box-footer -->
</div>
