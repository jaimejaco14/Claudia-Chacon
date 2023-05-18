<?php 
	//header("content-type: application/json");
include '../cnx_data.php';

	$precio      	= $_POST['precio'];
	$salon       	= $_POST['salon'];
	$tipo			= $_POST['tipo'];
	$fecha_desde 	= $_POST['fecha_desde'];
	$fecha_hasta 	= $_POST['fecha_hasta'];
	$observaciones 	= $_POST['observaciones'];
    $array          = array();



    /*mysqli_query($conn, "SET @numero=0;");
    $consulta = mysqli_query($conn, "SELECT @numero:=@numero+1 AS posicion, lprcodigo, slncodigo, lpsobservaciones, lpsdesde, lpshasta, lpscreacion from  btylista_precios_salon");

    $r = mysqli_fetch_array($consulta);

*/

    //$query = mysqli_query($conn, "SELECT * FROM btylista_precios_salon WHERE lpshasta = '$fecha_hasta' AND slncodigo = $salon");

    if ($fecha_hasta == null || $fecha_hasta == "") {
		$sql = mysqli_query($conn, "UPDATE btylista_precios_salon SET lprcodigo = $precio, lpsobservaciones = '$observaciones', lpsdesde = '$fecha_desde', lpshasta = null WHERE slncodigo = $salon AND lprcodigo = $precio")or die(mysqli_error($conn));

		if ($sql) {
			echo 1;
		}	
    	
    }else{
    	$sql = mysqli_query($conn, "UPDATE btylista_precios_salon SET lprcodigo = $precio, lpsobservaciones = '$observaciones', lpsdesde = '$fecha_desde', lpshasta = '$fecha_hasta' WHERE slncodigo = $salon AND lprcodigo = $precio")or die(mysqli_error($conn));

		if ($sql) {
			echo 1;
		}
    }



		
	

	/*while ($t = mysqli_fetch_object($consulta)) {
		$array[] = array(
			'cod' => $t->lprcodigo
		);
	}

	echo json_encode($array);*/

	/*$sql = mysqli_query($conn, "UPDATE btylista_precios_salon SET lprcodigo = $precio, lpsobservaciones = '$observaciones', lpsdesde = '$fecha_desde', lpshasta = '$fecha_hasta' WHERE slncodigo = $salon ")or die(mysqli_error($conn));

	if ($sql) {
		echo 1;
	}*/

	mysqli_close($conn);

 ?>