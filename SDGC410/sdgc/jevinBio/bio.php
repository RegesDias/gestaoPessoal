<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once 'connect.php';
    
    $sql = "select * from public.pto_pessoa where public.pto_pessoa.cpf = '11666683710' and dt_registro > '2020-02-01 00:00:00'";
    $result=pg_query($connect,$sql);
    
    ///teste sql
    if  (!$result) {
     echo "query did not execute";
    }
    
    while($row = pg_fetch_array($result)){
        print_p($row);
        echo dataHoraBr($row[1]);
    }
?>