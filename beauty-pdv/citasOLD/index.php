<?php 
    session_start();
    if(!isset($_SESSION['PDVslncodigo'])){
        header('location:../index.php');
        exit;
    }
    include '../../cnx_data.php';
    $sln = mysqli_query($conn, "SELECT slnnombre FROM btysalon WHERE slncodigo = '".$_SESSION['PDVslncodigo']."' AND slnestado = 1 ");
    $rowSln = mysqli_fetch_array($sln);
    //$codcol_arr=array();
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beauty | ERP Invelcon SAS</title>
    <link rel="shortcut icon" type="image/ico" href="../../contenidos/imagenes/favicon.png" />
    <link rel="stylesheet" href="../../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../../lib/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../../lib/vendor/sweetalert/lib/sweet-alert.css" />
    <link rel="stylesheet" href="../../lib/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="../js/selectpicker.css">
    <link rel="stylesheet" href="mailtip.css">
    <script src="../../lib/vendor/jquery/dist/jquery.min.js"></script>
    <script src="../../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="../../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>
    <script src="../../lib/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../js/selectpicker.js"></script>
    <script src="../../lib/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../lib/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <style type="text/css" media="screen">
        .alm{
            background-color: yellow; 
        }
        .notrn{
            background-color: gray;
        }
        .agendada{
            background-color: #1981f2;
            color:white;
            cursor:pointer;
        }
        .atendida{
            background-color: #4cd13a;color:white;cursor:pointer; 
        }
        .inasistencia{
            background-color: purple; color:white;cursor:pointer; 
        }
        .free{
        	cursor:pointer;
        }
    </style>
</head>
<div class="container-fluid">
    <input type="hidden" id="slncod" value="<?php echo $_SESSION['PDVslncodigo'];?>">
    <input type="hidden" id="usucod" value="<?php echo $_SESSION['PDVcodigoUsuario'];?>">
    <input type="hidden" id="slnhdesde">
    <input type="hidden" id="slnhhasta">
    <div class="row">
        <div class="col-md-3">
            <h3>GESTIÓN DE CITAS SALÓN <?php echo $rowSln[0]; ?> <br>
                <a type="button" href="../inicio.php" class="btn btn-info text-info btn-rounded" data-toggle="tooltip" data-placement="top" title="Volver a inicio"><i class="fa fa-arrow-circle-o-left"></i></a> 
                <button type="button" class="btn btn-warning text-info btn-rounded" id="regClienteNew" data-toggle="tooltip" data-placement="top" title="Nuevo Cliente"><i class="fa fa-users"></i></button>
                <button id="btn-pnp" class="btn btn-primary hidden" data-toggle="tooltip" data-placement="bottom" title="Habilitar Colaboradores que no laboran este dia"><i class="fa fa-users"></i></button>
            </h3>
            <input  id="fechaAgenda" class="form-control " style="width: 100%" autocomplete="off">
            <br>
        </div>
        <div class="col-md-9">
            <br>
            <div class="well">
                * Gracias por llamar a Claudia Chacón, ¿en qué podemos servirle?<br>
                * ¿A nombre de quién registro la reserva?<br>
                * ¿Me indica la fecha y hora de su cita?<br>
                * ¿Me espera un momento por favor mientras busco la disponibilidad de la cita?<br>
                * Señor(a), se le ha asignado una cita para los servicios de XXXX con el XXXX (estilista, manicurista,esteticista) a las XXXX horas del día XXXX, me confirma si está de acuerdo?<br>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" id="tablaLista">
                <table class="table table-hover table-bordered" id="tblListado">
                    <thead>
                        <tr id="trcrg"></tr>
                        <tr id="trcol"></tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr id="trcol2"></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!--=========================================
=            MODAL NUEVO CLIENTE            =
==========================================-->

<div class="modal fade" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> Nuevo Cliente</h4>
            </div>
            <div class="modal-body">                           
                                       

                    <input type="hidden" id="txtSexo">
                    <input type="hidden" id="txtFechaN">
                    <input type="hidden" id="txtTipoS">
                                            
                                            <div class="row">
                                                <div class="col-md-10" id="btnBarcode">
                                                    <span  data-toggle="tooltip" style="cursor: pointer" data-placement="top" title="Click para leer código de barra"><i class="fa fa-barcode fa fa-3x" ></i></span>
                                                    <div id="spin" style="display: none">
                                                        <i class="fa fa-spinner fa-spin fa 2x text-info" ></i> <span class="text-info"><b>Esperando por lectura de documento</b></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" id="dataCapture" class="form-control" style="border: none!important; border-color: transparent!important; color: transparent!important">
                                                </div>
                                            </div>
                                            
                                            <div class="row">                                                   
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">                                                            
                                                        <label for="">TIPO DOCUMENTO</label>
                                                        <br>
                                                            <select class="form-control" id="tipodoc"  style="width: 100%!important">
                                                                <?php 
                                                                $sql = mysqli_query($conn, "SELECT tdicodigo, tdialias FROM btytipodocumento WHERE tdiestado = 1 ORDER BY tdialias");

                                                                while ($row = mysqli_fetch_array($sql)) 
                                                                {
                                                                if ($row[1] == "CC") 
                                                                {
                                                                echo '<option value="'.$row[0].'" selected data-toggle="tooltip" data-placement="top" title="Cedula">'.$row[1].'</option>';                 
                                                                }
                                                                else
                                                                {
                                                                echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                                                                }

                                                                }
                                                                ?>
                                                            </select>
                                                            <input type="text" name="" id="docReadonly" class="form-control" value="" style="display: none">
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">DOCUMENTO</label>                                                               
                                                            <input type="text" id="nroDoc" placeholder="Digite documento" class="form-control">                                             
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">NOMBRES</label>
                                                            <input type="text" class="form-control" id="nombres" placeholder="Digite nombres">
                                                    </div>
                                                </div>

                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">APELLIDOS</label>
                                                            <input type="text" class="form-control" id="apellidos" placeholder="Digite apellidos">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">MES CUMPLEAÑOS</label>
                                                        <select name="" id="mes" class="form-control">
                                                            <option value="0" selected>SELECCIONE MES</option>
                                                            <option value="01">ENERO</option>
                                                            <option value="02">FEBRERO</option>
                                                            <option value="03">MARZO</option>
                                                            <option value="04">ABRIL</option>
                                                            <option value="05">MAYO</option>
                                                            <option value="06">JUNIO</option>
                                                            <option value="07">JULIO</option>
                                                            <option value="08">AGOSTO</option>
                                                            <option value="09">SEPTIEMBRE</option>
                                                            <option value="10">OCTUBRE</option>
                                                            <option value="11">NOVIEMBRE</option>
                                                            <option value="12">DICIEMBRE</option>
                                                        </select>

                                                        <input type="text" name="" id="mesReadonly" class="form-control" value="" style="display: none">
                                                    </div>                                                        
                                                </div> 

                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">DÍA CUMPLEAÑOS</label>
                                                        <select name="" id="dia" class="form-control">
                                                            <option value="0">SELECCIONE DÍA</option>
                                                            <?php 
                                                            for ($i=01; $i <= 31; $i++) { 
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                            }
                                                            ?>
                                                            </select>
                                                            <input type="text" name="" id="diaReadonly" class="form-control" value="" style="display: none">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label for="">E-MAIL</label>
                                                            <input type="email" class="form-control" id="email" placeholder="Digite el e-mail">
                                                                <p class="help-block text-danger" id="txtAlertEmail" style="display:none"><b>Digite el e-mail</b></p>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6 col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label for="">MÓVIL</label>
                                                            <div class="input-group"><input type="number" maxlength="10" id="movil" onblur="validar(this)" placeholder="Digite número móvil" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
                                                                <p class="help-block text-danger" id="txtAlertMovil" style="display:none"><b>Digite el número del móvil</b></p></div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6 col-sm-6 col-md-4">
                                                    <label for="">FIJO</label>
                                                        <div class="input-group"><input type="number" maxlength="7" id="fijo" placeholder="Digite número fijo" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" /> <p class="help-block text-danger" id="txtAlertFijo" style="display:none"><b>Digite el número fijo</b></p></span></div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">NOTIFICACIONES AL MOVIL</label>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" value="" id="nm" checked>
                                                                </label>
                                                            </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">NOTIFICACIONES AL E-MAIL</label>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" value="" id="ne" checked>
                                                                </label>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div> 

                                      

                                        <div class="text-right m-t-xs">
                                            <br>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                                <a class="btn btn-primary next btnNext2" type="button" href="javascript:void(0)"><i class="fa fa-save"></i> Registrar</a>
                                        </div>
               
            </div>
        </div>
    </div>
</div>

<!--====  End of MODAL NUEVO CLIENTE  ====-->
<!-- Modal -->
<div class="modal fade" id="modalAgendas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-search"></i> Información de la cita</h4>
      </div>
      <div class="modal-body">
            <input type="hidden" id="edtcodigocita"> 
            <input type="hidden" id="txtclicod">
            <input type="hidden" id="tdesde2">
            <input type="hidden" id="thasta2">
            <input type="hidden" id="sercodigo">
            <div class="row">
                <h5 class="text-center"><b>Datos del Cliente</b></h5> 
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon fa fa-user"></span>
                        <input type="text" class="form-control" id="txtcliente" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon fa fa-phone"></span>
                        <input type="text" class="form-control" id="txtmovil" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon fa fa-envelope"></span>
                        <input type="text" class="form-control" id="txtemail" placeholder="" readonly>
                    </div>
                </div>
            </div> 
            <br>    
            <div class="row">
                <h5 class="text-center"><b>Datos de la Cita</b></h5>
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon"><b>Servicio</b></span>
                        <input type="text" class="form-control" id="txtservicio" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Colaborador</label>
                        <input type="text" class="form-control" id="txtnomcol" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Hora</label>
                        <input type="text" class="form-control" id="txthora" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Agendado por</label>
                        <input type="text" class="form-control" id="txtusuarioagenda" placeholder="" readonly>
                    </div>
                </div>

            </div>
        
        <center>
            <div id="center">
                <div class="btn-group btnoptions" role="group" aria-label="...">
                <button type="button" class="btn btn-default estado" data-estado="8" style="background-color: #4cd13a; color: white; border-color: #4cd13a">Asistida</button>
                <button type="button" class="btn btn-default estado" data-estado="3" style="background-color: red; color: white; border-color: red">Cancelada</button>
                <button type="button" class="btn btn-default estado" data-estado="9" style="background-color: purple; color: white; border-color: purple">Inasistencia</button>
                <button type="button" id="reprogramar" class="btn btn-primary estado reprogramar" data-toggle="modal" style=" color: white;">Editar Cita</button>
                </div>
                <!-- <div class="btn-group btnscedit" style="display:none;">
                    <button class="btn canceledt" style="background-color: red; color: white; border-color: red">Cancelar</button>
                    <button class="btn saveedt" style="background-color: #4cd13a; color: white; border-color: #4cd13a">Guardar cambios</button>
                </div> -->
            </div>
        </center>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAgendarCita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Agendar Cita </h4>

      </div>
      <div class="modal-body">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title" id="nombreCol"></h3>                
            </div>
            <div class="panel-body">
                <input type="hidden" id="codigoCol">
                <input type="hidden" id="slncodigo">
                <input type="hidden" id="agencodcol">
                
                <div class="col-md-12">
                    <div class="form-group" style="display:none;">
                            <label for="">Medio</label>
                            <select name="" id="selMedio" class="form-control" required="required">
                                <option value="1" selected="">PRESENCIAL</option>
                            </select>
                    </div>
                 </div>


                     <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Cliente</label>
                            <div class="">
                            <select id="cliente" class="form-control"></select>
                            </div>
                            <input type="text" name="" id="clienteCed" readonly class="form-control" value="" required="required" pattern="" title="" style="display: none">
                            <input type="hidden" name="" id="IdclienteCed">
                        </div>
                    </div>


                
                  <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Servicio</label>
                            <select id="selServicio"  class="form-control"  style="width: 100%!important;">
                                
                            </select>
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-group">
                            <label for="">Hora</label>
                            <input type="text" name="" id="horaAge" class="form-control" readonly="" value="" title="">
                        </div>
                 </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Observaciones</label>
                            <textarea id="observaciones" class="form-control" rows="3" style="resize: none;" placeholder="Opcional..."></textarea>
                        </div>
                    </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="btnNuevoCli" data-toggle="tooltip" data-placement="top" title="Nuevo Cliente" data-container="body"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarCita" data-toggle="tooltip" data-placement="top" title="Agendar Cita"><i class="fa fa-save"></i> Agendar</button>
      </div>
    </div>
  </div>
</div>

<!--Fin Modal -->

<!-- Modal -->
<div class="modal fade" id="modalAgendarCita2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Editar Cita </h4>

      </div>
      <div class="modal-body">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title" id="nombreCol2"></h3>                
            </div>
            <div class="panel-body">
                <input type="hidden" id="edtcitcodigo">
                <input type="hidden" id="agencodcol2">
                <input type="hidden" id="txtclicod2">
                
                
                <div class="col-md-12">
                    <div class="form-group" style="display:none;">
                            <label for="">Medio</label>
                            <select name="" id="selMedio" class="form-control" required="required">
                                <option value="1" selected="">PRESENCIAL</option>
                            </select>
                    </div>
                 </div>
                     <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Cliente</label>
                            <div class="">
                            <select id="cliente2" class="form-control"></select>
                            </div>
                            <input type="text" name="" id="clienteCed2" readonly class="form-control" value="" required="required" pattern="" title="" style="display: none">
                            <input type="hidden" name="" id="IdclienteCed2">
                        </div>
                    </div>
                  <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Servicio</label>
                            <select id="selServicio2"  class="form-control"  style="width: 100%!important;"></select>
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-group">
                            <label for="">Hora</label>
                            <select id="horaAge2" class="form-control"></select>
                        </div>
                 </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Observaciones</label>
                            <textarea id="observaciones2" class="form-control" rows="3" style="resize: none;" placeholder="Opcional"></textarea>
                        </div>
                    </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
        <button type="button" class="btn btn-primary" id="saveeditcita" data-toggle="tooltip" data-placement="top"<i class="fa fa-save"></i> Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<!--Fin Modal -->

<!-- Modal Reprogramar Cita -->
<div class="modal fade" id="modalAgendarCitaRepro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Modificar Cita</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title" id="nombreColEdit"></h3>
            </div>
            <div class="panel-body">
                <input type="hidden" id="codigoColEdit">
                <input type="hidden" id="citcodigo">
                
                  <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Servicio</label>
                            <select name="" id="selServicioEdit" class="form-control"  data-size="10" data-header="Selecciona" data-live-search="true" style="width: 100%!important;">
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group">
                            <label for="">Fecha</label>
                            <input type="text" id="fechaEdit" class="form-control" readonly>
                        </div>
                   </div>

                <div class="col-md-6">
                    <div class="form-group">
                            <label for="">Hora</label>
                            <select name="" id="horaAgeEdit" class="form-control" required="required">
                            </select>
                        </div>
                 </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Observaciones</label>
                            <textarea id="observacionesEdit" class="form-control" rows="3" style="resize: none;" placeholder="Opcional"></textarea>
                        </div>
                    </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarCitaRepro"><i class="fa fa-edit"></i> Modificar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Habilitar citas para tpr != labora  -->
<div class="modal fade" id="modal-PNP">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><i class="fa fa-users"></i> Colaboradores que no laboran el día <b id="pnpfecha"></b></h3>
            </div>
            <div class="modal-body">
                <table id="tbpnp" class="table table-hover table-bordered" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Colaborador</th>
                            <th>Cargo</th>
                            <th>Programación actual</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

</html>
<script src="citas.js"></script>
<script src="mailtip.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#fechaAgenda').datepicker({ 
            format: "yyyy-mm-dd",
            autoclose: true
        }); 
    });
    var utc = new Date().toJSON().slice(0,10).replace(/-/g,'-');
    var f = new Date();
    var fecha=(f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate());
    loadhorasalon(fecha);
    var user=$("#usucod").val();
    //$("#fechaAgenda").val(fecha)
    
    loadcrg(fecha);
    loadcol(fecha);
    loadgrid();
    function loadhorasalon(fecha){
        var slncod=$("#slncod").val();
        $.ajax({
            url:'proccess.php',
            type:'POST',
            data:'opc=loadhsalon&fecha='+fecha+'&slncod='+slncod,
            async:false,
            success:function(res){ 
                var json = JSON.parse(res);
                $("#slnhdesde").val(json.hdesde);
                $("#slnhhasta").val(json.hhasta);
                
            }
        })
    } 
    function loadcrg(fecha){
        var slncod=$("#slncod").val();
        $.ajax({
            url:'proccess.php',
            type:'POST',
            data:'opc=loadcrg&fecha='+fecha+'&slncod='+slncod,
            async:false,
            success:function(res){
                var json;
                json = JSON.parse(res);
                $("#trcrg").empty();
                $("#trcrg").append('<th colspan="1" class="active"></th>');
                for(var i in json){
                    $("#trcrg").append('<th colspan="'+json[i].crgcount+'" class="active text-center">'+json[i].crgnombre+'S ('+ json[i].crgcount +')</th>');
                }
            }
        })
    }
    function loadcol(fecha){
        var slncod=$("#slncod").val();
        $.ajax({
            url:'proccess.php',
            type:'POST',
            data:'opc=loadcol&fecha='+fecha+'&slncod='+slncod,async:false,
            success:function(res){
                var json = JSON.parse(res);
                //console.log(json.citas);
                $("#trcol").html('');
                $("#trcol2").empty();
                $("#trcol").append('<th colspan="1" class="active">HORA</th>');
                $("#trcol2").append('<th colspan="1" class="active">HORA</th>');
                for(var i in json.turnos){
                    var cita = (json.citas.filter(function (col) {return (col.codcol == json.turnos[i].codcol)}));
                    var icita=[];
                    var fcita=[];
                    var cicod=[];
                    var estct=[];
                    if(cita.length>0){
                        for(var j in cita){
                            icita.push(cita[j].cithora);
                            fcita.push(cita[j].cithasta);
                            cicod.push(cita[j].citcod);
                            estct.push(cita[j].citestado);
                        }
                    }
                    $("#trcol").append('<th class="active text-center datacol" data-codcol="'+json.turnos[i].codcol+'" data-crgnom="'+json.turnos[i].crgnom+'" data-tdesde="'+json.turnos[i].tdesde+'" data-thasta="'+json.turnos[i].thasta+'" data-ialm="'+json.turnos[i].ialm+'" data-falm="'+json.turnos[i].falm+'" data-icita="'+icita+'"  data-fcita="'+fcita+'" data-cicod="'+cicod+'" data-estct="'+estct+'">'+json.turnos[i].nomcol+'</th>');
                    $("#trcol2").append('<th class="active text-center">'+json.turnos[i].nomcol+'</th>');
                }

            }
        })
    }
    function loadgrid(){
        var hdesde=$("#slnhdesde").val().split(':');
        var hhasta=$("#slnhhasta").val().split(':');
        var desde = new Date();
        desde.setHours(hdesde[0]);
        desde.setMinutes(hdesde[1]);
        desde.setSeconds(0);
        var hasta = new Date();
        hasta.setHours(hhasta[0]);
        hasta.setMinutes(hhasta[1]);
        hasta.setSeconds(0);
        $("#tblListado tbody").empty(); 
        var i=0;
        var j=0;
        while(desde<hasta){
            if(desde.getMinutes()==0){
                var min='00';
            }else{
                var min=desde.getMinutes()
            }
            if(desde.getHours()<10){
                var hour='0'+desde.getHours();
            }else{
                var hour=desde.getHours();
            }
            var horas=hour+':'+min;
            $("#tblListado tbody").append('<tr class="tbtr'+i+'">');
            $(".tbtr"+i).append('<td>'+horas+'</td>');
            $("#trcol").find(".datacol").each(function(e){
                var codcol=$(this).data('codcol');
                var nomcol=$(this).html();
                var tdesde=$(this).data('tdesde');
                var thasta=$(this).data('thasta');
                var ialm=$(this).data('ialm');
                var falm=$(this).data('falm');
                var fondo;
                var logo;
                var cita='';
                var estado='';
                var ct=$(this).data('icita').split(',');
                var fc=$(this).data('fcita').split(',');
                var cc=$(this).data('cicod').toString().split(',');
                var ec=$(this).data('estct').toString().split(',');
                if(horas<tdesde){
                    fondo='notrn free text-center';
                    logo='fa fa-times';
                }else if(horas>thasta){
                    fondo='notrn free text-center';
                    logo='fa fa-times';
                }else if(horas==ialm){
                    fondo='alm free text-center';
                    logo='fa fa-cutlery';
                }else if((horas>=ialm)&&(horas<falm)){
                    fondo='alm free text-center';
                    logo='fa fa-cutlery';
                }else{
                    fondo='free';
                } 
                if((ct.length>0)){
                    for(var k=0;k<=ct.length;k++){
                        if(((horas>ct[k]) && (horas<fc[k])) || (ct[k]==horas)){
                            cita='data-cithora="'+ct[k]+'" data-codcita="'+cc[k]+'"';
                            estado='data-estcita="'+ec[k]+'"';
                            switch(ec[k]){
                                case '1':
                                case '2':
                                case '4':
                                case '5':
                                case '6':fondo='verCita agendada text-center';logo='fa fa-clock-o';
                                break;
                                case '8':fondo='verCita atendida text-center';logo='fa fa-check';
                                break;
                                case '9':fondo='verCita inasistencia text-center';logo='fa fa-thumbs-down';
                                break;
                            }
                        }
                    }
                }
                $(".tbtr"+i).append('<td class="'+fondo+'" data-hora="'+horas+'" data-col="'+codcol+'" data-tdesde="'+tdesde+'" data-thasta="'+thasta+'" data-ialm="'+ialm+'" data-falm="'+falm+'" data-nomcol="'+nomcol+'" '+cita+' '+estado+'><i class="'+logo+'" ></i></td>');
                j++;
            });
            $("#tblListado tbody").append('</tr>');
            desde.setMinutes(desde.getMinutes()+30);
            i++;
        }
        //console.log(j);
        if(j==0){
            loadgrid();
        }
  
    }
    function reset(){
        $('#btnGuardarCita').removeAttr('disabled');
        $("#cliente").val('default').selectpicker("refresh");
        loadgrid();
    }
    var  loadpnp  = function(fecha) { 
        var sln=$("#slncod").val();
        var listado = $('#tbpnp').DataTable({
          "ajax": {
          "method": "POST",
          "url": "proccess.php",
          "data": {opc: "loadpnp", fecha:fecha, sln:sln},
          },
          "columns":[
            {"data": "trcrazonsocial"},
            {"data": "crgnombre"},
            {"data": "tprnombre"},
            {"render": function (data, type, JsonResultRow, meta) { 
                  return "<button class='btn btn-primary swpnp' data-toggle='tooltip' title='Activar este colaborador para éste día' data-placement='right' data-codcol='"+JsonResultRow.clbcodigo+"' ><i class='fa fa-check'></i></button>"; 
                 } 
            },
          ],"language":{
            "lengthMenu": "",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrada de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search": "Buscar:",
            "zeroRecords":    "No se encontraron registros coincidentes",
            "paginate": {
              "next":       "Siguiente",
              "previous":   "Anterior"
            } 
            },  
             "columnDefs":[
                  {className:"text-center","targets":[2]},
                  {className:"text-center","targets":[3]},
             ],
             "order": [[0, "desc"]],
             "bDestroy": true,
             "pageLength": 10,


      });
    };
    $("#fechaAgenda").on('changeDate', function(e) {
        e.preventDefault();
        fecha=$(this).val();
        if(fecha>utc){
            $("#btn-pnp").removeClass('hidden');
            loadpnp(fecha);
        }else{
            $("#btn-pnp").addClass('hidden');
        }
        $("#tblListado tbody").empty();
        $("#trcol").empty();
        $("#trcrg").empty();
        loadhorasalon(fecha);
        loadcrg(fecha);
        loadcol(fecha);
        loadgrid();
    })
    $("#btn-pnp").click(function(e){
        var fecha = $("#fechaAgenda").val();
        $("#pnpfecha").html(fecha);
        $("#modal-PNP").modal('show');
    });
    $(document).on('click','.swpnp',function(e){
        var codcol=$(this).data('codcol');
        var fecha=$("#fechaAgenda").val();
        $(this).empty().html('<i class="fa fa-spin fa-spinner"></i>').attr('disabled','disabled');
        $.ajax({
            url:'proccess.php',
            type:'POST',
            data:{opc:'swpnp',codcol:codcol,fecha:fecha},
            success:function(res){
                if(res==1){
                    loadcrg(fecha);
                    loadcol(fecha);
                    loadgrid();
                    loadpnp(fecha);
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente. Si el problema persiste, comuníquese con el departamento de sistemas.','error')
                }
                $("#modal-PNP").modal('hide');
            }
        })
    });
</script>
<script type="text/javascript">
    $(document).on('click', '.verCita', function(){
        var citcodigo = $(this).data("codcita");
        var hora      = $(this).data("cithora");
        var col       = $(this).data("col");
        var nomcol    = $(this).data('nomcol');
        var tdesde    = $(this).data('tdesde');
        var thasta    = $(this).data('thasta');
        $("#tdesde2").val(tdesde);
        $("#thasta2").val(thasta);
        $.ajax({
            url: 'process.php',
            method: 'POST',
            data: {opcion: "verAgenda", citcodigo:citcodigo},
            success: function (data) 
            {
                var json = JSON.parse(data);

                for(var i in json.json)
                {
                    $('#txtcliente').val(json.json[i].cliente);
                    $('#txtclicod').val(json.json[i].clicod);
                    $('#txtservicio').val(json.json[i].servicio + " DURACIÓN: [ " + json.json[i].duracion + " ]");
                    $("#sercodigo").val(json.json[i].sercod);
                    $('#txtmovil').val(json.json[i].movil);
                    $('#txtemail').val(json.json[i].email);
                    $('#txtusuarioagenda').val(json.json[i].usuagenda);
                    if (json.estadoCita == 3) 
                    {
                        $('.estado').attr('disabled', true);
                    }
                    else if (json.estadoCita == 9) 
                    {
                        $('.estado').attr('disabled', true);
                    }
                    else if (json.estadoCita == 8) 
                    {
                        $('.estado').attr('disabled', true);
                    }
                    else if (json.estadoCita == 1) 
                    {
                        $('.estado').attr('disabled', false);
                    }
                    else if (json.estadoCita == 7) 
                    {
                        $('#reprogramar').attr('disabled', true);
                    }
                }
                $("#txtnomcol").val(nomcol);
                $("#txthora").val(hora);
                $("#edtcodigocita").val(citcodigo);
                $("#agencodcol2").val(col);
                $('#modalAgendas').modal("show");
            }
        });
        loadgrid();
    });
    //$(document).on('click', '#reprogramar', function(){
    $("#reprogramar").click(function(e){
        
        var hora        = $("#txthora").val();
        var codcol      = $("#agencodcol2").val();
        var citcodigo   = $("#edtcodigocita").val();
        var tdesde      = $("#tdesde2").val();
        var thasta      = $("#thasta2").val();
        var slncod      = $("#slncod").val();
        var clinom      = $('#txtcliente').val();
        var clicod      = $("#txtclicod").val();
        var sercodigo   = $("#sercodigo").val();

        $("#slncodigo").val(slncod);
        $("#edtcitcodigo").val('');
        $("#edtcitcodigo").val(citcodigo);
        var hdesde=tdesde.split(':');
        var hhasta=thasta.split(':');
        var desde = new Date();
        desde.setHours(hdesde[0]);
        desde.setMinutes(hdesde[1]);
        desde.setSeconds(0);
        var hasta = new Date();
        hasta.setHours(hhasta[0]);
        hasta.setMinutes(hhasta[1]);
        hasta.setSeconds(0);
        var opcs2='';
        $("#horaAge2").html('');
        $.ajax({
            url: 'proccess.php',
            method: 'POST',
            data:'opc=loadser&codcol='+codcol+'&slncod='+slncod,
            success: function (res) {
                var json = JSON.parse(res);
                var opcs = "";
                opcs += "<option value='0'>Seleccione Servicio...</option>";
                for(var i in json.ser){
                    if(json.ser[i].cod==sercodigo){
                        opcs += "<option value='"+json.ser[i].cod+"' data-dur='"+json.ser[i].dur+"' selected>"+json.ser[i].nom+" ["+json.ser[i].dur+" Minutos]</option>";
                    }else{
                        opcs += "<option value='"+json.ser[i].cod+"' data-dur='"+json.ser[i].dur+"'>"+json.ser[i].nom+" ["+json.ser[i].dur+" Minutos]</option>";
                    }
                    //opcs += "<option value='"+json.ser[i].cod+"' data-dur='"+json.ser[i].dur+"'>"+json.ser[i].nom+" ["+json.ser[i].dur+" Minutos]</option>";
                }
                $("#selServicio2").html('');
                $("#selServicio2").html(opcs);
                var cantopcs=$('#selServicio2').children('option').length;
                if(cantopcs>1){
                    $("#nombreCol2").html('<i class="fa fa-user"></i> <b>'+json.nomcol+'</b>');
                    //$("#agencodcol2").val(codcol);
                    $("#cliente2").html('');
                    $("#cliente2").html('<option value="'+clicod+'" selected>'+clinom+'</option>').selectpicker('refresh');;
                    while(desde<hasta){
                        if(desde.getMinutes()==0){
                            var min='00';
                        }else{
                            var min=desde.getMinutes()
                        }
                        if(desde.getHours()<10){
                            var hour='0'+desde.getHours();
                        }else{
                            var hour=desde.getHours();
                        }
                        var horas=hour+':'+min;
                        if(horas==hora){
                            opcs2+='<option value="'+horas+'" selected>'+horas+'</option>';
                        }else{
                            opcs2+='<option value="'+horas+'">'+horas+'</option>';
                        }
                        desde.setMinutes(desde.getMinutes()+30);
                    }
                    $("#horaAge2").html(opcs2);
                    $("#modalAgendarCita2").modal('show');
                }else{
                    swal('No tiene servicios autorizados','','error');
                }
            }
        });
         $('#modalAgendas').modal('hide');
    });
    $(".estado").on( 'click', function(){
        var estado    = $(this).data("estado");
        var citcodigo = $('#edtcodigocita').val();    
        $.ajax({
            url: 'process.php',
            method: 'POST',
            data: {opcion: "estado", estado:estado, citcodigo:citcodigo},
            success: function (data) 
            {
                if (data == 1) 
                {
                    loadcol(fecha);
                    loadgrid();
                    $('#modalAgendas').modal("hide");
                }
            }
        });
    });
    $(document).on('click', '.free', function(){
        if($(this).hasClass('notrn')){
            swal('Fuera de turno','A esta hora el colaborador no se encuentra disponible, aún así podrá apartar la cita de común acuerdo con el colaborador','warning');
        }else if($(this).hasClass('alm')){
            swal('Hora de almuerzo!','A esta hora el colaborador no se encuentra disponible, aún así podrá apartar la cita de común acuerdo con el colaborador','warning');
        }
        var hora   = $(this).data("hora");
        var codcol = $(this).data("col");
        var slncod=$("#slncod").val();
        $("#slncodigo").val(slncod);
        $("#horaAge").val(hora);
        $.ajax({
            url: 'proccess.php',
            method: 'POST',
            data:'opc=loadser&codcol='+codcol+'&slncod='+slncod,
            success: function (res) {
                var json = JSON.parse(res);
                var opcs = "";
                opcs += "<option value='0'>Seleccione Servicio...</option>";
                for(var i in json.ser){
                    opcs += "<option value='"+json.ser[i].cod+"' data-dur='"+json.ser[i].dur+"'>"+json.ser[i].nom+" ["+json.ser[i].dur+" Minutos]</option>";
                }
                $("#selServicio").html('');
                $("#selServicio").html(opcs);
                var cantopcs=$('#selServicio').children('option').length;
                if(cantopcs>1){
                    $("#nombreCol").html('<i class="fa fa-user"></i> <b>'+json.nomcol+'</b>');
                    $("#agencodcol").val(codcol);
                    $("#modalAgendarCita").modal('show');
                }else{
                    swal('No tiene servicios autorizados','','error');
                }
            }
        });
    });
    $("#selServicio").change(function(e){
        var dur = $("#selServicio option:selected").data('dur');
        var sercod= $(this).val();
        var codcol=$("#agencodcol").val();
        var slncod=$("#slncod").val();
        var hora = $("#horaAge").val();
        if(sercod>0){
            $.ajax({
                url:'proccess.php',
                type:'POST',
                data:'opc=valtime&dur='+dur+'&codcol='+codcol+'&slncod='+slncod+'&fecha='+fecha+'&hora='+hora,
                success:function(res){
                    if(res!=0){
                        swal('Conflicto con cita agendada','La duración del servicio seleccionado interfiere con la siguiente cita','warning');
                        $("#selServicio").val(0);
                    }
                }
            })
            console.clear();
            loadgrid();
        }
    });
    $(document).on('click', '#btnGuardarCita', function(e){
        $(this).attr('disabled',true);
        var clbcodigo      = $('#agencodcol').val();
        var hora           = $('#horaAge').val();
        var servicio       = $('#selServicio').val();
        var observaciones  = $('#observaciones').val();
        var medio          = $('#selMedio').val();
        var cliente        = $('#cliente').val();
        var salon          = $("#slncod").val();
        var usucod         = $("#usucod").val();
        if((cliente>0) && (servicio>0)){
            $.ajax({
                url: 'proccess.php',
                method: 'POST',
                data: {opc: "inscita", codcol:clbcodigo, clicod:cliente, hora: hora, fecha:fecha, sercod:servicio, obs:observaciones, slncod:salon, usucod:usucod},
                success: function (res) 
                {
                    if(res=='1'){
                        $('#modalAgendarCita').modal("hide");
                        loadcol(fecha)
                        loadgrid();
                        reset();

                    }else{
                        swal('Error!','Refresque la página e intentelo nuevamente.','error');
                    }
                }
            }); 
        }else{
            swal('Faltan campos por diligenciar','Asegúrese de elegir cliente y servicio','error');
        }
    });
    $('#modalAgendarCita').on('hidden.bs.modal', function () {
       reset();
    });
    $('#modalAgendas').on('hidden.bs.modal', function () {
       loadgrid();
    });
    $("#saveeditcita").click(function(e){
        var codcli=$("#cliente2").val();
        var sercod=$("#selServicio2").val();
        var hora=$("#horaAge2").val();
        var obs=$("#observaciones2").val();
        var citcodigo=$("#edtcodigocita").val();
        var dur = $("#selServicio2 option:selected").data('dur');
        var usucod=$("#usucod").val();
        var salon=$("#slncod").val();
        var codcol=$("#agencodcol2").val();
        $.ajax({
            url:'proccess.php',
            type:'POST',
            data:{opc:'editcita',fecha:fecha,codcli:codcli,sercod:sercod,hora:hora,obs:obs,citcodigo:citcodigo,dur:dur,usucod:user,salon:salon,codcol:codcol},
            success:function(res){
                if(res==1){
                    swal('Error!','Refresque la página e intentelo nuevamente','error');
                }else if(res==2){
                    swal('Conflicto con cita agendada','Verifique que la hora de la cita no se cruce con una existente y que la duración del servicio seleccionado no interfiera con otra cita','warning');
                }else if(res==0){
                    $("#modalAgendarCita2").modal('hide');
                }
                loadcol(fecha);
                loadgrid();
            }
        })
    })
</script>
<script type="text/javascript">
    $(document).on('click', '#regClienteNew', function() {
        $('#modalNuevoCliente').modal("show");
        $('#modalNuevoCliente').on('shown.bs.modal', function () 
        {
            $('#dataCapture').focus();
        });
    });
    $(document).on('keyup', '#email', function() 
    {
        var doc = $('#nroDoc').val();

        $.ajax({
            url: 'process.php',
            method: 'POST',
            data: {opcion: "valDoc", doc:doc},
            success: function (data) 
            {
                var jsondata = JSON.parse(data);

                if (jsondata.res == "full" ) 
                {
                    for(var i in jsondata.json)
                    {
                        swal("El cliente ya está registrado", "Agende su cita", "success");
                        $('#email').val(jsondata.json[i].email);
                        $('#fijo').val(jsondata.json[i].fijo);
                        $('#movil').val(jsondata.json[i].movil);
                    }
                    $('.btnNext2').attr("disabled", true).addClass('disabled');
                }
            }
        });
    });
    $('#cliente').selectpicker({
        liveSearch: true,
        title:'Buscar y seleccionar cliente...'
    });
    $('#cliente').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker');
    });
    $(document).on('keyup', '#fucker', function(event) {
        var seek = $(this).val();
        if(seek.length>=3){
            $.ajax({
                url: 'proccess.php',
                type: 'POST',
                data:'opc=loadcli&txt='+seek,
                success: function(data){
                    if(data){
                        var json = JSON.parse(data);
                        var opcs = "";
                        for(var i in json){
                            opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+" ("+json[i].ced+")</option>";
                        }
                        $("#cliente").html(opcs).selectpicker('refresh');
                    }
                }
            }); 
        }
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('#cliente2').selectpicker({
        liveSearch: true,
        title:'Buscar y seleccionar cliente...'
    });
    $('#cliente2').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker2');
    });
    $(document).on('keyup', '#fucker2', function(event) {
        var seek = $(this).val();
        if(seek.length>=3){
            $.ajax({
                url: 'proccess.php',
                type: 'POST',
                data:'opc=loadcli&txt='+seek,
                success: function(data){
                    if(data){
                        var json = JSON.parse(data);
                        var opcs = "";
                        for(var i in json){
                            opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+" ("+json[i].ced+")</option>";
                        }
                        $("#cliente2").html(opcs).selectpicker('refresh');
                    }
                }
            }); 
        }
    });
</script>   
<script type="text/javascript">
    $(document).on('click', '#btnNuevoCli', function() {
        $('#modalNuevoCliente').modal("show");
        $('#modalNuevoCliente').on('shown.bs.modal', function () 
        {
            $('#dataCapture').focus();
        }); 
    });
    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });
</script>   