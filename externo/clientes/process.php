<?php 
      include '../../cnx_data.php';

	switch ($_POST['opcion']) 
	{
		case 'dv':
			
			if ($_POST['doc'] != "")
			{
				$cedula = $_POST['doc'];

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
				echo $dv;
			break;

		case 'validar':
			
			$query = mysqli_query($conn, "SELECT a.trcdocumento FROM btytercero a WHERE a.trcdocumento = '".$_POST['doc']."' ");

			if (mysqli_num_rows($query) > 0) 
			{				
				$sql = mysqli_query($conn, "SELECT a.trcdocumento FROM btycliente a WHERE a.trcdocumento = '".$_POST['doc']."' ");

				if (mysqli_num_rows($sql) > 0) 
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

		case 'newCli':
			
				if ($_POST["tpcli"] == 2) 
				{

					//$valDoc = mysqli_query($conn, "SELECT trcdocumento FROM btycliente WHERE trcdocumento = '".$_POST['doc']."' ");

					//if (mysqli_num_rows($valDoc) > 0) 
					//{
						//echo "dupli";
					//}
					//else
					//{
						$SqlTercero = mysqli_query($conn, "INSERT INTO btytercero (tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, brrcodigo, trcestado) VALUES('".$_POST['tipodoc']."', '".$_POST['doc']."', '".$_POST['digitov']."', '".utf8_decode(strtoupper($_POST['nombres']))."', '".utf8_decode(strtoupper($_POST['apellidos']))."', '".utf8_decode(strtoupper($_POST['nombres'])). " " . utf8_decode(strtoupper($_POST['apellidos']))."', '".$_POST['direccion']."', '".$_POST['fijo']."', '".$_POST['movil']."', '".$_POST['barrio']."', 1)")or die(mysqli_error($conn));

						$SqlCli = mysqli_query($conn, "SELECT MAX(clicodigo) FROM btycliente");

						$fetch = mysqli_fetch_array($SqlCli);

						$max = $fetch[0] + 1;

						$QueryCliente = mysqli_query($conn, "INSERT INTO btycliente (clicodigo, trcdocumento, tdicodigo, clisexo, ocucodigo, cliextranjero, cliemail, clinotificacionemail, clinotificacionmovil, cliempresa, clifecharegistro, cliimagen, clitiporegistro, cliestado, cliclave, cliacceso, clitiposangre, clifechanacimiento) VALUES('".$max."', '".$_POST['doc']."', '".$_POST['tipodoc']."', '".$_POST['sexo']."',  '".$_POST['ocupacion']."', '".$_POST['extranjero']."', '".strtoupper($_POST['email'])."', '".$_POST['ne']."', '".$_POST['nm']."', 'N', CURDATE(), 'default.jpg', 'EXTERNO', 1, ' ', 1, ' ', '".$_POST['fechana']."' )")or die(mysqli_error($conn));

						if ($SqlTercero && $QueryCliente) 
						{
							echo 1;
						}

					//}




					/*$QueryC

					$fila = mysqli_fetch_array($QueryClie);
					$cliente = $fila['clicodigo'];*/
						
				}
				else
				{
					if ($_POST["tpcli"] == 3) 
					{
						$SqlCli = mysqli_query($conn, "SELECT MAX(clicodigo) FROM btycliente");

						$fetch = mysqli_fetch_array($SqlCli);

						$max = $fetch[0] + 1;

						$QueryCliente = mysqli_query($conn, "INSERT INTO btycliente (clicodigo, trcdocumento, tdicodigo, clisexo, ocucodigo, cliextranjero, cliemail, clinotificacionemail, clinotificacionmovil, cliempresa, clifecharegistro, cliimagen, clitiporegistro, cliestado, cliclave, cliacceso, clitiposangre, clifechanacimiento) VALUES('".$max."', '".$_POST['doc']."', '".$_POST['tipodoc']."', '".$_POST['sexo']."',  '".$_POST['ocupacion']."', '".$_POST['extranjero']."', '".strtoupper($_POST['email'])."', '".$_POST['ne']."', '".$_POST['nm']."', 'N', CURDATE(), 'default.jpg', 'EXTERNO', 1, ' ', 1, '', '".$_POST['fechana']."' )")or die(mysqli_error($conn));

							if ($QueryCliente) 
							{
								echo 1;
							}
					}
					
				}	
	  		

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
		
		default:
			# code...
			break;
	}
 ?>