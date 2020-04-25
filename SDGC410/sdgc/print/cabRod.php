<?php
session_start();
require_once '../func/fPhp.php';
print_p($respGet);
$tipo='html';
if(@$respGet['tipo_relatorio']){//mesma coisa que isset($respGet['tipo_relatorio'])
    $tipo = $respGet['tipo_relatorio'];
}
$key = array_search('semSetor', $respGet);
if($key!==false){
    unset($respGet[$key]);
}
//Se for um relatorio vindo da pasta relatorio
    //VER DEPOIS-------------------------------------------------------------------------------------------------
    if($respGet['menuN3'] == '5' AND $respGet['link'] == 'Listar' AND !isset($respGet['idSetor'])){
        $secretaria = $respGet['idSecretaria'];
        $ordem = $respGet['ordenar'];
        $cBusc = array($secretaria ,$ordem, $tipo);
        //Para exibir só comissionado é outro relatorio
        if($respGet['exibicao']=='so_comissionado'){
            $lista = getRest('relatorio/getRelServidoresComissionadosPorSecretaria',$cBusc);
        }else if($respGet['exibicao']=='todos'){
            $lista = getRest('relatorio/getRelServidoresPorSecretaria',$cBusc);
        }else if($respGet['exibicao']=='biometria'){
            $lista = getRest('relatorio/getRelBiometriaCadastradaSecretaria',$cBusc);
        }
    }    
    //Servidores Por Setor
    if($respGet['menuN3'] == '5' AND $respGet['link'] == 'Listar' AND isset($respGet['idSetor'])){
        
        $respGet['orby'] = nome;
        $respGet['exibicao'] = 'todos';
        $setor = $respGet['idSetor'];
        $ordem = $respGet['orby'];
        $cBusc = array($setor,$ordem, $tipo);
        //Pega o nome do relatorio, pois para exibir todos é um relatorio
        //Para exibir só comissionado é outro relatorio
        if($respGet['exibicao']=='so_comissionado'){
            $lista = getRest('relatorio/getRelServidoresComissionadosPorSetor',$cBusc);
        }else if($respGet['exibicao']=='todos'){
            $lista = getRest('relatorio/getRelServidoresPorSetor',$cBusc);
        }else if($respGet['exibicao']=='biometria'){
            $lista = getRest('relatorio/getRelBiometriaCadastradaSetor',$cBusc);
        }
    }
    //Servidores Por Secretaria

    //servidor por cargo Geral
    if(isset($respGet['acao']) && $respGet['acao']=='ServidoresPorCargoGeral'){
        
        $cargoGeral = $respGet['idCargoGeral'];
        $cBusc = array($cargoGeral, $tipo);
        $lista = getRest('relatorio/getRelServidoresPorCargo',$cBusc);
    }
    //LancamentoIndividualPorPeriodo
    if(isset($respGet['acao']) && $respGet['acao'] =='LancamentoIndividualPorPeriodo'){
        
        $anoMes = $respGet['periodo'];
        $cpf = $respGet['cpf'];
        $cBusc = array($anoMes, $cpf, $tipo);
        $lista = getRest('relatorio/getRelLancamentoIndividualPorPeriodo',$cBusc);
    }
    //servidores sem setor
    if($respGet['menuN3'] == '1' AND $respGet['link'] == 'Sem lotação' AND isset($respGet['idSetor'])){ 
            $btnExportar = true;
            $btnExportarCSV = true;
            
            $btnVisualizar = TRUE;
            $cBusc = array($tipo);
            $lista = getRest('relatorio/getRelServidoresSemSetor',$cBusc);   
    }
    //servidores sem secretaria
    if($respGet['menuN3'] == '1' AND $respGet['link'] == 'Sem lotação' AND !isset($respGet['idSetor'])){ 
            $btnExportar = true;
            $btnExportarCSV = true;
            
            $btnVisualizar = TRUE;
            $cBusc = array($tipo);
            $lista = getRest('relatorio/getRelServidoresSemSecretaria',$cBusc);   
    }
    //FIM VER DEPOIS-------------------------------------------------------------------------------------------------
    //
    //Setores com total de servidores
    if($respGet['menuN3'] == '2' AND $respGet['link'] == 'Quantitativo' AND isset($respGet['idSetor'])){
        
        $secretaria = $respGet['idSecretaria'];
        $cBusc = array($secretaria, $tipo);
        $lista = getRest('relatorio/getRelSetoresComTotalServidores',$cBusc);
    }
    //Secretarias com total de servidores
    if($respGet['menuN3'] == '2' AND $respGet['link'] == 'Quantitativo' AND !isset($respGet['idSetor'])){
        
        $cBusc = array($tipo);
        $lista = getRest('relatorio/getRelSecretariasComTotalServidores',$cBusc);
    }
    if($respGet['menuN3'] == '6' AND $respGet['link'] == 'Especialidade'){
        
        if(isset($respGet[idSetor])){
            $local=$respGet[idSetor];
        }else{
            $local=$respGet[idSecretaria];
        }
        $cBusc = array($local,$tipo);
        $lista = getRest('relatorio/getRelEspecialidadeRotina',$cBusc);  
    }
    //previadeFalta
    if($respGet['menuN3'] == '3' AND $respGet['link'] == 'Listar' AND isset($respGet['idSetor'])){
        
        $cBusc = array($respGet['idSecretaria'],$respGet['idSetor'],$tipo);
        $lista = getRest('relatorio/getRelPreviaFalta',$cBusc);
        $btnExportar = true;
    }
    if($respGet['menuN3'] == '3' AND $respGet['link'] == 'Listar' AND !isset($respGet['idSetor'])){ 
            
            $cBusc = array($respGet['idSecretaria'],'',$tipo);
            $lista = getRest('relatorio/getRelPreviaFalta',$cBusc);
            $btnExportar = true;
    } 
    if(isset($respGet['acao']) && $respGet['acao'] =='previaFaltaInstrucoes'){
            
            $cBusc = array($tipo);
            $lista = getRest('relatorio/getRelPreviaFaltaInstrucoes',$cBusc);
            $btnExportarCSV = false;
            $btnExportar = false;
            $btnDownload = true;
    }
    //PLANEJAMENTO
    if($respGet['menuN3'] == '10' AND $respGet['link'] == 'Detalhamento'){ 
        $cBusc = array($respGet['idSetor'], "nome", $tipo);
        $lista = getRest('relatorio/getRelDetalhamentoPlanejamento',$cBusc);
    }
    if($respGet['menuN3'] == '7' AND $respGet['link'] == 'Guia de Remessa' AND !isset($respGet['idSetor'])){ 
        
        $cBusc = array($respGet['idSecretaria'], $tipo);
        $lista = getRest('relatorio/getRelPlanejamentoSecretaria',$cBusc);
    }
    if($respGet['menuN3'] == '7' AND $respGet['link'] == 'Guia de Remessa' AND isset($respGet['idSetor'])){ 
        
        $cBusc = array($respGet['idSetor'], $tipo);
        $lista = getRest('relatorio/getRelPlanejamentoSetor',$cBusc);
    }
    //Ocorrencias por Secretaria
    if($respGet['menuN3'] == '8' AND $respGet['link'] == 'Guia de Remessa' AND !isset($respGet['idSetor'])){ 
        
        $secretaria = $respGet['idSecretaria'];
        $cBusc = array($secretaria,$tipo);
        $lista = getRest('relatorio/getRelOcorrenciasPorSecretaria',$cBusc);
    }
    //Ocorrencias por setor
     if($respGet['menuN3'] == '8' AND $respGet['link'] == 'Guia de Remessa' AND isset($respGet['idSetor'])){ 
        
        $setor = $respGet['idSetor'];
        $cBusc = array($setor,$tipo);
        $lista = getRest('relatorio/getRelOcorrenciasPorSetor',$cBusc);
    }
    //AVALIACAO
    if($respGet['menuN3'] == '4' AND $respGet['link'] == 'Listar' AND isset($respGet['idSetor'])){ 
        
        $cBusc = array($respGet['idSetor'],$tipo);
        $lista = getRest('relatorio/getRelAvaliacaoPorSetor',$cBusc);  
    }
    if($respGet['menuN3'] == '4' AND $respGet['link'] == 'Listar' AND !isset($respGet['idSetor'])){ 
        
        $cBusc = array($respGet['idSecretaria'],$tipo);
        $lista = getRest('relatorio/getRelAvaliacaoPorSecretaria',$cBusc);  
    }
    if( $respGet['acao']=='avaliacaoFicha'){
        
        $cBusc = array($respGet['idLotacaoSub'],$respGet['idHistorioFunc'],$tipo);
        $lista = getRest('relatorio/getRelAvaliacaoPorFuncional',$cBusc);
    }
//feito
// Se for Portaria
if(isset($respGet['acao']) && $respGet['acao']=='portaria'){
    
    $idfuncional = $respGet['dado'];
    $cBusc = array($idfuncional,$tipo);
    $lista = getRest('relatorio/getRelPortarias',$cBusc);
}
// Se for usuarios e acessos
if(isset($respGet['acao']) && $respGet['acao']=='usuariosAcesso'){
    
    $idSecretaria = $respGet['idSecretaria'];
    $orby = $respGet['orby'];
    $cBusc = array($idSecretaria, $orby, $tipo);
    $lista = getRest('relatorio/getRelUsuariosAcesso',$cBusc);
}
// Se for relat LotacaoServidor
if(isset($respGet['acao']) && $respGet['acao']=='lotacaoServidor'){

    $respGet[acao] = 'gerar';
    $idFuncional = $respGet['dado'];
    $cBusc = array($idFuncional, $tipo);
    $lista = getRest('relatorio/getRelInfoSec',$cBusc);
}
// Se for relat LotacaoSubServidor
if(isset($respGet['acao']) && $respGet['acao']=='lotacaoSubServidor'){
    
    $v=explode('.', $idSecretaria = $_SESSION['funcionalPerfil']['setoresAtivos']['0']['idSetor']);
    $idSecretaria=$v[0];
    $idFuncional = $respGet['dado'];
    $respGet[acao] = 'gerar';
    $cBusc = array($idFuncional, $idSecretaria, $tipo);
    $lista = getRest('relatorio/getRelInfoSecSetor',$cBusc);
}
// Se for relat especialidadeServidor
if(isset($respGet['acao']) && $respGet['acao']=='especialidadeServidor'){
    
    $respGet[acao] = 'gerar';
    $idFuncional = $respGet['dado'];
    $cBusc = array($idFuncional, $tipo);
    $lista = getRest('relatorio/getRelInfoEspecialidades',$cBusc);
}
// Se for relat regimeservidor
if(isset($respGet['acao']) && $respGet['acao']=='regimeServidor'){
    
    $respGet[acao] = 'gerar';
    $idFuncional = $respGet['dado'];
    $cBusc = array($idFuncional, $tipo);
    $lista = getRest('relatorio/getRelInfoRegimeTrabalho',$cBusc);
}
// Se for aficha funcional
if(isset($respGet['acao']) && $respGet['acao']=='fichaFuncional'){
    
    $idpessoal = $respGet['dado'];
    $idpessoal = substr($idpessoal, 0, -4);//tira os 4 ultimos zeros
    $cBusc = array($idpessoal,$tipo);
    $lista = getRest('relatorio/getRelFichaFuncional',$cBusc);
}
// Se for contracheque
if(isset($respGet['acao']) && $respGet['acao']=='contraCheque'){
    $mesAno = $respGet['dado'];
    $matricula = $_SESSION['funcionalBusca']['matricula'];
    $cBusc = array($matricula, $mesAno, $tipo);
    $lista = getRest('relatorio/getRelContraCheque',$cBusc);
}
// Se for previaFolha
if(isset($respGet['acao']) && $respGet['acao']=='previaFolha'){
    
    $mesAno = $respGet['dado'].'-01';
    $matricula = $_SESSION['funcionalBusca']['matricula'];
    $cBusc = array($matricula, $mesAno, $tipo);
    $lista = getRest('relatorio/getRelServidorFolhaprevia',$cBusc);
}
// Se for folha ponto simples
if(isset($respGet['acao']) && $respGet['acao']=='folhapontoInicio'){
    
    $mesAno = $respData[4]['dataFrequenciaMesAno'];
    $anoMes = explode ("-", $mesAno)[1]."-".explode ("-", $mesAno)[0];
    $matricula = $_SESSION['funcionalBusca']['matricula'];
    $idSetor = $respGet['idSetor'];
    $cBusc = array($matricula, $anoMes, $idSetor, $tipo);
    $lista = getRest('relatorio/getRelFolhaPonto',$cBusc);
}
//Gera Folha de Ponto em Lote Por Setor
if(isset($respGet['acao']) && $respGet['acao']=='folhaDePontoEmLote'){
        $respGet['idSetor'] = $respGet['dado'];
        $mesAno = $respData[4]['dataFrequenciaMesAno'];
        $mes = explode("-",$mesAno)[0];
        $ano = explode("-",$mesAno)[1];
        $anoMes = $ano."-".$mes;
        $cBusc = array($respGet['idSetor'], $anoMes,$tipo);
        $lista = getRest('relatorio/getRelFolhaPontoEmLote',$cBusc);
}
//Gera Marcacoes em Lote Por Setor
if(isset($respGet['acao']) && $respGet['acao']=='marcacoesEmLote'){
        $respGet['idSetor'] = $respGet['dado'];
        $mesAno = $respData[4]['dataFrequenciaMesAno'];
        $mes = explode("-",$mesAno)[0];
        $ano = explode("-",$mesAno)[1];
        $anoMes = $ano."-".$mes;
        $cBusc = array($anoMes, $anoMes,$respGet['idSetor'],$tipo);
        $lista = getRest('relatorio/getRelMarcacaoServidorEmLotePorSetor',$cBusc);
}
//Gera Folha de Ponto em Lote Por Servidor
if(isset($respGet['acao']) && $respGet['acao']=='folhapontoInicioFim'){
       
        $mesAnoInicial = $respGet['mesAnoInicial'];
        $mesAnoFinal = $respGet['mesAnoFinal'];
        $idSetor = $respGet['idSetor'];
        $matricula = $_SESSION['funcionalBusca']['matricula'];
        $cBusc = array($matricula, $idSetor, $mesAnoInicial, $mesAnoFinal, $tipo);
        $lista = getRest('relatorio/getRelFolhaPontoEmLoteDoServidor',$cBusc);
}
//FolhaPrevia
if(isset($respGet['acao']) && $respGet['acao']=='getRelRevia'){
   
    $data = $respGet['mesAnoInicial'];
    $idLotacao = $respGet['idSecretaria'];
    $cBusc = array($idLotacao, $data, $tipo);
    $lista = getRest('relatorio/getRelFolhaPrevia',$cBusc);
    $btnExportarCSV = true;
    $btnExportar = true;
}
//NSD
if(isset($respGet['acao']) && $respGet['acao']=='getRelNsd'){

    $codNsd = $respGet['codNsd'];
    $cBusc = array($codNsd, $tipo);
    $lista = getRest('relatorio/getRelNsd',$cBusc);
}
//NSDS
if(isset($respGet['acao']) && $respGet['acao']=='getRelNsds'){

    $codNsds = $respGet['codNsd'];
    $cBusc = array($codNsds, $tipo);
    $lista = getRest('relatorio/getRelNsds',$cBusc);
}
//NSDA
if(isset($respGet['acao']) && $respGet['acao']=='getRelNsda'){
    $codNsda = $respGet['codNsd'];
    $cBusc = array($codNsda, $tipo);
    $lista = getRest('relatorio/getRelNsda',$cBusc);
}
//SinteticoMacprev
if(isset($respGet['acao']) && $respGet['acao']=='empenhoSinteticoMacprev'){

    if($respGet['tem13salario']){
        $respGet['tem13salario'] = 'sim';
    }else{
        $respGet['tem13salario'] = 'nao';
    }
    
    $mesAnoInicial = getDataReferenciaNSD($respGet['mesAnoInicial']);
    if(isset($respGet['tem13salario']) && ($respGet['tem13salario']=="sim")){
        $cBusc = array($mesAnoInicial, 'MP3',$tipo);
    } else {
        $cBusc = array($mesAnoInicial, 'MP2',$tipo);
    }
    $lista = getRest('relatorio/getRelEmpenhoSinteticoMacprev',$cBusc);
}
//AnaliticoMacprev
if(isset($respGet['acao']) && $respGet['acao']=='empenhoAnaliticoMacprev'){

    if($respGet['tem13salario']){
        $respGet['tem13salario'] = 'sim';
    }else{
        $respGet['tem13salario'] = 'nao';
    }
    
    $mesAnoInicial = getDataReferenciaNSD($respGet['mesAnoInicial']);
    if(isset($respGet['tem13salario']) && ($respGet['tem13salario']=="sim")){
        $cBusc = array($mesAnoInicial, 'MP3',$tipo);
    } else {
        $cBusc = array($mesAnoInicial, 'MP2',$tipo);
    }
    $lista = getRest('relatorio/getRelEmpenhoAnaliticoMacprev',$cBusc);
}
//ddoSinteticoMacprev
if(isset($respGet['acao']) && $respGet['acao']=='ddoSinteticoMacprev'){
    
    if($respGet['tem13salario'] == 'true'){
        $respGet['tem13salario'] = 'sim';
    }else{
        $respGet['tem13salario'] = 'nao';
    }
    
    $mesAnoInicial = getDataReferenciaNSD($respGet['mesAnoInicial']);
    if(isset($respGet['tem13salario']) && ($respGet['tem13salario']=="sim")){
        $cBusc = array($mesAnoInicial, '197','197',$tipo);
    } else {
        $cBusc = array($mesAnoInicial, '132','13F',$tipo);
    }
    $lista = getRest('relatorio/getRelDdoSinteticoMacprev',$cBusc);
    print_p($lista);
}
//ddoAnaliticoMacprev
if(isset($respGet['acao']) && $respGet['acao']=='ddoAnaliticoMacprev'){

    if($respGet['tem13salario'] == 'true'){
        $respGet['tem13salario'] = 'sim';
    }else{
        $respGet['tem13salario'] = 'nao';
    }
    
    $mesAnoInicial = getDataReferenciaNSD($respGet['mesAnoInicial']);
    if(isset($respGet['tem13salario']) && ($respGet['tem13salario']=="sim")){
        $cBusc = array($mesAnoInicial, '197',$tipo);
    } else {
        $cBusc = array($mesAnoInicial, '132',$tipo);
    }
    $lista = getRest('relatorio/getRelDdoAnaliticoMacprev',$cBusc);
    print_p($lista);
}
//export
if(isset($respGet['acao']) && $respGet['acao']=='exportarMacprevNsd'){

    $mesAnoInicial = getDataReferenciaNSD($respGet['mesAnoInicial']);
    $cBusc = array($mesAnoInicial,$tipo);
    $lista = getRest('relatorio/getRelExportarMacprevNsd',$cBusc);
}
//export
if(isset($respGet['acao']) && $respGet['acao']=='exportFUNDEB'){

    $mesAnoInicial = getDataReferenciaNSD($respGet['mesAnoInicial']);
    $cBusc = array($mesAnoInicial,$tipo);
    $lista = getRest('relatorio/getRelExportarFundebNsd',$cBusc);
    $btnExportarCSV = true;
    $btnExportar = true;
}
//export
if(isset($respGet['acao']) && $respGet['acao']=='exportAcomOrcamentario'){

    $mesAnoInicial = mesAno($respGet['mesAnoInicial']);
    $cBusc = array($mesAnoInicial,$tipo);
    $lista = getRest('relatorio/getRelExportarAcomOrcamentario',$cBusc);
}
if(isset($respGet['acao']) && $respGet['acao']=='bancoHoras'){

    $cBusc = array($respGet['idFuncional'],$tipo);
    $lista = getRest('relatorio/getRelBancoDeHoras',$cBusc);
}
//Marcacao Inicio fim
if(isset($respGet['acao']) && $respGet['acao']=='macacoesInicioFim'){

    $mesAnoInicial = $respGet['mesAnoInicial'];
    $mesAnoFinal = $respGet['mesAnoFinal'];
    $matricula = $_SESSION['funcionalBusca']['matricula'];

    $cBusc = array($mesAnoInicial, $mesAnoFinal, $matricula, $tipo);
    $lista = getRest('relatorio/getRelMarcacaoServidorEmLote',$cBusc);
}
//Marcacao Inicio
if(isset($respGet['acao']) && $respGet['acao']=='macacoesInicio'){

    $mesAnoInicial = $respGet['dado'];
    $mesAnoFinal = $respGet['dado'];
    $matricula = $_SESSION['funcionalBusca']['matricula'];

    $cBusc = array($mesAnoInicial, $mesAnoFinal, $matricula, $tipo);
    $lista = getRest('relatorio/getRelMarcacaoServidorEmLote',$cBusc);
}
//Folha Sintetica
if(isset($respGet['acao']) && $respGet['acao']=='exportAcomOrcamentario'){

    $mesAnoInicial = mesAnoParaDate($respGet['mesAnoInicial']);
    $mesAnoFinal = mesAnoParaDate($respGet['mesAnoFinal']);
    $mesAnoFinal =primeiroUltimoDiaMes($mesAnoFinal);
    $mesAnoFinal = dataBanco($mesAnoFinal['1']);
    $refNsds = $respGet['selectCompetencia'];
    $cBusc = array($mesAnoInicial, $mesAnoFinal, $refNsds, $tipo);
    $lista = getRest('relatorio/getRelFolhaSintetica',$cBusc);
    $btnExportarCSV = true;
    $btnExportar = true;
}
//PORTARIA
if(isset($respGet['acao']) && $respGet['acao']=='exibePortaria'){

    $nomePortaria = str_replace('/', '%2F', $respGet['portaria']);
    $pBusc = array($nomePortaria, $tipo);
    $lista = getRest('relatorio/getRelExibitPortaria',$pBusc);
}
    //commit
//Historico de acessos
if(isset($respGet['acao']) && $respGet['acao']=='historicoAcesso'){

    $cBusc = array($respGet['mesAnoInicial'].'T00:00:00.0', $respGet['mesAnoFinal'].'T23:59:00.0',$respGet['user'],$tipo);
    $lista = getRest('relatorio/getRelLogAcessos',$cBusc);
}
//Select Competencia Liquidacao
if(isset($respGet['acao']) && $respGet['acao']=='consiguinadoLiquidacao'){

    $cBusc = array($respGet['selectCompetencia'],$tipo);
    $lista = getRest('relatorio/getRelConsignadoLiquidacao',$cBusc);
}
//Select Competencia Critica
if(isset($respGet['acao']) && $respGet['acao']=='consiguinadoCritica'){

    $cBusc = array($respGet['selectCompetencia'],$tipo);
    $lista = getRest('relatorio/getRelConsignadoCritica',$cBusc);
}
//Select Competencia Critica
if(isset($respGet['acao']) && $respGet['acao']=='OcorrenciasPorPeriodo'){

    $hora1 = "T00:00:01";
    $hora2 = "T23:00:59";
    $cBusc = array($respGet['matricula'],$respGet['inicio'].$hora1,$respGet['fim'].$hora2,$respGet['idOcorrencia'],$tipo);
    //$cBusc = array($respGet['matricula'],$respGet['inicio'].$hora1,$respGet['fim'].$hora2,$respGet['idOcorrencia'],$tipo);
    $lista = getRest('relatorio/getRelOcorrenciasPorPeriodo',$cBusc);  
}
//VARIAVEIS
if( $respGet['acao']=='relatFechamentoVariavel'){

    $cBusc = array($respGet['idLotacao'],$respGet['idVariavelDesc'],$respGet['codValidacao'],$tipo);
    $lista = getRest('relatorio/getRelVariaveisLancamentoSecretaria',$cBusc);  
}
if( $respGet['acao']=='relatFechamentoVariavelSub'){

    $cBusc = array($respGet['idLotacaoSub'],$respGet['idVariavelDesc'],$tipo);
    $lista = getRest('relatorio/getRelVariaveisLancamentosSetor',$cBusc);  
}
if( $respGet['acao']=='relatorioVariavelCarregadas'){

    $cBusc = array($respGet['idLotacaoSub'],$respGet['idUserLogin'],$tipo);
    $lista = getRest('relatorio/getRelVariaveisModeloLancamento',$cBusc);  
}
if( $respGet['acao']=='relatVariavelLotacao'){

    $cBusc = array($respGet['idLotacao'],$respGet['idVariavelDesc'],$tipo);
    $lista = getRest('relatorio/getRelVariaveisLancamentosSecretaria',$cBusc);  
}
//Funcao para adequar a data ao formato da tabela NSD
function getDataReferenciaNSD($data){
    $separado = explode("-",$data);
    $dia = "01";
    $mes = $separado[1];
    $ano = $separado[0];
    $mesAnoInicial = $ano . "-" . $mes . "-" . $dia;
    return $mesAnoInicial;
}
//PEGA TODA QUERY STRING E JOGA NO parametro
$parametros ="";
foreach($respGet as $key=>$value){
  $parametros = $parametros."&".$key."=".$value;
  //echo $key."=".$value."<br>";
}
$parametros = substr($parametros, 1);
//nivel de acesso
        $buscAcessoNivel = array("4");
        $listaAcesso = getRest('userPermissaoAcesso/getPermissaoAcessoDirecao',$buscAcessoNivel);
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'Visualizar') AND ($valor['buscar'] == '1') AND ($respGet['exibeHTML'] != 'false')){ 
             $btnVisualizar = true;
             break;
        }
    }
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'Exportar') AND ($valor['buscar'] == '1')){ 
             $btnExportar = true;
             break;
        }
    }
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'ExportarCSV') AND ($valor['buscar'] == '1')){ 
             $btnExportarCSV = true;
             break;
        }
    }
    foreach ($listaAcesso as $valor) {
        if (($valor['link'] == 'Download') AND ($valor['buscar'] == '1')){ 
             $btnDownload = true;
             break;
        }
    }

if(isset($respGet['acao']) && $respGet['acao']=='crachaFuncional'){
    if($respGet['idImagem'] == 8){
        $cBusc = array($respGet['cpf'],$respGet['nome'],$respGet['matricula'],$respGet['idImagem'],$tipo);
        $lista = getRest('relatorio/getRelCrachaVerso',$cBusc);     
    }else{
        $partesDeNome = explode(" ", $respGet['nome']);
        $result = count($partesDeNome)-1;
        $respGet['nome'] = $partesDeNome[0]." ".$partesDeNome[$result];
        $cBusc = array($respGet['cpf'],$respGet['nome'],$respGet['idImagem'],$tipo);
        $lista = getRest('relatorio/getRelCrachaFrente',$cBusc); 
    }
}
//Select VariaveisLancamento por funcional
if(isset($respGet['acao']) && $respGet['acao']=='VariaveisLancamentos'){

        $cBusc = array($respGet['idHistorioFunc'],$respGet['dataPeriodoFolha'],$tipo);
        $lista = getRest('relatorio/getRelVariaveisLancamentos',$cBusc);  
}
//imprimir crachas em status impressos
if(isset($respGet['acao']) && $respGet['acao']=='crachaImpressos'){
        $btnExportar = true;
        $btnExportarCSV = true;

        $btnVisualizar = TRUE;
        $cBusc = array($tipo);
        $lista = getRest('relatorio/getRelCrachasImpressos',$cBusc);
    
}
//SESMT-----------------------------------------------------------------------
if(isset($respGet['acao']) && $respGet['acao']=='requerimentoProtocoloGeral'){
        $cBusc = array(
                        $respGet['endereco'],
                        $respGet['cidade'],
                        $respGet['bairro'],
                        $respGet['telefone'],
                        $respGet['email'],
                        $respGet['cpf'],
                        $tipo
                    );
        $lista = getRest('relatorio/getRelRequerimentoProtocoloGeral',$cBusc);   
}
if(isset($respGet['acao']) && $respGet['acao']=='readaptacao'){

        $cBusc = array(
                        $respGet['dado'],
                        $respGet['matricula'],
                        $tipo
                    );
        $lista = getRest('relatorio/getRelReadaptacao',$cBusc);   
}
if(isset($respGet['acao']) && $respGet['acao']=='destino4'){

        $cBusc = array(
                        $respGet['dado'],
                        $respGet['matricula'],
                        $tipo
                    );
        $lista = getRest('relatorio/getRelResultadoExameDestino4',$cBusc);   
}
if(isset($respGet['acao']) && $respGet['acao']=='destino5'){

        $cBusc = array(
                        $respGet['dado'],
                        $respGet['matricula'],
                        $tipo
                    );
        $lista = getRest('relatorio/getRelResultadoExameDestino5',$cBusc);   
}
if(isset($respGet['acao']) && $respGet['acao']=='destino6'){

        $cBusc = array(
                        $respGet['dado'],
                        $respGet['matricula'],
                        $tipo
                    );
        $lista = getRest('relatorio/getRelResultadoExameDestino6',$cBusc);   
}
if(isset($respGet['acao']) && $respGet['acao']=='solicitacaoLicenca'){

        $cBusc = array(
                        $respGet['dado'],
                        $respGet['matricula'],
                        $tipo
                    );
        $lista = getRest('relatorio/getRelSesmtSolicitaLicenca',$cBusc);   
}
if(isset($respGet['acao']) && $respGet['acao']=='laudoExameMedicoPericial'){

        $cBusc = array(
                        $respGet['dado'],
                        $respGet['matricula'],
                        $tipo
                    );
        $lista = getRest('relatorio/getRelLaudoExameMeidoPericial',$cBusc);   
}
if(isset($respGet['acao']) && $respGet['acao']=='todosProntuario'){

        if($respGet[redap] == 'true'){$respGet[redap] = 1;}else{$respGet[redap] = 0;}
        if($respGet[red1] == 'true'){$respGet[red1] = 1;}else{$respGet[red1] = 0;}
        if($respGet[red2] == 'true'){$respGet[red2] = 1;}else{$respGet[red2] = 0;}
        if($respGet[red3] == 'true'){$respGet[red3] = 1;}else{$respGet[red3] = 0;}
        if($respGet[sol] == 'true'){$respGet[sol] = 1;}else{$respGet[sol] = 0;}
        if($respGet[lemp] == 'true'){$respGet[lemp] = 1;}else{$respGet[lemp] = 0;}
        $cBusc = array(
                        $respGet['dado'],
                        $respGet['matricula'],
                        $respGet[redap],
                        $respGet[red1],
                        $respGet[red2],
                        $respGet[red3],
                        $respGet[sol],
                        $respGet[lemp],
                        $tipo
                    );
        $lista = getRest('relatorio/getRelTodosSesmt',$cBusc);   
}
 $_SESSION['listaUrl'] = $lista;
 $_SESSION['respGet'] = $respGet;
?>    
<!-- info row -->
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary">
          
            <div class="overlay" id="idSpinLoaderCabRod">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
          
          <div class="box-header with-border">
              <?php
              if ($botao == true){?>
                <div class="row no-print">
                  <div class="col-xs-12">
                      <?php if($btnDownload == true){?>
                      
                          
                          <button id="idBtnPdf" type="submit" class="btn btn-facebook pull-right">
                              <i class="fa fa-file-pdf-o"></i> Download
                          </button>
                     
                      <?php } if($btnVisualizar == true){?>
                      <!-- CODIGO DE IMPRESSÃO POR JAVASCRIPT-->
                        <script>
                            function imprimeBase64(data) {
                                printJS({printable: data, type: 'pdf', base64: true})
                            }
                        </script>

                        <?php
                            $url = $_SESSION['listaUrl']['url'];
                            $arrFrom = array(".html?");
                            $arrTo = array(".pdf?");

                            $url = str_replace($arrFrom, $arrTo, $url);

                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl, CURLOPT_HEADER, false);
                            $data = curl_exec($curl);
                            $base64Data = base64_encode($data);
                            curl_close($curl);
                        ?>

                        <form method="<?= $method ?>" action="index.php">
                            <input type="hidden" name="tipo_relatorio" value="pdf">
                            <button onclick="imprimeBase64('<?= $base64Data ?>')" type="button" style="margin-right: 5px;" class="btn btn-danger pull-right">
                                <i class="fa fa-print"></i> Imprimir
                            </button>
                        </form>
                       <!-- FIM CODIGO DE IMPRESSÃO POR JAVASCRIPT-->
                      
                          
                          <button id="idBtnVisualizar" type="submit" style="margin-right: 5px;" class="btn btn-dark pull-right">
                            <i class="fa fa-eye"></i> Visualizar
                          </button>
                   
                   <?php }if($btnExportarCSV == true){?>
    
                          <button id="idBtnExportarCsv" type="submit" style="margin-right: 5px;" class="btn btn-success pull-right">
                              <i class="fa fa-download"></i> Exportar CSV
                          </button>
              
                    <?php }if($btnExportar == true){
                        ?>
                       
                            <button id="idBtnExportarXls" style="margin-right: 5px;" class="btn btn-success pull-right">
                                <i class="fa fa-download"></i> Exportar
                            </button>
                       
                      <?php }?>
<!--                            <button class="btn btn-primary pull-right" style="margin-right: 5px;" onclick="voltarEmRelatorio('<?=$respGet['vpst']?>', '<?=$respGet['varq']?>','<?=$respGet['menuN3']?>','<?=$respGet['menuN4']?>','<?=$respGet['vtab']?>','<?=$respGet['pg']?>')" type="button">
                                 <i class="fa fa-reply-all"></i> Voltar
                            </button>            -->
                  </div>
                </div>
              <?php }?>   
          </div>
          <div class="box-body">
          <?php 
              if((isset($respGet['acao']) && $respGet['gerarRelatorio'] == "TRUE") || $respGet['ver'] == "true"){
                    if($respGet[tipo_relatorio] == '' || $respGet['ver'] == "true"){
                        $height = '600';
                        $width = '100%';
                    }else{
                        $height = '0';
                        $width = '0%';
                    }
                    
                  ?>
                   <iframe id="idPaginaRelatorio" name="nomePaginaRelatorio" frameborder="0" src="print/renderizadorDeHtml.php" width="<?=$width?>" height="<?=$height?>" hspace="0" vspace="0" marginheight="0" marginwidth="0">

                   </iframe>
                   <script type="text/javascript">
                            document.getElementById('idPaginaRelatorio').onload = function() {
                                $("#idSpinLoaderCabRod").addClass("hidden");
                            }
                    </script>
                  <?php
                }         
          ?>
          </div>
      </div>
  </div>
  <!-- /.col -->
</div>
<script>
    $(document).ready(function () {
        //Só exibe a janela de impressão se o usuario não esta visualizando
        <?php
            if($respGet['gerarRelatorio'] != "TRUE" and $respGet['ver'] != "true"){
        ?>       
                imprimeBase64('<?= $base64Data ?>');
        <?php        
            }
        ?>
        
    });
    function voltarEmRelatorio(pst,arq,menuN3,menuN4,tab,pg){
        $.ajax
                ({
                    //Configurações
                    type: 'POST', //Método que está sendo utilizado.
                    dataType: 'html', //É o tipo de dado que a página vai retornar.
                    url: pst + '/' + arq + '.php', //Indica a página que está sendo solicitada.
                    //função que vai ser executada assim que a requisição for enviada
                    beforeSend: function () {
                        $("#idSpinLoaderGestao").removeClass("hidden");

                    },
                    data: {pst:pst, arq:arq, menuN3:menuN3, menuN4:menuN4, tab:tab, pg:pg}, //Dados para consulta
                    //função que será executada quando a solicitação for finalizada.
                    success: function (msg)
                    {
                        $("#dados").html(msg);
                        configuraTela();
                        $("#idSpinLoaderGestao").addClass("hidden");
                    }
                });
    }
        
    function formatosDeRelatorio(tipo_relatorio,
                                pst,
                                arq,
                                vpst,
                                varq,
                                acao,
                                orby,
                                exibicao,
                                idSecretaria,
                                idSetor,
                                pg,
                                relat,
                                idUsuario,
                                periodo,
                                vtab,
                                id,
                                mesAnoInicial,
                                mesAnoFinal,
                                selectCompetencia,
                                codNsd,
                                codNsds,
                                codNsda,
                                inicio,
                                fim,
                                matricula,
                                cpf,
                                nome,
                                idOcorrencia,
                                exibeHTML,
                                idCrachaTipo,
                                idhistfunc,
                                periodofolha,
                                inativo,
                                codValidacao,
                                idVariavelDesc,
                                idLotacao,
                                link,
                                menuN3,
                                menuN4,
                                gerarRelatorio){
        
        console.log(pst + '/' + arq + '.php');
        $.ajax
                ({
                    //Configurações
                    type: 'POST', //Método que está sendo utilizado.
                    dataType: 'html', //É o tipo de dado que a página vai retornar.
                    url: pst + '/' + arq + '.php', //Indica a página que está sendo solicitada.
                    //função que vai ser executada assim que a requisição for enviada
                    beforeSend: function () {
                        $("#idSpinLoaderGestao").removeClass("hidden");
                    },
                    data: {
                        tipo_relatorio:tipo_relatorio,
                        pst:pst,
                        arq:arq,
                        vpst:vpst,
                        varq:varq,
                        acao:acao,
                        orby:orby,
                        exibicao:exibicao,
                        idSecretaria:idSecretaria,
                        idSetor:idSetor,
                        pg:pg,
                        relat:relat,
                        idUsuario:idUsuario,
                        periodo:periodo,
                        vtab:vtab,
                        id:id,
                        mesAnoInicial:mesAnoInicial,
                        mesAnoFinal:mesAnoFinal,
                        selectCompetencia:selectCompetencia,
                        codNsd:codNsd,
                        codNsds:codNsds,
                        codNsda:codNsda,
                        inicio:inicio,
                        fim:fim,
                        matricula:matricula,
                        cpf:cpf,
                        nome:nome,
                        idOcorrencia:idOcorrencia,
                        exibeHTML:exibeHTML,
                        idCrachaTipo:idCrachaTipo,
                        idhistfunc:idhistfunc,
                        periodofolha:periodofolha,
                        inativo:inativo,
                        codValidacao:codValidacao,
                        idVariavelDesc:idVariavelDesc,
                        idLotacao:idLotacao,
                        link:link,
                        menuN3:menuN3,
                        menuN4:menuN4,
                        gerarRelatorio:gerarRelatorio
                    }, //Dados para consulta
                    //função que será executada quando a solicitação for finalizada.
                    success: function (msg)
                    {
                        $("#imprimir").html(msg);
                        configuraTela();
                        $("#idSpinLoaderGestao").addClass("hidden");
                    }
                });
    }
    
    function defineFormato(formato){
        formatosDeRelatorio(
                            formato,
                            '<?=$respGet[pst]?>',
                            '<?=$respGet[arq]?>',
                            '<?=$respGet[vpst]?>',
                            '<?=$respGet[varq]?>',
                            '<?=$respGet[acao]?>',
                            '<?=$respGet[orby]?>',
                            '<?=$respGet[exibicao]?>',
                            '<?=$respGet[idSecretaria]?>',
                            '<?=$respGet[idSetor]?>',
                            '<?=$respGet[pg]?>',
                            '<?=$respGet[relat]?>',
                            '<?=$respGet[idUsuario]?>',
                            '<?=$respGet[periodo]?>',
                            '<?=$respGet[vtab]?>',
                            '<?=$respGet[id]?>',
                            '<?=$respGet[mesAnoInicial]?>',
                            '<?=$respGet[mesAnoFinal]?>',
                            '<?=$respGet[selectCompetencia]?>',
                            '<?=$respGet[codNsd]?>',
                            '<?=$respGet[codNsds]?>',
                            '<?=$respGet[codNsda]?>',
                            '<?=$respGet[inicio]?>',
                            '<?=$respGet[fim]?>',
                            '<?=$respGet[matricula]?>',
                            '<?=$respGet[cpf]?>',
                            '<?=$respGet[nome]?>',
                            '<?=$respGet[idOcorrencia]?>',
                            '<?=$respGet[exibeHTML]?>',
                            '<?=$respGet[idCrachaTipo]?>',
                            '<?=$_SESSION[funcionalBusca][id]?>',
                            '<?=$_SESSION[dataPeriodoFolha]?>',
                            '<?=$respGet[inativo]?>',
                            '<?=$respGet[codValidacao]?>',
                            '<?=$respGet[idVariavelDesc]?>',
                            '<?=$respGet[idLotacao]?>',
                            '<?=$respGet[link]?>',
                            '<?=$respGet[menuN3]?>',
                            '<?=$respGet[menuN4]?>',
                            'TRUE'
                );
    }
    
    
    $('#idBtnExportarXls').click(function () {
        defineFormato('xls');
    });
    $('#idBtnExportarCsv').click(function () {
        defineFormato('xls');
    });
    $('#idBtnVisualizar').click(function () {
        defineFormato('');
    });
    $('#idBtnPdf').click(function () {
        defineFormato('pdf');
    });


</script>
