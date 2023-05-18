<?php 
	include("../../cnx_data.php");

	$recaptcha = $_POST["g-recaptcha-response"];
   
	$url = 'https://www.google.com/recaptcha/api/siteverify';

	$data = array(
		'secret' => '6LcQ9S4UAAAAAIFpvWZS4-aJleleIHrQBgAvsfxt',
		'response' => $recaptcha
	);

	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success = json_decode($verify);
	if ($captcha_success->success) 
	{
				    
		    $Query = mysqli_query($conn, "SELECT MAX(pgrfcodigo) FROM btypqrf");

			$fetch = mysqli_fetch_array($Query);

			$maxCod = $fetch[0] + 1;

			$r = "INSERT INTO btypqrf (pgrfcodigo, pqrftipo, pqrffecha, slncodigo, pgrdescripcion, pgrfnombre_contacto, pgrftelefonofijo_contacto, pgrftelefonomovil_contacto, pgrfemail_contacto, pqrfhora, usucodigo, pgrrespuesta_descripcion, pqrfrespuesta_fecha, pqrfrespuesta_hora, pgrfestado) VALUES($maxCod, '".$_POST['tipo']."', CURDATE(), '".$_POST['sln']."', '".utf8_decode($_POST['comentario'])."', '".$_POST['name']."', '".$_POST['fijo']."', '".$_POST['movil']."', '".$_POST['email']."', CURTIME(), '0', '', NULL, NULL, 'RADICADO')";

				$QueryInsert = mysqli_query($conn, $r)or die(mysqli_error($conn));

				if ($QueryInsert) 
				{
					echo json_encode(array("codigo" => $maxCod, "res" => 1));
				}
	} 
	else 
	{
		echo "Bots!";
	}
?>