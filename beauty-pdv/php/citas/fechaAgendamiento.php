<?php 

include("../../../cnx_data.php");
include("../funciones.php");

$fechaHoraAgendamiento    = explode(" ", $_REQUEST["fechaAgendamiento"]);
$fecha                    = $fechaHoraAgendamiento[0];
$hora                     = $fechaHoraAgendamiento[1];
$servicio                 = $_REQUEST["servicio"];
$colaboradores            = $_REQUEST["colaboradores"];
$codigoColaboradores      = array();
$colaboradoresDisponibles = array();

$query = "SELECT btyprogramacion_colaboradores.clbcodigo AS codColaborador, btyprogramacion_colaboradores.prgfecha AS Fecha, ter.trcrazonsocial, btyturno.trndesde AS desde, crg.crgnombre, btyturno.trnhasta AS hasta FROM  btyprogramacion_colaboradores INNER JOIN btyturno ON btyprogramacion_colaboradores.trncodigo = btyturno.trncodigo JOIN btycolaborador col ON col.clbcodigo=btyprogramacion_colaboradores.clbcodigo JOIN btytercero ter ON ter.trcdocumento=col.trcdocumento JOIN btycargo crg ON crg.crgcodigo=col.crgcodigo JOIN btyservicio_colaborador ser ON ser.clbcodigo=col.clbcodigo WHERE (btyprogramacion_colaboradores.prgfecha = '$fecha') AND (TIME('$hora')) AND crg.crgincluircolaturnos = 1 AND ser.sercodigo = '$servicio'";


	$resultadoQuery = $conn->query($query);

	while($registros = $resultadoQuery->fetch_array())
	{

		$codigoColaboradores[] =  $registros["codColaborador"];
	}


	$query2 = "SELECT CONCAT(btytercero.trcnombres,' ',btytercero.trcapellidos) AS nombreColaborador, btycolaborador.clbcodigo AS codigoColaborador FROM btytercero INNER JOIN btycolaborador ON btytercero.trcdocumento = btycolaborador.trcdocumento WHERE btycolaborador.clbcodigo IN (";



	/*******************************************************/
	
	//What The Hell????

	/*
		||||||||||||||
		||||||||||||||
		||||||  ||||||
		 ||||||||||||
		  |||||||||
		   |||||||
		     |||
		      |

	*/

	foreach($codigoColaboradores as $codigoColaborador)
	{
		$query2 .= $codigoColaborador.", ";
	}

	$query2 = trim($query2, ", ").")";

	/*******************************************************/

	$resultadoQuery2 = $conn->query($query2);

	if(($resultadoQuery2 != false) && mysqli_num_rows($resultadoQuery2) > 0)
	{

		while($registros2 = $resultadoQuery2->fetch_array())
		{

			$colaboradoresDisponibles[] = array(
				"codigoColaborador" => $registros2["codigoColaborador"],
				"nombreColaborador" => $registros2["nombreColaborador"]
			);
		}

		$colaboradoresDisponibles= utf8_converter($colaboradoresDisponibles);

		echo json_encode(array("result" => "full", "data" => $colaboradoresDisponibles));
	} 
	else 
	{
		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>