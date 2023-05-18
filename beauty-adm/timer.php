<?php
    include "../cnx_data.php";    //print_r($_SESSION);


    $QueryUltimoAcceso = mysqli_query($conn, "SELECT a.sescodigo, a.usucodigo,  CONCAT(a.sesfechainicio, ' ', a.seshorainicio)AS fecha FROM btysesiones a WHERE a.sescodigo = '".$_SESSION['numerosesion']."'");

    $fetchAcceso = mysqli_fetch_array($QueryUltimoAcceso);

    $UltimoAcceso = $fetchAcceso['fecha'];

    //echo $UltimoAcceso;
 
    if (!isset($_SESSION['user_session'])) 
    { 
        header("Location: login.php"); 
    } 
    else 
    { 

          $ahora = date("Y-n-j H:i:s");

          $tiempo_transcurrido = (strtotime($ahora)-strtotime($UltimoAcceso)); 

          if($tiempo_transcurrido >= 900) 
          { 
              $codigo_sesion   = $_SESSION['numerosesion'];
              $codigo_usu      = $_SESSION["codigoUsuario"];
              $fechf           = date("Y-n-j");
              $hfin            = date("H:i:s");

              $sql= "UPDATE `btysesiones` SET `sesfechafin`= '$fechf',`seshorafin`='$hfin',`sesestado`= 0 WHERE `sescodigo`= $codigo_sesion and `usucodigo`= $codigo_usu";
              
              if ($conn->query($sql)) 
              {
                echo "TRUE";
              } 
              else 
              {

                echo "Error: " . $sql . "" . mysqli_error($conn);

              } 


              session_destroy();
              header("Location: login.php");// destruyo la sesión 
          }
          else 
          { 
            $UltimoAcceso = $ahora; 
          }

          if ($_SESSION['user_session'] == "BLOCKED") 
          {
            header("Location: bloquear_pantalla.php");
          } 
    }