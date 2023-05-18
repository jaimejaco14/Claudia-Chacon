<?php 
	session_start();
  include '../../../cnx_data.php';

	$colaborador 	= $_SESSION['clbcodigo'];
	$fecde 		= $_POST['fecde'];
	$horade 		= $_POST['horade'];
	$fhasta 		= $_POST['fhasta'];
	$hhasta 		= $_POST['hhasta'];
	$observ 		= $_POST['observ'];

	$sql = mysqli_query($conn, "SELECT MAX(percodigo) AS maxpermiso FROM btypermisos_colaboradores");

	$row = mysqli_fetch_array($sql);

	$maxpermiso = $row['maxpermiso'] + 1;

	$query = mysqli_query($conn, "INSERT INTO btypermisos_colaboradores (percodigo, slncodigo, perfecha_registo, perhora_registro, perobservacion_registro, clbcodigo, perfecha_desde, perhora_desde, perfecha_hasta, perhora_hasta, usucodigo_registro, usucodigo_autorizacion, perfecha_autorizacion, perhora_autorizacion, perestado_tramite, perestado,perobservacion_autorizacion) VALUES($maxpermiso, '".$_SESSION['PDVslncodigo']."', CURDATE(), CURTIME(), '$observ',  '$colaborador', '$fecde', '$horade', '$fhasta', '$hhasta', '".$_SESSION['PDVcodigoUsuario']."', '".$_SESSION['PDVcodigoUsuario']."', NULL, NULL, 'REGISTRADO', 1, '') ")or die(mysqli_error($conn));

	if ($query) 
	{
		echo $maxpermiso;
	}

 ?>