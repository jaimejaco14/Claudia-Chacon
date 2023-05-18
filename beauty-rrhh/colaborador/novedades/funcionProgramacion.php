<?php 
	include("../../../cnx_data.php");
	include("../../funciones.php");


	switch ($_POST['opcion']) 
	{
		case 'fnProg':
			
			$sql = mysqli_query($conn, "SELECT a.prgfecha, b.trnnombre,  CONCAT(TIME_FORMAT(b.trndesde, '%H:%i'), ' a ', TIME_FORMAT(b.trnhasta,'%H:%i'))AS horario, c.slnnombre, e.tprnombre, d.ptrnombre FROM btyprogramacion_colaboradores a JOIN btyturno b ON b.trncodigo=a.trncodigo JOIN btysalon c ON c.slncodigo=a.slncodigo JOIN btypuesto_trabajo d ON d.ptrcodigo=a.ptrcodigo  JOIN btytipo_programacion e ON e.tprcodigo=a.tprcodigo WHERE a.prgfecha BETWEEN '".$_POST['f1']."' AND '".$_POST['f2']."' AND a.clbcodigo = '".$_POST['col']."' ORDER BY a.prgfecha");

			$array = array();

			if (mysqli_num_rows($sql) > 0) 
			{
				while ($row = mysqli_fetch_array($sql)) 
				{
					$array[] = array(
						'fecha'	=> $row['prgfecha'],
						'turno'	=> $row['trnnombre'],
						'salon'	=> $row['slnnombre'],
						'puesto'	=> $row['ptrnombre'],
						'tipo'	=> $row['tprnombre'],
						'horario'	=> $row['horario'],
						'clbcodigo'	=> $_POST['col'],
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

		case 'verNovedad':
			
			$sql = mysqli_query($conn, "SELECT a.nvpcodigo, GROUP_CONCAT(b.tnvnombre)AS tnvnombre, a.nvpfechadesde, a.nvphoradesde, a.nvphorahasta FROM btynovedades_programacion a JOIN btytipo_novedad_programacion b ON a.tnvcodigo=b.tnvcodigo JOIN btynovedades_programacion_detalle c ON c.nvpcodigo=a.nvpcodigo WHERE '".$_POST['fecha']."' BETWEEN  a.nvpfechadesde AND a.nvpfechahasta  AND c.clbcodigo = '".$_POST['clbcodigo']."' AND a.nvpestado IN('MODIFICADO', 'REGISTRADO') GROUP BY a.nvpcodigo, b.tnvnombre ORDER BY a.nvpfechadesde");

			$array = array();

			if (mysqli_num_rows($sql) > 0) 
			{
				while($row = mysqli_fetch_array($sql))
				{
					$array[] = array(
						'codNov'	=> $row['nvpcodigo'],
						'novedad'	=> $row['tnvnombre'],
						'desde'	=> $row['nvphoradesde'],
						'hasta'	=> $row['nvphorahasta'],
						'fecha'	=> $row['nvpfechadesde'],
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
		
		default:
			# code...
			break;
	}
?>