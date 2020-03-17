<?php
//   require_once '../func/fPhp.php';
//   $nome_relatorio = $respGet['nome_relatorio'];
//   $parametros = $respGet['parametros'];
//   echo "<br>" + $parametros;
//   $arquivo = gerarJasperRelat($nome_relatorio,'pdf',$parametros);
//   header("Content-type:application/pdf");
//   header("Content-Disposition:attachment;filename='Relatorio_".$nome_relatorio.".pdf'");
//   readfile($arquivo); // lê o arquivo
//   exit; // aborta pós-açõe
   session_start();
   require_once '../func/fPhp.php';
   $nome_relatorio = $respGet['nome_relatorio'];
   $parametros = $respGet['parametros'];
   $arquivo = gerarJasperRelat($nome_relatorio,'pdf',$parametros);
   header("Content-type:application/pdf");
   header("Content-Disposition:attachment;filename='Relatorio_".$nome_relatorio.".pdf'");
   readfile($arquivo); // lê o arquivo
   exit; // aborta pós-açõe
   
?>

