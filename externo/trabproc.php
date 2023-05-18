<?php 
require dirname(__FILE__).'/../lib/phpmailer/phpmailer/PHPMailerAutoload.php';


$ruta='http://beauty.claudiachacon.com/beauty/externo/trabproc';

$nombre=$_POST['nombre'];
$correo=$_POST['mail'];
$phone=$_POST['phone'];
$address=$_POST['address'];
$city=$_POST['city'];
$cargo=$_POST['cargo'];

$message.="HOJA DE VIDA ENVIADA DESDE LA PÁGINA.".PHP_EOL;
$message.="Enviado por: ".$nombre.PHP_EOL;
$message.="Tel: ".$phone.PHP_EOL;
$message.="E-Mail: ".$correo.PHP_EOL;
$message.="Direccion: ".$address.PHP_EOL;
$message.="Ciudad: ".$city.PHP_EOL;
$message.="Cargo al que aplica: ".$cargo.PHP_EOL;


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
	$mail->Subject = utf8_decode('De Pagina web: Hoja de vida');
	$mail->Body=$message;
	$mail->addAddress('app@claudiachacon.com');
	$mail->addAddress('direccion.comercial@claudiachacon.com');
	$mail->addAddress('direccion.administrativa@claudiachacon.com');
	$mail->addAddress('gestionhumana@claudiachacon.com');
	$mail->addAddress('asistente.gestionhumana@claudiachacon.com');


    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
	    $mail->AddAttachment($_FILES['archivo']['tmp_name'], $_FILES['archivo']['name']);
		if (!$mail->send()) 
		{
		    	if($mail->send())
		    	{
		    		echo 'ok';
		    	}
		    	else if($mail->send())
		    	{
		    		echo 'ok';
		    	}else{

	      			echo "Error: " . $mail->ErrorInfo."\n";
		    	}
		} 
		else 
		{
		    echo 'ok';
		}
	}else{
		echo 'error';
	}
   

?>