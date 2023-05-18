<?php

require dirname(__FILE__).'/../lib/phpmailer/phpmailer/PHPMailerAutoload.php';

$message = '<html><body><h3>Esto es una prueba</h3></body></html>';

try{

$mail = new PHPMailer(true);
$mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        //$mail->Host = "smtpout.secureserver.net";
	//$mail->Host = 'mailstore1.secureserver.net';
	$mail->Host = 'smtp.gmail.com';
        //$mail->Port = 465;
	$mail->Port = 587;
        $mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
        $mail->Username = "emails.claudiachacon@gmail.com";
        $mail->Password = "hfsvghitqumivmwm";
        $mail->setFrom('info@claudiachacon.com', 'Beauty Soft');
        $mail->addReplyTo('info@claudiachacon.com', 'Beauty Soft');
        $mail->Subject = utf8_decode('INFORME DIARIO DE VENTAS');
        $mail->msgHTML($message, dirname(__FILE__));

        //$mail->addAddress('sistemas@claudiachacon.com');
        $mail->addAddress('jvelasco@claudiachacon.com');
        /*$mail->AddCC('sistemas@claudiachacon.com');
        $mail->AddCC('direccion.comercial@claudiachacon.com');
        $mail->AddCC('direccion.operaciones@claudiachacon.com');
        $mail->AddCC('direccion.administrativa@claudiachacon.com');
        $mail->AddCC('asistente.mercadeo@claudiachacon.com');*/
        $mail->addAddress('correaorozcojaime@gmail.com');
        
	if($mail->send()){
                echo "Enviado";
        }else{
                echo "No enviado";
	}
}
catch(Exception $e){
	echo "Error " . $e->getMessage();
}

exit;
$mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = "smtpout.secureserver.net";
        $mail->Port = 25;
        $mail->SMTPAuth = true;
        $mail->Username = "info@claudiachacon.com";
        $mail->Password = "Cchacon2018";
        $mail->setFrom('info@claudiachacon.com', 'Beauty Soft');
        $mail->addReplyTo('info@claudiachacon.com', 'Beauty Soft');
        $mail->Subject = utf8_decode('INFORME DIARIO DE VENTAS');
        $mail->msgHTML($message, dirname(__FILE__));

        //$mail->addAddress('sistemas@claudiachacon.com');
        $mail->addAddress('jvelasco@claudiachacon.com');
        /*$mail->AddCC('sistemas@claudiachacon.com');
        $mail->AddCC('direccion.comercial@claudiachacon.com');
        $mail->AddCC('direccion.operaciones@claudiachacon.com');
        $mail->AddCC('direccion.administrativa@claudiachacon.com');
        $mail->AddCC('asistente.mercadeo@claudiachacon.com');*/
        $mail->addAddress('correaorozcojaime@gmail.com');
        if($mail->send()){
                echo 'Sent '.date("Y-m-d").PHP_EOL;
        }else{
                echo '**ERROR**'.date("Y-m-d").PHP_EOL;
        }

?>
