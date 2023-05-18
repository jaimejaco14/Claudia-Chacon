<?php 
	include("../cnx_data.php");


	switch ($_POST['opcion']) 
	{
		case 'cargar':
			
			$sql = mysqli_query($conn, "SELECT citcodigo, clbcodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycolaborador colaborador ON tercero.trcdocumento = colaborador.trcdocumento WHERE colaborador.clbcodigo = btycita.clbcodigo) AS clbnombre, slncodigo, (SELECT slnnombre FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slnnombre, (SELECT slndireccion FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slndireccion, sercodigo, (SELECT sernombre FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS sernombre, (SELECT CONCAT(serduracion, ' MIN')AS serduracion FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS serduracion, clicodigo,(SELECT tercero.trctelefonomovil FROM btytercero tercero INNER JOIN btycliente cliente ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo) AS movil, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycliente cliente ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo) AS clinombre, usucodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btyusuario usuario ON tercero.trcdocumento = usuario.trcdocumento WHERE usuario.usucodigo = btycita.usucodigo) AS usunombre, citfecha, cithora, citobservaciones, citfecharegistro, cithoraregistro FROM btycita WHERE slncodigo = '".$_POST['salon']."' AND citfecha = '".$_POST['fecha']."' ORDER BY cithora");


			$array = array();

			if (mysqli_num_rows($sql) > 0) 
			{
				while ($row = mysqli_fetch_array($sql)) 
				{
					$array[] = array(
						'citcodigo' => $row['citcodigo'],
						'clbcodigo' => $row['clbcodigo'],
						'clbnombre' => $row['clbnombre'],
						'slncodigo' => $row['slncodigo'],
						'slnnombre' => $row['slnnombre'],
						'sernombre' => $row['sernombre'],
						'serduracion' => $row['serduracion'],
						'usunombre' => $row['usunombre'],
						'cithora'   => $row['cithora']
					);
				}

				$array = utf8_converter($array);

				echo json_encode(array("res" => "full", "json" => $array));
				
			}
			else
			{
				echo json_encode(array("res" => "empty"));
			}


			break;

		case 'eliminar':
			
			$sql = mysqli_query($conn, "DELETE FROM btycita WHERE citcodigo = '".$_POST['citcodigo']."' ");

			if ($sql) 
			{
				echo 1;
			}

			break;
		
		default:
			# code...
			break;
	}

	


function utf8_converter($array)
{
	array_walk_recursive($array, function(&$item, $key){
  		if(!mb_detect_encoding($item, 'utf-8', true)){
      		$item = utf8_encode($item);
  		}
	});

	return $array;
}
?>