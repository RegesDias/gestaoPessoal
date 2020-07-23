<?php
    $cnt = new mysqli("10.40.10.6", "root", "semad@cpd", "repositorio");
    if ($cnt->connect_errno) {
        printf("Connect failed: %s\n", $cnt->connect_error);
        exit();
    }
    $respGet = filter_input_array(INPUT_POST, FILTER_DEFAULT);
 if ( $respGet['acao'] == "salvar" ){
    $arquivo = $_FILES["arquivo"]["tmp_name"]; 
    $tamanho = $_FILES["arquivo"]["size"];
    $tipo    = $_FILES["arquivo"]["type"];
    $nome  = $_FILES["arquivo"]["name"];
    $titulo  = $respGet['titulo'];

    if (( $arquivo != "" ) and ($titulo != '')){
       $fp = fopen($arquivo, "rb");
       $conteudo = fread($fp, $tamanho);
       $conteudo = addslashes($conteudo);
       fclose($fp); 
       $sql = "INSERT INTO arquivos VALUES (0,'$nome','$titulo','$conteudo','$tipo')";
       if ($result = $cnt->query($sql)){
           echo "O arquivo foi gravado na base de dados."; 
       }else{
          echo "Não foi possível gravar o arquivo na base de dados.";
       }
    }else{
        echo "Não foi possível carregar o arquivo para o servidor.";
    }
 }
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Título da página</title>
    <meta charset="utf-8">
  </head>
  <body>
    <!-- ...código anterior -->
    <form enctype="multipart/form-data" action="guardar_arquivo.php" method="post">
    Descrição <input type="text" name="titulo" size="30">
    Arquivo <input type="file" name="arquivo">
    <input type="hidden" name='acao' value="salvar">
    <input type="submit" value="Enviar arquivo">
    </form>
    <!-- ...código posterior -->
  </body>
</html>