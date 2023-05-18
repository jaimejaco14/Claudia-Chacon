<?php
function generaPass(){
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
     
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=10;
     
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
     
        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}
$user = $_POST['username'];
$fecha_clave = date("Y-m-d");
include '../cnx_data.php';

//$sql = "SELECT brrnombre FROM btybarrio";
if(($user = $_POST['username'])) {

$sql = "SELECT usulogin, usuemail FROM btyusuario where usulogin= '$user'";  //and usuclave = sha1($user_password);
/* @var $result type */
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    $pass = generaPass();
    
    while($row = $result->fetch_assoc()) {
        $email = $row['usuemail'];
    }
    
    // output data of each row
    $to = $email; //'remitente1prueba@gmail.com';
    $subject = 'Restablecer contraseña'; 
    $message = 'Usted ha solicitado restablecer su clave, su nueva clave es: '.$pass; 
    $headers = 'From: app@claudiachacon.com' . "\r\n" . 'Reply-To: app@claudiachacon.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); 
    if (mail($to, $subject, $message, $headers, '-fapp@claudiachacon.com')){
        $sql = "UPDATE `btyusuario` SET `usuclave`= md5('$pass'), usufechaultcambioclave= '$fecha_clave'  WHERE usulogin = '$user'";
                if ($conn->query($sql) === TRUE) {
                  //echo "Record updated successfully";
                    $_SESSION['record'] = 'true';
                    header("Location: recuperar_contraseña.php");
                    } else {
                        $_SESSION['record'] = '';
                        echo "Error updating record: " . $conn->error;
                    }
    } else {
        echo "erro en el mail ".$mail->ErrorInfo; 
    }
   
} else {
    
        echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Usuario no existe</font></div>';
    //echo '<div id="Success">Well</div>';
}
$conn->close();
} else {
    echo $user; 
    $_SESSION['record'] = 'False';
    header("Location: recuperar_contraseña.php");
}

 
?>


