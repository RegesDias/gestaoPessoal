<?php
    session_start();
    require_once '../func/fPhp.php';
    require_once '../func/fModal.php';
        $teste = getRest('relatorio/getRelTeste');
        $dadosXls  = "";
        $dadosXls .= "  <table border='1' >";
        $dadosXls .= "        <tr>";
        $dadosXls .= "          <th>codPlanDestino</th>";
        $dadosXls .= "          <th>nomePlanDestino</th>";
        $dadosXls .= "          <th>matricula</th>";
        $dadosXls .= "          <th>nome</th>";
        $dadosXls .= "          <th>cargo</th>";
        $dadosXls .= "          <th>codGanho</th>";
        $dadosXls .= "          <th>nomeGanho</th>";
        $dadosXls .= "          <th>tipo</th>";
        $dadosXls .= "          <th>valorRubrica</th>";
        $dadosXls .= "          <th>setores</th>";
        $dadosXls .= "          <th>quantRubrica</th>";
        $dadosXls .= "          <th>empenhado</th>";
        $dadosXls .= "          <th>bloqueado</th>";
        $dadosXls .= "          <th>dataHora</th>";
        $dadosXls .= "          <th>id_hist_func</th>";
        $dadosXls .= "          <th>anoMes</th>";
        $dadosXls .= "          <th>nome_lotacao</th>";
        $dadosXls .= "          <th>id_lotacao</th>";
        $dadosXls .= "      </tr>";
        foreach ($teste as $res) {
            $dadosXls .= "      <tr>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "          <td>".$res['campo1']."</td>";
            $dadosXls .= "      </tr>";
       }
       $dadosXls .= "  </table>";
       $arquivo = "MinhaPlanilha.xls";  
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$arquivo.'"');
    header('Cache-Control: max-age=0');
    echo $dadosXls;  
?>