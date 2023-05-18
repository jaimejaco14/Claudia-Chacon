<?php
	include("./head.php");


   	VerificarPrivilegio("CITAS (PDV)", $_SESSION['PDVtipo_u'], $conn);
    	RevisarLogin();
    
	
	$cod_salon = $_SESSION['PDVslncodigo'];
    	$salon     = $_SESSION['PDVslnNombre'];
	
	$querySalones            = "SELECT slncodigo, slnnombre, slndireccion FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre";
	$queryServicios          = "SELECT sercodigo, sernombre,	serduracion FROM btyservicio WHERE serstado = 1	ORDER BY sernombre";
	$queryEstados            = "SELECT esccodigo, escnombre FROM btyestado_cita WHERE escestado = 1 ORDER BY escnombre";
	$queryMedios             = "SELECT meccodigo, mecnombre FROM btymedio_contacto WHERE mecestado = 1 ORDER BY mecnombre";
	$resultadoQuerySalones   = $conn->query($querySalones);
	$resultadoQueryServicios = $conn->query($queryServicios);
	$resultadoQueryEstados   = $conn->query($queryEstados);
	$resultadoQueryMedios    = $conn->query($queryMedios);
	$salones                 = array();
	$estados                 = array();

	while($registrosSalones = $resultadoQuerySalones->fetch_array())
	{

		$salones[] = array(
			"codigo" 	=> $registrosSalones["slncodigo"],
			"nombre" 	=> $registrosSalones["slnnombre"],
			"direccion" => $registrosSalones["slndireccion"]);
	}

	while($registrosEstados = $resultadoQueryEstados->fetch_array())
	{
		$estados[] = array("codigo" => $registrosEstados["esccodigo"], "nombre" => $registrosEstados["escnombre"]);
	}
?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<link rel="stylesheet" href="js/mailtip.css">

<div class="row">
	<input type="number" name="txtUsuario" id="txtUsuario" value="<?php echo $_SESSION['PDVcodigoUsuario'] ?>" readonly style="display: none">
		<div class="col-lg-4">
			<div class="content animate-panel">
				<div class="row">
					<div class="hpanel">
						<div class="panel-heading">
							<div class="panel-tools">
								<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							</div>
							CITAS
						</div>
						<div class="panel-body">					

	                        <div class="text-center m-b-md" id="wizardControl">

	                            <a class="btn btn-primary paso_1 border" href="#step1" data-toggle="tab">Paso 1</a>
	                            <a class="btn btn-default paso_2 border" href="#step2" data-toggle="tab">Paso 2</a>
	                            <a class="btn btn-default paso_3 border" href="#step3" data-toggle="tab">Paso 3</a>
	                            <a class="btn btn-warning	 nuevoCliente pull-right border" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Nuevo cliente"><i class="fa fa-user-plus"></i></a>

	                        </div>

                        	<div class="tab-content">
                        		<div id="step1" class="p-m tab-pane active">

                            		<div class="row">
                            			<center><h4>Seleccione Cliente y Servicio</h4></center>                               
                            			<hr>
                                		<div class="col-lg-12">
                                    		<div class="row">
                                    			<div class="form-group">
                                            		<label class="control-label" for="selectCliente"><b>Medio</b></label>
                                                 
                                                		<form id="formularioCitasAgen">  

                                                    		<select name="selectMedios" id="selectMedios" class="form-control" style="width: 100%!important">
																<option value="0">SELECCIONE MEDIOS</option>
																		<?php 
																		    while($registros = $resultadoQueryMedios->fetch_array())
																		    {
																		    		if ($registros['mecnombre'] == "PRESENCIAL") 
																		    		{
																		    			echo "<option value='".$registros['meccodigo']."' selected>".utf8_encode($registros['mecnombre'])."</option>";
																		    		}
																		    		else
																		    		{
																		            	echo "<option value='".$registros['meccodigo']."'>".utf8_encode($registros['mecnombre'])."</option>";
																		    			
																		    		}
																		    }
																		?>									       
                                                    		</select>                                                   
                                                
                                        		</div>
                                        	<hr>

											<div id="containerCli">
                                        		<label class="control-label" for="selectCliente"><b>Cliente</b></label>
	                                        		<div class="input-group" >
	                                        			<input type="hidden" name="salon" value="<?php echo $cod_salon; ?>">
	                                        		 		<select required name="selectCliente" id="selectClienteCitas" class="selectpicker" data-live-search="true" title='Selecciona Cliente' data-size="10" style="width: 100%">
																<option value="0" selected>Seleccione Cliente</option>	
	  														</select> 
	                                        				<span class="input-group-btn"> 
	                                        					<button type="button" class="btn btn-primary border" data-toggle="tooltip" data-placement="top" title="Clientes"><i class="fa fa-users"></i></button> 
	                                        				</span>
	                                        				<div id="containerCli"> </div>
	                                        		</div>
	                                        </div>

                                         	<div class="form-group containerCli" style="display: none">
                                            	<label class="control-label" for="selectCliente"><b>Cliente</b></label>
                                                                                             	
                                                	<input type="hidden" name="salon" value="<?php echo $cod_salon; ?>">  			
									<input type="hidden" name="docCli" id="docCli" style="display: none">
									<input type="text" id="nomCli" style="display: none" class="form-control">							
                                        	</div>
                                        	<hr>
                                       		<div class="form-group">
                                            	<label class="control-label" for="selectServicio">Servicio</label>
                                                <div class="input-group inpSer">
                                                    <select required name="selectServicio" id="selectServicio" class="selectpicker" data-live-search="true" title='Selecciona Servicio' data-size="10" data-size="auto">
                                                       	<option value="0" selected>Seleccione Servicio</option>
                                                    </select>

                                                </div>
                                        	</div>                                       
                                    	</div>
                                	</div>
                            	</div>

	                            <div class="text-right m-t-xs">
	                                <a class="btn btn-primary nextStep btn-xs border" href="javascript:void(0)" title="Siguiente"> <i class="pe-7s-angle-right-circle fa-2x"></i></a>
	                            </div>
                        	</div>

                        	<div id="step2" class="p-m tab-pane">

                            <div class="row">
                                <center><h4>Seleccione Fecha y Colaborador</h4></center>
                                <hr>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>Seleccione Fecha</label>
                                            <input type="" placeholder="0000-00-00" id="fecha" class="form-control" name="fecha">
                                        </div>                                       
                                       
                                        <div class="form-group col-lg-6">
                                        	<label>Seleccione Hora</label>
    										<div class="input-group clockpicker" data-autoclose="true">
        										<input type="text" class="form-control" placeholder="06:00" id="hora" name="hora">
					                                <span class="input-group-addon">
					                                    <span class="fa fa-clock-o"></span>
					                                </span>
    										</div>
                						</div>
                                        
                                    </div>                                  
									
                                    <hr>
                                    <div class="row">
                                    	 <div class="form-group col-lg-12">
                                        	<label>Seleccione Colaborador</label>
    											<select required name="selectColaborador" id="selectColaborador" class="form-control" data-placeholder="Seleccione Colaborador" style="width: 100%">
                                                        <option></option>
                                            </select>
                						</div>
                                    </div>

                                    <div class="row">
                                    	 <div class="form-group col-lg-12">
                                        		<label>Observaciones</label>
    										<textarea name="obser" id="obser" class="form-control" rows="3" placeholder="Observaciones (Opcional)" style="resize: none;"></textarea>
                						</div>
                                    </div>
                                
                            </div>

                            <div class="text-right m-t-xs">
                                
                                <button type="submit" class="btn btn-primary btn-xs border" ><i class="pe-7s-angle-right-circle fa-2x"></i></button>
                            </div>
                                </form>

                        </div>
                        <div id="step3" class="tab-pane">
                            <div class="row text-center m-t-lg m-b-lg">
                            	<h4 id="txtConsecutivo"></h4>                                
								<div class="list-group" id="resumen" style="font-size: .8em!important">
								 								  
								</div>
								<center><button href="javascript:void(0)" class="btn btn-primary btn-xs" id="update" title="Volver a Agendar"> <i class="pe-7s-refresh fa-2x"></i></a></center>
                            </div>
                        </div>
                        </div>
                    
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="content animate-panel">
				<div class="row">
					<div class="hpanel">
						<div class="panel-heading">
							<div class="panel-tools">
								<a class="showhide"><i class="fa fa-chevron-up"></i></a>
							</div>
							CALENDARIO
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-12">
									<div id="calendar"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
	<!-- Modal para busqueda avanzada de servicio -->
	<div class="modal fade" id="modalBusquedaServicio" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Búsqueda avanzada de servicio</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label class="control-label" for="selectGrupo"><b>Grupo</b></label>
								<select name="selectGrupo" id="selectGrupo" class="form-control input-sm" placeholder="Seleccione un grupo">
									<option></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectSubgrupo" id="lbl_subgrupo">Sub-grupo</label>
								<select name="selectSubgrupo" id="selectSubgrupo" class="form-control input-sm" placeholder="Seleccione un sub-grupo" disabled>
									<option></option>
								</select>
							</div>							
						</div>
					</div>
					 <div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectLinea" id="lbl_linea">Línea</label>
								<select name="selectLinea" id="selectLinea" class="form-control input-sm" placeholder="Seleccione una l&iacute;nea" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectSublinea" id="lbl_sublinea">Sub-línea</label>
								<select name="selectSublinea" id="selectSublinea" class="form-control input-sm" placeholder="Seleccione una sub-l&iacute;nea" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectCaracteristica" id="lbl_car">Caracter&iacute;stica</label>
								<select name="selectCaracteristica" id="selectCaracteristica" class="form-control input-sm" placeholder="Seleccione una caracter&iacute;stica" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</div> 
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label for="selectServicio2" id="lbl_ser">Servicio</label>
								<select name="selectServicio2" id="selectServicio2" class="form-control input-sm" placeholder="Seleccione un servicio" disabled>
									<option></option>
								</select>
							</div>
						</div>
					</div>
					<div class="table-responsive">
								<div id="tabla_ser">
									 <?php include("php/citas/mostrar_tabla_servicios.php"); ?>									
								</div>
							</div> 
					<div class="row">
						<div class="col-xs-12">
							<button type="button" id="btn_buscar_ser_mod" class="btn btn-primary pull-right">Buscar</button>
						</div>
					</div>
				</div>
					
				<div class="modal-footer">
					<div class="row">
						<div class="col-xs-12">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							<button type="button" class="btn btn-success" id="btnServicioModal" name="btnServicioModal">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- Fin Modal busqueda avanzada de servicio -->
	<!-- Inicio Modal detalle cita -->
	<div class="modal fade" id="modalDetalleCita" data-backdrop="static" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" onclick="cerrarDetalleModal()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="tituloModalDetalle"></h4>
				</div>
				<div class="modal-body">
					<div class="row" style="display: none">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Codigo salon</label>
								<input type="number" name="txtModalCita" id="txtModalCita" readonly class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Salón</label>
								<input type="text" id="txtModalSalon" placeholder="Nombre del sal&oacute;n" readonly class="form-control">
								<select class="form-control selsln" id="selectSalon2" style="display: none"></select>
								<input type="number" min="1" id="txtModalSalon2" placeholder="Codigo del salón" readonly class="form-control" style="display: none">
							</div>
						</div>						
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Fecha</label>
								<input type="text" id="txtModalFecha" placeholder="Fecha de la cita" readonly class="form-control">
								<input type="text" id="txtModalFecha2" placeholder="Fecha de la cita" class="form-control" style="display: none">
								 <p class="help-block text-danger" id="pfechavigente" style="display: none"> </p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Cliente</label>
								<input type="text" id="txtModalCliente" placeholder="Nombre del cliente" readonly class="form-control">
								<select class="form-control" id="selectCliente2" style="display: none"></select>
								<input type="number" min="1" id="txtModalCliente2" placeholder="Codigo del cliente" readonly class="form-control" style="display: none">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Colaborador asignado</label>
								<input type="text" id="txtModalColaborador" placeholder="Colaborador asignado" readonly class="form-control">
								<select class="form-control" id="selectColaborador2" style="display: none"></select>
								<input type="number" min="1" id="txtModalColaborador2" placeholder="Codigo del colaborador" readonly class="form-control" style="display: none">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Servicio</label>
								<input type="text" id="txtModalServicio" placeholder="Nombre del servicio" readonly class="form-control">
								<select class="form-control" id="selectServicio3" style="display: none"></select>
								<input type="number" id="txtModalServicio2" placeholder="Codigo del servicio" readonly class="form-control" style="display: none">
								<p class="help-block" id="txtModalDuracion"></p>
								<input type="hidden" id="codiservicio">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Asignado por</label>
								<input type="text" id="txtModalUsuario" placeholder="Asignado por" readonly class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Estado</label>
								<input type="text" id="txtModalEstado" name="txtModalEstado" class="form-control" readonly>
								<select class="form-control" id="selectEstado2" style="display: none">
									<option selected disabled>--- Seleccione el nuevo estado ---</option>
									<?php 
										foreach($estados as $estado){

											echo "<option value='".$estado["codigo"]."'>".$estado["nombre"]."</option>";
										}
									?>
								</select>
								<p class="help-block text-danger" id="pestadovigente" style="display: none"> </p>
								<input type="number" name="txtModalEstado2" id="txtModalEstado2" readonly placeholder="Estado nuevo de la cita" style="display: none">
								<input type="number" name="txtModalEstado3" id="txtModalEstado3" readonly placeholder="Estado antiguo de la cita" style="display: none">
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label">Observaciones</label>
							<textarea class="form-control" id="txtModalObservaciones" rows="2" readonly></textarea>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive" id="tablaNovedades">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="btnCerrarModalDetalle" data-dismiss="modal" onclick="cerrarDetalleModal()">Cerrar</button>
					<button type="button" class="btn btn-success" id="btnActualizarModalDetalle" style="display: none" disabled>Actualizar</button>
				</div>
			</div>
		</div>
	</div>


<!-- ******************************************** -->



	<!--Inicio Modal Citas por día -->
	<div class="modal fade" id="modalCitasDia" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="tituloModalCitasDia"></h4>
				</div>
				<div class="modal-body">
					<input type="text" name="txtFechaReporte" id="txtFechaReporte" style="display: none" readonly>
					<h4>Seleccione el formato del reporte a generar.</h4>
					<br>
					<div class="well center-block">
						<button type="button" class="btn btn-default btn-lg btn-block" id="btnReporteExcel"><span style="color: #2e7d32" class="fa fa-file-excel-o"></span> Excel</button>
						<button type="button" class="btn btn-default btn-lg btn-block" id="btnReportePdf"><span class="fa fa-file-pdf-o text-danger"></span> PDF</button>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal Ver Salon -->
<div class="modal fade" id="mdlBackDoor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="title_imagen">Dev_BckDor</h4>
      </div>
      <div class="modal-body">
          <form action="" method="POST" role="form">
          
          	<div class="form-group">
          		<label for="">Pass</label>
          		<input type="password" class="form-control" id="pass" placeholder="*/*/*/*/*">
          		<button type="button" id="btn_del" style="display: none" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-trash"></i> Del</button>
          	</div>           
          	<button type="button" id="btn_back_door" class="btn btn-primary">Submit</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btn_clean" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalColaborador_busqueda" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Programación Colaborador</h4>
                </div>
                <div class="modal-body">
                   
                        <div class="panel-body">
                        	<div class="form-group">
                        		<select name="" id="selColSearch" class="form-control colbuscar">
                        			<option value="">SELECCIONE COLABORADOR</option>
                        		<?php 
                        		include("./php/conexion.php");
                        			$QueryCol = mysqli_query($conn, "SELECT col.clbcodigo as codigoColaborador, CONCAT(ter.trcnombres,' ',ter.trcapellidos) AS nombreColaborador  FROM btycolaborador col JOIN btytercero ter ON col.trcdocumento=ter.trcdocumento");
                        			while($FetchCol = mysqli_fetch_array($QueryCol)){
                        				echo '<option value="'.$FetchCol['codigoColaborador'].'">'.utf8_encode($FetchCol['nombreColaborador']).'</option>';                        				
                        			}
                        		 ?>
                        			
                        		</select>
                        	</div>
                        	<div id="calendario">
                            	
                            </div>
                        </div>
                    
                  
                </div>
                
            </div>
        </div>
    </div>


<!--=========================================
=            MODAL NUEVO CLIENTE            =
==========================================-->

<!-- Modal -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> Nuevo Cliente</h4>
      </div>
      <div class="modal-body">
        <div class="row centered-form">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-edit"></i> Diligencie el formulario </h3>
                        </div>
                        <div class="panel-body">
                                <div class="tab-content">
                                    <div id="data1" class="p-m tab-pane active">
                                        <div class="row">                                
                                            <!-- <form role="form"> -->
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
                                                		<input type="text" id="dataCapture" class="form-control" style="border: none; border-color: transparent; color: transparent;">
                                                	</div>
                                            	</div>
                                                <div class="row">                                                	
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">                                                        	
                                                            <label for="">TIPO DOCUMENTO</label>
                                                            <br>
                                                                <select class="form-control" id="tipodoc"  style="width: 100%!important">
                                                                   
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

                                        </div>

                                        <div class="text-right m-t-xs">
                                            <br>
                                            <a class="btn btn-primary next" id="btnNext2" href="#">REGISTRAR</a>
                                        </div>
                                    </div>

                                    <div id="data2" class="p-m tab-pane">

                                        <div class="row">                               

                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label for="">FECHA DE NACIMIENTO</label>
                                                            <div class="input-group date">
                                                            <input type="text" class="form-control" id="fechaNac" placeholder="0000-00-00"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                        </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6" id="coldepto">
                                                        <div class="form-group">
                                                             <label for="">DEPARTAMENTO</label>
                                                                <select class="" id="selDepartamento" data-live-search="true" title='DEPARTAMENTO' data-size="10" style="width: 100%!important">
                                                                <?php                                            
                                                                    $sql = mysqli_query($conn,"SELECT depcodigo, depombre FROM btydepartamento WHERE NOT depcodigo = 0 AND depstado = 1");

                                                                        while ($row = mysqli_fetch_array($sql)) 
                                                                        {  
                                                                            echo '<option value="'.$row['depcodigo'].'">'.utf8_encode($row['depombre']).'</option>';

                                                                        }
                                                                ?>
                                                        </select>
                                                         </div>
                                                    </div>
                                                </div>



        

                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6" id="colciudad">
                                                            <div class="form-group">
                                                                <label for="">CIUDAD</label>
                                                                <select name="" id="selCiudad" class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6" id="colbarrio">
                                                            <div class="form-group">
                                                                <label for="">BARRIO</label>
                                                                 <select name="" id="selBarrio" class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">DIRECCIÓN</label>
                                                                <input type="text" class="form-control" id="direccion" placeholder="DIGITE SU DIRECCIÓN">
                                                            </div>
                                                        </div>

                                                         <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">MÓVIL</label>
                                                                <input type="number" class="form-control" id="movil" placeholder="DIGITE SU MÓVIL">
                                                            </div>
                                                        </div>
                                                    </div> 
                                                     <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">FIJO</label>
                                                                <input type="number" class="form-control" id="fijo" placeholder="DIGITE SU TELÉFONO FIJO">
                                                            </div>
                                                        </div>

                                                         <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">E-MAIL</label>
                                                                <input type="email" class="form-control" id="emailg" placeholder="DIGITE SU E-MAIL">
                                                            </div>
                                                        </div>
                                                    </div>  
                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">RECIBIR NOTIFICACIONES AL MOVIL</label>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="" id="nm" checked>
                                                                        
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                         <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">RECIBIR NOTIFICACIONES AL E-MAIL</label>
                                                               <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="" id="ne" checked>
                                                                        
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                    
                                       
                                        </div>
                                        <div class="text-right m-t-xs">
                                            <a class="btn btn-primary next" id="btnRegistrarCli"><i class="fa fa-chevron-right"></i></a>
                                        </div>

                                    </div>
                                    <div id="data3" class="tab-pane">
                                        <div class="row text-center m-t-lg m-b-lg">
                                            <div class="col-lg-12">
                                                <i class="pe-7s-check fa-5x text-muted"></i>
                                                <div class="form-group col-lg-12" id="terminos">
                                       
                                    </div>
                                            </div>
                                            <div class="checkbox col-lg-12">
                                                <input type="checkbox" class="i-checks approveCheck" name="approve" id="aprobar">
                                                Estoy de acuerdo
                                            </div>
                                        </div>
                                        <div class="text-right m-t-xs">
                                            <button type="button"  class="btn btn-primary">REGISTRAR</button>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>

<!--====  End of MODAL NUEVO CLIENTE  ====-->

<!--==================================================
=            EDITAR CLIENTE EMAIL Y MOVIL            =
===================================================-->

<!-- Modal -->
<div class="modal fade" id="modalEditarCliente" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Añadir E-mail y Móvil</h4>
      </div>
      <div class="modal-body">
         	<input type="hidden" id="codCliente">
         	<input type="hidden" id="docCliente">
         	<div class="form-group">
         		<label for="">E-mail</label>
         		<input type="text" class="form-control" id="emailEditCli">
         	</div>

         	<div class="form-group">
         		<label for="">Móvil</label>
         		<input type="text" class="form-control" id="movilEditCli">
         	</div> 
         	<div class="well" style="text-align: justify;"><p class="text-danger">Con el fin de brindar un mejor servicio se aconseja que se llene el campo del e-mail y el número de celular. Así podremos contactar al cliente y enviar notificaciones concerniente a los servicios solicitados.</p></div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnGuardarEdicion">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!--====  End of EDITAR CLIENTE EMAIL Y MOVIL  ====-->


<div class="modal fade" id="modalServicios" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Servicios del colaborador</h4>
				</div>
				<div class="modal-body">
					<div class="panel panel-info">
  						<div class="panel-heading">
    						<h3 class="panel-title">Servicios Autorizados</h3>
  						</div>
					  	<div class="panel-body">
					    	<div class="row">
								<div class="col-xs-3">
									<img src="" id="imagenColaboradorServicio" alt="Imagen colaborador" class="img-thumbail img-responsive" width="180" height="180">
								</div>
								<div class="col-xs-9">
								    <div class="form-group">
										<div class="col-sm-12">
											<input type="hidden" id="txtCodigoColaborador">
										</div>
									</div>
									
                  <div class="form-group">                  
                      <div id="listaData"></div>         
                  </div>
								
									
								</div>
							</div> 
					  	</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive" id="">                             
							    	<table class="table table-hover table-bordered table-striped" id="tblLista" style="width: 100%">
                        <thead>
                          <tr class="info">
                            <th>Servicio</th>
                            <th>Duración</th> 
                          </tr>         
                        </thead>

                        <tbody>

                        </tbody>                        
                    </table>	                  
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" title="Cerrar ventana">Cerrar</button>
				</div>
			</div>
		</div>
	</div>



<!-- Modal -->
<div class="modal fade" id="modalReporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Seleccionar Tipo Reporte</h4>
      </div>
      <div class="modal-body">
         <div class="panel panel-info">
             <div class="panel-heading">
                 <h3 class="panel-title"></h3>
             </div>
             <div class="panel-body">
                    <select name="" id="selReport" class="form-control" required="required">
                        <option value="1">AGENDA</option>
                        <option value="2">BIOMÉTRICO</option>
                    </select>
             </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnIr">Ir</button>
      </div>
    </div>
  </div>
</div>


<style>
	th,td{
		white-space: nowrap;
		font-size: .8em;

	}

	th{
		text-align: center;
	}

	.fechaEstilo
	{
		color: red!important;
		font-size: .9em;
	}

	.btn-group, .bootstrap-select, .input-group-btn{
	    width: 100% !important;
	}

	.inpSer{
		 width: 100% !important;
	}

	.border{
		border-radius: 0px!important;
	}

</style>

<?php include("./librerias_js.php"); ?>
<script src="js/toastr.min.js"></script>

<script src="./js/sube_baja.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<!-- <script src="./js/cita.js"></script> -->
<script src="./js/citas2.js"></script>


<script src="./js/mailtip.js"></script>
<!-- <script src="js/select2-4.0.1.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.7/typed.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
</body>
</html>

