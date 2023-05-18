<?php 
	include("../cnx_data.php");

	
	function generaPass()
	{

		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
		$longitudCadena=strlen($cadena);
 
		$pass = "";
		$longitudPass=8;
 
		for($i=1 ; $i<=$longitudPass ; $i++)
		{
    
    		$pos=rand(0,$longitudCadena-1);
 
    		$pass .= substr($cadena,$pos,1);
		}
		
		return $pass;
	}

	$clave = generaPass();
	$password = $clave;

	$QueryUsuario = mysqli_query($conn, "SELECT * FROM btyusuario WHERE usuemail = '".$_POST['email']."'");
	
	if (mysqli_num_rows($QueryUsuario) > 0) 
	{
		

		$sql = "UPDATE btyusuario SET usuclave = SHA1('".$password."') WHERE usuemail = '".$_POST['email']."' ";

		$query = mysqli_query($conn, $sql);

				require '../lib/phpmailer/phpmailer/PHPMailerAutoload.php';

				$mail = new PHPMailer;

				$mail->isSMTP();

				$mail->SMTPDebug = 0;

				$mail->Debugoutput = 'html';

				$mail->Host = "smtpout.secureserver.net";

				$mail->Port = 25;

				$mail->SMTPAuth = true;

				$mail->Username = "app@claudiachacon.com";

				$mail->Password = "AppBTY.18";

				$mail->setFrom('app@claudiachacon.com', 'Beauty ERP');

				$mail->addReplyTo('app@claudiachacon.com', 'Beauty ERP');

				$mail->addAddress($_POST['email'], 'Beauty Soft');

				$content = str_replace(array('%clave%'),array($clave), file_get_contents('contents.html'));

				$mail->Subject = ''.utf8_decode('Contraseña').' restablecida.';

				$mail->msgHTML($content, dirname(__FILE__));

				$mail->AltBody = 'This is a plain-text message body';

				if (!$mail->send()) 
				{
	    			echo "Error: " . $mail->ErrorInfo;
				} 
				else 
				{
	    			echo 1;
				}
	}
	else
	{
		echo 2;
	}

 ?>