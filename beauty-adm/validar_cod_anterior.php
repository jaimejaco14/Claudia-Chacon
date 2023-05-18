<?php 
include '../cnx_data.php';

	$cod_anterior = $_POST['cod_ant'];
	if ($_POST['caso'] == 1) {
		
		$cod_ant = mysqli_query($conn, "SELECT procodigoanterior FROM btyproducto WHERE procodigoanterior = $cod_anterior");
	    if (mysqli_num_rows($cod_ant) > 0) {
	        echo 1;
	    }
	}else{
		$cod_ant = mysqli_query($conn, "SELECT procodigoanterior FROM btyproducto WHERE procodigoanterior = $cod_anterior");
	    if (mysqli_num_rows($cod_ant) > 0) {
	        echo 1;
	    }
	}


    mysqli_close($conn);
 ?>