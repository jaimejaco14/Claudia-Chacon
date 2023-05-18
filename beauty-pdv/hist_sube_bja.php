<?php 
	session_start();
	include("../cnx_data.php");

	$query = mysqli_query($conn, "SELECT usucodigo FROM btyusuario u INNER JOIN btyprivilegioperfil p ON u.tiucodigo = p.tiucodigo AND p.pricodigo = 41 WHERE u.trcdocumento = '".$_SESSION['documento']."' ");
	
    if (mysqli_num_rows($query) != 0) {
      
    }else{
        //header("Location: index.php"); 
    }
    
	include("head.php");
	include("librerias_js.php");
	$cod_salon = $_SESSION['cod_salon'];
	$sql = mysqli_query($conn, "SELECT slnnombre FROM btysalon WHERE slncodigo = $cod_salon");
	$s = mysqli_fetch_array($sql);
	$salon =$s[0];
?>

<input type="hidden" value="<?php echo $salon ?>" class="sln">
<input type="hidden" value="<?php echo $cod_salon ?>" id="cod_salon">


<div class="container">
	<div class="row">
		<div class="col-md-10">
			<div class="hpanel hyellow">
				<div class="panel-heading">
					<span>Histórico Sube y Baja</span>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered" id="tbl_crear_subeybaja">
							<thead>
								<tr class="active">
									<th><i class="fa fa-user"></i> Colaborador</th>
									<th><i class="fa fa-calendar-o"></i> Turno</th>
									<th><i class="fa fa-user-plus"></i> Añadir a Cola</th>
									<th><i class="fa fa-user-times" aria-hidden="true"></i> Terminar Turno</th>	
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
						<textarea name="" id="comentario" class="form-control" rows="2" placeholder="Espacio para comentarios iniciales"></textarea>

					</div>
				</div>
				<div class="panel-footer">
					<button type="button" id="btn_comentario" class="btn btn-success" disabled><i class="fa fa-edit"></i></button>
					<button type="button" id="cerrar_sube_baja" style="display:none; float: right" data-toggle="modal" data-target="#modal_cerrar_sube_baja" class="btn btn-primary">Cerrar Sube y Baja</button>
				</div>
				<span id="alerta"></span>
				
			</div>
		</div>
	</div>
</div>

