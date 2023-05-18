<?php 
	include("head.php");
	include("librerias_js.php");
?>


<div class="container-fluid">
	<div class="content animate-panel">
     		<div class="row">
     			<?php
     				$html=''; 
     				if ($_SESSION['incluturno'] != 0) 
     				{
     					$html.='
						<div class="col-md-4">
				          	<div class="hpanel hbgviolet">
				                   <div class="panel-body">
				                        	<a href="javascript:void(0)" id="btnAgenda" title="Click para ver la Agenda" style="color: white">
				                        		<div class="text-center">
							                    <h3>AGENDA</h3>
						                            	<p class="text-big font-light">
						                              	<i class="pe pe-7s-pen" style="color: white"></i>
						                            	</p>
						                            	<small>
						                                	En este módulo puede ver las citas que tiene registrada
						                            	</small>
				                        		</div>
				                        	</a>
				                    </div>
				                </div>
				          </div>


				          <div class="col-md-4">
							<div class="hpanel">
								<div class="panel-body" style="background-color: #34495e!important">
									<a href="javascript:void(0)" id="btnVerBio" title="Click para ver las novedades en las que se encuentra involucrado" style="color: white">
										<div class="text-center">
											<h3>BIOMETRICO</h3>
											<p class="text-big font-light">
												<i class="pe-7s-display1" style="color: white"></i>
											</p>
											<small>
												En este módulo puede ver las novedades del biométrico.
											</small>
										</div>
									</a>
								</div>
							</div>
						</div>

				          <div class="col-md-4">
	                			<div class="hpanel hbgyellow">
	                    			<div class="panel-body">
				                        	<a href="javascript:void(0)" id="btnVerNov" title="Click para ver las novedades en las que se encuentra involucrado" style="color: white">
				                        			<div class="text-center">
							                            <!-- <h3>PROGRAMACIÓN</h3> btnVerProg  -->
							                            <h3>NOVEDADES</h3>
							                            <p class="text-big font-light">
							                              	<i class="pe pe-7s-note2" style="color: white"></i>
							                            </p>
							                            <small>				                               
							                                En este módulo puede ver las novedades.
							                            </small>
				                        			</div>
				                        	</a>
	                    		</div>
	                		</div>
            			</div>

            			</div>

            			<div class="row">
						<div class="col-md-4">
							<div class="hpanel hbgred">
				    				<div class="panel-body">
						        	<a href="javascript:void(0)" id="btnVerPermisos" title="Click para ver los permisos" style="color: white">
						        			<div class="text-center">
						                        <h3>PERMISOS</h3>
						                        <p class="text-big font-light">
						                          	<i class="pe pe-7s-coffee" style="color: white"></i>
						                        </p>
						                        <small>
						                            En este módulo puede ver los permisos.
						                        </small>
						        			</div>
						        	</a>
				    			</div>
						</div>
					</div>

            			<div class="col-md-4">
	                		<div class="hpanel">
	                    		<div class="panel-body" style="background-color: #74d348!important">
		                        	<a href="javascript:void(0)" id="btnVerProg" title="Click para ver las novedades en las que se encuentra involucrado" style="color: white">
		                        			<div class="text-center">
					                            <h3>PROGRAMACIÓN</h3>
					                            <p class="text-big font-light">
					                              	<i class="pe-7s-note2" style="color: white"></i>
					                            </p>
					                            <small>
					                                 En este módulo puede ver la programación que se le ha asignado.
					                            </small>
		                        			</div>
		                        	</a>
	                    	</div>
	                	</div>
            		</div>
				
				<div class="col-md-4">
					<div class="hpanel hbgblue">
						<div class="panel-body">
					        	<a href="javascript:void(0)" id="btnVerServicios" title="Click para ver los servicios autorizadoss" style="color: white">
					        			<div class="text-center">
					                        <h3>SERVICIOS</h3>
					                        <p class="text-big font-light">
					                          	<i class="pe pe-7s-scissors" style="color: white"></i>
					                        </p>
					                        <small>
					                            En este módulo puede ver los servicios que tiene autorizados.
					                        </small>
					        			</div>
					        	</a>
						</div>
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
									<a href="javascript:void(0)" id="btnVerBio" title="Click para ver las novedades en las que se encuentra involucrado" style="color: white">
										<div class="text-center">
											<h3>BIOMETRICO</h3>
											<p class="text-big font-light">
												<i class="pe-7s-display1" style="color: white"></i>
											</p>
											<small>
												En este módulo puede ver las novedades del biométrico.
											</small>
										</div>
									</a>
								</div>
							</div>
						</div>

				          <div class="col-md-4">
	                			<div class="hpanel hbgyellow">
	                    			<div class="panel-body">
				                        	<a href="javascript:void(0)" id="btnVerNov" title="Click para ver las novedades en las que se encuentra involucrado" style="color: white">
				                        			<div class="text-center">
							                            <!-- <h3>PROGRAMACIÓN</h3> btnVerProg  -->
							                            <h3>NOVEDADES</h3>
							                            <p class="text-big font-light">
							                              	<i class="pe pe-7s-note2" style="color: white"></i>
							                            </p>
							                            <small>				                               
							                                En este módulo puede ver las novedades.
							                            </small>
				                        			</div>
				                        	</a>
	                    		</div>
	                		</div>
            			</div>

            			<div class="col-md-4">
							<div class="hpanel hbgred">
								<div class="panel-body">
									<a href="javascript:void(0)" id="btnVerPermisos" title="Click para ver los permisos" style="color: white">
										<div class="text-center">
											<h3>PERMISOS</h3>
												<p class="text-big font-light">
													<i class="pe pe-7s-coffee" style="color: white"></i>
												</p>
												<small>
													En este módulo puede ver los permisos.
												</small>
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
			                        	<a href="javascript:void(0)" id="btnVerProg" title="Click para ver las novedades en las que se encuentra involucrado" style="color: white">
			                        			<div class="text-center">
						                            <h3>PROGRAMACIÓN</h3>
						                            <p class="text-big font-light">
						                              	<i class="pe-7s-note2" style="color: white"></i>
						                            </p>
						                            <small>
						                                 En este módulo puede ver la programación que se le ha asignado.
						                            </small>
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


<!-- Footer-->
<footer class="footer" style="position: fixed;">
    <span class="pull-right">
       <b> Derechos Reservados <script>var f = new Date(); document.write(f.getFullYear())</script>
    </span>
    <b>BEAUTY SOFT</b> 
</footer>
<script src="js/main.js"></script>


