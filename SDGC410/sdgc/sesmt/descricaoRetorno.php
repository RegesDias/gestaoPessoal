<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
    $pieces = explode("-", $respGet[id]);
    $id = $pieces[0];
    $dias = $pieces[1];
    $calendario = $pieces[2];
    $Atribuicoes = $pieces[3];
    echo "<script> mudaAtribuicao('mudaAtribuicao','0-0') </script>";
if($dias == true){
    echo "<label>Dias</label>";
    echo "<input type='text' class='form-control'>";
}
if($calendario == true){
    echo "<label>Data</label>";
    echo "<input type='date' class='form-control'>";
}
if($Atribuicoes == true){
    echo "<script> mudaAtribuicao('mudaAtribuicao','1-1') </script>";
}