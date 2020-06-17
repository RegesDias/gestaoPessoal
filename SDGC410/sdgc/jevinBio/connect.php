<?php
     $servidor = "179.233.129.76";
     $porta = 5438;
     $bancoDeDados = "neweasy";
     $usuario = "postgres";
     $senha = "velti@123";

     $connect = pg_connect("host=$servidor port=$porta dbname=$bancoDeDados user=$usuario password=$senha");
     //teste conexao
     if(!$connect) {
         die("Não foi possível se conectar ao banco de dados.");
     }
?>