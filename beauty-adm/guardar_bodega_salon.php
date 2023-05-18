<?php 
	include '../cnx_data.php';

	$cod 	= $_POST['cod'];
	$bodega = $_POST['bodega'];
	$tipos  = $_POST['tipos'];

	$sql = mysqli_query($conn, "SELECT bodcodigo FROM btybodega_salon WHERE bodcodigo = $bodega ");

	if (mysqli_num_rows($sql) > 0) {
		  echo 3;
	}else{
		
		$cons = mysqli_query($conn, "SELECT bodcodigo FROM btybodega_salon WHERE bodcodigo = $bodega AND slncodigo = $cod");

		if (mysqli_num_rows($cons) > 0) {
			echo 1;

		}else{
			
			$s = mysqli_query($conn, "INSERT INTO btybodega_salon (bodcodigo, slncodigo, bostipo) VALUES($bodega, $cod, '$tipos' ) ");

			if ($s) {
				echo 2;	
			}		
		}
	}


	mysqli_close($conn);
 ?>
