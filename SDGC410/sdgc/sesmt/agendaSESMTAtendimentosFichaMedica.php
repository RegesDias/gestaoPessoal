<?php
session_start();
require_once '../func/fPhp.php';
require_once '../func/fModal.php';
?> 
<div class="box box-primary">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-widget">
                <?php require_once '../sesmt/dadosPaciente.php'; ?>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Ficha Médica</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        
                        
                        <label>CID <span id="idCarregaStatusCid"></span> </label>
                        <select tabindex="indice1" name="cid-10" size="1"  multiple onchange="descricaoCID10('descricaoCID10', $('select#idCid10 option:selected').map(function () {
                                    return $(this).val();
                                }).get(), )" class="form-control select2" id='idCid10' style="width: 100%;">
                            <option value="0"> </option> 
                        </select>
                        
                        <label>HPP <span id="idCarregaStatusHpp"></span> </label>
                        <select tabindex="indice2" name="HPP" size="1"  multiple onchange="('descricaoCID10', $('select#idHPP option:selected').map(function () {
                                    return $(this).val();
                                }).get(), )" class="form-control select2" id='idHPP' style="width: 100%;">
                            <option value="0"> </option> 
                        </select>
                        
                        
                        <script>

                            var labelCarregaStatusCid = document.getElementById("idCarregaStatusCid");
                            var labelCarregaStatusHPP = document.getElementById("idCarregaStatusHpp");
                            
                            var listaDescricaoCid = [];
                            var listaIdCid = [];
                            var listaIdDescricaoCid = [] ;
                            var selectAPreencher;
                            var labelCarregaStatus;
                            
                            $(document).on('keyup', "input[tabindex='indice1'].select2-search__field", function (e) {
                                let stringCapturada = $("input[tabindex='indice1'].select2-search__field")[0].value;
                                labelCarregaStatus = labelCarregaStatusCid;
                                selectAPreencher = document.getElementById("idCid10");
                             
                                if (stringCapturada.length > 3) {
                                    getAJAX(<?= "'" . $ajurl . "'"; ?>, 'cid/getListCidCategoriaSubPorIdOuNome/', stringCapturada, preencheSelectCID10ouHPP);
                                    labelCarregaStatus.innerHTML = " Carregando";
                                }else{
                                    labelCarregaStatus.innerHTML = "";
                                }
                                
                            });
                            
                            $(document).on('keyup', "input[tabindex='indice2'].select2-search__field", function (e) {
                                let stringCapturada = $("input[tabindex='indice2'].select2-search__field")[0].value;
                                labelCarregaStatus = labelCarregaStatusHPP; 
                                selectAPreencher = document.getElementById("idHPP");
                                if (stringCapturada.length > 3) {
                                    getAJAX(<?= "'" . $ajurl . "'"; ?>, 'cid/getListCidCategoriaSubPorIdOuNome/', stringCapturada, preencheSelectCID10ouHPP);
                                    labelCarregaStatus.innerHTML = " Carregando";
                                }else{
                                    labelCarregaStatus.innerHTML = "";
                                }
                                
                            });
                            
                            function preencheSelectCID10ouHPP(lista) {

                                var listaMapeada = lista.map(item => [item.descricao, item.id]);
                                let arrayColumn = (arr, n) => arr.map(x => x[n]);
                                
                                listaDescricaoCid = listaDescricaoCid.concat(arrayColumn(listaMapeada, 0));
                                listaDescricaoCid = eliminaRepetidos(listaDescricaoCid);
                                
                                listaIdCid = listaIdCid.concat(arrayColumn(listaMapeada, 1)) ;
                                listaIdCid = eliminaRepetidos(listaIdCid);

                                listaIdDescricaoCid = listaIdDescricaoCid.concat(
                                    listaDescricaoCid.map(function (elem, index) {
                                    return listaIdCid[index] + ' - ' + elem;
                                })); 
                                listaIdDescricaoCid = eliminaRepetidos(listaIdDescricaoCid);
                                
                                let selectCid = selectAPreencher;
                                preencheSelect(selectCid, listaIdDescricaoCid, listaIdCid);
                                
                                if(lista.length > 0){
                                    labelCarregaStatus.innerHTML = " Carregado";
                                }else{
                                    labelCarregaStatus.innerHTML = " Sem resultados";
                                }
                            }
                            

                            function eliminaRepetidos(lista){
                                return lista.filter(function(este, i) {
                                    return lista.indexOf(este) === i;
                                });
                            }
                            
                        </script>
                    </div>
                    <div id="dadosCid10">
                    </div>
                    <div class="form-group">
                        <label>Medicamentos</label>
                        <input type="text" class="form-control" >
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Evolução</label>
                            <div class="form-group">
                                <select name="evolucao" size="1" id="evolucao" onchange="mudaAtribuicao('atribuicao', $('#evolucao').val())" class="form-control select2" style="width: 100%;">
                                    <option selected="selected"></option>
                                    <?php foreach ($_SESSION[evolucao] as $value) { ?>
                                        <option value="<?= $value[id] . "-" . $value[atribuicoes] ?>"><?= $value[descricao] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Retorno</label>
                            <div class="form-group">
                                <select name="retorno" size="1" id="retorno" onchange="mudaEvolucao('atribuicao', $('#retorno').val())" class="form-control select2" style="width: 100%;">
                                    <option selected="selected"></option>
                                    <?php
                                    foreach ($_SESSION[retorno] as $value) {
                                        if ($value[retorna] == 1) {
                                            $value[retorna] = 'Sim';
                                        } else {
                                            $value[retorna] = 'Não';
                                        }
                                        ?>
                                        <option value="<?= $value[id] . '-' . $value[dias], '-', $value[calendario] . '-' . $value[atribuicoes] ?>"><?= $value[retorna] . " - " . $value[descricao] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6"></div>
                        <div class="col-md-6" id="dadoRetorno" >
                        </div>
                    </div>

                    <div id ='descricaoAtribuicoes'>
                    </div>

                    <script>
                        $(document).on("keydown", "#obsOco", function () {
                            var caracteresRestantes = 499;
                            var caracteresDigitados = parseInt($(this).val().length);
                            var caracteresRestantes = caracteresRestantes - caracteresDigitados;

                            $(".caracteres").text(caracteresRestantes);
                        });
                    </script>
                    <div class="form-group col-sm-12">
                        <label>Observação<i><sub class="caracteres">500</sub> <sub>Restantes </sub></i></label> 
                        <textarea id="obsOco" name='ObsOco'class="form-control"  maxlength="500"rows="4"></textarea>
                    </div>
                    <div class="row" id="idBoxSelectSetor">
                        <div class="col-md-12">
                            <label>Dias de Afastamento</label>
                            <input type="text" class="form-control" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" data-toggle="modal" data-target="#fecharLotacao<?= $ArrEsp[idVariavelDesc] ?>" >
            <i class="fa fa-check"></i> Finalizar
        </button>
        <button class="btn btn-primary" onclick="salvaFichaMedica('salvaFichaMedica', '<?= $respGet[cpf] ?>')" type="button">
            <i class="fa fa-save"></i> Salvar
        </button>
    </div>
    <div class="modal fade" id="fecharLotacao<?= $ArrEsp[idVariavelDesc] ?>" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-sm-12">
                        <label>Ação</label>
                        <select id="agendaMedico" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <option value="1">Homologado</option>
                            <option value="2">Não Homologado</option>
                            <option value="3">Pendente de Documentos</option>
                            <option value="4">Junta Médica</option>
                        </select>
                    </div>
                    <div class="col-sm-12"><br></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="agendaSESMTAgendar('agendar', $('#agendaMedico').val(), $('#agendaDia').val(), $('#agendaPeriodo').val())" type="button">
                        Confirmar
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    configuraTela();
</script>