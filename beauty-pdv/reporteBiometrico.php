<?php 
	include("head.php");
	include("../cnx_data.php");	
	include("librerias_js.php");
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<div class="normalheader ">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>

            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Reporte de Biométrico</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-12">
            	<div class="col-md-2">
            		<input type="text" name="" id="fechaDesdeBio" class="form-control" placeholder="Desde" required="required" pattern="" title="">
                </div>
                <div class="col-md-2">
            		<input type="text" name="" id="fechaHastaBio" class="form-control" disabled placeholder="Hasta" required="required" pattern="" title="">
                </div>
                <div class="col-md-3">
                   <select class="selectpicker" name="" id="selCargoBio" data-width="100%"  disabled title="Seleccione Cargo">    <?php 
                          $result = $conn->query("SELECT crgcodigo, crgnombre FROM btycargo WHERE crgestado = 1 ORDER BY crgnombre");
                            if ($result->num_rows > 0) {
                                    echo '<option value="0">TODOS LOS CARGOS</option>';
                                while ($row = $result->fetch_assoc()) 
                                {                
                                    echo '<option value="'.$row['crgcodigo'].'">'.$row['crgnombre'].'</option>';
                                }
                            }
                        ?>                                                                            
                    </select> 
                </div>
                <div class="col-md-3">
                    <div class="input-group m-b"><span class="input-group-addon"> <input type="checkbox" id="chkTodosBio"> </span>  <select class="selectpicker" name="" id="selColaboradorBio" disabled  data-live-search="true" data-width="100px" title="Seleccione Colaborador">           
                                                                            
                    </select></div>
                  
                </div>
                <div class="col-md-2">
                    <button type="button" id="btnFiltrarBio" class="btn btn-info pull-right">Filtrar</button>
                </div>
            </div>

            <small>Filtrar su búsqueda</small>
        </div>
    </div>
 
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="content animate-panel">
				<div class="row">
					<div class="hpanel">
						<div class="panel-heading">
				            LISTADO
				        </div>

						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-info">
										<div class="panel-heading">
											
											<h3 class="panel-title"><i class="pe-7s-note2"></i><span id="nm"></span> </h3>
										</div>
										<div class="panel-body">
											<table class="table table-hover table-bordered" id="tblListadoBio">
                                                <thead>
                                                    <tr>
                                                        <th>Colaborador</th>
                                                        <th>Cargo</th>
                                                        <th>Categoría</th>
                                                        <th>Costo</th>
                                                        <th>Acciones</th>
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
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 92%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="" id="nombreP"></h5>
      </div>
      <div class="modal-body">
          <table class="table table-hover table-bordered" id="tblListadoDetallesBio">
              <thead>
                  <tr>
                      <th>SERVICIO</th>
                      <th>CLIENTE</th>
                      <th>AGENDÓ</th>
                      <th>FECHA CITA</th>
                      <th>HORA CITA</th>
                      <th>FECHA REGISTRO</th>
                      <th>HORA REGISTRO</th>
                      <th>ESTADO</th>
                      <th>USUARIO NOVEDAD</th>
                  </tr>
              </thead>
              <tbody>
                 
              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalDetallesBio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="" id="nombrePBio"></h5>
      </div>
      <div class="modal-body">
          <table class="table table-hover table-bordered" id="tblListadoDetallesBio">
              <thead>
                  <tr>
                      <th>NOVEDAD</th>
                      <th>FECHA</th>
                      <th>TURNO</th>
                      <th>HORA</th>
                      <th>DIFERENCIA</th>
                      <th>MARCÓ</th>
                      <th>COSTO</th>
                  </tr>
              </thead>
              <tbody>
                 
              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



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
                    <!-- <label class="label label-success" id="nombreColaboradorServicio"></label> -->         
                  </div>
                  <div class="form-group">                  
                      <div id="listaData"></div>         
                  </div>
                <!--   <div class="form-group">
                  <label class="label label-warning" id="cargoColaboradorServicio"></label>
                
                </div> -->
                  
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



<script src="js/reporte.js"></script>
<script src="js/sube_baja.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>


<style>
    th,td{
        white-space: nowrap;
        font-size: .9em;
    }
    .material-switch > input[type="checkbox"] {
    display: none!important;   
}

.material-switch > label {
    cursor: pointer!important;
    height: 0px!important;
    position: relative!important; 
    width: 40px!important;  
}

.material-switch > label::before {
    background: rgb(0, 0, 0)!important;
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5)!important;
    border-radius: 8px!important;
    content: '';
    height: 16px!important;
    margin-top: -8px!important;
    position:absolute!important;
    opacity: 0.3!important;
    transition: all 0.4s ease-in-out!important;
    width: 40px!important;
}
.material-switch > label::after {
    background: rgb(255, 255, 255)!important;
    border-radius: 16px!important;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3)!important;
    content: '';
    height: 24px!important;
    left: -4px!important;
    margin-top: -8px!important;
    position: absolute!important;
    top: -4px!important;
    transition: all 0.3s ease-in-out!important;
    width: 24px!important;
}
.material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit!important;
    opacity: 0.5!important;
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit!important;
    left: 20px!important;
}
</style>