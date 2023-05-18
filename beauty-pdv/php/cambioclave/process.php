<?php 
	session_start();
	include("../../../cnx_data.php");

	switch ($_POST['opcion']) 
	{
		case 'validar':

			$sql = "SELECT *, b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON b.trcdocumento=a.trcdocumento WHERE a.usulogin = '".$_SESSION['PDVuser_session']."' AND a.usuestado='1' and a.usuclave=MD5('".$_POST['actual']."')";


			$sqlw = mysqli_query($conn, $sql);


			if (mysqli_num_rows($sqlw) > 0) 
			{
				echo 1;
			}
			else
			{
				echo 2;
			}
			# code...
			break;

		case 'nueva':
			$sql = "UPDATE btyusuario SET usuclave = MD5('".$_POST['new_pass']."') WHERE usucodigo = '".$_SESSION['PDVcodigoUsuario']."' ";

			$sqlw = mysqli_query($conn, $sql)or die(mysqli_error($conn));

			require '../../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';

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

			$mail->addAddress($_SESSION['PDVusuemail'], $_SESSION['PDVnombreCol']);

			$content = str_replace(array('%nombre%'),array($_SESSION['PDVnombreCol']), file_get_contents('contents.html'));

			$mail->Subject = 'Cambio de clave correcto';

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

		break;
		
		default:
			# code...
			break;
	}
 ?>