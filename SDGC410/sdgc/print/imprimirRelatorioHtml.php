<?php
    require_once '../func/fPhp.php';
//    $parametros = $_GET['parametros'].'&idpessoal='.$_GET['idpessoal'].'&idlotacao='.$_GET['idlotacao'].'&ordem='.$_GET['ordem'].'&idlotacaosub='.$_GET['idlotacaosub'].'&mesAno='.$_GET['mesAno'].'&iduserlogin='.$_GET['iduserlogin'].'&idfuncional='.$_GET['idfuncional'];
//    $parametros = str_replace(' ', '%20', $parametros);
//    echo gerarJasperRelat($_GET['nome_relatorio'],'html',$parametros);
//    echo gerarJasperRelat($_POST['nome_relatorio'],'html',$_POST['parametros']);
//    if(isset($_POST['nome_relatorio'])){
//        <script type="text/javascript">
//        window.onload=function(){self.print();}
//        </script>        
//    }
       
      $cBusc = array('0940.09','matricula','pdf');
      $lista = getRest('relatorio/getRelServidoresPorSetor',$cBusc);
       echo 'teste<br>teste'.$lista;
        
?>