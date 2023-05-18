<?php 
	include '../cnx_data.php';
	
	$cod = $_POST['cod'];
	$fec = $_POST['f'];
	$obse= $_POST['o'];
	$tipo= $_POST['tipo'];

	$max = mysqli_query($conn, "SELECT MAX(clecodigo) AS max FROM btyestado_colaborador");

	$row = mysqli_fetch_array($max);

	$maximo = $row['max'] + 1;


	$sql = mysqli_query($conn, "SELECT * FROM btyestado_colaborador WHERE clbcodigo = $cod AND clefecha = '$fec' AND cleestado = 1 ");

	if (mysqli_num_rows($sql) > 0) {
		echo 1;
	}else{
		$insert = mysqli_query($conn, "INSERT INTO btyestado_colaborador (clecodigo, clbcodigo, clefecha, cleobservaciones, cletipo, cleestado) VALUES($maximo, $cod, '$fec', '$obse', '$tipo', '1') ");
		if ($insert) {
			echo 2;
		}
	}

	mysqli_close($conn);
	
 ?>