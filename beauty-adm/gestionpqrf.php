<?php 

    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("PQRF", $_SESSION['tipo_u'], $conn);
    //RevisarLogin();
    include "librerias_js.php";
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
                    <li><a href="index.php">Inicio</a></li>
                    <li class="active">
                        <span> Gestión de PQRF</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Gestión de PQRF 
            </h2>
        </div>
    </div>
</div>

<div class="content">
	<div class="col-lg-12">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1"> Listado</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                         <div class="table-responsive">
                         	 <table class="table table-bordered table-hover" id="tblPQRF">
                         	 	<thead>
                         	 		<tr>
                         	 			<th>Código</th>
                         	 			<th>Tipo</th>
                         	 			<th>Fecha</th>
                         	 			<th>Hora</th>
                         	 			<th>Salón</th>
                         	 			<th>Nombre</th>
                         	 			<th>Estado</th>
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
<script src="js/gestionpqrf.js"></script>



<!-- Modal -->
<div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalles PQRF</h4>
      </div>
      <div class="modal-body">
      		<input type="hidden" id="codPqrf">
	      	<div class="panel panel-info">
	      		<div class="panel-heading">
	      			<h3 class="panel-title" id="fechaPQRF"></h3>
	      		</div>
	      		<div class="panel-body">
	      			<div class="col-md-6">
	      				<div class="list-group" id="listGroup">
			  
						</div>
				        <form action="" method="POST" role="form">
				          	<div class="form-group">
				          		<label for="">Descripción</label>
				          		<textarea name="" id="txtPqrf" class="form-control" rows="4" disabled style="resize: none; text-align: justify;" placeholder="Responder PQRF"></textarea>
				          	</div>

				        </form>      		
	      			</div>
	      			
			      	<div class="col-md-6">
			      		<div class="list-group" id="listGroupRes">
			  
					    </div>
			      		<textarea name="" id="txtRespuesta" class="form-control" rows="6" style="resize: none;text-align: justify;" placeholder="Digite su respuesta"></textarea>
			      		<textarea name="" id="txtRespuestaUsu" class="form-control" rows="6" style="resize: none;text-align: justify;" placeholder="Digite su respuesta"></textarea>
			      	</div>
	      		</div>
	      	</div>
      	 	 
      	 	 	
      	 	      	 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnResponder">Responder</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    //conteoPermisos ();
});
</script>

<style>
	th{
		text-align: center;
	}
</style>