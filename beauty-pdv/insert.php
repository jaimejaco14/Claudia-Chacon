
<?php
/*define('E_FATAL',  E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR | 
        E_COMPILE_ERROR | E_RECOVERABLE_ERROR);
        define('ENV', 'dev');
        //Custom error handling vars
        define('DISPLAY_ERRORS', TRUE);
        define('ERROR_REPORTING', E_ALL | E_STRICT);
        define('LOG_ERRORS', TRUE);
        register_shutdown_function('shut');
        set_error_handler('handler');
        
        function shut()
        {
            $error = error_get_last();
            if($error && ($error['type'] & E_FATAL))
            {
                handler($error['type'], $error['message'], $error['file'], $error['line']);
            }
        }

        
        function handler( $errno, $errstr, $errfile, $errline ) 
        {

            switch ($errno)
            {
                case E_ERROR: // 1 //
                    $typestr = 'E_ERROR'; break;
                case E_WARNING: // 2 //
                    $typestr = 'E_WARNING'; break;
                case E_PARSE: // 4 //
                    $typestr = 'E_PARSE'; break;
                case E_NOTICE: // 8 //
                    $typestr = 'E_NOTICE'; break;
                case E_CORE_ERROR: // 16 //
                    $typestr = 'E_CORE_ERROR'; break;
                case E_CORE_WARNING: // 32 //
                    $typestr = 'E_CORE_WARNING'; break;
                case E_COMPILE_ERROR: // 64 //
                    $typestr = 'E_COMPILE_ERROR'; break;
                case E_CORE_WARNING: // 128 //
                    $typestr = 'E_COMPILE_WARNING'; break;
                case E_USER_ERROR: // 256 //
                    $typestr = 'E_USER_ERROR'; break;
                case E_USER_WARNING: // 512 //
                    $typestr = 'E_USER_WARNING'; break;
                case E_USER_NOTICE: // 1024 //
                    $typestr = 'E_USER_NOTICE'; break;
                case E_STRICT: // 2048 //
                    $typestr = 'E_STRICT'; break;
                case E_RECOVERABLE_ERROR: // 4096 //
                    $typestr = 'E_RECOVERABLE_ERROR'; break;
                case E_DEPRECATED: // 8192 //
                    $typestr = 'E_DEPRECATED'; break;
                case E_USER_DEPRECATED: // 16384 //
                    $typestr = 'E_USER_DEPRECATED'; break;
            }


            $message = '<b>'.$typestr.': </b>'.$errstr.' in <b>'.$errfile.'</b> on line <b>'.$errline.'</b><br/>';
            if(($errno & E_FATAL) && ENV === 'production')
            {
                header('Location: 500.html');
                header('Status: 500 Internal Server Error');
            }
            if(!($errno & ERROR_REPORTING))
                return;
            if(DISPLAY_ERRORS)
                printf('%s', $message);
            //Logging error on php file error log...
            if(LOG_ERRORS)
                error_log(strip_tags($message), 0);
        }
            ob_start();*/

$secret = "6LcQ9S4UAAAAAIFpvWZS4-aJleleIHrQBgAvsfxt";
include("../cnx_data.php");
// Recibimos por POST los datos procedentes del formulario  
$tabla_db1 = "btytercero";
$tipo_documento = $_POST["tipo_documento"];
$externo=$_POST['externo'];
$nombre = $_POST["nombres"];    
$apellidos = $_POST["apellidos"];
$sexo = $_POST["sexo"];
$documento = $_POST["no_documento"];
$ocupacion = $_POST["ocupacion"];
$barrio = $_POST["barrio"];
if ($_POST["telefono_fijo"] != "") {
  $telefono_fijo = $_POST["telefono_fijo"];

} else {
  $telefono_fijo = " ";
}

$telefono_movil = $_POST["telefono_movil"];
$email = $_POST["email"];  
$fecha = $_POST["fecha"];
$direccion = $_POST["direccion"];
$empresa = $_POST["tipo_nombre"];
$razon_social = $_POST["razon_social"];
$dv = $_POST["dv"];
$notif =$_POST["notif"];
$nmovil = "N";
$nemail = "N";
if ($_POST['extr'] != "") {
  $extr = $_POST['extr'];
  $barrio = 0;
  $direccion = " ";
} else {
  $extr = "N";
}

for ($i=0;$i<count($notif);$i++){     
  if  ($notif[$i]==  "movil"){
    $nmovil = "S";
  }
  if  ($notif[$i]==  "email"){
    $nemail = "S";
  }
  
}
if ($empresa == "S"){
  $ocupacion = 0;
}
$sql = "SELECT * from btytercero where trcdocumento = '$documento'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $conn->close();
  include 'insert_new_cliente.php';
    // output data of each row
  
} else {
  
  
  $razon = $nombre." ".$apellidos;
  if ($empresa == "S"){
    
    $sql = "INSERT INTO btytercero(tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, brrcodigo, trcestado) VALUES (1,'$documento','$dv',' ', ' ','$razon_social','$direccion', '$telefono_fijo', '$telefono_movil', '$barrio', '1')";
  } else{
    $sql = "INSERT INTO btytercero(tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, brrcodigo, trcestado) VALUES ('$tipo_documento','$documento','$dv','$nombre', '$apellidos','$razon','$direccion', '$telefono_fijo', '$telefono_movil', '$barrio', '1')"; 
  }
  if (mysqli_query($conn, $sql)) {
    //echo "New record created successfully";
    $conn->close();
    include 'insert_new_cliente.php';
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
 
            /*ob_end_flush();*/
?>