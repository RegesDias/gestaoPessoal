<?php
require_once '../func/fPhp.php';
if (isset($_POST['acao']) && isset($_POST['parametros']) ) {
   $nome_relatorio = $_POST['nome_relatorio'];
   $parametros = $_POST['parametros'];
   $arquivo = gerarJasperRelat($nome_relatorio,'csv',$parametros);
   header("Content-type:application/csv");
   header("Content-Disposition:attachment;filename='Relatorio_".$nome_relatorio.".csv'");
   readfile($arquivo); // lê o arquivo
   exit; // aborta pós-açõe
}
?>

