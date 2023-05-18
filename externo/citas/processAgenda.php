<?php 
	include '../../cnx_data.php';
	include("../funciones.php");

	switch ($_POST['opcion']) 
	{
		case 'agendar':

			/*----------  CODIGO DE RESERVA  ----------*/

			$QueryCodigoReserva = mysqli_query($conn, "SELECT MAX(rsvcodigo) FROM btyreserva");

			$row = mysqli_fetch_array($QueryCodigoReserva);

			$maxCodigo = $row[0] + 1;

			/*----------  CODIGO CLIENTE  ----------*/


			$QueryCodCliente = mysqli_query($conn, "SELECT a.clicodigo FROM btycliente a WHERE a.trcdocumento = '".$_POST['doc']."' ");

			$row = mysqli_fetch_array($QueryCodCliente);

			$codigoCliente = $row['clicodigo'];


			/*----------  AGENDAR CITA  ----------*/

			if ($_POST['salon'] == "0" || $_POST['salon'] == "") 
			{
				$salon = 'NULL';
			}
			else
			{
				$salon = $_POST['salon'];
			}


			$QueryAgenda = mysqli_query($conn, "INSERT INTO btyreserva (rsvcodigo, meccodigo, rsvdomicilio, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, rsvfecha, rsvhora, rsvfecharegistro, rsvhoraregistro, rsvobservaciones) VALUES('$maxCodigo', '6', '0', NULL, ".$salon.", NULL, '".$codigoCliente."', '0', '".$_POST['fecha']."', '".$_POST['hora']."', CURDATE(), CURTIME(), '".utf8_decode($_POST['obser'])."' )")or die(mysqli_error($conn));

			if ($QueryAgenda) 
			{
				echo json_encode(array("res" => "full", "reserva" => $maxCodigo));
			}

			break;
		
		default:
			# code...
			break;
	}


	mysqli_close($conn);
?>