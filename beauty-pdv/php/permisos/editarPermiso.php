<?php 
	include("../../../cnx_data.php");

	$sql = mysqli_query($conn, "SELECT p.percodigo, t.trcrazonsocial, p.clbcodigo, p.perobservacion_registro, CONCAT(p.perfecha_registo, ' ', p.perhora_registro) AS fecha, p.perfecha_desde, p.perhora_desde, p.perfecha_hasta, p.perhora_hasta, t1.trcrazonsocial AS usu_reg, IF(t1.trcrazonsocial = t2.trcrazonsocial, '', t2.trcrazonsocial)as usu_aut, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE p.perfecha_autorizacion END AS fecha_autori, p.perestado_tramite AS estado_tramite FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND p.percodigo = '".$_POST['idpermiso']."' AND p.slncodigo = '".$_SESSION['PDVslncodigo']."' ORDER BY p.perestado_tramite DESC");


		$array = array();

		while ($row = mysqli_fetch_array($sql)) 
		{
			$array[] = array(
				'id' 			=> $row['percodigo'],
				'colaborador' 	=> $row['trcrazonsocial'],
				'clbcodigo' 	=> $row['clbcodigo'],
				'fechaReg' 		=> $row['fecha'],
				'Fechadesde' 	=> $row['perfecha_desde'],
				'Horadesde' 	=> $row['perhora_desde'],
				'Fechahasta' 	=> $row['perfecha_hasta'],
				'Horahasta' 	=> $row['perhora_hasta'],
				'observacion' 	=> $row['perobservacion_registro'],
				'usureg' 		=> $row['usu_reg']
			);
		}

		$array = utf8_converter($array);

		echo json_encode(array("res" => "full", "json" => $array));

		function utf8_converter($array)
		{
			array_walk_recursive($array, function(&$item, $key)
			{
				if(!mb_detect_encoding($item, 'utf-8', true)){
					$item = utf8_encode($item);
				}
			});

			return $array;
		}



	mysqli_close($conn);
?>