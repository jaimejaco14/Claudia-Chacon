<?php
    include '../cnx_data.php';
    //session_start();   
    if (!isset($_SESSION['Db'])) 
    {
        $_SESSION['Db'] = $_POST['db'];
    }
    include("./php/funciones.php");



    $SqlUsuario =  "SELECT * FROM btyusuario WHERE usulogin = '".$_POST['user']."' AND usuestado='1'";
    
    $QueryUsuario = mysqli_query($conn, $SqlUsuario);



    if (mysqli_num_rows($QueryUsuario) > 0) 
    {        

        $SqlClave =  "SELECT * FROM btyusuario WHERE usulogin = '".$_POST['user']."' AND usuestado='1' and usuclave=MD5('".$_POST['pass']."')";
        
        $QueryClave = mysqli_query($conn, $SqlClave);

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    $user_os= getOS();
                    $user_browser =getBrowser(); 
                    $f = mysqli_query($conn, "SELECT MAX(sescodigo)AS max FROM btysesiones")or die(mysqli_error($conn));
                    $g = mysqli_fetch_array($f);
                    $idsesion = $g[0] + 1;
                    $RsUsuario = mysqli_fetch_array($QueryUsuario);

            if (mysqli_num_rows($QueryClave) == 0)
            {                  
                    
                $RsSesion=mysqli_query($conn, "INSERT INTO btysesiones (sescodigo, sesmodulo, usucodigo, seslogin, sesdireccionipv4wan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado) VALUES('".$idsesion."', 'ADMINISTRATIVO','".$RsUsuario['usucodigo']."', '".$RsUsuario['usulogin']."', '$ip', '$user_os', '$user_browser', CURDATE(), CURTIME(), CURDATE(), CURTIME(), 1, 0)")or die(mysqli_error($conn));
                    echo 1;
            }
            else
            { 

                $_SESSION['tipo_u']        = $RsUsuario['tiucodigo'];
                $_SESSION['codigoUsuario'] = $RsUsuario['usucodigo'];
                $_SESSION['user_session']  = $RsUsuario['usulogin'];
                $_SESSION['documento']     = $RsUsuario['trcdocumento'];                        
                $_SESSION['numerosesion']  = $idsesion;
                $_SESSION['dbname']        = $_POST['dbname'];

                $sql=mysqli_query($conn, "INSERT INTO btysesiones (sescodigo, sesmodulo, usucodigo, seslogin, sesdireccionipv4wan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado) VALUES('".$_SESSION['numerosesion']."', 'ADMINISTRATIVO', '".$_SESSION['codigoUsuario']."', '".$_SESSION['user_session']."', '$ip', '$user_os', '$user_browser', CURDATE(), CURTIME(), CURDATE(), CURTIME(), 0, 1)")or die(mysqli_error($conn));

                    if ($sql) 
                    {
                        echo 3;                        
                    }                           
                        
            }                       
        
    }           
    else
    {
        echo 4;//usuario equivocado
    }

    mysqli_close($conn);

?>