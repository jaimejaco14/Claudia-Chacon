<?php 
//inicio de sesion para poder usar las variables de las busquedas de datos 
session_start();
//se adiciona la clase de mailer, la cual generalos metos de envio explicados posteriormente
require 'PHPMailerAutoload.php';
//se instancia un objeto de esta clase mailer que sera quien contendra los metodos para rrellenar los datos del correo
$mail = new PHPMailer;
//la variable body contiene le cuerpo del mesaje, el cual posteriormente es convertido por un metodo en un "codigo html", en este archivo se adicionan datos especificos del correo como fecha de incio y fecha fin, ademas de el numero de registros procedentes de la consulta 
   $body='Se adjuntan reporte(s) de las sesiones de usuarios ingresados por Beauty Soft ERP.<br> con el rango de fechas: <br> Fecha inicial '.$_SESSION['fch']. ' y fecha final '.$_SESSION['fc'].'<br> <br>  La consulta genero un total de: '. $_SESSION['numrows'].'  registros para mostrar. <br><br> Se adicionaron los siguientes filtros de busqueda avanzada: <br><br>';
// se verifica si uno de los campos de las busquedas avanzadas esta lleno, de ser asi sera adicionada una etiqueta para adicionar esto en el cuerpo del mensaje, de la misma forma funcionan los condicionale posteriores
    if ($_SESSION['nave']!="null") {
     $body= $body."Navegador(es): ".$_SESSION['nave'].'<br>';
    }
    if ($_SESSION['dispo']!="null") {
       $body= $body."Dispositivo(s): ".$_SESSION['dispo'].'<br>';
    }
    if ($_SESSION['nnom']!="") {
       $body= $body."Nombre de Usuario: ".$_SESSION['nnom'].'<br>';
    }
    if ($_SESSION['sesip']!="") {
      $body= $body."Direccion IP: ".$_SESSION['sesip'].'<br>';
    }
    if ($_SESSION['actvv']!="false") {
      $body= $body."Usuarios Activos : SI".'<br>';
    }
    if ( $_SESSION['fall']!="false") {
      $body= $body."Usuarios Fallidos : SI".'<br>';
    }
    if ($_SESSION['desc']!="false") {
      $body= $body."Usuarios Desconectados : SI".'<br>';
    }
  
//en la pagina principal, quien almacena los primeros correos, se asigna un valor maximo de correos como de  maximo.
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
    $mail->Subject = 'Reporte  de Sesiones';
    //Read an HTML message body from an external file, convert reference
    //convert HTML into a basic plain-text alternative body
    //conversion a formato html del body, sin esto el body queda vacio 
    $mail->msgHTML($body);
    //texto alternativo que remplaza el texto con texto plano 
    $mail->AltBody ='este es el cuerpo del mensaje';
    //atyachment funciona como adjuntador de registros, usando el fopen la funcion mailer facilita la accion y solo se usa una funcion para adjuntar, acompañado de la ruta del archivo
      $mail->addAttachment("tmp/Reporte de sesiones ".$_SESSION['user_session'].".pdf");
      $mail->addAttachment("tmp/Reporte de sesiones ".$_SESSION['user_session'].".xls");
    

      

    //send the message, check for errors
    

   }
   }
   //chekeo de posibles errores dentro de alguno de los correos, de haber error en alguno se enviaran los otros pero uno, no
if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        //este condicional contiene los errores y de la misma forma que el condicional que se efectua por el correcto envio tambien elimina ls archivos de la ruta 
         unlink("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".pdf");
         unlink("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".xls");
    } else {
         echo ' Enviado Satisfactoriamente. Si no esta en su bandeja de entrada, verifique el SPAM ';
         //la sentencia de abajo hace la eliminacion del archivo en la ruta especifica. en este condicional se hace para verificar que el correo fue enviado, o por lo menos algunos de ellos
         unlink("tmp/Reporte de sesiones ".$_SESSION['user_session'].".pdf");
         unlink("tmp/Reporte de sesiones ".$_SESSION['user_session'].".xls");
    }

   
 ?>
