<?php 
	
	/*include "conexion.php";
	$sln_nom = $_POST['sln_name'];

	if ($sln_nom != "") {

		$sln_dir = $_POST['sln_dir'];
		$fijo = $_POST['sln_fijo'];
		$movil = $_POST['sln_movil'];
		$email = $_POST['sln_email'];
		$size = $_POST['sln_size'];
		$fecha = $_POST['sln_fecha_apert'];
		$alias = $_POST['sln_alias'];

		if ($_FILES['imagen']['name'] == ""){
			$img = "default.jpg";

		} else {
			$img = $_FILES['imagen']['name'];
		}

		


	}

	echo "true";

	$sql = "SELECT max(slncodigo) as m, count(*) as c FROM `btysalon`";

		$result = $conn->query($sql);


		if ($result->num_rows > 0){

			while ($row->fech_assoc()) {
				$nun = $row['c'];

				if ($num == 0){

					$codigo = 0;

				} else {

					$codigo = $row['m'];
				}
			}
		}
//$codigo = $codigo + 1;
		echo $codigo;*/
		//echo "false";