<?php 
	session_start();
  include '../../cnx_data.php';

	switch ($_POST['opcion']) 
	{
		case 'validar':
			$currpass=md5($_POST['actual']);

			$sql = "SELECT a.trcdocumento FROM btyusuario a WHERE a.trcdocumento = '".$_SESSION['documento']."'  AND a.usuclave = '$currpass' AND a.usuestado = 1";


			$sqlw = mysqli_query($conn, $sql);


			if (mysqli_num_rows($sqlw) > 0) 
			{
				echo 1;
			}
			else
			{
				echo 2;		
			}
			
			break;

		case 'nueva':
			$newpass=md5($_POST['new_pass']);
			$sql = "UPDATE btyusuario SET usuclave = '$newpass' WHERE trcdocumento = '".$_SESSION['documento']."' ";

			//$sqlw = $conn->query($sql);

			if($conn->query($sql)){
				//echo 'ok';
				require '../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';

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

				$mail->addAddress($_SESSION['email'], $_SESSION['nombre'].' '.$_SESSION['apellido']);
				//$mail->addAddress('silmasur@gmail.com', 'Sil');

				$content = str_replace(array('%nombre%'),array($_SESSION['nombre']), file_get_contents('contents.html'));

				$mail->Subject = 'Cambio de clave correcto';

				$mail->msgHTML($content, dirname(__FILE__));

				$mail->Body = 'Tu nueva clave es: <b>' . $_POST['new_pass'] . '</b>';

				if (!$mail->send()) 
				{
					if (!$mail->send()) 
					{
		    			echo "Error: " . $mail->ErrorInfo;
					} else{	
	    				echo 1;
					}
				} 
				else 
				{
					echo 1;
				}
			}else{
				echo 'error•update';
			}


		break;

	case 'recovery':
		
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

		$QueryUsuario = mysqli_query($conn, "SELECT a.clbemail FROM btycolaborador a WHERE a.clbemail = '".$_POST['email']."'");
	
		if (mysqli_num_rows($QueryUsuario) > 0) 
		{

		

			$sql = "UPDATE btycolaborador SET clbclave = md5('".$password."') WHERE clbemail = '".$_POST['email']."' ";

			//echo $sql;

			$query = mysqli_query($conn, $sql);

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

				$mail->addAddress($_POST['email'], 'Beauty Soft');

				//$mail->addAddress("silmasur@gmail.com", 'Beauty Soft');

				$content = str_replace(array('%clave%'),array($clave), file_get_contents('contents.html'));

				$mail->Subject = ''.utf8_decode('Contraseña').' restablecida.';

				$mail->msgHTML($content, dirname(__FILE__));

				$mail->AltBody = '';

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

		break;
		
		default:
			# code...
			break;
	}
 ?>