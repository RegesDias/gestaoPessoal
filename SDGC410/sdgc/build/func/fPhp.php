<?php
//---INFORMACOES DO SISTEMA
    ////#servidor back interno
    //$gurl
    //
    ////#servidor back externo
    //$ajurl
    //
    ////#servidor back interno endereço
    //$eurl
    //
    ////#servidor back externo endereço
    //$aeurl
    //
//SISTEMA
$versaoSDGC = '4.0.5';
$localBack = false;
$localEndereco = false;
$DBteste = true;
$DBtestePort = '32796'; 
//---DEFINIÇÃO DE PARAMETROS PARA TESTE DO SISTEMA
//raphael
//$ip = '128';
//alan
//$ip = '106'; 
//juliano
//$ip = '113'; 
//reges
//$ip = '97'; 
//joao
//$ip = '89'; 


//---CONFIGURAÇÃO DO SERVIDOR ----------
     //controle de URL 
     $urlTeste = explode('/', $_SERVER["REQUEST_URI"]);
    //servidor Relatorio
       $jurl = "http://10.40.10.235:81/jasperserver/rest_v2/reports/SDGC/";
       $user = 'j_username=user';
       $passwd = 'j_password=ti@suporte';  
    //Conexão externa ajax
    if ($localBack != true){
       $gurl = "http://10.40.10.236:8080/api/rest/";
       $ajurl = "https://sdgc.com.br/api/rest/";
    }else{
       $ajurl = "http://10.40.10.".$ip.":8080/api/rest/";
       $gurl = $ajurl;
    }
    if ($localEndereco != true){
       $eurl = "http://10.40.10.236:32778/address/rest/";
       $aeurl = "https://www.sdgc.com.br/address/rest/";
    }else{
       $eurl = "http://10.40.10.".$ip.":8080/address/rest/";
       $aeurl = $eurl;
    }
    if ($DBteste == true){
        $eurl = "http://10.40.10.236:".$DBtestePort."/address/rest/";
        $gurl = "http://10.40.10.236:".$DBtestePort."/api/rest/";
    }
//---VERSÃO ------------
    $gappv = 'fc86c6d3bfdfe121791b280f2d87dd49';
//---Metodo de envio-----
    //$method = 'get';
    $method = 'post';

//---CONEXOES AO WS ----
function postJson2D($id, $arrayN){
    $arrySetores = array();
    foreach ($id as $ArrEsp){
        $i++;
        $arrySetores[$i][$arrayN] = "$ArrEsp";
    }
    foreach ($arrySetores as $ArrEsp){
        $arrayJson2D[] =$ArrEsp;
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
            'app:sdgc',
            'chave:' . $_SESSION["user"]["chave"],
            'ip:' . $_SERVER["REMOTE_ADDR"],
            'appv:'. $gappv
    ));
    curl_setopt_array($curl, $options);
    $resp = curl_exec($curl);
    if(($resp == 'Usuário com a chave enviada não encontrado')){
        session_destroy();
        header('Location: login.php');
    }
    curl_close($curl);
        //echo $_SESSION["user"]["chave"];
    return json_decode($resp, true);

}

function postRest($url, $data) {
    global $gurl;
    global $gappv;
    if($data[0][0]){
        foreach ($data[0] as $value) {
            $value = str_replace(" => ", ":'", $value);
            $value = str_replace(", ", "',", $value)."'";
            $value = str_replace("'", '"', $value);
            $jsonMult = $jsonMult.'{'.$value.'},';
        }
        $jsonMult = substr($jsonMult, 0, -1);
        $dataJson = '['.$jsonMult.']';
    }else{
        $dataJson = json_encode($data);
    }
    //print_p($dataJson);
    $ch = curl_init($gurl . $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'app:sdgc',
        'chave:' . $_SESSION["user"]["chave"],
        'ip:' . $_SERVER["REMOTE_ADDR"],
        'appv:'.$gappv,
        'Content-Length: ' . strlen($dataJson))
    );
    $result = curl_exec($ch);
    $getExecInfo = curl_getinfo($ch);
    $info = $getExecInfo['http_code'];
    $return = array(
        'result' => $result,
        'info' => $info,
        'msn'=> $result
    );
    return $return;
}
//---ALTERAR ARRAY
function alterarArray($status, $array, $tabela, $id, $idNome,$mult=null){
    foreach ($array as $key => $value) {
        foreach ($array as $key => $value) {
           if($value[$idNome] == 'NAOPODE'){
               unset($_SESSION["funcionalPerfil"][$tabela][$key]);
           }
       }
    } 
    if($mult == true){
        foreach ($array as $key => $value) {
           $_SESSION["funcionalPerfil"][$tabela][$key]['ativo'] = '0';
        }
        foreach ($id as $idSetor) {
            foreach ($array as $key => $value) {
               if($value['idSetor'] === $idSetor){
                   $_SESSION["funcionalPerfil"][$tabela][$key]['ativo'] = '1';
               }
           }
        } 
        return true;
    }else{
        if (($status['info'] >= 200)AND ( $status['info'] <= 299)){
            foreach ($array as $key => $value) {
               if(($value['ativo'] == 1) AND ($value[$idNome] != $id)){
                   $_SESSION["funcionalPerfil"][$tabela][$key]['ativo'] = '0';
               }
               if($value[$idNome] == $id){
                   $_SESSION["funcionalPerfil"][$tabela][$key]['ativo'] = '1';
               }
           }
           return true;
        }else{
           return false;
        }
    }
}
//---MENSSAGEM ----
function exibeMsn($msnExibe, $msnTexto, $msnTipo=null, $exec) {
    if (isset($exec['info'])) {
        if (($exec['info'] >= 200)AND ( $exec['info'] <= 299)) {
            $msnTexto = "Sucesso " . $msnTexto;
            $msnTipo = "success";
            $msnExibe = true;
        } else {
            $msnTexto = "Erro " . $msnTexto;
            $msnTipo = "danger";
            $msnExibe = true;
        }
    }
    if ($msnExibe == true) {
        ?>
        <script type="text/javascript">
            $(function () {
                $.bootstrapGrowl("<?= $msnTexto ?>", {
                    ele: 'body', // which element to append to
                    type: '<?= $msnTipo ?>', // (null, 'info', 'danger', 'success')
                    offset: {from: 'top', amount: 60}, // 'top', or 'bottom'
                    align: 'right', // ('left', 'right', or 'center')
                    width: 300, // (integer, or 'auto')
                    delay: 4000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
                    allow_dismiss: true, // If true then will display a cross to close the popup.
                    stackup_spacing: 10 // spacing between consecutively stacked growls.
                });
            });
        </script>
    <?php
    }
}
//---PAGINAÇÃO ----
function getPagina($qtd, $arq, $local) {
    $pgAtl = (isset($local['pg'])) ? intval($local['pg']) : 1;
    $pgArq = array_chunk($arq, $qtd);
    $pgTtl = count($pgArq);
    $pgExb = $pgArq[$pgAtl - 1];
    $return = array(
        pgArq => $pgArq,
        pgTtl => $pgTtl,
        pgExb => $pgExb,
        pgAtl => $pgAtl
    );
    return $return;
}
function print_p($array){
    echo '<br><pre>';
    print_r($array);
    echo '</pre><br>';
}

function paginaAtual($array, $pgAtual){
    if($pagina == 1){
        $ii = 0;
    }else{
        $ii = ($pgAtual * 5) - 5;
    }
    $array = array_slice($array, $ii, 5 );
    return $array;
}
function controleDePagina($array,$pgAtual,$nome) {
    global $method;
    global $pst;
    global $arq;
    $total = count($array);
    $pg = $total/5;
    $pag = ceil($pg);
    if($pag < $pgAtual+5 ){
        $ultimapg = $pag;
    }else{
        $ultimapg = $pgAtual+5;
    }
    if ($pg >=1){ ?>
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right"><?php
                    if($pgAtual>1){?>
                        <li>
                            <a>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="<?=$nome?>" value="<?=$pgAtual-1?>"/>
                                    <button type="submit" class="link-button">
                                        &laquo;
                                    </button>
                                </form>
                            </a>
                        </li><?php
                    }
                    //calcula total de paginas
                    for ($index = $pgAtual;$index <= $ultimapg;$index++) {
                        if($pgAtual == $index){
                            $v = '<b>'.$index.'</b>'; 
                         }else{
                            $v = $index;
                         }
                         
                        ?>
                            <li>
                                <a>
                                    <form method="<?=$method?>" action="index.php" class="inline">
                                        <input type="hidden" name="pst" value="<?=$pst?>"/>
                                        <input type="hidden" name="arq" value="<?=$arq?>"/>
                                        <input type="hidden" name="<?=$nome?>" value="<?=$index?>"/>
                                        <button type="submit" class="link-button">
                                            <?=$v?>
                                        </button>
                                    </form>
                                </a>
                            </li>
                            <?php   
                    }
                    if($pag > $pgAtual){?>
                        <li>
                            <a>
                                <form method="<?=$method?>" action="index.php" class="inline">
                                    <input type="hidden" name="pst" value="<?=$pst?>"/>
                                    <input type="hidden" name="arq" value="<?=$arq?>"/>
                                    <input type="hidden" name="<?=$nome?>" value="<?=$pgAtual+1?>"/>
                                    <button type="submit" class="link-button">
                                        &raquo;
                                    </button>
                                </form>
                            </a>
                        </li><?php 
                    }?>
             </ul>
          </div>
    <?php
  }
}
function exibePag($hrefPag, $respGet, $return) {
    global $method;
    if ($respGet['pg'] <= 1) {
        $respGet['pg'] = 1;
    } else {
        $pg = $return['pgAtl'] - 1;
        ?>
        <li>
            <a>
                <form method="<?=$method?>" action="index.php" class="inline">
                   <input type="hidden" name="acao" value="ordenar" />
                    <?=implode($hrefPag,"<input type='hidden' name=")?>
                   <input type="hidden" name="pg" value="<?=$pg?>"/>
                   <button type="submit" class="link-button">
                     &laquo
                   </button>
               </form>
            </a>
        </li>
        <?php
               // echo'<li><a href="?acao=ordenar' . implode($hrefPag) . '&pg=' . $pg . '"> &laquo </a></li>';
    }
    for ($i = $respGet['pg']; $i < $respGet['pg'] + 5; $i++) {
        if ($return['pgTtl'] > $i) {
            if ($i == $return['pgAtl']) {
                printf('<li><a href="#"> <b> %s </b> </a></li>', $i);
            } else {?>
        <li>    
        <a>
               <form method="<?=$method?>" action="index.php" class="inline">
                   <input type="hidden" name="acao" value="ordenar" />
                    <?=implode($hrefPag,"<input type='hidden' name=")?>
                   <input type="hidden" name="pg" value="<?=$i?>"/>
                   <button type="submit" class="link-button">
                       <?=$i?>
                   </button>
               </form>
            </a>
        </li>
                
                
       <?php
            }
        }
    }
    if ($return['pgTtl'] > $respGet['pg']) {
        $pg = $return['pgAtl'] + 1;
        ?>
        <li>
            <a>
                <form method="<?=$method?>" action="index.php" class="inline">
                   <input type="hidden" name="acao" value="ordenar" />
                   <input type="hidden" name="pg" value="<?=$pg?>"/>
                   <?=implode($hrefPag,"<input type='hidden' name=")?>
                   <button type="submit" class="link-button">
                     &raquo
                   </button>
               </form>
            </a>
        </li>

        <?php
        //echo'<li><a href="?acao=ordenar' . implode($hrefPag) . '&pg=' . $pg . '"> &raquo </a></li>';
    }
}

//---Permissao acesso ----
function permissaoAcesso($trueFalce, $acao) {
    if($trueFalce != 1){
        return $acao;
    }
}

//---FORMATAR DATA ----
function dataBr($dataCriaPro) {
    $Edmes = substr("$dataCriaPro", -5, 2);
    $Eddia = substr("$dataCriaPro", -2);
    $Edano = substr("$dataCriaPro", 0, 4);
    $EdData = $Eddia . "/" . $Edmes . "/" . $Edano;
    if($EdData == '//'){
        $EdData=' - ';
    }
    return $EdData;
}
//mesAno
function mesAno($dataCriaPro) {
    $Eddia = substr("$dataCriaPro", -2);
    $Edano = substr("$dataCriaPro", 0, 4);
    $EdData = $Eddia . "/" . $Edano;
    return $EdData;
}
function mesAnoBanco($dataCriaPro) {
    $Eddia = substr("$dataCriaPro", 0, -5);
    $Edano = substr("$dataCriaPro", 3);
    $EdData = $Edano . "-" . $Eddia;
    return $EdData;
}

//---FORMATAR DATA HORA----
function dataHoraBr($dataHoraCriaPro) {
    $dataCriaPro = substr("$dataHoraCriaPro", 0, 10);
    $horaCriaPro = substr("$dataHoraCriaPro", 11);
    $Edmes = substr("$dataCriaPro", -5, 2);
    $Eddia = substr("$dataCriaPro", -2);
    $Edano = substr("$dataCriaPro", 0, 4);
    $EdData = $Eddia . "/" . $Edmes . "/" . $Edano . " " . $horaCriaPro;
    return $EdData;
}
function dataHoraBanco($dataCriaPro) {
    $dataCriaPro = str_replace('/', '', $dataCriaPro);
    $dataCriaPro = str_replace(' ', '', $dataCriaPro); 
    $Eddia = substr("$dataCriaPro", 0, -6);
    $Edmes = substr("$dataCriaPro", 2, -4);
    $Edano = substr("$dataCriaPro", -4, 4); 
    $EdData = $Edano . "-" . $Edmes . "-" . $Eddia . " " . $horaCriaPro;
    return $EdData;
}
function mesAnoParaDate($dataCriaPro) {
    $dataCriaPro = str_replace('/', '', $dataCriaPro);
    $dataCriaPro = str_replace(' ', '', $dataCriaPro); 
    $Eddia = '01';
    $Edmes = substr("$dataCriaPro", 0, -4);
    $Edano = substr("$dataCriaPro", -4, 4); 
    $EdData = $Edano . "-" . $Edmes . "-" . $Eddia;
    $EdData = trim($EdData, '\n');
    return $EdData;
}
function dataBanco($dataCriaPro) {
    $dataCriaPro = str_replace('/', '', $dataCriaPro);
    $dataCriaPro = str_replace(' ', '', $dataCriaPro); 
    $Eddia = substr("$dataCriaPro", 0, -6);
    $Edmes = substr("$dataCriaPro", 2, -4);
    $Edano = substr("$dataCriaPro", -4, 4); 
    $EdData = $Edano . "-" . $Edmes . "-" . $Eddia;
    return $EdData;
}
function dataHoraAmPM($respGet) {
    $pieces = explode("até", $respGet['datetimes']);
    $inicioData = substr($pieces[0], 0, 11);
    $fimData = substr($pieces[1], 0, 11);
    $inicioData=dataHoraBanco($inicioData);
    $fimData=dataHoraBanco($fimData);
    $pieces2 = explode(" ", $respGet['datetimes']);
    $inicioHora = $pieces2[1]." "."$pieces2[2]";
    $fimHora = $pieces2[5]." "."$pieces2[6]";
    $inicioHora = date("H:i", strtotime($inicioHora));
    $fimHora = date("H:i", strtotime($fimHora));
    $respGet['inicioDataHora'] = $inicioData.' '.$inicioHora.':00';
    $respGet['fimDataHora'] = $fimData.' '.$fimHora.':00';
    unset($respGet['datetimes']);
    return $respGet;
}
function dataHora24($respGet) {
    $pieces = explode("até", $respGet['datetimes']);
    $inicioData = substr($pieces[0], 0, 11);
    $fimData = substr($pieces[1], 0, 11);
    $inicioData=dataHoraBanco($inicioData);
    $fimData=dataHoraBanco($fimData);
    $pieces2 = explode(" ", $respGet['datetimes']);
    $inicioHora = $pieces2[1];
    if($pieces2[4] !=''){
        $fimHora = $pieces2[4];
        $respGet['fimDataHora'] = $fimData.' '.$fimHora.':00';
    }
    $respGet['inicioDataHora'] = $inicioData.' '.$inicioHora.':00';
    unset($respGet['datetimes']);
    return $respGet;
}

function dataHoraMensagem($strDataHora){
    $strDataHora = $strDataHora;
    $pedacos = explode("T", $strDataHora);
    //echo $pedacos[0] . " " . $pedacos[1]."<br>";
    //trata data
    $pedacosData = explode("-", $pedacos[0]);
    $data = $pedacosData[2]."/".$pedacosData[1]."/".$pedacosData[0];
    //echo $data;
    $hora = $pedacos[1];
    $retorno = [
        "data" => $data,
        "hora" => $hora,
    ];
    return $retorno;
}

//---AUTO COMPLETA ----
function autoComplete($lista, $id, $campo) {
    ?>
    <script>
        $(function () {
            var availableTags = [
    <?php
    foreach ($lista as $valor) {
        $nome = $valor[$campo];
        echo "'$nome',";
    }
    ?>
            ];
            $("<?= $id ?>").autocomplete({
                source: availableTags,
                minLength: 6
            });
        });
    </script><?php
}

//--ORDENAR ARRAY ----
function ordernarPor($lista, $respGet) {
    uasort($lista, function ($a, $b) {
        global $campo;
        global $ar;
        global $sinal;
        if (isset($ar)) {
            echo $a[$campo][$ar];
            if (($sinal == 'up')and ( $a[$campo][$ar] > $b[$campo][$ar])) {
                return $a[$campo] > $b[$campo];
            } elseif (($sinal == 'up')and ( $a[$campo][$ar] < $b[$campo][$ar])) {
                return $a[$campo] < $b[$campo];
            }
        } else {
            if ($sinal == 'up') {
                return $a[$campo] > $b[$campo];
            } else {
                return $a[$campo] < $b[$campo];
            }
        }
    });
    return getPagina(20, $lista, $respGet);
}

//BUSCA FOTO ----
function exibeFoto($cpf) {
    $foto = "img/fotos/" . $cpf . ".bmp";
    if (file_exists($foto)) {
        $foto = "img/fotos/" . $cpf . ".bmp";
    } else {
        $foto = "img/fotos/semFoto.png";
    }
    return $foto;
}

//VERIFICA ATIVO
function tabId($id, $tab, $padrao = null) {
    if ($tab == $id) {
        return 'active';
    } else if (($padrao == true)and ( $tab == '')) {
        return 'active';
    }
}

//ALERTA
function muda($id) {
    ?>
    <script>
        function <?= $id ?>() {
            document.getElementById('<?= $id ?>').className = 'label label-danger';
        }
    </script>
<?php
}
function esconderItem($id) {
    ?>
    <script>
        function <?= $id ?>() {
            document.getElementById('<?= $id ?>').className = '';
        }
    </script>
<?php
}
//CombEvent
function CombEvent($funcTion, $idText, $idNunber, $idPeriodo) {
    ?>
    <script type="text/javascript">
        var lastItem0 = false;
        var lastItem1 = false;
        function <?= $funcTion ?>(sel) {
            var ta = document.getElementById("<?= $idText ?>");
            var tb = document.getElementById("<?= $idNunber ?>");
            var tp = document.getElementById("<?= $idPeriodo ?>");
            var item = sel.options[sel.selectedIndex].id;
            var resultado = item.split("--");
            var limite = resultado[1].split(" a ");
            if (lastItem0) {
                ta.placeholder = ta.placeholder.replace(lastItem0, resultado['0']);
                document.getElementById('<?= $idText ?>').value = '';
            } else {
                ta.placeholder += resultado['0'];
                document.getElementById('<?= $idText ?>').value = '';
            }
            if (lastItem1) {
                if (resultado['1'] === '0') {
                    tb.placeholder = tb.placeholder.replace(lastItem1, resultado['1']);
                    document.getElementById('<?= $idNunber ?>').disabled = true;
                    document.getElementById('<?= $idNunber ?>').value = ' ';
                } else {
                    document.getElementById('<?= $idNunber ?>').disabled = false;
                    tb.placeholder = tb.placeholder.replace(lastItem1, resultado['1']);
                    document.getElementById('<?= $idNunber ?>').value = ' ';
                    document.getElementById('<?= $idNunber ?>').max = limite['1'];
                    document.getElementById('<?= $idNunber ?>').min = limite['0'];
                }
            } else {
                if (resultado['1'] === '0') {
                    tb.placeholder += resultado['1'];
                    document.getElementById('<?= $idNunber ?>').disabled = true;
                    document.getElementById('<?= $idNunber ?>').max = limite['1'];
                    document.getElementById('<?= $idNunber ?>').min = limite['0'];
                } else {
                    tb.placeholder += resultado['1'];
                    document.getElementById('<?= $idNunber ?>').disabled = false;
                    document.getElementById('<?= $idNunber ?>').max = limite['1'];
                    document.getElementById('<?= $idNunber ?>').min = limite['0'];
                }
            }
            if (resultado['2'] === '1') {
                document.getElementById('<?= $idPeriodo ?>').className = 'hide';
                alterarPadraoDataLancamento(1);
            }else{
                document.getElementById('<?= $idPeriodo ?>').className = '';
                alterarPadraoDataLancamento(0);
            }
            lastItem0 = resultado['0'];
            lastItem1 = resultado['1'];
            lastItem2 = resultado['2'];
        }
    </script>
<?php
}
function gravar($texto,$arquivo){
    //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
    $fp = fopen($arquivo, "a+");

    //Escreve no arquivo aberto.
    fwrite($fp, $texto);

    //Fecha o arquivo.
    fclose($fp);
}
function primeiroUltimoDiaMes($dataBanco){
    $mesAno = str_replace("-", "/", $dataBanco);
    $inicio = dataBr($dataBanco);
    $pieces = explode("/", $inicio);
    $diasfim = cal_days_in_month(CAL_GREGORIAN, $pieces[1], $pieces[2]);
    $fim = $diasfim."/".$pieces[1]."/".$pieces[2];
    $periodo = array ($inicio,$fim);
    return $periodo;
}
function ultimoDiaMes($dataBanco){
    $mesAno = str_replace("-", "/", $dataBanco);
    $inicio = dataBr($dataBanco);
    $pieces = explode("/", $inicio);
    $diasfim = cal_days_in_month(CAL_GREGORIAN, $pieces[1], $pieces[2]);
    $fim = $pieces[2]."-".$pieces[1]."-".$diasfim;
    return $fim;
}
function diaSemana($dia){
    $diasemana = array('', 'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado');
    return $diasemana[$dia];
}
function trueFalse($respGet,$variavel){
    foreach ($variavel as $ArrEsp){
        if($respGet[$ArrEsp] != '1'){
                $respGet[$ArrEsp] = 'false';
            }else{
                $respGet[$ArrEsp] = 'true';
        }
    }
    return $respGet;
}
//function gerarJasperRelat($arquivo,$output){
//    global $jurl;
//    global $user;
//    global $passwd;
//    if ($output == 'html'){
//        $contents = file_get_contents($jurl.$arquivo.".".$output.'?'.$user.'&'.$passwd);
//    }else{
//        $contents = $jurl.$arquivo.$output.'?'.$user.'&'.$passwd;
//    }
//    return $contents;
//}

function gerarJasperRelat($arquivo,$output,$parametros=''){
    global $jurl;
    global $user;
    global $passwd;
    //Constroi URL
    $URL = $jurl.$arquivo.".".$output.'?'.$user.'&'.$passwd.'&'.$parametros;
    //echo '<br>'.$URL;
    //Requisita dados do servidor
    if ($output == 'html'){
        $contents = file_get_contents($URL);
    }else{
        $contents = $URL;
    }
    return $contents;
}
function removeArrayDublicado($array, $uniqueKey) {
  if (!is_array($array)) {
    return array();
  }
  $uniqueKeys = array();
  foreach ($array as $key => $item) {
    if (!in_array($item[$uniqueKey], $uniqueKeys)) {
      $uniqueKeys[$item[$uniqueKey]] = $item;
    }
  }
  return $uniqueKeys;
}
function statusVariaveis($status){
    if($status == 'Lançado'){$lable='label label-info';}
    if($status == 'Negado'){$lable='label label-danger';}
    if($status == 'Aprovado'){$lable='label label-success';}
    return $lable;
}