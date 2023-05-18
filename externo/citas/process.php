<?php 
 	include '../../cnx_data.php';
    	include("../funciones.php");
    	include("../recaptchalib.php");

	switch ($_POST['opcion']) 
	{
		case 'validarDoc':

			$QueryValidar = mysqli_query($conn, "SELECT ter.trcdocumento FROM btytercero ter WHERE ter.trcdocumento = '".$_POST['doc']."'");

				if (mysqli_num_rows($QueryValidar) > 0) 
				{
					$QueryC = mysqli_query($conn, "SELECT cli.trcdocumento FROM btycliente cli WHERE cli.trcdocumento = '".$_POST['doc']."'");

					if (mysqli_num_rows($QueryC) > 0) 
					{
						echo 1;
					}
					else
					{
						echo 3;
					}
				}
				else
				{
					echo 2;
				}

			break;

		case 'buscarServicio':
			
			$QueryServicio = mysqli_query($conn, "SELECT a.sercodigo, a.sernombre FROM btyservicio a WHERE a.sernombre  LIKE '%".$_GET['q']."%' ORDER BY a.sernombre ");

			$jsonServicio = array();

			if (mysqli_num_rows($QueryServicio) > 0) 
			{
					$data = array();
					while ( $row = $QueryServicio->fetch_assoc()){
						$data[] = $row;
					}

					$array= utf8_converter($data);

						
					echo json_encode($array);

			}
			else
			{
				echo json_encode(array("res" => "empty"));
			}


			break;

		case 'dv':
		   
			if ($_POST['documento'] != "")
			{
					$cedula = $_POST['documento'];
					$primos =  array(3, 7, 13,17,19,23,29,37,41,43);
					$sum = 0;
						$j = strlen($cedula) - 1;
					for($i=0;$i<strlen($cedula);$i++)
					{ 
						$sum = $sum+ ($primos[$j]*$cedula[$i]);
				    	$j = $j - 1;
					} 

					$dv = $sum % 11;

					if ($dv != 1 and $dv !=0)
						$dv = 11 - $dv;
			}
					echo json_encode(array("res" => "full", "dv" => $dv));

			break;


		case 'depciu':


			$sql = mysqli_query($conn, "SELECT loccodigo, locnombre FROM btylocalidad WHERE depcodigo = '".$_POST['depto']."' ORDER BY locnombre");
			echo '<option value="0">SELECCIONE CIUDAD</option>';
			while($row = mysqli_fetch_array($sql))
			{
				echo '<option value="'.$row['loccodigo'].'">'.utf8_encode($row['locnombre']).'</option>';			
			}
			
			break;


		case 'barrio':


			$sql = mysqli_query($conn, "SELECT brrcodigo, brrnombre FROM btybarrio WHERE NOT brrcodigo = 0 AND brrstado = 1 AND loccodigo = '".$_POST['barrio']."' ORDER BY brrnombre");
			echo '<option value="0">SELECCIONE BARRIO</option>';

			while($row = mysqli_fetch_array($sql))
			{
				echo '<option value="'.$row['brrcodigo'].'">'.utf8_encode($row['brrnombre']).'</option>';			
			}
			
			break;

		case 'newCli':

			
			

			if ($_POST['barrio'] != 0) 
			{
				$barrio = $_POST['barrio'];
			}
			else
			{
				$barrio = 0;
			}

			if ($_POST['extranjero'] != "") 
			{
				$extranjero = $_POST['extranjero'];
			}
			else
			{
				$extranjero = 'N';
			}

			if ($_POST['ocupacion'] != "") 
			{
				$ocupacion = $_POST['ocupacion'];
			}
			else
			{
				$ocupacion = 0;
			}

	

			

			$QueryTercero = mysqli_query($conn, "SELECT * FROM btytercero ter WHERE ter.trcdocumento = '".$_POST['doc']."' ");

			if (mysqli_num_rows($QueryTercero) > 0) 
			{
				$maxCli = mysqli_query($conn, "SELECT MAX(clicodigo)as max FROM btycliente");

				$row = mysqli_fetch_array($maxCli);

				$maxiCli = $row['max'] + 1;

				$rows = mysqli_fetch_array($QueryTercero);

				$t =  "INSERT INTO btycliente (clicodigo, trcdocumento, tdicodigo, clisexo, ocucodigo, cliextranjero, cliemail, clifechanacimiento, clinotificacionemail, clinotificacionmovil, cliempresa, clifecharegistro, cliimagen, clitiporegistro, cliestado, cliclave, cliacceso, clitiposangre) VALUES($maxiCli, '".$rows['trcdocumento']."', '".$rows['tdicodigo']."', '".$_POST['sexo']."', '".$ocupacion."', '".$extranjero."', '".$_POST['email']."',  CASE WHEN '".$_POST['fechana']."' = ' ' THEN NULL ELSE '".$_POST['fechana']."' END,'".$_POST['ne']."', '".$_POST['nm']."', 'N', CURDATE(), 'default.jpg', 'EXTERNO', 1, '".$password."', 1,'' )";

				$QueryInsCli = mysqli_query($conn, $t)or die(mysqli_error($conn));

				if ($QueryInsCli) 
				{
					echo json_encode(array("res" => 1, "codcli" => $maxiCli));
				}
				else
				{
					echo json_encode(array("res" => 2, "codcli" => $maxiCli));
				}
			}
			else
			{

				//nsert a terceros y a cliente

			$QueryNewcli = mysqli_query($conn, "INSERT INTO btytercero (tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, brrcodigo, trcestado) VALUES('".$_POST['tipodoc']."', '".$_POST['doc']."', '".$_POST['digitov']."', '".utf8_decode(strtoupper($_POST['nombres']))."', '".utf8_decode(strtoupper($_POST['apellidos']))."', '".utf8_decode(strtoupper($_POST['nombres'])) . " " . utf8_decode(strtoupper($_POST['apellidos'])) ."', '".$_POST['direccion']."', '".$_POST['fijo']."', '".$_POST['movil']."', '".$barrio."', 1)");

					if ($QueryNewcli) 
					{
						$SqlTercero = mysqli_query($conn, "SELECT * FROM btytercero ter WHERE ter.trcdocumento = '".$_POST['doc']."' ");

						$rows = mysqli_fetch_array($SqlTercero);

						$maxCli = mysqli_query($conn, "SELECT MAX(clicodigo)as max FROM btycliente");

						$row = mysqli_fetch_array($maxCli);

						$maxiCli = $row['max'] + 1;

						$t =  "INSERT INTO btycliente (clicodigo, trcdocumento, tdicodigo, clisexo, ocucodigo, cliextranjero, cliemail, clifechanacimiento, clinotificacionemail, clinotificacionmovil, cliempresa, clifecharegistro, cliimagen, clitiporegistro, cliestado, cliclave, cliacceso, clitiposangre) VALUES($maxiCli, '".$rows['trcdocumento']."', '".$rows['tdicodigo']."', '".$_POST['sexo']."', '".$ocupacion."', '".$extranjero."', '".$_POST['email']."',  CASE WHEN '".$_POST['fechana']."' = ' ' THEN NULL ELSE '".$_POST['fechana']."' END,'".$_POST['ne']."', '".$_POST['nm']."', 'N', CURDATE(), 'default.jpg', 'EXTERNO', 1, '".$password."', 1,'' )";

						//echo $t;

						$QueryInsCli = mysqli_query($conn, $t)or die(mysqli_error($conn));


						//echo 1;
						echo json_encode(array("res" => 1, "codcli" => $maxiCli));
					}
			}

			break;

		case 'validarServicio':

		$d= "SELECT DISTINCT pc.clbcodigo, ter.trcrazonsocial FROM btyprogramacion_colaboradores AS pc, btycolaborador AS col, btytercero AS ter, btyturno AS tur, btyservicio_colaborador AS sc, btytipo_programacion AS tp, btypermisos_colaboradores AS per WHERE pc.clbcodigo=col.clbcodigo AND ter.trcdocumento=col.trcdocumento AND tur.trncodigo=pc.trncodigo AND sc.clbcodigo=pc.clbcodigo AND tp.tprcodigo=pc.tprcodigo AND tp.tprlabora = 1 AND pc.prgfecha = '".$_POST['fecha']."' AND (tur.trndesde <= '".$_POST['hora']."' AND tur.trnhasta >= '".$_POST['hora']."') AND sc.sercodigo = '".$_POST['servicio']."' AND pc.slncodigo = '".$_POST['salon']."' AND per.perfecha_desde = '".$_POST['fecha']."' 

				AND pc.clbcodigo NOT IN(SELECT DISTINCT a.clbcodigo FROM btypermisos_colaboradores a, btycolaborador AS c,btytercero AS t WHERE c.clbcodigo=a.clbcodigo AND t.trcdocumento=c.trcdocumento AND a.perfecha_desde = '".$_POST['fecha']."' AND a.perestado_tramite = 'AUTORIZADO' AND a.perhora_desde <= '".$_POST['hora']."' AND a.perhora_hasta >= '".$_POST['hora']."')

				AND pc.clbcodigo NOT IN(SELECT clbcodigo FROM btycita as cita, btyservicio as serv WHERE cita.sercodigo=serv.sercodigo AND cita.slncodigo = '".$_POST['salon']."' AND cita.citfecha = '".$_POST['fecha']."' AND '".$_POST['hora']."' BETWEEN SUBTIME(cita.cithora,sec_to_time(1)) AND SUBTIME(ADDTIME(cita.cithora ,sec_to_time(serv.serduracion*60)),1))";
			
			//echo $d;
			$QueryValidar = mysqli_query($conn, $d);

			if (mysqli_num_rows($QueryValidar) > 0) 
			{
				while ($row = mysqli_fetch_array($QueryValidar)) 
				{
					echo "<option value='".$row['clbcodigo']."'>".utf8_encode($row['trcrazonsocial'])."</option>";
				}
			}
			else
			{
				$sql = mysqli_query($conn, "SELECT DISTINCT pc.clbcodigo, ter.trcrazonsocial FROM btyprogramacion_colaboradores AS pc, btycolaborador AS col, btytercero AS ter, btyturno AS tur, btyservicio_colaborador AS sc, btytipo_programacion AS tp WHERE pc.clbcodigo=col.clbcodigo AND ter.trcdocumento=col.trcdocumento AND tur.trncodigo=pc.trncodigo AND sc.clbcodigo=pc.clbcodigo AND tp.tprcodigo=pc.tprcodigo AND tp.tprlabora = 1 AND pc.prgfecha = '".$_POST['fecha']."' AND (tur.trndesde <= '".$_POST['hora']."' AND tur.trnhasta >= '".$_POST['hora']."') AND sc.sercodigo = '".$_POST['servicio']."' AND pc.slncodigo = '".$_POST['salon']."' AND pc.clbcodigo NOT IN(SELECT clbcodigo FROM btycita AS cita, btyservicio AS serv WHERE cita.sercodigo=serv.sercodigo AND cita.slncodigo = '".$_POST['salon']."' AND cita.citfecha = '".$_POST['fecha']."' AND '".$_POST['hora']."' BETWEEN SUBTIME(cita.cithora, SEC_TO_TIME(1)) AND SUBTIME(ADDTIME(cita.cithora, SEC_TO_TIME(serv.serduracion*60)),1)) ");

					if (mysqli_num_rows($sql) > 0) 
					{
						while ($row = mysqli_fetch_array($sql)) 
						{
							echo "<option value='".$row['clbcodigo']."'>".utf8_encode($row['trcrazonsocial'])."</option>";
						}
					}
					else
					{
						echo "<option>No hay disponibilidad</option>";						
					}
			}


			break;

		case 'serDescripcion':

                  $Query = mysqli_query($conn, "SELECT CONCAT(a.serdescripcion, ' - ', '<b>[', a.serduracion,']</b>' ' MIN')AS duracion FROM btyservicio a WHERE a.sercodigo = '".$_POST['ser']."' ");

                  $row = mysqli_fetch_array($Query);

                  echo utf8_encode($row['duracion']);
			break;
		
		default:
			# code...
			break;
	}



	mysqli_close($conn);
 ?>