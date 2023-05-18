<?php 
include '../cnx_data.php';

	$bod = $_POST['bod'];

	$sql = mysqli_query($conn, "SELECT bodcodigo FROM btybodega_salon WHERE bodcodigo = $bod ");

	if (mysqli_num_rows($sql) > 0) {
		  echo 1;
	}

	mysqli_close($conn);
 ?>