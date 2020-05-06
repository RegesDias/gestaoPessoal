

<?php
session_start();
ini_set('memory_limit', '-1');



if($_SESSION['respGet']['tipo_relatorio']==''){
   $strHtml = file_get_contents($_SESSION['listaUrl']['url']);
   echo $strHtml; 
}
if($_SESSION['respGet']['tipo_relatorio']=='pdf'){
   $strUrlPdf = $_SESSION['listaUrl']['url'];
   header("Content-type:application/pdf");
   header("Content-Disposition:attachment;filename=Relatorio".$_SESSION['respGet']['varq'].$_SESSION['respGet']['acao'].".pdf");
   readfile($strUrlPdf); // lê o arquivo
   exit; // aborta pós-açõe
}
if($_SESSION['respGet']['tipo_relatorio']=='csv'){
   $strUrlPdf = $_SESSION['listaUrl']['url'];
   header("Content-type:application/csv");
   header("Content-Disposition:attachment;filename=Relatorio".$_SESSION['respGet']['varq'].$_SESSION['respGet']['acao'].".csv");
   readfile($strUrlPdf); // lê o arquivo
   exit; // aborta pós-açõe
}
if($_SESSION['respGet']['tipo_relatorio']=='xls'){
   $strUrlPdf = $_SESSION['listaUrl']['url'];
   header("Content-type:application/excel");
   header("Content-Disposition:attachment;filename=Relatorio".$_SESSION['respGet']['varq'].$_SESSION['respGet']['acao'].".xls");
   readfile($strUrlPdf); // lê o arquivo
   exit; // aborta pós-açõe
}
?>
