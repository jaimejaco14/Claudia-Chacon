<?php 
	include '../../cnx_data.php';

	$id = $_POST['id'];

	$sql = mysqli_query($conn, "UPDATE btybodega SET bodestado = 0 WHERE bodcodigo = $id ");

	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);
 ?>