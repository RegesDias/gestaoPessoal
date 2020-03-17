<?php
session_start();
//filtraPost
$respGet = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//---VERSÃO ------------
$gappv = '40b55216fa64bfddfaa15801d37ec687';
$gurl = "http://10.40.10.236:8080/api/rest/";
//$gurl = "https://www.sdgc.com.br/api/rest/";

//---CONEXOES AO WS ----
function postJson2D($id, $arrayN) {
    $arrySetores = array();
    foreach ($id as $ArrEsp) {
        $i++;
        $arrySetores[$i][$arrayN] = "$ArrEsp";
    }
    foreach ($arrySetores as $ArrEsp) {
        $arrayJson2D[] = $ArrEsp;
    }
    return $arrayJson2D;
}

function getRest($pf, $data = null) {
    global $gurl;
    global $gappv;
    $curl = curl_init();
    $url = $gurl . $pf;
    foreach ($data as $campos) {
        $q = curl_escape($curl, $campos);
        $url = $url . '/' . $q;
    }
    //echo '<br>'.$url;
    $options = array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false, // If You have https://
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            'app:MacaeApp',
            'chave:81dc9bdb52d04dc20036dbd8313ed055',
            'ip:' . $_SERVER["REMOTE_ADDR"],
            'appv:' . $gappv
    ));
    curl_setopt_array($curl, $options);
    $resp = curl_exec($curl);
    if (($resp == 'Usuário com a chave enviada não encontrado')) {
        session_destroy();
        header('Location: login.php');
    }
    curl_close($curl);
    return json_decode($resp, true);
}

//busca especialidades
$especialidadeLista = getRest('macaeapp/getListaEspecialidadeTipo');
$localLista = getRest('macaeapp/getListaLotacaoSubUsuario');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>macaeApp</title>
    </head>
    <body bgcolor="009CB8">
        <b>Busca por Especialidades e Dia Semana</b>
        <form action="especialidadeDiasemana.php" method="post">
            <select name="idEspecialidade">
                <?php foreach ($especialidadeLista as $el) { ?>
                    <option value="<?= $el[id] ?>"><?= $el[nome] ?></option> 
<?php } ?>
            </select>
            <select name="iddiasemana">
                <option></option>
                <option value="0">Domingo</option>
                <option value="1">Segunda</option> 
                <option value="2">Terça</option> 
                <option value="3">Quarta</option> 
                <option value="4">Quinta</option> 
                <option value="5">Sexta</option> 
                <option value="6">Sabado</option>  
            </select>
            <input type="hidden" name='acao' value="BuscaEspDS">
            <input type="submit" value="buscar" >
        </form>
        <center>
            <?php
            if ($respGet[acao] == 'BuscaEspDS') {
                echo '<br><b>Resultado Por Especialidades e Dia Semana ...</b><br>';
                $buscarEspecialidade = array('idEspecialidade' => $respGet['idEspecialidade'], 'iddiasemana' => $respGet['iddiasemana']);
                //$bEspecialidade = array($buscarEspecialidade);
                $be = getRest('macaeapp/getFuncionalPorIdEspecialidadeTipo', $buscarEspecialidade);
            }
            if ($respGet[acao] == 'BuscalocDS') {
                echo '<br><b>Resultado Por Local e Dia Semana ...</b><br>';
                $buscarLotacaoSub = array('idLotacaoSub' => $respGet['idLotacaoSub'], 'iddiasemana' => $respGet['iddiasemana']);
                //$bEspecialidade = array($buscarEspecialidade);
                $be = getRest('macaeapp/getFuncionalPorIdLotacaoSub', $buscarLotacaoSub);
            }
            if ($respGet[acao] == 'BuscaNome') {
                echo '<br><b>Resultado Por Nome ...</b><br>';
                $buscarLotacaoSub = array('nome' => $respGet['nome']);
                //$bEspecialidade = array($buscarEspecialidade);
                $be = getRest('macaeapp/getFuncionalPorNome', $buscarLotacaoSub);
            }
                echo '<table>';
                foreach ($be as $b) {
                    echo '<tr>';
                    echo '<td>'.$b[nome].'<td>';
                    echo '<td>'.$b[nomeEscala].'<td>';
                    echo '<td>'.$b[nomeLotacaoSub].'<td>';
                    echo '<tr>';
                }
                echo '</table>';
            ?>
        </center>
    </body>
</html>
