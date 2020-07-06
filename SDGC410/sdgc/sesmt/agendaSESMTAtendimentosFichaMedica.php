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
                        <label>CID</label>
                        <select name="cid-10" size="1"  multiple onchange="descricaoCID10('descricaoCID10', $('select#idCid10 option:selected').map(function () {
                                    return $(this).val();
                                }).get(), )" class="form-control select2" id='idCid10' style="width: 100%;">
                            <option value="valor1"></option> 
                            <?php foreach ($_SESSION[listaCID10] as $value) { ?>    


                                <option value="<?= $value[id] ?>"><?= "$value[id] - $value[descricaoCidCategoriaSub]" ?></option> 
                            <?php } ?>
                        </select>
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
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="evolucao" id="evolucao" value="option1" >
                                        Em tratamento
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="evolucao" id="evolucao" value="option2">
                                        Curado
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="evolucao" id="evolucao" value="option3" >
                                        Melhorando (Crônica)
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="evolucao" id="evolucao" value="option3" >
                                        Melhorando (Aguda)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">Retorno</label>
                            <div class="form-group">
                                <select name="cid-10" size="1" class="form-control select2" id='idretorno' style="width: 100%;">
                                    <option selected="selected"></option>
                                    <option value="1">Sim - Readaptação Provisoria</option>
                                    <option value="2">Sim - Readaptação Definitiva</option>
                                    <option value="3">Sim - Sem Restrição</option>
                                    <option value="4">Sim - Prorogação com Alta</option>
                                    <option value="4">Não - Nova Avaliação</option> 
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6"></div>
                        <div class="col-md-6" id="dadoRetorno" >
                            <label>Dias</label>
                            <input type="text" class="form-control" >
                        </div>
                    </div>

                        <div class="col-md-12">
                        
                        <div class="box-header with-border">
                            <h3 class="box-title">Atribuições do Cargo</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 8px"></th>
                                    <th style="width: 32px">Descrição</th>
                                </tr>
                                <?php
                                $nome = array('00002');
                                $lista = getRest('cargo/getListAtribuicoesCargoPorIdCargoGeral', $nome);
                                foreach ($lista as $value) {
                                    ?>
                                    <tr>
                                        <td>
                                            <label>
                                                <input type="checkbox" class="flat-red" checked>
                                            </label>
                                        </td>
                                        <td>
                                            <?= $value[descricaoAtribuicao] ?>
                                        </td>

                                    </tr>

                                <?php } ?>
                            </table>
                        </div>
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
        <button class="btn btn-primary" onclick="salvaFichaMedica('salvaFichaMedica')" type="button">
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