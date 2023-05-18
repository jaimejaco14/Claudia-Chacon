<?php 
include("../../../cnx_data.php");

mysqli_query( $conn, "SET lc_time_names = 'es_CO'" ); 



$salon            = $_GET["salon"];
$queryCitas       = "SELECT a.clbcodigo, ter.trcrazonsocial, s.slnnombre, a.trncodigo, a.horcodigo, a.slncodigo, a.ptrcodigo, tur.trnnombre, DATE_FORMAT(a.prgfecha, '%d de %M de %Y') AS fecha2, a.prgfecha, hor.hordia, hor.hordesde, hor.horhasta, a.tprcodigo, b.tprnombre, b.tprlabora, pt.ptrnombre, col.cblimagen, car.crgnombre FROM btyprogramacion_colaboradores a JOIN btytipo_programacion b ON b.tprcodigo=a.tprcodigo JOIN btysalon s ON a.slncodigo=s.slncodigo JOIN btycolaborador col ON col.clbcodigo=a.clbcodigo JOIN btytercero ter ON ter.trcdocumento=col.trcdocumento JOIN btyturno tur ON a.trncodigo=tur.trncodigo JOIN btypuesto_trabajo pt ON a.ptrcodigo=pt.ptrcodigo JOIN btyhorario hor ON a.horcodigo=hor.horcodigo JOIN btyestado_colaborador estado ON col.clbcodigo=estado.clbcodigo JOIN btycargo car ON car.crgcodigo=col.crgcodigo WHERE a.slncodigo = $salon";

	$resultadoQueryCitas = $conn->query($queryCitas);

	if($resultadoQueryCitas != false){
		if(mysqli_num_rows($resultadoQueryCitas) > 0){

			$progr = array();

			while($registros = $resultadoQueryCitas->fetch_array()){


				$progr[] = 	array(
								"codColaborador" => $registros["clbcodigo"],
								"colaborador"    => utf8_encode($registros["trcrazonsocial"]),
								"salon"          => utf8_encode($registros["slnnombre"]),
								"codSalon"       => $registros["slncodigo"],
								"turno"          => utf8_encode($registros["trnnombre"]),
								"fecha"          => $registros["prgfecha"],
								"fecha2"         => $registros["fecha2"],
								"dia"            => $registros["hordia"],
								"desde"          => $registros["hordesde"],
								"hasta"          => $registros["horhasta"],
								"tipo_pro"       => utf8_encode($registros["tprnombre"]),
								"puesto_tr"      => utf8_encode($registros["ptrnombre"]),
								"imagen"         => $registros["cblimagen"],
								"cargo"          => $registros["crgnombre"]
							);
			}
		


				echo json_encode(array("result" => "full", "progr" => $progr));

		}else{
			echo json_encode(array("result" => "vacio"));
		}


	}else{

		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>