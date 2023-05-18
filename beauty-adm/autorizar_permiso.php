<?php 
	session_start();
	include '../cnx_data.php';

	$idpermiso   = $_POST['idpermiso'];
	$comentarios = $_POST['comentario'];
	$autorizado  = strtoupper($_POST['aut']);

	if ($_POST['aut'] == "Noautorizado") 
	{
		
		$sql = mysqli_query($conn, "UPDATE btypermisos_colaboradores SET usucodigo_autorizacion = '".$_SESSION["codigoUsuario"]."', perfecha_autorizacion = CURDATE(), perhora_autorizacion = CURTIME(), perestado_tramite = 'NO AUTORIZADO', perobservacion_autorizacion = '$comentarios' WHERE percodigo = $idpermiso ");

		if ($sql) 
		{
			echo 0;
		}
	}
	else
	{
		$sql = mysqli_query($conn, "UPDATE btypermisos_colaboradores SET usucodigo_autorizacion = '".$_SESSION["codigoUsuario"]."', perfecha_autorizacion = CURDATE(), perhora_autorizacion = CURTIME(), perestado_tramite = '$autorizado', perobservacion_autorizacion = '$comentarios' WHERE percodigo = $idpermiso ");

		if ($sql) 
		{
			echo 1;
		}
	}


	

	mysqli_close($conn);
 ?>