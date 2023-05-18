<?php 
    /*header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");*/
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
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

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
        .domicilio{
            background-color: #2C3E50;
            color:white;
            cursor:pointer;
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
                                            <!-- QUITAR HIDDEN y values AL FINALIZAR COVID (SI ALGUN DIA PASA...) -->
                                           <div class="row">
                                               <div class="col-xs-6 col-sm-6 col-md-4">
                                                   <div class="form-group">
                                                       <label for="">E-MAIL</label>
                                                           <input type="email" class="form-control" id="email" placeholder="Digite el e-mail" value="">
                                                               <p class="help-block text-danger" id="txtAlertEmail" style="display:none"><b>Digite el e-mail</b></p>
                                                   </div>
                                               </div>
                                           
                                               <div class="col-xs-6 col-sm-6 col-md-4">
                                                   <div class="form-group">
                                                       <label for="">MÓVIL</label>
                                                           <div class="input-group">
                                                            <input type="number" maxlength="10" id="movil" onblur="validar(this)" placeholder="Digite número móvil" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="" />
                                                               <p class="help-block text-danger" id="txtAlertMovil" style="display:none"><b>Digite el número del móvil</b></p>
                                                           </div>
                                                   </div>
                                               </div>
                                           
                                               <div class="col-xs-6 col-sm-6 col-md-4">
                                                   <label for="">FIJO</label>
                                                       <div class="input-group"><input type="number" maxlength="7" id="fijo" placeholder="Digite número fijo" class="form-control " oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" /> <p class="help-block text-danger" id="txtAlertFijo" style="display:none"><b>Digite el número fijo</b></p></span></div>
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
<!-- Modal VER AGENDA-->
<div class="modal fade" id="modalAgendas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-search"></i> Información de la cita</h4>
      </div>
      <div class="modal-body">
        <div id="detcita">
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
				<h4 id="msjdomi" class="text-center hidden"><b>---- ESTE ES UN SERVICIO A DOMICILIO ----</b></h4>
                <div class="text-center hidden detDom" >
                    <button id="btndetDom" class="btn btn-info">Ver detalles</button>
                </div>
            </div>
        
            <center>
                <hr>
                <div id="center">
                    <div id="citaApp" class="text-center">
                        <label>Forma de pago</label>
                        <badge class="badge badge-info" id="formpgo">Efectivo</badge>
                    </div>
                    
                    <hr>
                    <div class="btn-group btnoptions" role="group" aria-label="...">
                        <button type="button" class="btn btn-default estado" data-estado="8" style="background-color: #4cd13a; color: white; border-color: #4cd13a">Atendida</button>
                        <button type="button" class="btn btn-default estado" data-estado="3" style="background-color: red; color: white; border-color: red">Cancelada</button>
                        <button type="button" class="btn btn-default estado" data-estado="9" style="background-color: purple; color: white; border-color: purple">Inasistencia</button>
                        <button type="button" id="reprogramar" class="btn btn-primary estado reprogramar" data-toggle="modal" style=" color: white;">Editar Cita</button>
                    </div>
                    <!-- <div class="btn-group btnscedit" style="display:none;">
                        <button class="btn canceledt" style="background-color: red; color: white; border-color: red">Cancelar</button>
                        <button class="btn saveedt" style="background-color: #4cd13a; color: white; border-color: #4cd13a">Guardar cambios</button>
                    </div> -->
                </div>
                <hr>
                <div class="text-center">
                    <label class="sienc btn btn-success estenc hidden"><i class="fa fa-check"></i> ENCUESTA COVID REALIZADA Y APROBADA</label>
                    <label class="noenc btn btn-warning estenc hidden"><i class="fa fa-warning"></i> NO HA REALIZADO ENCUESTA COVID</label>
                    <label class="failenc btn btn-danger estenc hidden"><i class="fa fa-times"></i> ENCUESTA COVID NO APROBADA, NO PUEDE INGRESAR</label>
                </div>
            </center>
        </div>
        <div id="detDom" class="hidden">
            <h4 class="text-center ldtbdetdom"><i class="fa fa-spin fa-spinner"></i> Cargando...</h4>
            <table class="table table-hover table-condensed tbdetdom hidden">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">Detalle servicio en casa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Cliente</th>
                        <td id="domcli" colspan="2"></td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td id="domdir" colspan="2"></td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td id="domtel" colspan="2"></td>
                    </tr>
                    <tr>
                        <th>Forma de Pago</th>
                        <td id="domfpago" colspan="2"></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-center">Servicios y colaboradores asignados al domicilio</th>
                    </tr>
                    <tr>
                        <th class="text-center">Colaborador</th>
                        <th class="text-center">Servicio</th>
                        <th class="text-center">Costo</th>
                    </tr>
                </tbody>
                <tbody id="tbsrvDom">
                </tbody>
            </table>
        </div>
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
                        <select id="selServicio"  class="form-control"  style="width: 100%!important;"></select>
                    </div>
                </div>
                <div class="row">
	                <div class="col-md-6">
	                    <div class="form-group">
	                        <label for="">Hora</label>
	                        <input type="text" name="" id="horaAge" class="form-control" readonly="" value="" title="">
	                    </div>
	                </div>
                	<div class="col-md-6">
	                    <div class="form-group">
	                        <label for="tipocita">Atención en:</label>
	                        <select id="tipocita" class="form-control" >
	                        	<option value="0">Salón</option>
	                        	<option value="1">Domicilio</option>
	                        </select>
	                    </div>
	                </div>
                </div>
				<div class="divdomicilio hidden">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Dirección</div>
                                    <input class="form-control" id="address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Barrio</div>
                                    <select class="form-control selbrr" data-size="5" id="selbrr"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                <div class="input-group-addon">Celular</div>
                                    <input class="form-control text-right celphone" id="phone">
                                </div>
                            </div>
                        </div>
                    </div>
	               	<div class="row">
	               		<div class="col-md-6">
	               			<div class="form-group">
	               				<div class="input-group">
									<div class="input-group-addon">Valor Servicio - $</div>
									<input class="form-control number money text-right" id="vlrser">
								</div>
	               			</div>
	               		</div>
	               		<div class="col-md-6">
	               			<div class="form-group">
	               				<div class="input-group">
								<div class="input-group-addon">Recargo - $</div>
									<input class="form-control number money text-right" id="vlrrec">
								</div>
	               			</div>
	               		</div>
	               	</div>
					<div class="row">
	               		<div class="col-md-6">
	               			<div class="form-group">
	               				<div class="input-group">
									<div class="input-group-addon">Transp ida - $</div>
									<input class="form-control number money text-right" id="traida">
								</div>
	               			</div>
	               		</div>
	               		<div class="col-md-6">
	               			<div class="form-group">
	               				<div class="input-group">
								<div class="input-group-addon">Transp regreso - $</div>
									<input class="form-control number money text-right" id="trareg">
								</div>
	               			</div>
	               		</div>
	               	</div>
	               	<div class="row">
	               		<div class="col-md-6 col-md-push-6">
		               		<div class="form-group">
		               			<label for="totaldom">TOTAL SERVICIO A DOMICILIO</label>
		               			<input id="totaldom" class="form-control text-right" value='0' readonly>
		               		</div>
	               		</div>
	               	</div>
				</div>	
                <div class="col-md-12 hidden">
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
				<div class="row">
	                <div class="col-md-6">
	                    <div class="form-group">
	                        <label for="horaAge2">Hora</label>
	                        <select id="horaAge2" class="form-control"></select>
	                    </div>
	                </div>
                	<div class="col-md-6">
	                    <div class="form-group">
	                        <label for="tipocita2">Atención en:</label>
	                        <select id="tipocita2" class="form-control" >
	                        	<option value="0">Salón</option>
	                        	<option value="1">Domicilio</option>
	                        </select>
	                    </div>
	                </div>
                </div>
                <div class="divdomicilio2 hidden">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Dirección</div>
                                    <input class="form-control" id="address2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Barrio</div>
                                    <select class="form-control selbrr" data-size="5" id="selbrr2"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                <div class="input-group-addon">Celular</div>
                                    <input class="form-control text-right celphone" id="phone2">
                                </div>
                            </div>
                        </div>
                    </div>
	               	<div class="row">
	               		<div class="col-md-6">
	               			<div class="form-group">
	               				<div class="input-group">
									<div class="input-group-addon">Valor Servicio - $</div>
									<input class="form-control number money2 text-right" id="vlrser2">
								</div>
	               			</div>
	               		</div>
	               		<div class="col-md-6">
	               			<div class="form-group">
	               				<div class="input-group">
								<div class="input-group-addon">Recargo - $</div>
									<input class="form-control number money2 text-right" id="vlrrec2">
								</div>
	               			</div>
	               		</div>
	               	</div>
					<div class="row">
	               		<div class="col-md-6">
	               			<div class="form-group">
	               				<div class="input-group">
									<div class="input-group-addon">Transp ida - $</div>
									<input class="form-control number money2 text-right" id="traida2">
								</div>
	               			</div>
	               		</div>
	               		<div class="col-md-6">
	               			<div class="form-group">
	               				<div class="input-group">
								<div class="input-group-addon">Transp regreso - $</div>
									<input class="form-control number money2 text-right" id="trareg2">
								</div>
	               			</div>
	               		</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                <div class="input-group-addon">COVID PRO - $</div>
                                    <input class="form-control number money2 text-right" id="covid" readonly>
                                </div>
                            </div>
                        </div>
	               	</div>
	               	<div class="row">
	               		<div class="col-md-6 col-md-push-6">
		               		<div class="form-group">
		               			<label for="totaldom">TOTAL SERVICIO A DOMICILIO</label>
		               			<input id="totaldom2" class="form-control text-right" value='0' readonly>
		               		</div>
	               		</div>
	               	</div>
				</div>	
                <div class="col-md-12 hidden">
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
        <button type="button" class="btn btn-primary" id="saveeditcita" data-toggle="tooltip" data-placement="top"><i class="fa fa-save"></i> Guardar cambios</button>
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
<script src = "https://cdn.pubnub.com/sdk/javascript/pubnub.4.21.6.js" > </script>
<script type="text/javascript">
    $(document).ready(function() {
        /***********************************************************************************/
        var pubnub = new PubNub ({
            subscribeKey: 'sub-c-26641974-edc9-11e8-a646-e235f910cd5d' , // siempre requerido
            publishKey: 'pub-c-870e093a-6dbd-4a57-b231-a9a8be805b6d' // solo es necesario si se publica
        });
        var sln=$("#slncod").val();
        pubnub.addListener({
            message: function(data) {
                console.log(data.message);
                var fecha=$("#fechaAgenda").val();
                if(fecha==''){
                    var d=new Date();
                    fecha=d.getFullYear()+'-'+((parseInt(d.getMonth())+1)<10?'0':'')+(parseInt(d.getMonth())+1)+'-'+(d.getDate()<10?'0':'')+d.getDate();
                }
                console.log(fecha);
                if(data.message==fecha){
                    loadhorasalon(fecha);
                    loadcrg(fecha);
                    loadcol(fecha);
                    loadgrid();
                    console.log('tb-reloaded');
                }
            }
        });
        pubnub.subscribe({
            channels: ['cita'+sln]
        });
        /************************************************************************************/
        $('#fechaAgenda').datepicker({ 
            format: "yyyy-mm-dd",
            autoclose: true
        }); 
        $('#cliente').selectpicker({
            liveSearch: true,
            title:'Buscar y seleccionar cliente...'
        });
        $('#cliente2').selectpicker({
            liveSearch: true,
            title:'Buscar y seleccionar cliente...'
        });
        $('.selbrr').selectpicker({
            liveSearch: true,
            title:'Seleccionar barrio...'
        });
    });
    var utc = new Date().toJSON().slice(0,10).replace(/-/g,'-');
    var f = new Date();
    var fecha=(f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate());
    loadhorasalon(fecha);
    var user=$("#usucod").val();
    
    //loadcrg(fecha);
    //loadcol(fecha);
    //loadgrid();
    loadbarrio();
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
                loadcrg(fecha);
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
                var json = JSON.parse(res);
                if(json.length>0){
                    $("#trcrg").empty();
                    $("#trcrg").append('<th colspan="1" class="active"></th>');
                    for(var i in json){
                        $("#trcrg").append('<th colspan="'+json[i].crgcount+'" class="active text-center">'+json[i].crgnombre+'S ('+ json[i].crgcount +')</th>');
                    }
                    loadcol(fecha);
                }else{

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
                    var tipct=[];
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
                loadgrid();
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
                                case '10':fondo='verCita domicilio text-center';logo='fa fa-home';
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
        $(".money").val('').trigger('keyup');
        loadgrid();
    }
    function loadbarrio(){
        $.ajax({
            url:'proccess.php',
            type:'POST',
            data:{opc:'loadbarrio'},
            success:function(res){
                var resp=JSON.parse(res);
                var opc='';
                for(var i=0 in resp){
                    opc+='<option value="'+resp[i].cod+'">'+resp[i].nom+'</option>';
                }
                $("#selbrr").html(opc).selectpicker('refresh');
                $("#selbrr2").html(opc).selectpicker('refresh');
            }
        })
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
        /*loadcrg(fecha);
        loadcol(fecha);
        loadgrid();*/
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
            url: 'proccess.php',
            method: 'POST',
            data: {opc: "verAgenda", citcodigo:citcodigo},
            success: function (res){
                var json = JSON.parse(res);
                for(var i in json){
                    $('#txtcliente').val(json[i].cliente);
                    $('#txtclicod').val(json[i].clicod);
                    $('#txtservicio').val(json[i].servicio + " DURACIÓN: [ " + json[i].duracion + " ]");
                    $("#sercodigo").val(json[i].sercod);
                    $('#txtmovil').val(json[i].movil);
                    $('#txtemail').val(json[i].email);
                    $('#txtusuarioagenda').val(json[i].usuagenda);
                    $("#address2").val(json[i].address);
                    $("#selbrr2").val(json[i].barrio).selectpicker('refresh');
                    $("#phone2").val(json[i].movil);
                    $("#tipocita2").val('0').change();
                    $(".divdomicilio2").addClass('hidden');
                    $("#vlrser2").val('');
            		$("#vlrrec2").val('');
            		$("#traida2").val('');
            		$("#trareg2").val('');
            		$("#totaldom2").val('');
                    $("#formpgo").html(json[i].fpgo);
                    var estado = json[i].estadoCita;
                    switch(estado){
                    	case '1':
                    		$('.estado').attr('disabled', false);
                    		$("#msjdomi").addClass('hidden');
                            $(".detDom").addClass('hidden');
                    	break;
                    	case '3':
                    	case '8':
                    	case '9':
                    		$('.estado').attr('disabled', true);
                    		$("#msjdomi").addClass('hidden');
                            $(".detDom").addClass('hidden');
                    	break;
                    	case '7':
                    		$('#reprogramar').attr('disabled', true);
                    	break;
                    	case '10':
                    		$('.estado').attr('disabled', false);
                    		$("#msjdomi").removeClass('hidden');
                            $(".detDom").removeClass('hidden');
                    		$("#tipocita2").val('1').change();
                            //$(".divdomicilio2").removeClass('hidden');
                    		$("#vlrser2").val(json[i].valser);
                    		$("#vlrrec2").val(json[i].valrec);
                    		$("#traida2").val(json[i].vtrai);
                    		$("#trareg2").val(json[i].vtrar);
                            $("#covid").val(json[i].covid!=''?'10,000':0);
                    		$("#totaldom2").val(json[i].vtot);
                    	break;
                    }
                    /*ESTADO ENCUESTA COVID*/
                        if(json[i].csw==0){
                            $(".sienc").removeClass('hidden');
                        }else if(json[i].csw==1){
                            $(".failenc").removeClass('hidden');
                        }else if(json[i].csw==null){
                            $(".noenc").removeClass('hidden');
                        }
                    /*FIN ESTADO ENCUESTA COVID*/
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
                opcs += "<option value='0' disabled>Seleccione Servicio...</option>";
                for(var i in json.ser){
                    if(json.ser[i].cod==sercodigo){
                        opcs += "<option value='"+json.ser[i].cod+"' data-dur='"+json.ser[i].dur+"' selected>"+json.ser[i].nom+" ["+json.ser[i].dur+" Minutos]</option>";
                    }else{
                        opcs += "<option value='"+json.ser[i].cod+"' data-dur='"+json.ser[i].dur+"'>"+json.ser[i].nom+" ["+json.ser[i].dur+" Minutos]</option>";
                    }
                }
                $("#selServicio2").html('');
                $("#selServicio2").html(opcs);
                var cantopcs=$('#selServicio2').children('option').length;
                if(cantopcs>1){
                    $("#nombreCol2").html('<i class="fa fa-user"></i> <b>'+json.nomcol+'</b>');
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
        var btn=$(this);
        var sw=1;
        var clbcodigo      = $('#agencodcol').val();
        var hora           = $('#horaAge').val();
        var servicio       = $('#selServicio').val();
        var observaciones  = $('#observaciones').val();
        var medio          = $('#selMedio').val();
        var cliente        = $('#cliente').val();
        var salon          = $("#slncod").val();
        var usucod         = $("#usucod").val();
        var tipocita	   = $("#tipocita").val();
        //*****************************************
        var address        = $("#address").val();
        var barrio         = $("#selbrr").val();
        var celu           = $("#phone").val().replace(/\D/g, "");
        //*****************************************
        var vserv		   = $("#vlrser").val().replace(/\D/g, "");
        var vrcgo		   = $("#vlrrec").val().replace(/\D/g, "");
        var vtrai		   = $("#traida").val().replace(/\D/g, "");
        var vtrar		   = $("#trareg").val().replace(/\D/g, "");
        var total 		   = $("#totaldom").val().replace(/\D/g, "");

        if((cliente>0) && (servicio>0)){
        	if(tipocita==0){
        		sw=1;
        	}else{
        		$(".money").each(function(){
        			if(!$(this).val()>0){
        				sw*=0;
        			}
        		});
                if(address.length<3){sw*=0;}
                if(barrio==0){sw*=0;}
                if(celu.length!=10){sw*=0;}
        	}
        	if(sw==1){
        		btn.attr('disabled',true);
	            $.ajax({
	                url: 'proccess.php',
	                method: 'POST',
	                data: {opc: "inscita", 
			                codcol:clbcodigo, 
			                clicod:cliente, 
			                hora: hora, 
			                fecha:fecha, 
			                sercod:servicio, 
			                obs:observaciones, 
			                slncod:salon, 
			                usucod:usucod, 
			                tipocita:tipocita,
                            address:address,
                            barrio:barrio,
                            celu:celu,
			                vserv:vserv,
							vrcgo:vrcgo,
							vtrai:vtrai,
							vtrar:vtrar,
							total:total
			            },
	                success: function (res){
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
        		swal('Todos los campos son obligatorios','El servicio a domicilio requiere de TODOS los campos diligenciados, no se admiten campos en blanco ni con errores','error');
        	}
        }else{
            swal('Faltan campos por diligenciar','Asegúrese de elegir cliente y servicio','error');
        }
    });
    $('#modalAgendarCita').on('hidden.bs.modal', function () {
       reset();
       $("#tipocita").val('0').change();
    });
    $('#modalAgendas').on('hidden.bs.modal', function () {
        $(".estenc").addClass('hidden');/*ADICION COVID*/
        $("#detDom").addClass('hidden');
        $("#detcita").removeClass('hidden');
        $(".ldtbdetdom").removeClass('hidden');
        $(".tbdetdom").addClass('hidden');
       loadgrid();
    });
    $("#saveeditcita").click(function(e){
        var btn=$(this);
        var citcodigo	=$("#edtcodigocita").val();
        var codcli		=$("#cliente2").val();
        var sercod		=$("#selServicio2").val();
        var dur 		=$("#selServicio2 option:selected").data('dur');
        var hora		=$("#horaAge2").val();
        var obs			=$("#observaciones2").val();
        var usucod		=$("#usucod").val();
        var salon		=$("#slncod").val();
        var codcol		=$("#agencodcol2").val();
        //*********************************************************************
        var address     = $("#address2").val();
        var barrio      = $("#selbrr2").val();
        var celu        = $("#phone2").val().replace(/\D/g, "");
        //*********************************************************************
        var tcita 		= $("#tipocita2").val();
        var vserv		= $("#vlrser2").val().replace(/\D/g, "");
        var vrcgo		= $("#vlrrec2").val().replace(/\D/g, "");
        var vtrai		= $("#traida2").val().replace(/\D/g, "");
        var vtrar		= $("#trareg2").val().replace(/\D/g, "");
        var total 		= $("#totaldom2").val().replace(/\D/g, "");
        var sw=1;

        if(tcita==1){
        	$(".money2").each(function(){
    			if(!$(this).val()>0){
    				sw*=0;
    			}
    		});
            if(address.length<3){sw*=0;}
            if(barrio==0){sw*=0;}
            if(celu.length!=10){sw*=0;}
        }
        if(sw==1){
            btn.attr('disabled',true);
	        $.ajax({
	            url:'proccess.php',
	            type:'POST',
	            data:{opc:'editcita',
	            		fecha:fecha,
	            		codcli:codcli,
	            		sercod:sercod,
	            		hora:hora,
	            		obs:obs,
	            		citcodigo:citcodigo,
	            		dur:dur,
	            		usucod:user,
	            		salon:salon,
	            		codcol:codcol,
                        address:address,
                        barrio:barrio,
                        celu:celu,
	            		tcita:tcita,
	            		vserv:vserv,
						vrcgo:vrcgo,
						vtrai:vtrai,
						vtrar:vtrar,
						total:total},
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
	        });
        }else{
        	swal('Faltan datos!','El servicio a domicilio requiere de TODAS los campos diligenciados. Asegurese que todos los datos estén completos','error');
        }
    });
    $("#modalAgendarCita2").on('hide.bs.modal', function (){
        $("#saveeditcita").removeAttr('disabled');
    });
</script>
<script type="text/javascript">//busqueda de clientes
    $(document).on('click', '#regClienteNew', function() {
        $('#modalNuevoCliente').modal("show");
        $('#modalNuevoCliente').on('shown.bs.modal', function () 
        {
            $('#dataCapture').focus();
        });
    });
    $(document).on('keyup', '#email', function(){
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
                    //comentado x covid
                    //$('.btnNext2').attr("disabled", true).addClass('disabled');
                }
            }
        });
    });
    //****************************************************************//
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
                            opcs += "<option data-phone='"+json[i].phone+"' data-address='"+json[i].address+"' data-brr='"+json[i].brr+"' value='"+json[i].cod+"'>"+json[i].nom+" ("+json[i].ced+")</option>";
                        }
                        $("#cliente").html(opcs).selectpicker('refresh');
                    }
                }
            }); 
        }
    });
    //******************************************************************//
    $('#selbrr').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo3');
        $('.algo3 .form-control').attr('id', 'fucker3');
    });
    $('#selbrr2').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo4');
        $('.algo4 .form-control').attr('id', 'fucker4');
    });
    $("#cliente").on("change", function () {
      var tel = $("option[value=" + $(this).val() + "]", this).attr('data-phone');
      var dir = $("option[value=" + $(this).val() + "]", this).attr('data-address');
      var brr = $("option[value=" + $(this).val() + "]", this).attr('data-brr');
      $("#address").val(dir);
      $("#phone").val(tel);
      $("#selbrr").val(brr).selectpicker('refresh');
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('#cliente2').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo2');
        $('.algo2 .form-control').attr('id', 'fucker2');
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
        $('#modalNuevoCliente').on('shown.bs.modal', function () {
            $('#dataCapture').focus();
        }); 
    });
</script>   
<script type="text/javascript">
    //script modal sobre modalc
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
<script type="text/javascript">
    //script number
    $('.number').on('change click keyup input paste',(function (event) {
	    $(this).val(function (index, value){
	        return value.replace(/\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	    });
	}));
    $('#nroDoc').on('change click keyup input paste',(function (event) {
        $(this).val(function (index, value){
            return value.replace(/\D/g, "");
        });
    }));
    $('.celphone').on('change click keyup input paste',(function (event) {
        $(this).val(function (index, value){
            return value.replace(/\D/g, "");
        });
    }));
    
	//***********************************
	$('#modalNuevoCliente').on('hide.bs.modal', function (){
		var newced=$("#nroDoc").val();
        var celu=$("#movil").val().replace(/\D/g, "");
		$('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker');
        $('#fucker').val(newced).trigger('keyup');
        setTimeout(function(){
			$('#cliente option')[1].selected = true;
			$('#cliente').selectpicker('refresh');
            $('#cliente').change();
        }, 500);
	});
    $(document).on('change','#tipocita',function(){
	//$("#tipocita").change(function(){
		var tc=$(this).val();
		if(tc==0){
			$(".divdomicilio").addClass('hidden');
		}else{
			$(".divdomicilio").removeClass('hidden');
		}
	});
    /*$(document).on('change','#tipocita2',function(){
	//$("#tipocita2").change(function(){
		var tc=$(this).val();
		if(tc==0){
			$(".divdomicilio2").addClass('hidden');
		}else{
			$(".divdomicilio2").removeClass('hidden');
		}
	});*/
</script>   
<script>
	//sumador valor servicios y recargos
	$('.money').keyup(function(){
		var total = 0
	  	$(".money").each(
		    function(index, value) {
		      if($.isNumeric( $(this).val().replace(/\D/g,''))){
		      	var num=eval($(this).val().replace(/\D/g,''));
		      	total = total + num;
		      }
		    }
	  	);
	  	var tot=total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	    $("#totaldom").val(tot);
	});
	$('.money2').keyup(function(){
		var total = 0
	  	$(".money2").each(
		    function(index, value) {
		      if($.isNumeric( $(this).val().replace(/\D/g,''))){
		      	var num=eval($(this).val().replace(/\D/g,''));
		      	total = total + num;
		      }
		    }
	  	);
	  	var tot=total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	    $("#totaldom2").val(tot);
	});
</script>
<script type="text/javascript">
    //detalle de domicilios
    $("#btndetDom").click(function(){
        var ds='';
        var tot=0;
        var codCita=$("#edtcodigocita").val();
        $("#detcita").addClass('hidden');
        $("#detDom").removeClass('hidden');
        $.ajax({
            url:'proccess.php',
            type:'POST',
            data:{opc:'detDom', codCita:codCita},
            success:function(res){
                var dt=JSON.parse(res);
                $("#domcli").html(dt.datacli['domcli']);
                $("#domdir").html(dt.datacli['domdir']);
                $("#domtel").html(dt.datacli['domtel']);
                $("#domfpago").html(dt.datacli['domfpago']);
                for(i in dt.dataser){
                    ds+='<tr><td>'+dt.dataser[i].col+'</td><td>'+dt.dataser[i].ser+'</td><td>$'+formatprecio(dt.dataser[i].pre)+'</td></tr>';
                    tot+=parseInt(dt.dataser[i].pre);
                }
                if(dt.datacli['covid']==1){
                    ds+='<tr><td colspan="2">Kit COVID PRO</td><td>$'+formatprecio(dt.datacli['kit'])+'</td></tr>';
                    tot+=parseInt(dt.datacli['kit']);
                }
                ds+='<tr><th colspan="2">TOTAL</th><th>$'+formatprecio(tot)+'</th></tr>';
                $("#tbsrvDom").empty();
                $("#tbsrvDom").html(ds);
                $(".ldtbdetdom").addClass('hidden');
                $(".tbdetdom").removeClass('hidden');
            }
        })
    });
    function formatprecio(num){
        var tot=num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return tot;
    }
</script>