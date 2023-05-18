<?php 
	
	include '../cnx_data.php';

	switch ($_REQUEST["categoria"]) {
		
		case 'grupo':
			
			$query = "SELECT grucodigo, grunombre FROM btygrupo WHERE gruestado = 1 and tpocodigo=2 ORDER BY grunombre";
			$resultQuery = $conn->query($query);

			if(mysqli_num_rows($resultQuery) > 0){

				$grupos = array();

				while($registros = $resultQuery->fetch_array()){

					$grupos[] = array("codGrupo" => $registros["grucodigo"], "nomGrupo" => utf8_encode($registros["grunombre"]));
				}

				echo json_encode(array("result" => "full", "grupos" => $grupos));
			}
			else{

				echo json_encode(array("result" => "vacio"));
			}

			break;
		
		case 'subgrupo':

			$codGrupo = $_REQUEST["codGrupo"];
			$query = "SELECT sbgcodigo, sbgnombre FROM btysubgrupo WHERE grucodigo = $codGrupo AND sbgestado = 1 ORDER BY sbgnombre";
			$resultQuery = $conn->query($query);

			if(mysqli_num_rows($resultQuery) > 0){

				$subgrupos = array();

				while($registros = $resultQuery->fetch_array()){

					$subgrupos[] = array("codSubgrupo" => $registros["sbgcodigo"], "nomSubgrupo" => utf8_encode($registros["sbgnombre"]));
				}

				echo json_encode(array("result" => "full", "subgrupos" => $subgrupos));
			}
			else{

				echo json_encode(array("result" => "vacio"));
			}

			break;

		case 'linea':

			$codSubgrupo = $_REQUEST["codSubgrupo"];
			$query = "SELECT lincodigo, linnombre FROM btylinea WHERE sbgcodigo = $codSubgrupo AND linestado = 1 ORDER BY linnombre";
			$resultQuery = $conn->query($query);

			if(mysqli_num_rows($resultQuery) > 0){

				$lineas = array();

				while($registros = $resultQuery->fetch_array()){

					$lineas[] = array("codLinea" => $registros["lincodigo"], "nomLinea" => utf8_encode($registros["linnombre"]));
				}

				echo json_encode(array("result" => "full", "lineas" => $lineas));
			}
			else{

				echo json_encode(array("result" => "vacio"));
			}

			break;

		case 'sublinea':

			$codLinea = $_REQUEST["codLinea"];
			$query = "SELECT sblcodigo, sblnombre FROM btysublinea WHERE lincodigo = $codLinea AND sblestado = 1 ORDER BY sblnombre";
			$resultQuery = $conn->query($query);

			if(mysqli_num_rows($resultQuery) > 0){

				$sublineas = array();

				while($registros = $resultQuery->fetch_array()){

					$sublineas[] = array("codSublinea" => $registros["sblcodigo"], "nomSublinea" => utf8_encode($registros["sblnombre"]));
				}

				echo json_encode(array("result" => "full", "sublineas" => $sublineas));
			}
			else{

				echo json_encode(array("result" => "vacio"));
			}

			break;

		case 'caracteristica':

			$codSublinea = $_REQUEST["codSublinea"];
			$query = "SELECT crscodigo, crsnombre FROM btycaracteristica WHERE sblcodigo = $codSublinea AND crsestado = 1 ORDER BY crsnombre";
			$resultQuery = $conn->query($query);

			if(mysqli_num_rows($resultQuery) > 0){

				$caracteristicas = array();

				while($registros = $resultQuery->fetch_array()){

					$caracteristicas[] = array("codCaracteristica" => $registros["crscodigo"], "nomCaracteristica" => utf8_encode($registros["crsnombre"]));
				}

				echo json_encode(array("result" => "full", "caracteristicas" => $caracteristicas));
			}
			else{

				echo json_encode(array("result" => "vacio"));
			}

			break;

		default:

			exit;
			break;
	}

	mysqli_close($conn);
?>