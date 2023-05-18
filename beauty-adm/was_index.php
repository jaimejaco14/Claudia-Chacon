<div class="content animated-panel">
        <!-- Modal colaboradores -->
    <div class="modal fade" tabindex="-1" role="dialog" id="my_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Colaboradores en el turno</h4>
      </div>
        
      <div class="modal-body">
      <div id="lista"></div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success">Guardar</button>
       
      </div>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>  
            </a>
            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb"> 
                    
                    <li class="active">filtros:</li>
                    <li>
                       <a id="by_clb"> <span>Colaborador</span></a>
                    </li>
                    <li class="active">
                       <a id="by_sln"> <span>Salon</span></a>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">

                            <div class="input-group">
                            <input type="hidden" value="salon" id="p">
                            <div id="sln"><select class="form-control" type="text" id="salon" name="salon"> 
                                <?php
                                    $sql = "SELECT `slncodigo`, `slnnombre`, `slnalias` FROM `btysalon` WHERE slnestado = 1";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0){
                                        $sw = 0;
                                        while ($row=$result->fetch_assoc()) {
                                            # code...
                                            if ($sw == 0) {
                                                $sln = $row['slncodigo'];
                                                $sw = 1;
                                            }
                                            echo "<option value='".$row['slncodigo']."'>".$row['slnnombre']."</option>";
                                        }
                                    }
                                ?>
                                </select></div><!--SALON-->
                                      <div id="clb" hidden="true"><select class="form-control" type="text" id="cola" name="clb"> 
                                <?php
                                    $sql = "SELECT c.`clbcodigo`, t.trcrazonsocial FROM `btycolaborador` c inner join btytercero t on t.trcdocumento = c.trcdocumento WHERE clbestado = 1";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0){
                                        $sw = 0;
                                        while ($row=$result->fetch_assoc()) {
                                            # code...
                                            if ($sw == 0) {
                                                $sln = $row['slncodigo'];
                                                $sw = 1;
                                            }
                                            echo "<option value='".$row['clbcodigo']."'>".$row['trcrazonsocial']."</option>";
                                        }
                                    }
                                ?>
                                </select></div><!--COLABORADOR-->

                                
                                <div class="input-group-btn">
                                    
                                      <a><button id="btn" class="btn btn-default" title="Nuevo horario"><i class="fa fa-plus-square-o text-info"></i></button></a>
                                 
                                </div>
                                <div class="input-group">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="hpanel">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                Calendar
            </div>
            <div class="panel-body">
                <div id="calendar"></div>
            </div>
        </div>

    </div>