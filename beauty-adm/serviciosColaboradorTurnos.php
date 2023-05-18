<?php 
	include "../cnx_data.php";

	$codColaborador = $_REQUEST["codColaborador"];

	if($_REQUEST["buscar"] == "no"){

		$query          = "SELECT servicio.sercodigo, servicio.sernombre, servicio.seralias, servicio.serduracion, servicio.serpreciofijo, caracteristica.crscodigo, caracteristica.crsnombre, colaborador.clbcodigo, tercero.trcrazonsocial FROM btyservicio_colaborador INNER JOIN btycolaborador colaborador ON btyservicio_colaborador.clbcodigo = colaborador.clbcodigo INNER JOIN btytercero tercero ON colaborador.trcdocumento = tercero.trcdocumento INNER JOIN btyservicio servicio ON btyservicio_colaborador.sercodigo = servicio.sercodigo INNER JOIN btycaracteristica caracteristica ON servicio.crscodigo = caracteristica.crscodigo WHERE colaborador.clbcodigo = $codColaborador AND servicio.serstado = 1 ORDER BY colaborador.clbcodigo";
	}
	else{
		
		$nombreServicio = $_REQUEST["nombreServicio"];
		$query = "SELECT servicio.sercodigo, servicio.sernombre, servicio.seralias, servicio.serduracion, servicio.serpreciofijo, caracteristica.crscodigo, caracteristica.crsnombre, colaborador.clbcodigo, tercero.trcrazonsocial FROM btyservicio_colaborador INNER JOIN btycolaborador colaborador ON btyservicio_colaborador.clbcodigo = colaborador.clbcodigo INNER JOIN btytercero tercero ON colaborador.trcdocumento = tercero.trcdocumento INNER JOIN btyservicio servicio ON btyservicio_colaborador.sercodigo = servicio.sercodigo INNER JOIN btycaracteristica caracteristica ON servicio.crscodigo = caracteristica.crscodigo WHERE servicio.sernombre LIKE '%$nombreServicio%' AND (colaborador.clbcodigo = $codColaborador AND servicio.serstado = 1) ORDER BY colaborador.clbcodigo";
	}

	$resultQuery    = $conn->query($query);
	$servicios      = array();

	if($resultQuery != false){

		while($registros = $resultQuery->fetch_array()){

			$servicios[] = array(
							"nombre"         => $registros["sernombre"],
							"duracion"       => $registros["serduracion"],
							"precioFijo"     => $registros["serpreciofijo"],
							"caracteristica" => $registros["crsnombre"],
							"alias"          => $registros["seralias"]);
		}

		echo json_encode(array("result" => "full", "servicios" => $servicios));
	}
	else{

		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>