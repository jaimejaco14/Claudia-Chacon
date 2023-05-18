<?php 
	include '../cnx_data.php';

	$cita  = $_REQUEST["codCita"];
	$query = "SELECT cita.citcodigo AS citcodigo, estado.escnombre AS escnombre, novedad.citfecha AS nvcfecha, novedad.cithora AS nvchora, novedad.nvcobservaciones AS nvcobservaciones, tercero.trcrazonsocial AS usuarioNovedad FROM bty_vw_citas_detallado cita INNER JOIN btynovedad_cita novedad ON cita.citcodigo = novedad.citcodigo INNER JOIN btyestado_cita estado ON novedad.esccodigo = estado.esccodigo INNER JOIN btyusuario usuario ON usuario.usucodigo = novedad.usucodigo INNER JOIN btytercero tercero ON usuario.trcdocumento = tercero.trcdocumento WHERE cita.citcodigo = $cita ORDER BY cita.citcodigo, novedad.cithora, novedad.citfecha";
	$resultQueryNovedades = $conn->query($query);

	if($resultQueryNovedades != false){

		$novedades = array();

		while($registros = $resultQueryNovedades->fetch_array()){

			$novedades[] = array(
							"codCita"       => $registros["citcodigo"],
							"estado"        => $registros["escnombre"],
							"fechaNovedad"  => $registros["nvcfecha"],
							"horaNovedad"   => $registros["nvchora"],
							"observaciones" => $registros["nvcobservaciones"],
							"autorNovedad"  => $registros["usuarioNovedad"]
						);
		}

		echo json_encode(array("result" => "full", "novedades" => $novedades));
	}
	else{

		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>