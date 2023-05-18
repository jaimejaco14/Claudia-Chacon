<?php 
	include '../cnx_data.php';

	$nombre        = trim(utf8_encode($_REQUEST["nombre"]));
	$tipo        	= trim(utf8_encode($_REQUEST["tipo"]));
	$observaciones = trim(utf8_encode($_REQUEST["observaciones"]));
	
	if(!empty($nombre)){

		$maxcodigo = "";
		$resultQueryMax = $conn->query("SELECT MAX(lprcodigo) AS maxcodigo FROM btylista_precios");

		while($registros = $resultQueryMax->fetch_array()){

			$maxcodigo = $registros["maxcodigo"];
		}

		if($maxcodigo == null){

			$maxcodigo = 1;
		}
		else{

			$maxcodigo = $maxcodigo + 1;
		}

		$resultQuery = $conn->query("INSERT INTO btylista_precios (lprcodigo, lprtipo, lprnombre, lprobservaciones, lprcreacion, lprestado) VALUES ($maxcodigo, '$tipo', '$nombre', '$observaciones', CURDATE(), 1)");

	}
	mysqli_close($conn);
?>