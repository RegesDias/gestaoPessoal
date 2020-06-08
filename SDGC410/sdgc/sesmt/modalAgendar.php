<?php
if ($value[matriculaServidor] == 'VAGO') {
    ?>
    <div class="modal fade" id="agendaServidor<?=$ArrEsp?>" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-sm-12">
                        <label>Servidor</label>
                        <select id="agendaS<?=$ArrEsp?>" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <?php
                            foreach ($listaReqEntrada as $servidor) {
                                ?>     
                                <option value="<?= $servidor[idRequerimentoFuncional] ?>"><?= $servidor[nomeServidor]." - ".$servidor[nomeSolicitaco] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-12"><br></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="agendaSESMTAgendarServidor('agendarServidor', $('#agendaS<?=$ArrEsp?>').val(), '<?=$value[idLinha]?>','<?=$respGet[inicio]?>','<?=$respGet[fim]?>','<?=$respGet[medico]?>')" type="button">
                        Confirmar
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>   
    <div class="modal fade" id="agenda<?= $ArrEsp ?>" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-sm-12">
                        <label>Médico</label>
                        <select onchange="getAJAX(<?="'".$ajurl."'";?>,'requerimento/getListarLinhasVagasPorIdRequerimentoMedico/',this.value,selectAgendaDia<?= $ArrEsp ?>)" id="agendaMedico<?= $ArrEsp ?>" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                            <?php
                            foreach ($listaMedicos as $medico) {
                                ?>     
                                <option value="<?= $medico[idRequerimentoMedico] ?>"><?= $medico[nomeMedico] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label>Vaga</label>
                        <select id="idLinha<?= $ArrEsp ?>" class="form-control select2" style="width: 100%;">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="col-sm-12"><br></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="agendaSESMTAgendar('agendar', $('#idLinha').val(), '<?=$value[idRequerimentoFuncional]?>',$('#agendaMedico').val(),)" type="button">
                        Confirmar
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<script>
    function selectAgendaDia<?= $ArrEsp ?>(lista) {

        var listaMapeada = lista.map(item => [item.dataFolha, item.periodo, item.idLinha]);
        let arrayColumn = (arr, n) => arr.map(x => x[n]);
        listaDataFolha = arrayColumn(listaMapeada, 0);
        listaPeriodo = arrayColumn(listaMapeada, 1);
        listaIdLinha = arrayColumn(listaMapeada, 2);

        let listaDataFolhaPeriodo = listaDataFolha.map(function (elem, index) {
            listaPeriodo[index] = listaPeriodo[index].replace("manha", "Manhã");
            listaPeriodo[index] = listaPeriodo[index].replace("tarde", "Tarde");
            let data = elem.split('T')[0];
            let dia = data.split('-')[2];
            let mes = data.split('-')[1];
            let ano = data.split('-')[0];
            data = dia+'/'+mes+'/'+ano;
            return data + ' (' + listaPeriodo[index]+')';
        });

        let selectAgenda = pegaElementoPorId('idLinha<?= $ArrEsp ?>');
        preencheSelect(selectAgenda, listaDataFolhaPeriodo, listaIdLinha);
    }
</script>
<?php } ?>

