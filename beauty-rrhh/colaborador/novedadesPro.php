<?php 

    include("../head.php");

    VerificarPrivilegio("NOVEDADES (COLABORADOR)", $_SESSION['tipo_u'], $conn);
    include "../librerias_js.php";
    $today = date("Y-m-d"); 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<div class="normalheader transition animated fadeIn">
    <div class="hpanel">
      <div class="panel-body">
        <a class="small-header-action" href="">
          <div class="clip-header">
            <i class="fa fa-arrow-up"></i>
          </div>
        </a>

        <div id="hbreadcrumb" class="pull-right m-t-lg">
          <ol class="hbreadcrumb breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li class="active"><span>Novedades</span></li>
          </ol>
        </div>

        <div class="col-md-9">
          <div class="row">
            <div class="col-lg-12">
              <h3>Novedades</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="hpanel">
          <ul class="nav nav-tabs">
            <li class="active grp"><a data-toggle="tab" href="#tab-1"> GRUPAL</a></li>
            <li class="individual"><a data-toggle="tab" href="#novIndividual"> INDIVIDUAL</a></li>
            <li class="buscar"><a data-toggle="tab" href="#tab-2">BUSCAR</a></li>
            <li class="verNovedadCol" style="display:none"><a data-toggle="tab" href="#tab-3">NOVEDADES COLABORADOR</a></li>
            <li class="panelDet" style="display:none"><a data-toggle="tab" href="#VerNovedad" >VER DETALLES</a></li>
            <li class="panelEdit" style="display:none"><a data-toggle="tab" href="#EditarNov" >MODIFICAR</a></li>
          </ul>
        <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
          <div class="panel-body">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-edit"></i>  GESTIONAR NOVEDAD GRUPAL </h3>
              </div>
              <div class="panel-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <select name="" id="selectSalon" class="form-control">
                      <option value="0" selected>SELECCIONE SALÓN</option>                                    
                          <?php 
                              $QuerySln = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

                              while ($row = mysqli_fetch_array($QuerySln)) 
                              {
                              echo '<option value="'.$row['slncodigo'].'">'.utf8_encode($row['slnnombre']).'</option>';
                              }
                          ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">                  
                  <div class="form-group">
                    <select name="" id="selectTipo" class="form-control">
                      <option value="0" selected>SELECCIONE TIPO DE NOVEDAD</option>                                    
                          <?php 
                              $QuerySln = mysqli_query($conn, "SELECT a.tnvcodigo, a.tnvnombre FROM btytipo_novedad_programacion a WHERE a.aptestado = 1 ORDER BY a.tnvnombre");

                              while ($row = mysqli_fetch_array($QuerySln)) 
                              {
                              echo '<option value="'.$row['tnvcodigo'].'">'.utf8_encode($row['tnvnombre']).'</option>';
                              }
                          ?>
                    </select>
                  </div>    
                </div>

                <div class="col-sm-12">
                  <label for="">Fecha</label>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="input-group date">
                            <input type="text" class="form-control" id="fecha_de" placeholder="<?php echo $today ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group date2">
                            <input type="text" class="form-control" id="fecha_hasta" placeholder="<?php echo $today ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <div class="checkbox checkbox-success checkbox-inline">
                            <input type="checkbox" id="allday" value="option1">
                              <label for="inlineCheckbox2"> Día completo </label>
                          </div>
                        </div>
                      </div>                                    
                    </div>                               
                </div> 

                <div class="col-sm-6">
                  <label for="">De</label>
                    <div class="row">                                    
                       <div class="col-md-12">
                          <div class="input-group clockpicker" data-autoclose="true">
                              <input type="text" class="form-control" value="00:00" id="hora_de">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                          </div>
                      </div>                                    
                    </div>                               
                </div>

                <div class="col-sm-6">
                  <label for="">Hasta</label>
                    <div class="row">                                    
                       <div class="col-md-12">
                           <div class="input-group clockpicker" data-autoclose="true">
                              <input type="text" class="form-control" value="00:00" id="hora_hasta">
                                <span class="input-group-addon">
                                  <span class="fa fa-clock-o"></span>
                                </span>
                          </div>
                        </div>                                    
                    </div>                               
                </div>

                <div class="col-sm-12">
                    <label for="">Observaciones</label>
                      <div class="row">                                    
                        <div class="col-md-12">
                            <textarea name="" id="observaciones" class="form-control" rows="3" placeholder="Obervaciones" style="resize: none"></textarea>
                        </div>                                    
                      </div>                               
                </div>
            </div>
          </div>

            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-users"></i>  Colaboradores  <i class="fa fa-search pull-right" type="button" id="btnSearch" style="cursor: pointer;" title="Buscar colaboradores"></i></h3>
              </div>
              <div class="panel-body">
                  <div class="">
                  <table class="table table-bordered table-hover" id="tblColabAdd">
                    <thead>
                        <tr class="active">
                          <th>Código</th>
                          <th>Nombre</th>
                          <th>Cargo</th>
                          <th><center><button class="btn btn-xs btn-primary" id="btnRemoveAll" title="REMOVER TODOS LOS COLABORADORES"><i class="fa fa-minus"></i></button></center></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                  </div>
                  <div class="col-md-12">
                             <div class="form-group"> 
                              <br>
                                <button type="button" id="btnAddNov" class="btn btn-info pull-right" title="Guardar Novedad"><i class="pe-7s-diskette"></i></button>
                              </div>
                  </div>
              </div>
            </div> 

          </div>
        </div>
          <div id="tab-2" class="tab-pane ">
              <div class="panel-body">
                   <div class="panel panel-info">
                     <div class="panel-heading">
                       <h3 class="panel-title"><i class="fa fa-search"></i> BUSCAR NOVEDAD </h3>
                     </div>
                     <div class="panel-body">
                        <form action="" method="POST" role="form">

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">SALÓN</label>
                              <select name="" id="selectSalonBus" class="form-control">
                                <option value="0" selected>SELECCIONE SALÓN</option>                                    
                                    <?php 
                                        $QuerySln = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

                                        while ($row = mysqli_fetch_array($QuerySln)) 
                                        {
                                        echo '<option value="'.$row['slncodigo'].'">'.utf8_encode($row['slnnombre']).'</option>';
                                        }
                                    ?>
                              </select>
                            </div>                             
                          </div>

                           <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">FECHA</label>
                                  <input type="text" class="form-control" id="fecha" placeholder="<?php echo $today ?>">
                              </div>                             
                          </div>

                          <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">FECHA HASTA</label>
                                  <input type="text" class="form-control" id="fechaHasta" placeholder="<?php echo $today ?>">
                              </div>                             
                          </div>

                           <!-- <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">CONSECUTIVO</label>
                                    <select name="" id="input" class="form-control" required="required">
                                    <option value=""></option>
                                  </select>
                              </div>                             
                                                     </div> -->
                        
                        </form>
                        <div class="col-md-12">
                            <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tblBusqueda">
                              <thead>
                                <tr>
                                  <th>NOVEDAD N°</th>
                                  <th>TIPO </th>
                                  <th>FECHA REGISTRO</th>
                                  <th>FECHA DESDE</th>
                                  <th>FECHA HASTA</th>
                                  <th>DESDE / HASTA</th>
                                  <th>OBSERVACIONES</th>
                                  <th>SALÓN</th>
                                  <th>REGISTRADO POR</th>
                                  <th>ACCIONES</th>
                                </tr>
                              </thead>
                              <tbody>
                                
                              </tbody>
                            </table>
                            </div>
                        </div>
                     </div>
                   </div>
              </div>
          </div>
          <div id="VerNovedad" class="tab-pane">
            <div class="panel-body">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-search"></i> <!-- <label for="" id="lblnovedad"></label><a href="javascript:void(0)" id="btnReportePdf" title="GENERAR REPORTE PDF" class="text-muted pull-right"><i class="fa fa-file-pdf-o fa-2x"></i></a> --></h3>
                </div>
                <div class="panel-body">
                 <input type="hidden" id="idNovedad">
                    <form action="" method="POST" role="form">
                     <div class="col-md-6">                    
                        <div class="form-group">
                          <label for="" id="lblnovedad">FECHA DESDE</label>
                          <input type="text" class="form-control" value="" id="txtFecha" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">                    
                        <div class="form-group">
                          <label for="" id="lblnovedad">FECHA HASTA</label>
                          <input type="text" class="form-control" value="" id="txtFechaHasta" disabled>
                        </div>
                    </div> 
                    <div class="col-md-6">                    
                        <div class="form-group">
                          <label for="" id="lblnovedad">TIPO NOVEDAD</label>
                          <input type="text" class="form-control" value="" id="txtTipoNovedad" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">                    
                        <div class="form-group">
                          <label for="">DESDE / HASTA</label>
                         <input type="text" class="form-control" value="" id="txtRango" disabled>
                        </div>
                    </div> 
                    <div class="col-md-6">                    
                        <div class="form-group">
                          <label for="">OBSERVACIONES</label>
                          <textarea name="" id="txtObser" class="form-control" rows="3" disabled style="resize: none"></textarea>
                        </div>
                    </div> 
                    <div class="col-md-6">                    
                        <div class="form-group">
                          <label for="" id="lblnovedad">SALÓN</label>
                          <input type="text" class="form-control" value="" id="txtSalon" disabled>
                        </div>
                    </div> 
                    <div class="col-md-6">                    
                        <div class="form-group">
                          <label for="">REGISTRADO</label>
                         <input type="text" class="form-control" value="" id="txtUsuario" disabled>
                        </div>
                    </div>                                      
                    </form> 
                      <legend>COLABORADORES</legend>                     
                      <table class="table table-bordered table-hover" id="tblDetallesNov">
                        <thead>
                          <tr class="info">
                            <th>COLABORADOR</th>
                            <th>CARGO</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                </div>
              </div>
              
            </div>
          </div>


          <div id="novIndividual" class="tab-pane">
            <div class="panel-body">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-edit"></i> GESTIONAR NOVEDAD INDIVIDUAL</h3>
                </div>
                  <div class="panel-body">            
                       <form action="" method="POST" role="form">                       
                           <div class="col-md-4">
                                <label for="">Colaborador</label>
                              <div class="form-group">
                                    <select required name="selectCliente" id="selectClienteCitas" class="selectpicker" data-live-search="true" title='Selecciona Colaborador' data-size="10">
                                          <option value="0" selected>Seleccione Colaborador</option>  
                                    </select>
                              </div>
                           </div>

                           <div class="col-md-4">
                                <label for="">Rango Inicial</label>
                              <div class="form-group">
                                    <input type="text" name="" id="txtFechaIni" placeholder="0000-00-00" class="form-control">
                              </div>
                           </div>

                           <div class="col-md-4">
                                <label for="">Rango Final</label>
                              <div class="form-group">
                                    <input type="text" name="" id="txtFechaFin" placeholder="0000-00-00" class="form-control">
                              </div>
                           </div>
                           <div class="col-md-12">
                                <div class="table-responsive">
                               <table class="table table-bordered table-hover" id="tblProgCol" style="display: none">
                                 <thead>
                                   <tr>
                                     <th>FECHA</th>
                                     <th>TURNO</th>
                                     <th>TIPO PROGRAMACIÓN</th>
                                      <th>SALÓN</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                      
                                 </tbody>
                               </table>
                               </div>
                           </div>
                       </form>
                        <hr>
                       <form action="" method="POST" role="form"> 
                            
                            <div class="row">


                            <div class="col-md-3">
                               <div class="form-group">
                                   <label for="">Fecha Inicio</label>
                                   <input type="text" class="form-control" id="fechaI" placeholder="0000-00-00">
                               </div>                                
                            </div>                      

                           <div class="col-md-3">
                               <div class="form-group">
                                   <label for="">Fecha Fin</label>
                                   <input type="text" class="form-control" id="fechaF" placeholder="0000-00-00">
                               </div>                                
                            </div>

                            <div class="col-md-3">
                               <div class="form-group">
                                   <label for="">Todo el Día</label>
                                   <div class="checkbox">
                                       <label>
                                           <input type="checkbox" value="" id="btnCheck">
                                           Todo el día
                                       </label>
                                   </div>
                               </div>                                
                            </div>

                            <div class="col-md-3">
                               <div class="form-group">
                                   <label for="">Tipo</label>
                                   <select name="" id="selectTipoNovedad" class="form-control">
                                      <option value="0" selected>SELECCIONE TIPO DE NOVEDAD</option>                                    
                                          <?php 
                                              $QuerySln = mysqli_query($conn, "SELECT a.tnvcodigo, a.tnvnombre FROM btytipo_novedad_programacion a WHERE a.aptestado = 1 ORDER BY a.tnvnombre");

                                              while ($row = mysqli_fetch_array($QuerySln)) 
                                              {
                                              echo '<option value="'.$row['tnvcodigo'].'">'.utf8_encode($row['tnvnombre']).'</option>';
                                              }
                                          ?>
                                    </select>
                               </div>                                
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-3">
                                <label for="">De</label>
                                  <div class="row">                                    
                                     <div class="col-md-12">
                                         <div class="input-group clockpickerHD" data-autoclose="true">
                                            <input type="text" class="form-control" placeholder="00:00" id="horaDesde">
                                              <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                              </span>
                                        </div>
                                      </div>                                    
                                  </div>                               
                              </div>

                              <div class="col-md-3">
                                <label for="">Hasta</label>
                                  <div class="row">                                    
                                     <div class="col-md-12">
                                         <div class="input-group clockpickerHA" data-autoclose="true">
                                            <input type="text" class="form-control" placeholder="00:00" id="horaHasta">
                                              <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                              </span>
                                        </div>
                                      </div>                                    
                                  </div>                               
                              </div>

                              <div class="col-md-3">
                                <label for="">Salón</label>
                                  <div class="row">                                    
                                     <div class="col-md-12">
                                         <div class="input-group clockpickerHA" data-autoclose="true">
                                            <select name="" id="selectSalonNov" class="form-control">
                                <option value="0" selected>SELECCIONE SALÓN</option>                                    
                                    <?php 
                                        $QuerySln = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

                                        while ($row = mysqli_fetch_array($QuerySln)) 
                                        {
                                        echo '<option value="'.$row['slncodigo'].'">'.utf8_encode($row['slnnombre']).'</option>';
                                        }
                                    ?>
                              </select>
                                        </div>
                                      </div>                                    
                                  </div>                               
                              </div>  

                              <div class="col-md-3">
                                <label for="">Observaciones</label>
                                <textarea name="" id="observacionNov" class="form-control" rows="3" style="resize: none"></textarea>                              
                              </div>

                              <!-- <div class="col-md-3">
                                <label for="">Ingresar Novedad</label>
                                  <button type="button" class="btn btn-info pull-right btn-block" data-toggle="tooltip" data-placement="top" title="Ingresar Novedad" id="btnGuardarNov"><i class="fa fa-save"></i></button>                              
                              </div> -->
                            </div>
                            <div class="col-md-3">
                                <label for="">Ingresar Novedad</label>
                                  <button type="button" class="btn btn-info pull-right btn-block" data-toggle="tooltip" data-placement="top" title="Ingresar Novedad" id="btnGuardarNov"><i class="fa fa-save"></i></button>                              
                              </div>

                       </form>
                    
                 </div>
              </div>
              </div>
          </div>
          <div id="tab-2" class="tab-pane">
              <div class="panel-body">
                   <div class="panel panel-info">
                     <div class="panel-heading">
                       <h3 class="panel-title"><i class="fa fa-search"></i> BUSCAR NOVEDAD </h3>
                     </div>
                     <div class="panel-body">
                        <form action="" method="POST" role="form">

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">SALÓN</label>
                              <select name="" id="selectSalonBus" class="form-control">
                                <option value="0" selected>SELECCIONE SALÓN</option>                                    
                                    <?php 
                                        $QuerySln = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

                                        while ($row = mysqli_fetch_array($QuerySln)) 
                                        {
                                        echo '<option value="'.$row['slncodigo'].'">'.utf8_encode($row['slnnombre']).'</option>';
                                        }
                                    ?>
                              </select>
                            </div>                             
                          </div>

                           <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">FECHA</label>
                                  <input type="text" class="form-control" id="fecha" placeholder="<?php echo $today ?>">
                              </div>                             
                          </div>

                          <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">FECHA HASTA</label>
                                  <input type="text" class="form-control" id="fechaHasta" placeholder="<?php echo $today ?>">
                              </div>                             
                          </div>

                           <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">CONSECUTIVO</label>
                                  <input type="text" class="form-control" id="fechaHasta" placeholder="<?php echo $today ?>">
                              </div>                             
                          </div>
                        
                        </form>
                        <div class="col-md-12">
                            <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tblBusqueda">
                              <thead>
                                <tr>
                                  <th>NOVEDAD N°</th>
                                  <th>TIPO </th>
                                  <th>FECHA REGISTRO</th>
                                  <th>DESDE / HASTA</th>
                                  <th>OBSERVACIONES</th>
                                  <th>SALÓN</th>
                                  <th>REGISTRADO POR</th>
                                  <th>FECHA NOVEDAD</th>
                                  <th>ACCIONES</th>
                                </tr>
                              </thead>
                              <tbody>
                                
                              </tbody>
                            </table>
                            </div>
                        </div>
                     </div>
                   </div>
              </div>
          </div>

          <div id="EditarNov" class="tab-pane">
            <div class="panel-body">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-edit"></i> <label for="" id="lblnovedadEdit"></label></h3>
                </div>
                  <div class="panel-body">            
                        <form action="" method="POST" role="form">
                          <div class="row">
                              <div class="col-md-3">                    
                                  <div class="form-group">
                                    <input type="hidden" id="txtidnovedad">
                                    <label for="" id="lblnovedad">TIPO NOVEDAD</label>
                                    <input type="hidden" id="oldtipo">
                                    <div class="input-group"><input type="text" class="form-control" id="txtTiponov" disabled> <span class="input-group-btn"> <button type="button" class="btn btn-primary" id="btnEdit">Editar
                                  </button> </span></div>
                                    <select name="" id="selTipo" class="form-control" style="display: none">
                                       <option value="0" selected>SELECCIONE TIPO DE NOVEDAD</option>                                    
                                   
                                   </select>
                                  </div>
                              </div>

                               <div class="col-md-3">                    
                                  <div class="form-group">
                                    <input type="hidden" id="oldfecha">
                                    <label for="" id="lblnovedad">FECHA DESDE</label>
                                    <input type="text" class="form-control" value="" id="txtFechaEdit">
                                  </div>
                              </div> 


                              <div class="col-md-3">                    
                                  <div class="form-group">
                                    <input type="hidden" id="oldfechahasta">
                                    <label for="" id="lblnovedad">FECHA HASTA</label>
                                    <input type="text" class="form-control" value="" id="txtFechaHastaEdit">
                                  </div>
                              </div>


                              <div class="col-md-3"> 
                              <label for="" id="lblnovedad">DESDE</label> 
                                   <input type="hidden" id="olddesde">                  
                                  <div class="input-group clockpicker" data-autoclose="true">
                                        <input type="text" class="form-control" value="00:00" id="hora_deEdit">
                                          <span class="input-group-addon">
                                              <span class="fa fa-clock-o"></span>
                                          </span>
                                    </div>
                              </div>
                          </div> <!-- row -->

                          <div class="row">
                             <div class="col-md-3">                    
                                 <label for="" id="lblnovedad">HASTA</label>
                                    <input type="hidden" id="oldhasta">                   
                                <div class="input-group clockpicker" data-autoclose="true">
                                      <input type="text" class="form-control" value="00:00" id="hora_hastaEdit">
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                  </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                       <label for="">Día completo</label><br>
                                      <input type="checkbox" id="alldayedit" value="option1">
                                      <label for="inlineCheckbox2"> Seleccione </label>
                                </div>
                            </div>


                            <div class="col-md-3">                    
                                <div class="form-group">
                                  <label for="">OBSERVACIONES</label>
                                  <textarea name="" id="txtObserEdit" class="form-control" rows="3" style="resize: none"></textarea>
                                </div>
                            </div> 

                            <div class="col-md-3">                    
                                <div class="form-group">
                                  <label for="" id="lblnovedad">SALÓN</label>
                                  <input type="hidden" id="txtcodsalon">
                                  <input type="text" class="form-control" id="txtSalonEdit" disabled> 
                                  <select name="" id="selSalonEdit" class="form-control" style="display: none">
                                  <option value="0" selected>SELECCIONE SALÓN</option>                                    
                                  <?php 
                                      $QuerySln = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

                                      while ($row = mysqli_fetch_array($QuerySln)) 
                                      {
                                      echo '<option value="'.$row['slncodigo'].'">'.utf8_encode($row['slnnombre']).'</option>';
                                      }
                                  ?>
                                </select>
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-md-6">                    
                                <div class="form-group">
                                  <label for="">REGISTRADO</label>
                                 <input type="text" class="form-control" value="" id="txtUsuarioEdit" disabled>
                                </div>
                            </div> 
                        </div>
                        
                        <div class="row">

                              <center><legend>COLABORADORES <button type="button" class="btn btn-primary" title="AÑADIR COLABORADORES" id="btnAddCola"><i class="fa fa-plus"></i></button></legend></center>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="tblEdit">
                                        <thead>
                                            <tr>
                                              <th>CODIGO</th>
                                              <th>COLABORADOR</th>
                                              <th>CARGO</th>
                                              <th><center><button class="btn btn-xs btn-primary" id="btnRemoveAllEdit" title="REMOVER TODOS LOS COLABORADORES"><i class="fa fa-minus"></i></button></center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-info pull-right" id="btdModificar" title="MODIFICAR NOVEDAD"><i class="pe-7s-diskette"></i></button>
                                    <button type="button" class="btn btn-success pull-right" id="btnCancelar" title="CANCELAR EDICIÓN" style="margin-right: 9px"><i class="pe-7s-back"></i></button>
                                </div> 
                            </div>
                        </div>
                        </form>
                   
                    

                  </div>
              </div>
              </div>
          </div>
      </div>
      </div>
      </div>   
      </div>
  </div>


<script src="js/novedadesPro.js"></script>



<!-- Modal Colaboradores -->
<div class="modal fade" id="modalColabordores"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Colaboradores</h4>
      </div>
      <div class="modal-body">
          <div class="table-responsive">
          <table class="table table-hover table-bordered" id="tblColab">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Cargo</th>
                <th><center><button class="btn btn-primary check btn-xs"><i class="fa fa-plus"></i></button></center></th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Colaboradores Editar -->
<div class="modal fade" id="modalColabordoresEdit"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Colaboradores</h4>
      </div>
      <div class="modal-body">
          <div class="table-responsive">
          <table class="table table-hover table-bordered" id="tblColabEdit">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Cargo</th>
                <th><center><button class="btn btn-primary check btn-xs"><i class="fa fa-plus"></i></button></center></th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalNovedades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="tituloNov"></h4>
      </div>
      <div class="modal-body">
           <table class="table table-bordered table-hover" id="tblNovedad">
             <thead>
               <tr>
                 <th>NOVEDAD</th>
                 <th>DESDE</th>
                 <th>HASTA</th>
               </tr>
             </thead>
             <tbody>
               <tr>
                 <td></td>
               </tr>
             </tbody>
           </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
  th,td{
    font-size: 1em!important;
    white-space: nowrap;
  }

  .btn-group, .bootstrap-select{
       width: 100%!important;
  }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
