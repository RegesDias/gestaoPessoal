    <div class="modal fade" id="agenda<?=$ArrEsp?>" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-sm-12">
                    <label>Médico</label>
                    <select id="agendaMedico" class="form-control select2" style="width: 100%;">
                        <option value=""></option>
                        <option value="1">dr1</option>
                        <option value="2">dr2</option>
                        <option value="3">dr3</option>
                        <option value="4">dr4</option>
                    </select>
                </div>
                <div class="col-sm-6">
                  <label>Dia</label>
                  <select id="agendaDia" class="form-control select2" style="width: 100%;">
                      <option value=""></option>
                      <option>01/02/2020</option>
                      <option>01/02/2020</option>
                      <option>01/02/2020</option>
                      <option>01/02/2020</option>
                    </select>
                </div>
                <div class="col-sm-6">
                  <label>Periodo</label>
                  <select id="agendaPeriodo" class="form-control select2" style="width: 100%;">
                      <option value=""></option>
                      <option value='am'>Manhã</option>
                      <option value='pm'>Tarde</option>
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