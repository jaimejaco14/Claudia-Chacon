<?php 
session_start();
$idact=$_GET['idact'];
if(isset($_SESSION['auth'])){
	if($_SESSION['auth']!='OK'){
		session_destroy();
		header('location:../activos.php?idact='.$idact);
		exit;
	}
}else{
	session_destroy();
	header('location: ../activos.php?idact='.$idact);
	exit;
}
include '../../cnx_data.php';
$sql="SELECT p.pgmconsecutivo,a.actcodigo,a.actnombre,p.pgmfecha,p.pgmtipo, CONCAT(al.lugnombre,' - ',aa.arenombre) AS ubicacion, p.pgmestado
				FROM btyactivo_programacion p
				JOIN btyactivo a ON a.actcodigo=p.actcodigo
				JOIN btyactivo_ubicacion au ON au.actcodigo=a.actcodigo AND au.ubchasta IS NULL
				JOIN btyactivo_area aa ON aa.arecodigo=au.arecodigo
				JOIN btyactivo_lugar al ON al.lugcodigo=aa.lugcodigo
				WHERE p.pgmfecha = CURDATE() AND p.actcodigo=$idact AND p.pgmestado NOT IN ('EJECUTADO','CANCELADO')";
$res=$conn->query($sql);
?> 
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="shortcut icon" type="image/ico" href="../../contenidos/imagenes/favicon.png" />
	    <link rel="stylesheet" href="../../lib/vendor/fontawesome/css/font-awesome.css" />
	    <link rel="stylesheet" href="../../lib/vendor/bootstrap/dist/css/bootstrap.css" />
	    <link rel="stylesheet" href="../../lib/vendor/animate.css/animate.css" />

	    <link rel="stylesheet" href="../../lib/vendor/sweetalert/lib/sweet-alert.css" />

	    <script src="../../lib/vendor/jquery/dist/jquery.min.js"></script>
		<script src="../../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
		<script src="../../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="../../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>
	</head>
	<body>
<?php
if($res->num_rows>0){
	$row=$res->fetch_array();
?>
		<h2 class="text-center">Orden de servicio</h2>
		<div class="container" id="detorden">
			<input type="hidden" id="pgmcon" value="<?php echo $row['pgmconsecutivo'];?>">
			<table class="table table-bordered">
				<tbody>
	                <tr><th>Activo:</th><td><?php echo $row['actnombre'];?></td></tr>
	                <tr><th>Ubicación:</th><td><?php echo $row['ubicacion'];?></td></tr>
	                <tr><th>Actividad:</th><td><?php echo $row['pgmtipo'];?></td></tr>
	            </tbody>
			</table>
			<div class="form-group">
				<label for="txtobs">Observaciones/Comentarios/Hallazgos</label>
				<textarea id="txtobs" class="form-control" cols="30" rows="10" style="resize: none;" placeholder="Describa el estado en que encontró el activo, procedimiento ejecutado, repuestos usados, etc."></textarea>
			</div>
			<div class="form-group">
				<!-- <button id="btnpause" class="btn btn-warning">PAUSAR</button> -->
				<button id="btnexe" class="btn btn-success">Guardar</button>
			</div>
		</div>
		<div class="container" id="ejecutado" style="display:none;">
			<a href="../activos.php?idact=<?php echo $idact;?>" class="btn btn-info" >Regresar...</a>
		</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#txtobs").focus();
	});
	$("#btnexe").click(function(e){
		var pgmcon=$("#pgmcon").val();
		var obs=$("#txtobs").val().trim();
		if(obs.length>4){
			$.ajax({
				url:'exeservicio.php',
				type:'POST',
				data:'opc=exe&pgmcon='+pgmcon+'&obs='+obs,
				success:function(res){
					if(res=='OK'){
						$("#detorden").hide();
						swal('Ejecutado','Se guardó su reporte y se ha cambiado el estado de la orden a EJECUTADO','success');
						$("#ejecutado").show();
					}else{
						swal('Oops!','Ha ocurrido un error. Refresque la página e intentelo nuevamente','error');
					}
				}
			})
		}else{
			swal('Falta su reporte','Debe escribir un reporte detallado de la ejecución de la orden de servicio.','warning');
		}
	})
</script>
<?php
}else{
	?>
	<div class="container">
		<h1>No hay actividades programadas para este activo hoy</h1>
		<a href="../activos.php?idact=<?php echo $idact;?>" class="btn btn-info" >Regresar...</a>
	</div>
	<?php
}
?>
	</body>
</html>