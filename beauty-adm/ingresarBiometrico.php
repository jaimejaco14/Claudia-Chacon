<?php 
	header("Content-Type: Application/Json");
	include '../cnx_data.php';

	$codcol		= $_POST['codcol'];
	$codbio		= $_POST['codbio'];
	$cod        = $_POST['cod'];

	switch ($_POST['opcion']) 
	{
		case 'validar':

				$validar = mysqli_query($conn, "SELECT a.clbcodigoswbiometrico, b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE clbcodigoswbiometrico = $codbio");

				if (mysqli_num_rows($validar) > 0) 
				{
					$row = mysqli_fetch_array($validar);
					if ($row['clbcodigoswbiometrico'] != null) 
					{
						echo json_encode(array("bio" => $row['clbcodigoswbiometrico'], "colaborador" => $row['trcrazonsocial'], "resultado" => 'exitoso'));						
					}
					else{
						echo json_encode(array("bio" => 0, "colaborador" => 0, "resultado" => 0));	
					}

				}			
			break;

		case 'ingreso':

				$sql = mysqli_query($conn, "UPDATE btycolaborador SET clbcodigoswbiometrico = $codbio WHERE clbcodigo = $codcol ");

				if ($sql) 
				{
					echo 1;
				}
			break;

		case 'comprobar':
				$validar = mysqli_query($conn, "SELECT clbcodigoswbiometrico FROM btycolaborador WHERE clbcodigo = $cod");

					if (mysqli_num_rows($validar) > 0) 
					{
						$row = mysqli_fetch_array($validar);
						if ($row['clbcodigoswbiometrico'] == null || $row['clbcodigoswbiometrico'] == "") 
						{
							echo json_encode(array("resultado" => "nulo"));
						}
						else
						{
							echo json_encode(array("bio" => $row['clbcodigoswbiometrico'], "resultado" => "exitoso"));						
						}
					}
				
			break;


		case 'modificar':
			
				$sql = mysqli_query($conn, "UPDATE btycolaborador SET clbcodigoswbiometrico = $codbio WHERE clbcodigo = $codcol ");

				if ($sql) 
				{
					echo 1;
				}

				break;
		
		default:
			
			break;
	}

	mysqli_close($conn);
 ?>