<?php 
	include '../cnx_data.php';

	$id 			= $_POST['id'];
	$nombre_bod 	= $_POST['nombre_bod'];
	$nombre_alias 	= $_POST['nombre_alias'];

	$cons = mysqli_query($conn, "SELECT bodnombre FROM btybodega WHERE bodnombre = '$nombre_bod'");

	if (mysqli_num_rows($cons) > 0) {
		echo 1;
	}else{

		$cons2 = mysqli_query($conn, "SELECT * FROM btybodega WHERE bodalias = '$nombre_alias' ");

		if (mysqli_num_rows($cons2) > 0) {
			echo 2;
		}else{

			$sql = mysqli_query($conn, "UPDATE btybodega SET bodnombre = '".strtoupper($nombre_bod)."', bodalias = '".strtoupper($nombre_alias)."' WHERE bodcodigo = $id ");

			if ($sql) {
				echo 3;
			}
		}

	}


	mysqli_close($conn);
 ?>