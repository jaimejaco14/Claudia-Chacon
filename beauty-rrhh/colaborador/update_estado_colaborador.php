<?php 
	header("content-type: application/json");
	include '../../cnx_data.php';

	$codigo 	= $_POST['c'];
	$fecha  	= $_POST['f'];
	$obser		= $_POST['o'];
	$tipo		= $_POST['t'];
	$estado 	= $_POST['estado'];
	$codigo_cle = $_POST['codigo_cle'];

	//print_r($_POST);

	$sql = mysqli_query($conn, "UPDATE btyestado_colaborador SET clefecha = '$fecha', cleobservaciones = '$obser', cletipo = '$tipo' WHERE clecodigo = $codigo_cle");

	$array = array();

	if ($sql) {
		$array[] = array(
			'query'  => '1',
			'codigo' => $codigo
		);		
	}

	echo json_encode($array);

	mysqli_close($conn);
 ?>