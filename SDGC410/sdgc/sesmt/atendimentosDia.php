          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Atendimentos do dia</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                <div class="pull-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  
                      <?php 
                      $array = array(1,2,3,4,5,6,7,8);
                     for ($index = 0; $index < count($array); $index++) {
                          ?>
                            <tr>
                                <td class="mailbox-star">
                                   <a>
                                        <form action="index.php" method="<?= $method ?>" class="inline">
                                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                                            <input type="hidden" name="file" value="formExame"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <input type="hidden" name="acao" value="destino6"/>
                                            <button type="submit" class="link-button-limpo">
                                               <i class="fa fa-history"></i>
                                            </button>
                                        </form>
                                    </a>
                                </td>
                                <td class="mailbox-name">
                                    <a>
                                        <form action="index.php" method="<?= $method ?>" class="inline">
                                            <input type="hidden" name="pst" value="<?=$pst?>"/>
                                            <input type="hidden" name="arq" value="<?=$arq?>"/>
                                            <input type="hidden" name="file" value="formExame"/>
                                            <input type="hidden" name="pg" value="1"/>
                                            <input type="hidden" name="acao" value="destino6"/>
                                            <button type="submit" class="link-button-limpo">
                                                Nadia Carmichael
                                            </button>
                                        </form>
                                    </a>
                                </td>
                                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                </td>
                                <td class="mailbox-attachment"></td>
                                <td class="mailbox-date">5 mins ago</td>
                            </tr>
                      <?php }?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                <div class="pull-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
            </div>
          </div>