<?php 
	include("head.php");
	include("librerias_js.php");
?>


<div class="container-fluid">
	<div class="content animate-panel start">
     	<div class="row">
     			<?php
     				$html='<div class="col-md-4">
				          	<div class="hpanel hbgblue">
				                   <div class="panel-body">
				                        	<a class="btnmenu" href="misdatos.php" id="" title="" style="color: white">
				                        		<div class="text-center">
							                    <h3><i class="fa fa-user pull-left" style="color: white"></i> ACTUALICE SUS DATOS</h3>
				                        		</div>
				                        	</a>
				                    </div>
				                </div>
				          </div>'; 
				          //$html='';
     				if ($_SESSION['incluturno'] != 0) 
     				{
     					$html.='
						<div class="col-md-4">
				          	<div class="hpanel hbgviolet">
				                   <div class="panel-body">
				                        	<a class="btnmenu" href="javascript:void(0)" id="btnAgenda" title="Click para ver la Agenda" style="color: white">
				                        		<div class="text-center">
							                    <h3><i class="pe pe-7s-pen pull-left" style="color: white"></i> Mis Citas</h3>
				                        		</div>
				                        	</a>
				                    </div>
				                </div>
				          </div>


				          <div class="col-md-4">
							<div class="hpanel">
								<div class="panel-body" style="background-color: #34495e!important">
									<a class="btnmenu" href="javascript:void(0)" id="btnVerBio" title="" style="color: white">
										<div class="text-center">
											<h3><i class="pe-7s-display1 pull-left" style="color: white"></i> Ajuste de contrato</h3>
										</div>
									</a>
								</div>
							</div>
						</div>

				          <!--<div class="col-md-4">
	                			<div class="hpanel hbgyellow">
	                    			<div class="panel-body">
				                        	<a class="btnmenu" href="javascript:void(0)" id="btnVerNov" title="" style="color: white">
				                        			<div class="text-center">
							                            <h3><i class="pe pe-7s-note2 pull-left" style="color: white"></i> Mis Novedades</h3>
				                        			</div>
				                        	</a>
	                    		</div>
	                		</div>
            			</div>-->

            		

						<div class="col-md-4">
							<div class="hpanel hbgred">
				    				<div class="panel-body">
						        	<a class="btnmenu" href="javascript:void(0)" id="btnVerPermisos" title="Click para ver la programación de suspension de arriendo" style="color: white">
						        			<div class="text-center">
						                        <h3><i class="pe pe-7s-coffee pull-left" style="color: white"></i> INTERRUPCION POR AUSENCIA</h3>
						        			</div>
						        	</a>
				    			</div>
							</div>
						</div>

            			<div class="col-md-4">
	                		<div class="hpanel">
	                    		<div class="panel-body" style="background-color: #74d348!important">
		                        	<a class="btnmenu" href="javascript:void(0)" id="btnVerProg" title="Click para ver las novedades en las que se encuentra involucrado" style="color: white">
		                        			<div class="text-center">
					                            <h3><i class="pe-7s-note2 pull-left" style="color: white"></i> Mi Programación</h3>
		                        			</div>
		                        	</a>
		                    	</div>
		                	</div>
	            		</div>
					
						<div class="col-md-4">
							<div class="hpanel hbgblue">
								<div class="panel-body">
							        	<a class="btnmenu" href="javascript:void(0)" id="btnVerServicios" title="Click para ver los servicios autorizadoss" style="color: white">
							        			<div class="text-center">
							                        <h3><i class="pe pe-7s-scissors pull-left" style="color: white"></i> Mis Servicios</h3>
							        			</div>
							        	</a>
								</div>
							</div>
						</div>
						<div class="col-md-4">
	                		<div class="hpanel hbgblue">
	                    		<div class="panel-body">
		                        	<a class="btnmenu" href="solicitudes.php" id="btnsol" title="Click para gestionar sus solicitudes" style="color: white">
	                        			<div class="text-center">
				                            <h3><i class="pe-7s-phone pull-left" style="color: white"></i> Mis Solicitudes</h3>
	                        			</div>
		                        	</a>
	                    		</div>
	                		</div>
        				</div>';
			     	}
			     	else
			     	{
		     			$html.='
								<div class="col-md-4">
									<div class="hpanel">
										<div class="panel-body" style="background-color: #34495e!important">
											<a class="btnmenu" href="javascript:void(0)" id="btnVerBio" title="" style="color: white">
												<div class="text-center">
													<h3><i class="pe-7s-display1 pull-left" style="color: white"></i> AJUSTE DE CONTRATO</h3>
												</div>
											</a>
										</div>
									</div>
								</div>

						          <!--<div class="col-md-4">
			                			<div class="hpanel hbgyellow">
			                    			<div class="panel-body">
						                        	<a class="btnmenu" href="javascript:void(0)" id="btnVerNov" title="" style="color: white">
						                        			<div class="text-center">
									                            <h3><i class="pe pe-7s-note2 pull-left" style="color: white"></i> NOVEDADES</h3>
						                        			</div>
						                        	</a>
			                    		</div>
			                		</div>
		            			</div>-->

		            			<div class="col-md-4">
									<div class="hpanel hbgred">
										<div class="panel-body">
											<a class="btnmenu" href="javascript:void(0)" id="btnVerPermisos" title="Click para ver la programación de ausencias" style="color: white">
												<div class="text-center">
													<h3><i class="pe pe-7s-coffee pull-left" style="color: white"></i> INTERRUPCION POR AUSENCIA </h3>
												</div>
											</a>
										</div>
									</div>
								</div>

		            			</div>

		            			<div class="row">
								

			            			<div class="col-md-4">
				                		<div class="hpanel">
				                    		<div class="panel-body" style="background-color: #74d348!important">
					                        	<a class="btnmenu" href="javascript:void(0)" id="btnVerProg" title="Click para ver su programacion" style="color: white">
				                        			<div class="text-center">
							                            <h3><i class="pe-7s-note2 pull-left" style="color: white"></i> MI PROGRAMACIÓN</h3>
				                        			</div>
					                        	</a>
				                    		</div>
				                		</div>
		            				</div>

		            				<div class="col-md-4">
				                		<div class="hpanel hbgblue">
				                    		<div class="panel-body">
					                        	<a class="btnmenu" href="solicitudes.php" id="btnsol" title="Click para gestionar sus solicitudes" style="color: white">
				                        			<div class="text-center">
							                            <h3><i class="pe-7s-phone pull-left" style="color: white"></i> MIS SOLICITUDES</h3>
				                        			</div>
					                        	</a>
				                    		</div>
				                		</div>
		            				</div>
								</div>';
		     		}
     				
     					echo $html;
     			 ?>  		
      	</div>
	</div>
</div>


<!-- Footer-->
<script src="js/main.js"></script>
<script type="text/javascript">
	$(".btnmenu").click(function(e){
		$('.start').html('<center><h1 class="text-center" style="position: fixed;"><i class="fa fa-spin fa-spinner"></i> Cargando...</h1></center>');
	});	
</script>
<?php include 'footer.php'; ?>


