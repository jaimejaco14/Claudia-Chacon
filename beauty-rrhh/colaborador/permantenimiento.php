<?php
    include '../head.php';

  	VerificarPrivilegio("AUTORIZACIONES", $_SESSION['tipo_u'], $conn);
?>
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>


<div class="content">
	<div class="row">
        <div class="col-md-12">
            <div class="hpanel panel-group">
                <div class="panel-body">
                    <div class="text-center text-muted font-bold">Personal de Mantenimiento</div>
			<button type="button" class="btn btn-warning" title="Ingresar nuevo usuario" id="btnNuevoUsuario"><i class="fa fa-plus"></i></button>
                </div>
                <div class="panel-section">                    
                   <div class="table-responsive">
                   	<table class="table table-hover table-bordered" id="tblPerMantenimiento">
                   		<thead>
                   			<tr>
                   				<th>Código</th>
                   				<th>Documento</th>
                   				<th>Usuario</th>
                   				<th>Dirección</th>
                   				<th>Fijo</th>
                   				<th>Móvil</th>
                   				<th>E-mail</th>
                   				<th>Fecha Nacimiento</th>
                   				<th>Estado</th>
                   				<th><center><i class="fa fa-edit"></i></center></th>
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

<div class="modal fade" id="modalEditar">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-edit"></i> Editar Usuario</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" role="form">
						<input type="hidden" id="codigo">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Nombres</label>
										<input type="text" class="form-control" id="nombres">
									</div>

									<div class="form-group">
										<label for="">Dirección</label>
										<input type="text" class="form-control" id="direccion">
									</div>

									<div class="form-group">
										<label for="">Móvil</label>
										<input type="number" class="form-control" id="movil">
									</div>

									<div class="form-group">
										<label for="">Fecha Nacimiento</label>
										<input type="text" class="form-control" id="fecha">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="">Apellidos</label>
										<input type="text" class="form-control" id="apellidos">
									</div>

									<div class="form-group">
										<label for="">E-mail</label>
										<input type="text" class="form-control" id="email">
									</div>

									<div class="form-group">
										<label for="">Fijo</label>
										<input type="number" class="form-control" id="fijo">
									</div>
								</div>
							</div>
						</div>				
					
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="btnGuardarCambios">Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modalNuevoUsuario">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Nuevo Usuario Mantenimiento</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" role="form">
						<input type="hidden" id="codigo">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Tipo de Documento</label>
										<select name="" id="newTipoDoc" class="form-control">
		                                                <?php 
		                                                     $sql = mysqli_query($conn, "SELECT * FROM btytipodocumento WHERE tdiestado = 1 ORDER BY tdialias");

		                                                     	while($row = mysqli_fetch_array($sql))
		                                                     	{
		                                                       	echo '<option value="'.$row['tdicodigo'].'">'.ucwords(strtolower(utf8_encode($row['tdinombre']))).'</option>';                                                   
		                                                     	}

		                                                ?>
                                              </select>
									</div>

									<div class="form-group">
										<label for="">Nombres</label>
										<input type="text" class="form-control" id="newNombres">
									</div>

									<div class="form-group">
										<label for="">Dirección</label>
										<input type="text" class="form-control" id="newDireccion">
									</div>

									<div class="form-group">
										<label for="">Tel Fijo</label>
										<input type="text" class="form-control" id="newFijo">
									</div>

									<div class="form-group">
										<label for="">Fecha de Nacimiento</label>
										<input type="text" class="form-control" id="newFecha" placeholder="0000-00-00">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="">Ingrese Documento</label>
										<input type="number" class="form-control" id="newDocumento">
									</div>

									<div class="form-group">
										<label for="">Apellidos</label>
										<input type="text" class="form-control" id="newApellidos">
									</div>

									<div class="form-group">
										<label for="">Móvil</label>
										<input type="number" class="form-control" id="newMovil">
									</div>

									<div class="form-group">
										<label for="">E-mail</label>
										<input type="text" class="form-control" id="newEmail">
									</div>
								</div>
							</div>
						</div>				
					
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="btnGuardarNewUsuario">Guardar</button>
			</div>
		</div>
	</div>
</div>

<?php include "../librerias_js.php"; ?>
<script src="js/permantenimiento.js"></script>