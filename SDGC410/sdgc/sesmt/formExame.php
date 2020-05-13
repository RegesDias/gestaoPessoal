<div class="box box-primary">
        <div class="col-md-12">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue espaco-direita">
              <div class="widget-user-image">
                <img class="img-circle" src="dist/img/user7-128x128.jpg" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username pull-right">000001</h3>
              <h3 class="widget-user-username">Nadia Carmichael</h3>
              <h5 class="widget-user-desc">Data Nascimento: 00/00/0000</h5>
              <h5 class="widget-user-desc">Grau de instrução: SUPERIOR</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                  <?php
                  $array = array(1,2);
                    for ($index = 0; $index < count($array); $index++) { ?>
                        <li><a href="#">Cargo:<?=$index?><span class="pull-right badge bg-blue">00000<?=$index?></span></a></li>
                        <li><a href="#">Carga Horaria<?=$index?><span class="pull-right badge bg-blue">31</span></a></li>
                        <li><a href="#">Secretaria<?=$index?><span class="pull-right badge bg-aqua">secretaria lugar trabalho</span></a></li>
                        <li><a href="#">Data Admissão<?=$index?><span class="pull-right badge bg-aqua">00/00/0000</span></a></li>
                    <?php }?>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
    <div class="box-header with-border">
        <h3 class="box-title">Exame Médico Pericial</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <div class="col-md-4">
                <label>Data do Exame</label>
                <input name="dataExame" placeholder="Data do Exame" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date">
            </div>
            <div class="col-md-4">
                <label>Número da Portaria</label>
                <input name="numeroPortaria" class="form-control" placeholder="Número da Portaria">
            </div>
            <div class="col-md-4">
                <label>Data da Portaria</label>
                <input nome="dataPortaria" placeholder="Data da Portaria" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 espaco-direita" >
                <label>Referência (ofício, despacho, etc)</label>
                <select name="referencia" class="form-control select2">
                    <option value="" disabled selected >Referência (ofício, despacho, etc)</option>
                    <option value="hurr">Durr</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 espaco-direita" >
                <label>Sintomas</label>
                <select name="sitomas" class="form-control select2">
                    <option value="" disabled selected>Sintomas</option>
                    <option value="hurr">Durr</option>
                </select>
            </div>
        </div>
        <script>
            $(document).on("keydown", "#obsHist", function () {
                var caracteresRestantes = 500;
                var caracteresDigitados = parseInt($(this).val().length);
                var caracteresRestantes = caracteresRestantes - caracteresDigitados;
                $(".caracteres").text(caracteresRestantes);
            });
        </script>
        <div class="form-group col-sm-12">
            <label>Histórico <i><sub class="caracteres">500</sub> <sub>Restantes </sub></i></label> 
            <textarea id="obsHist" name='ObsOco'class="form-control"  maxlength="500"rows="4"></textarea>
        </div>
        <div class="form-group">
            <div class="col-md-12 espaco-direita" >
                <label>HPP</label>
                <select name="sitomas" class="form-control select2">
                    <option value="" disabled selected>HPP</option>
                    <option value="hurr">Durr</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 espaco-direita" >
                <label>Exames</label>
                <select name="exames" class="form-control select2">
                    <option value="" disabled selected>Exames</option>
                    <option value="hurr">Durr</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 espaco-direita" >
                <label>Exames Físicos</label>
                <select name="examesFisicos" class="form-control select2">
                    <option value="" disabled selected>Exames Físicos</option>
                    <option value="hurr">Durr</option>
                </select>
            </div>
        </div>
        <script>
            $(document).on("keydown", "#obsCon", function () {
                var caracteresRestantes = 500;
                var caracteresDigitados = parseInt($(this).val().length);
                var caracteresRestantes = caracteresRestantes - caracteresDigitados;
                $(".caracteres").text(caracteresRestantes);
            });
        </script>
        <div class="form-group col-sm-12">
            <label>Considerações <i><sub class="caracteres">500</sub> <sub>Restantes </sub></i></label> 
            <textarea id="obsCon" name='ObsOco'class="form-control"  maxlength="500"rows="4"></textarea>
        </div>
        <script>
            $(document).on("keydown", "#obs", function () {
                var caracteresRestantes = 500;
                var caracteresDigitados = parseInt($(this).val().length);
                var caracteresRestantes = caracteresRestantes - caracteresDigitados;
                $(".caracteres").text(caracteresRestantes);
            });
        </script>
        <div class="form-group col-sm-12">
            <label>Observações <i><sub class="caracteres">500</sub> <sub>Restantes </sub></i></label> 
            <textarea id="obsCon" name='obs'class="form-control"  maxlength="500"rows="4"></textarea>
        </div>
        <div class="form-group">
            <div class="col-md-12 espaco-direita" >
                <label>É considerada Doença Grave segundo a Lei 8112 e suas alterações?</label>
                <select name="exames" class="form-control select2">
                    <option value="" disabled selected>Selecione a opção...</option>
                    <option value="hurr">Não</option>
                    <option value="hurr">Sim</option>
                </select>
            </div>
        </div>
        <div class="form-group espaco-direita">
            <div class="col-md-12 espaco-direita" >
                <div class="col-md-4" >
                    <label>Necessita Curador?</label>
                    <select name="exames" class="form-control ">
                        <option value="" disabled selected>Selecione a opção...</option>
                        <option value="hurr">Não</option>
                        <option value="hurr">Sim</option>
                    </select>
                </div>
                <div class="col-md-4" >
                    <label>CID principal</label>
                    <select name="exames" class="form-control ">
                        <option value="" disabled selected>Selecione a opção...</option>
                        <option value="hurr">1</option>
                        <option value="hurr">2</option>
                    </select>
                </div>
                <div class="col-md-4" >
                    <label>CID Secundário</label>
                    <select name="exames" class="form-control ">
                        <option value="" disabled selected>Selecione a opção...</option>
                        <option value="hurr">1</option>
                        <option value="hurr">2</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 espaco-direita" >
                <label>Tipo de doença</label>
                <select name="exames" class="form-control select2">
                    <option value="" disabled selected>Selecione a opção...</option>
                    <option value="hurr">Psíquicas</option>
                    <option value="hurr">sdsdsdsd</option>
                </select>
            </div>
        </div>

    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="pull-right">
           <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
        </div>
        <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Descartar</button>
    </div>
</div>