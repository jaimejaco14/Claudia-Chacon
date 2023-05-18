<?php 
session_start();
require 'PHPMailerAutoload.php';
$mail = new PHPMailer;

   $body='Se adjuntan reporte(s) de los colaboradores ingresados a Beauty Soft ERP.<br> <br><br> La busuqueda fue filtrada por la cadena: <br><br>'.$_SESSION['vrbrptcol'];


   for ($i=0; $i<5 ; $i++) { 
   	if ($_POST["correos"][$i] != "") {
   	 // para los correos
    $mail->isSendmail();
    //el cuerpo del mensaje, tambien se puede añadir un html al cuerpo
    //quien remite el mensaje, aprecera en la cabecera de remitente
    $mail->setFrom('app@claudiachacon.com', 'Beauty Soft');
    //sirve para aquien le llegara una respuesta del mensaje que se mando, se puede usa noreply@correo.com para evitar que se responda.
    $mail->addReplyTo('app@claudiachacon.com', 'Beauty Soft');
    //la asignacion de los correos, la variable to, perimete cambiar entre los diferentes correos que trae el vector
    $to = (string)"".$_POST["correos"][$i];
    //esta funcion asigna la direccion de correo y el posible nombre de usuario en caso de conocerse
    $mail->addAddress($to, 'Usuario');
    //el tema de del mensaje
    $mail->Subject = 'Reporte  de Colaboradores';
    //Read an HTML message body from an external file, convert reference
    //convert HTML into a basic plain-text alternative body
    //conversion a formato html del body, sin esto el body queda vacio 
    $mail->msgHTML($body);
    //texto alternativo que remplaza el texto con texto plano 
    $mail->AltBody ='este es el cuerpo del mensaje';
    //atyachment funciona como adjuntador de registros, usando el fopen la funcion mailer facilita la accion y solo se usa una funcion para adjuntar, acompañado de la ruta del archivo
    $mail->addAttachment("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".pdf");
    $mail->addAttachment("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".xls");
    

      

    //send the message, check for errors
    

   }
   }
   //chekeo de posibles errores dentro de alguno de los correos, de haber error en alguno se enviaran los otros pero uno, no
if (!$mail->send()) {
         echo "Mailer Error: " . $mail->ErrorInfo;
         unlink("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".pdf");
         unlink("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".xls");
    } else {
         echo ' Enviado Satisfactoriamente. Si no esta en su bandeja de entrada, verifique el SPAM ';
         unlink("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".pdf");
         unlink("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".xls");
    }

   
 ?>