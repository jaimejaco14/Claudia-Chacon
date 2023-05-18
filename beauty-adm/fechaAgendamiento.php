<?php 

include '../cnx_data.php';

$fechaHoraAgendamiento    = explode(" ", $_REQUEST["fechaAgendamiento"]);
$fecha                    = $fechaHoraAgendamiento[0];
$hora                     = $fechaHoraAgendamiento[1];
$servicio                 = $_REQUEST["servicio"];
$colaboradores            = $_REQUEST["colaboradores"];
$codigoColaboradores      = array();
$colaboradoresDisponibles = array();
echo $fecha."-".$fechaHoraAgendamiento."-".$hora;

	// $query = "SELECT btyprogramacion_colaboradores.clbcodigo AS codColaborador, 
	// 			btyprogramacion_colaboradores.prgfecha AS Fecha, 
	// 			btyturno_salon.trndesde AS desde, 
	// 			btyturno_salon.trnhasta AS hasta 
	// 			FROM btyprogramacion_colaboradores 
	// 			INNER JOIN btyturno_salon 
	// 				ON btyprogramacion_colaboradores.trncodigo = btyturno_salon.trncodigo
	// 			WHERE (btyprogramacion_colaboradores.prgfecha = '$fecha') AND (TIME('$hora')) AND (btyprogramacion_colaboradores.clbcodigo = '$colaborador')";
	$query = "SELECT btyprogramacion_colaboradores.clbcodigo AS codColaborador, 
	 			btyprogramacion_colaboradores.prgfecha AS Fecha, 
	 			btyturno.trndesde AS desde, 
	 			btyturno.trnhasta AS hasta 
	 			FROM btyprogramacion_colaboradores 
	 			INNER JOIN btyturno 
	 			ON btyprogramacion_colaboradores.trncodigo = btyturno.trncodigo
				WHERE (btyprogramacion_colaboradores.prgfecha = '$fecha') AND (TIME('$hora'))";
	$resultadoQuery = $conn->query($query);

	while($registros = $resultadoQuery->fetch_array()){

		$codigoColaboradores[] =  $registros["codColaborador"];
	}


$query2 = "SELECT CONCAT(btytercero.trcnombres,' ',btytercero.trcapellidos) AS nombreColaborador,
					btycolaborador.clbcodigo AS codigoColaborador
					FROM btytercero
					INNER JOIN btycolaborador
					ON btytercero.trcdocumento = btycolaborador.trcdocumento
					WHERE btycolaborador.clbcodigo IN (";

foreach($codigoColaboradores as $codigoColaborador){

	$query2 .= $codigoColaborador.", ";
}

$query2 = trim($query2, ", ").")";

$resultadoQuery2 = $conn->query($query2);

if(($resultadoQuery2 != false) && mysqli_num_rows($resultadoQuery2) > 0){

	while($registros2 = $resultadoQuery2->fetch_array()){

		$colaboradoresDisponibles[] = array(
										"codigoColaborador" => $registros2["codigoColaborador"],
										"nombreColaborador" => $registros2["nombreColaborador"]
										);
	}

	echo json_encode(array("result" => "full", "data" => $colaboradoresDisponibles));
} else {

	echo json_encode(array("result" => "error"));
}
?>