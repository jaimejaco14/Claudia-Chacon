<?php 
	include("./head.php");
	include("./php/conexion.php");

    VerificarPrivilegio("DIRECTORIO (PDV)", $_SESSION['PDVtipo_u'], $conn);
    RevisarLogin();
    
	include("./librerias_js.php");
	$cod_salon = $_SESSION['PDVslncodigo'];
    $salon     = $_SESSION['PDVslnNombre'];
 ?>

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
                        <span>Directorio</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Directorio
            </h2>
            <input type="text" id="txt_buscar" class="form-control" style="width: 50%" pattern="" title="Buscar contacto" placeholder="Buscar contacto">
        </div>
    </div>
</div>

<div class="content">
	<div class="row">
	    <div class="col-lg-12">
	        <div class="hpanel">
	            <ul class="nav nav-tabs">
	                <li class="active list"><a data-toggle="tab" href="#listado"> Listado</a></li>
	                <li class="nuevo"><a data-toggle="tab" href="#nuevo">Nuevo</a></li>
                    <li class="new disabled" disabled="disabled" style="display: none"><a data-toggle="tab" class="disabled" href="#editar">Editar</a></li>
                    <span class="label label-success cnt pull-right" id="spanCount"></span>
	            </ul>
	            <div class="tab-content">
	                <div id="listado" class="tab-pane active">
	                    <div class="panel-body">
	                        <div class="row">
                                <div id="contactos_lista"></div>
                            </div>
                            <div class="row">
                                <center>
                                    <ul class="pagination" id="paginacion_contacto">

                                    </ul>
                                </center>
                            </div>	                       
	                    </div>
	                </div>
	                 <div id="nuevo" class="tab-pane">
                    	<div class="panel-body">
                            <div class="col-md-6 col-md-offset-3">
                        	<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Registrar Contacto</h3>
                                </div>
                                <div class="panel-body">
                                    
                                <form action="" method="POST" role="form">                              
                                    <div class="form-group">
                                        <label for="">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" placeholder="Digite nombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Móvil</label>
                                        <input type="number" class="form-control" id="movil" placeholder="Digite Móvil">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Fijo</label>
                                        <input type="number" class="form-control" id="fijo" placeholder="Digite teléfono fijo">
                                    </div>
                                    <div class="form-group">
                                        <label for="">E-mail</label>
                                        <input type="email" class="form-control" id="email" placeholder="Digite e-mail">
                                    </div>
                                    <button type="button" id="btneviar" class="btn btn-info pull-right">Ingresar</button>
                                </form>
                            </div>
                                </div>
                            </div>
                    	</div>
                     </div>
                     <div id="editar" class="tab-pane panel-edit">
                        <div class="panel-body">
                            <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Editar Datos</h3>
                                </div>
                                <div class="panel-body">
                                    
                                <form action="" method="POST" role="form">
                                    <input type="hidden" id="id">                              
                                    <div class="form-group">
                                        <label for="">Nombre</label>
                                        <input type="text" class="form-control" id="editnombre" placeholder="Digite nombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Móvil</label>
                                        <input type="number" class="form-control" id="editmovil" placeholder="Digite Móvil">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Fijo</label>
                                        <input type="number" class="form-control" id="editfijo" placeholder="Digite teléfono fijo">
                                    </div>
                                    <div class="form-group">
                                        <label for="">E-mail</label>
                                        <input type="email" class="form-control" id="editemail" placeholder="Digite e-mail">
                                    </div>
                                    <button type="button" id="btnmodificar" class="btn btn-info pull-right">Modificar</button>
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

<script src="js/directorio.js"></script>
<script src="js/sube_baja.js"></script>
