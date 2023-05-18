<?php
    session_destroy();
    include '../../../cnx_data.php';
    include("../funciones.php");
    $user=$_POST['user'];
    $pass=md5($_POST['pass']);
    $DB = mysqli_fetch_array(mysqli_query($conn,"SELECT DATABASE()"));
    // $_SESSION['Db']=$DB[0];
    $_SESSION['Db']='beauty_erp';

   
    $SqlUsuario =  "SELECT * FROM btyusuario u join btytercero t on t.trcdocumento=u.trcdocumento WHERE usulogin = '$user' AND usuestado= 1";
    
    $res = $conn->query($SqlUsuario);
    $rusr=$res->fetch_assoc();

           

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $user_os= getOS();
    $user_browser =getBrowser(); 
    $f = mysqli_query($conn, "SELECT MAX(sescodigo)AS max FROM btysesiones")or die(mysqli_error($conn));
    $g = mysqli_fetch_array($f);
    $idsesion = $g[0] + 1;
    
    $_SESSION['tipo_u']           = $rusr['tiucodigo'];
    $_SESSION['codigoUsuario']    = $rusr['usucodigo'];
    $_SESSION['user_session']     = $rusr['usulogin'];
    $_SESSION['documento']        = $rusr['trcdocumento']; 
    $_SESSION['numerosesion']     = $idsesion;
    $_SESSION['email']            = $rusr['usuemail'];


    if (mysqli_num_rows($res) > 0){

        $sqlpass="SELECT COUNT(*) FROM btyusuario WHERE usulogin = '$user' AND usuclave = '$pass' AND usuestado = 1";
        $resp=$conn->query($sqlpass);
        $rlog=$resp->fetch_array();

        if($rlog[0] == 1){
            $_SESSION['nombre']           = $rusr['trcnombres'];
            $_SESSION['apellido']         = $rusr['trcapellidos'];
            

            $sql="INSERT INTO btysesiones (sescodigo, sesmodulo, usucodigo, seslogin, sesdireccionipv4wan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado) VALUES('".$_SESSION['numerosesion']."', 'RECURSOS HUMANOS', '".$_SESSION['codigoUsuario']."', '".$_SESSION['user_session']."', '$ip', '$user_os', '$user_browser', CURDATE(), CURTIME(), CURDATE(), CURTIME(), 0, 1)";

                    if ($conn->query($sql))
                    {
                       if(privilegiologin("RECURSOS HUMANOS", $_SESSION['tipo_u'], $conn) ){
                        echo "3";//login OK                    
                       }else{
                        echo "4";
                       }
                    }  else{
                        echo $sql;
                    }
        }else{
            $RsSesion=mysqli_query($conn, "INSERT INTO btysesiones (sescodigo, sesmodulo, usucodigo, seslogin, sesdireccionipv4wan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado) VALUES('".$idsesion."', 'RECURSOS HUMANOS','".$rusr['usucodigo']."', '".$rusr['usulogin']."', '$ip', '$user_os', '$user_browser', CURDATE(), CURTIME(), CURDATE(), CURTIME(), 1, 0)")or die(mysqli_error($conn));
            echo "2";//contraseña errada
        }
    }           
    else{
        
       echo "1";//usuario no existe
    }


?>