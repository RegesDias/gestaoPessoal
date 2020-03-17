<?php
$lista = array (
    array('aaa', 'bbb', 'ccc', 'dddd'),
    array('123', '456', '789'),
    array('"aaa"', '"bbb"')
);
   header("Content-type: application/csv");
   header("Content-Disposition: attachment; filename=test.csv");
   $fp = fopen('php://output', 'w');

   foreach ($lista as $row) {
        fputcsv($fp, $row);
   }
   fclose($fp);
?>