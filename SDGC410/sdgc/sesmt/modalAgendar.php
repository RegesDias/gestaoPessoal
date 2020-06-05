<?php
    $histR = array();
    $listaMedicos = getRest('requerimento/getListarMedicoComVagasAbertas',$histR);
    if($value2[matriculaServidor] == 'VAGO'){ ?>
        <div class="modal fade" id="agenda<?=$ArrEsp?>" role="dialog">
          <div class="modal-dialog modal-md">

            <div class="modal-content">
              <div class="modal-body">
                    <div class="col-sm-12">
                      <label>Servidor</label>
                      <select id="agendaDia" class="form-control select2" style="width: 100%;">
                          <option value=""></option>
                          <option>2222-joao</option>
                          <option>2223-Reges</option>
                          <option>2224-Amauri</option>
                        </select>
                    </div>
                    <div class="col-sm-12"><br></div>
              </div>
              <div class="modal-footer">
                    <button class="btn btn-primary" onclick="buscaAtendimentos('agendar',$('#agendaMedico').val(),$('#agendaDia').val())" type="button">
                        Confirmar
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
    <?php }else{?>   
        <div class="modal fade" id="agenda<?=$ArrEsp?>" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <label>Médico</label>
                            <select id="agendaMedico" class="form-control select2" style="width: 100%;">
                                <option value=""></option>
                                <?php
                                    foreach($listaMedicos as $medico){
                                  ?>     

                                <option value="<?=$medico[idRequerimentoMedico]?>"><?=$medico[nomeMedico]?></option>

                                 <?php       
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-12">
                          <label>Vaga</label>
                          <select id="agendaDia" class="form-control select2" style="width: 100%;">
                              <option value=""></option>
                              <option>01/02/2020</option>
                              <option>01/02/2020</option>
                              <option>01/02/2020</option>
                              <option>01/02/2020</option>
                            </select>
                        </div>

                        <div class="col-sm-12"><br></div>
                    </div>
                    <div class="modal-footer">
                          <button class="btn btn-primary" onclick="agendaSESMTAgendar('agendar',$('#agendaMedico').val(),$('#agendaDia').val(),$('#agendaPeriodo').val(),'1')" type="button">
                              Confirmar
                          </button>
                          <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                    </div>
                </div>
              </div>
            </div>
    <?php }?>