<?php  
	header("content-type: application/json");
	include("../../../cnx_data.php");

	$cod_salon = $_POST['id'];
	$array = array();
	$sql = mysqli_query($conn, "SELECT slnimagen, slnnombre FROM btysalon WHERE slncodigo = $cod_salon");

	$row = mysqli_fetch_object($sql);
    $array[] = array(
    	'imagen' => $row->slnimagen,
    	'nombre' => $row->slnnombre
    );

    echo json_encode($array);

	mysqli_close($conn);
 ?>