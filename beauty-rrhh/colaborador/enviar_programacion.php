<?php
include '../../cnx_data.php';
$email   = $_POST['email'];
$codigo  = $_POST['colaborador'];
$_SESSION['codigo'] = $codigo;


$sql = "SELECT t.trcrazonsocial FROM btycolaborador c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento WHERE c.clbcodigo = $codigo ";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) 
{
	$nombre = $row['trcrazonsocial'];
}
require '../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';


//Create a new PHPMailer instance

$mail = new PHPMailer;

//Tell PHPMailer to use SMTP

$mail->isSMTP();

//Enable SMTP debugging

// 0 = off (for production use)

// 1 = client messages

// 2 = client and server messages

$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output

$mail->Debugoutput = 'html';

//Set the hostname of the mail server

$mail->Host = "smtpout.secureserver.net";

//Set the SMTP port number - likely to be 25, 465 or 587

$mail->Port = 25;

//Whether to use SMTP authentication

$mail->SMTPAuth = true;

//Username to use for SMTP authentication

$mail->Username = "app@claudiachacon.com";

//Password to use for SMTP authentication

$mail->Password = "app2017";

//Set who the message is to be sent from

$mail->setFrom('app@claudiachacon.com', 'Beauty ERP');

//Set an alternative reply-to address

$mail->addReplyTo('app@claudiachacon.com', 'Beauty ERP');

//Set who the message is to be sent to

$mail->addAddress($email); //////////////////////////ESTE ES LA LINEA QUE VA

//$mail->addAddress('silmasur@gmail.com', 'Sil');


$content = str_replace(array('%codigo%', '%nombre%'),array($_SESSION['codigo'], $nombre), file_get_contents('contents.html'));

//Set the subject line

$mail->Subject = 'Notificacion de Programacion';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($content, dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('imagenes/logo_empresa.jpg');

//send the message, check for errors
if (!$mail->send()) {
    echo "Error: " . $mail->ErrorInfo;
} else {
    echo 1;
}

 
?>




