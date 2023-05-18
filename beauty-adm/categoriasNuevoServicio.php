<?php 
include '../cnx_data.php';

$codGrupo = $_REQUEST["codigoGrupo"];
$codSubgrupo = $_REQUEST["codigoSubgrupo"];
$codLinea = $_REQUEST["codigoLinea"];
$codSublinea = $_REQUEST["codigoSublinea"];
$codCaracteristica = $_REQUEST["codCaracteristica"];

//Obtener subgrupos para el servicio
if((!empty($codGrupo)) && (empty($codSubgrupo)) && (empty($codLinea)) && (empty($codSublinea)) && (empty($codCaracteristica))){

	$subgrupos = array();
	$resulQuerySubgrupos = $conn->query("SELECT sbgcodigo AS codigoSubgrupo, sbgnombre AS nombreSubgrupo FROM btysubgrupo WHERE grucodigo = '$codGrupo' AND sbgestado = 1");

	if(($resulQuerySubgrupos != false) && (mysqli_num_rows($resulQuerySubgrupos) > 0)){

		while($registrosSubgrupos = $resulQuerySubgrupos->fetch_array()){

			$subgrupos[] = array(
								"codigo" => $registrosSubgrupos["codigoSubgrupo"],
								"nombre" => $registrosSubgrupos["nombreSubgrupo"]
						);
		}

		echo json_encode(array("result" => "full", "dataSubgrupos" => $subgrupos));
	}
	else{

		echo json_encode(array("result" => "error"));
	}
}
//Obtener lineas para el servicio
elseif((empty($codGrupo)) && (!empty($codSubgrupo)) && (empty($codLinea)) && (empty($codSublinea)) && (empty($codCaracteristica))){

	$lineas = array();
	$resulQueryLineas = $conn->query("SELECT lincodigo AS codigoLinea, linnombre AS nombreLinea FROM btylinea WHERE sbgcodigo = '$codSubgrupo' AND linestado = 1");

	if(($resulQueryLineas != false) && (mysqli_num_rows($resulQueryLineas) > 0)){

		while($registrosLineas = $resulQueryLineas->fetch_array()){

			$lineas[] = array(
								"codigo" => $registrosLineas["codigoLinea"],
								"nombre" => $registrosLineas["nombreLinea"]
						);
		}

		echo json_encode(array("result" => "full", "dataLineas" => $lineas));
	}
	else{

		echo json_encode(array("result" => "error"));
	}
}
//Obtener sublineas para el servicio
elseif((empty($codGrupo)) && (empty($codSubgrupo)) && (!empty($codLinea)) && (empty($codSublinea)) && (empty($codCaracteristica))){

	$sublineas = array();
	$resulQuerySublineas = $conn->query("SELECT sblcodigo AS codigoSublinea, sblnombre AS nombreSublinea FROM btysublinea WHERE lincodigo = '$codLinea' AND sblestado = 1");

	if(($resulQuerySublineas != false) && (mysqli_num_rows($resulQuerySublineas) > 0)){

		while($registrosSublineas = $resulQuerySublineas->fetch_array()){

			$sublineas[] = array(
								"codigo" => $registrosSublineas["codigoSublinea"],
								"nombre" => $registrosSublineas["nombreSublinea"]
						);
		}

		echo json_encode(array("result" => "full", "dataSublineas" => $sublineas));
	}
	else{

		echo json_encode(array("result" => "error"));
	}
}
//Obtener caracteristicas para el servicio
else{

	$caracteristicas = array();
	$resulQueryCaracteristicas = $conn->query("SELECT crscodigo AS codigoCaracteristica, crsnombre AS nombreCaracteristica FROM btycaracteristica WHERE sblcodigo = '$codSublinea' AND crsestado = 1");

	if(($resulQueryCaracteristicas != false) && (mysqli_num_rows($resulQueryCaracteristicas) > 0)){

		while($registrosCaracteristicas = $resulQueryCaracteristicas->fetch_array()){

			$caracteristicas[] = array(
								"codigo" => $registrosCaracteristicas["codigoCaracteristica"],
								"nombre" => $registrosCaracteristicas["nombreCaracteristica"]
						);
		}

		echo json_encode(array("result" => "full", "dataCaracteristicas" => $caracteristicas));
	}
	else{

		echo json_encode(array("result" => "error"));
	}
}
?>