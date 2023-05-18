<?php

	include '../cnx_data.php';

	$query          = "SELECT grucodigo AS codigoGrupo,
						grunombre AS nombreGrupo
						FROM btygrupo
						WHERE tpocodigo = 2 AND gruestado = 1
						ORDER BY grunombre";
	$resultadoQuery = $conn->query($query);
	$gruposServicio = array();

	if(($resultadoQuery != false) && (mysqli_num_rows($resultadoQuery) > 0)){

		while($registros = $resultadoQuery->fetch_array()){

			$gruposServicio[] = array(
									"codigoGrupo" => $registros["codigoGrupo"],
									"nombreGrupo" => $registros["nombreGrupo"]
				);
		}
	}
?>