<?php 

	require dirname(__FILE__).'/../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
	
	include(dirname(__FILE__).'/../cnx_data.php');

	$ruta='http://beauty.claudiachacon.com/beauty/scripts';
	
	$message = '<html><style>th{font-size: .9em;}</style>
	<head>
	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://beauty.claudiachacon.com/beauty/lib/vendor/fontawesome/css/font-awesome.css" />

	</head>
	<body>';

	$message .= '<table cellpadding="5" cellspacing="5" border="1">
		<thead>
			<tr style="background-color: #d2e3fc">
			  <th colspan="5"><center>REPORTE DE ACTIVOS</center></th>
			</tr>
			<tr>
				<th colspan="0">TIPO</th>
				<th colspan="0">SUBTIPO</th>
				<th colspan="0">GRUPO</th>
				<th colspan="0">SUBGRUPO</th>
				<th colspan="0">CANTIDAD</th>
			</tr>
			
		</thead>
		<tbody>';

		$sql = mysqli_query($conn, "SELECT e.tianombre, d.sbtnombre, c.granombre, b.sbganombre,  a.sbgcodigo, COUNT(*)AS cantidad FROM btyactivo a JOIN btyactivo_subgrupo b ON a.sbgcodigo=b.sbgcodigo JOIN btyactivo_grupo c ON c.gracodigo=b.gracodigo JOIN btyactivo_subtipo d ON d.sbtcodigo=c.sbtcodigo JOIN btyactivo_tipo e ON e.tiacodigo=d.tiacodigo WHERE a.actestado = 1 GROUP BY a.sbgcodigo ORDER BY e.tianombre");

		if (mysqli_num_rows($sql) > 0) 
		{
			while ($row = mysqli_fetch_array($sql)) 
			{
				$message.='
					<tr>
						<td>'.utf8_decode($row['tianombre']).'</td>
						<td>'.utf8_decode($row['sbtnombre']).'</td>
						<td>'.utf8_decode($row['granombre']).'</td>
						<td>'.utf8_decode($row['sbganombre']).'</td>
						<td style="text-align: right"><a href="'.$ruta.'/detalle_listado_activos.php?sbgcodigo='.$row['sbgcodigo'].'" target="_blank">'.$row['cantidad'].'</a></td>
					</tr>
				';
			}

			$totalActivos = mysqli_query($conn, "SELECT COUNT(a.actcodigo) FROM btyactivo a WHERE a.actestado = 1 ");

			$Sum = mysqli_fetch_array($totalActivos);

			$totalizado = $Sum[0];

			$message.='
				<tr>
					<td colspan="4" style="background-color: #fc9a9a">TOTAL</td>
					<td colspan="1" style="background-color: #fc9a9a; text-align: right"><a href="'.$ruta.'/detalle_listado_activos.php?sbgcodigo=0">'.$totalizado.'</a></td>
				</tr>
			';
		}

		$message.='</tbody>';
		$message.='</table></body>';


	$mail = new PHPMailer;

	$mail->isSMTP();

	$mail->SMTPDebug = 0;

	$mail->Debugoutput = 'html';

	$mail->Host = "smtpout.secureserver.net";

	$mail->Port = 25;

	$mail->SMTPAuth = true;

	$mail->Username = "app@claudiachacon.com";
	$mail->Password = "AppBTY.18";
	$mail->setFrom('app@claudiachacon.com', 'Beauty Soft');
	$mail->addReplyTo('app@claudiachacon.com', 'Beauty Soft');

	//$mail->addAddress('jvelasco@claudiachacon.com');
	//$mail->addAddress('cchacon@claudiachacon.com');
	//$mail->addAddress('direccion.operaciones@claudiachacon.com');
	//$mail->addAddress('gestionhumana@claudiachacon.com');
	//$mail->addAddress('direccion.administrativa@claudiachacon.com');
    	$mail->addAddress('app@claudiachacon.com');
   	//$mail->addAddress('soporte@mipc-soluciones.com');
    
    	$mail->Subject = utf8_decode('Beauty Soft: Informe diario de Activos');

    	$mail->msgHTML($message, dirname(__FILE__));
	
	$mail->AltBody = '';

      if (!$mail->send()) 
    	{
	    	if($mail->send())
	    	{
	    		echo 'enviado en 2do intento';
	    	}
	    	else
	    	{
	    		$mail->send();echo 'enviado al 3er intento';
	    	}
      		echo "Error: " . $mail->ErrorInfo."\n";
	} 
	else 
	{
	    echo "Enviado a: "."\n";
	    echo "====";
	}
?>
