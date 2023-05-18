<?php 
	include '../cnx_data.php';

	$nombre = $_POST['nombre'];
	$alias	= $_POST['alias'];

	$val_max = mysqli_query($conn, "SELECT MAX(bodcodigo) AS max FROM btybodega");
	$row = mysqli_fetch_array($val_max);
	$maxid = $row[0]+1;


	$sql = mysqli_query($conn, "SELECT bodnombre FROM btybodega WHERE bodnombre = '$nombre'");

		if (mysqli_num_rows($sql) > 0) {
			echo 1;
		}else{
			$sql2 = mysqli_query($conn, "SELECT bodalias FROM btybodega WHERE bodalias = '$alias'");

			if (mysqli_num_rows($sql2) > 0) {
				 echo 2;
			}else{
				$sql3 = mysqli_query($conn, "INSERT INTO btybodega (bodcodigo, bodnombre, bodalias, bodestado) VALUES($maxid, '$nombre', '$alias', 1)");
				if ($sql3) {
					echo 3;
				}
			}
		}


	

?>