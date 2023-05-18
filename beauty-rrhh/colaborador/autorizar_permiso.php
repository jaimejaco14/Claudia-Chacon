<?php 
	include '../../cnx_data.php';
	require '../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';

	$idpermiso   = $_POST['idpermiso'];
	$comentarios = $_POST['comentario'];
	$autorizado  = strtoupper($_POST['aut']);

	if ($_POST['aut'] == "Noautorizado") 
	{
		
		$sql = mysqli_query($conn, "UPDATE btypermisos_colaboradores SET usucodigo_autorizacion = '".$_SESSION["codigoUsuario"]."', perfecha_autorizacion = CURDATE(), perhora_autorizacion = CURTIME(), perestado_tramite = 'NO AUTORIZADO', perobservacion_autorizacion = '$comentarios' WHERE percodigo = $idpermiso ");

		if ($sql) 
		{
			echo 0;
		}
	}
	else
	{
		$sql = mysqli_query($conn, "UPDATE btypermisos_colaboradores SET usucodigo_autorizacion = '".$_SESSION["codigoUsuario"]."', perfecha_autorizacion = CURDATE(), perhora_autorizacion = CURTIME(), perestado_tramite = '$autorizado', perobservacion_autorizacion = '$comentarios' WHERE percodigo = $idpermiso ");

		if ($sql) 
		{
			//consultar datos del permiso
			$sql2="SELECT s.slnemail,p.percodigo,t.trcrazonsocial, CONCAT(p.perfecha_desde,'|',p.perhora_desde) AS desde, CONCAT(p.perfecha_hasta,'|',p.perhora_hasta) AS hasta,p.perobservacion_registro,p.perobservacion_autorizacion,t2.trcrazonsocial
				FROM btypermisos_colaboradores p
				NATURAL JOIN btysalon s
				NATURAL JOIN btycolaborador c
				NATURAL JOIN btytercero t
				JOIN btyusuario u on u.usucodigo=p.usucodigo_autorizacion
				JOIN btytercero t2 on u.trcdocumento=t2.trcdocumento and u.tdicodigo=t2.tdicodigo
				WHERE p.percodigo=$idpermiso";
			$res=$conn->query($sql2);
			$row=$res->fetch_array();
			//enviar mail a salon
			if(sendmail($row[0],$row[1],utf8_encode($row[2]),$row[3],$row[4],$row[5],$row[6],utf8_encode($row[7]))){
				echo 1;
			}else{
				echo 2;
			}
		}
	}

	
function sendmail($slnemail,$codper,$nomcol,$desde,$hasta,$motivo,$observ,$autor){
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = "smtpout.secureserver.net";
    $mail->Port = 25;
    $mail->SMTPAuth = true;
    $mail->Username = "app@claudiachacon.com";
    $mail->Password = "AppBTY.18";
    $mail->setFrom('app@claudiachacon.com', ''.utf8_decode('Beauty Soft')).'';
    $mail->addReplyTo('app@claudiachacon.com', ''.utf8_decode('Beauty Soft').'');
    $mail->addAddress($slnemail, 'Beauty Soft');
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
	          <th colspan="2"><center>BEAUTY SOFT | AUTORIZACION DE AUSENCIAS</center></th>
	        </tr>
	        
	    </thead>
	    <tbody>';

            /******************/
    $message.='
    	<tr>
            <th>Ausencia No:</th>
            <th style="text-align: left;">'.$codper.'</th>
        </tr>
        <tr>
            <th>Colaborador:</th>
            <th style="text-align: left;">'.$nomcol.'</th>
        </tr>
        <tr>
            <th>Desde:</th>
            <th style="text-align: left;">'.$desde.'</th>
        </tr>
        <tr>
            <th>Hasta:</th>
            <th style="text-align: left;">'.$hasta.'</th>
        </tr>
        <tr>
            <th>Motivo</th>
            <th style="text-align: left;">'.$motivo.'</th> 
        </tr>
        <tr>
            <th>Observaciones:</th>
            <th style="text-align: left;">'.$observ.'</th>
        </tr>
        <tr>
            <th>Autoriza:</th>
            <th style="text-align: left;">'.$autor.'</th>
        </tr>
    	</tbody></table>';

    $mail->Subject = utf8_decode('Ausencia autorizada | Beauty Soft - Gestion Humana');

    $mail->msgHTML($message, dirname(__FILE__));
    
    $mail->AltBody = '';

    if (!$mail->send()){
        if (!$mail->send()){
	        return false;
	    }else {
	       return true;
	    }
    }else {
       return true;
    }
}
?>
