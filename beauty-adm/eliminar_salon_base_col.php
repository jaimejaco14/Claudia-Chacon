<?php 
	include '../cnx_data.php';

	$cod_col   = $_POST['cod_col'];
	$cod_sln   = $_POST['cod_sln'];
	$cod_desde = $_POST['cod_desde'];

	$sql = mysqli_query($conn,"DELETE FROM btysalon_base_colaborador WHERE clbcodigo = $cod_col AND slncodigo = $cod_sln AND slcdesde = '$cod_desde'");
	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);
 ?>