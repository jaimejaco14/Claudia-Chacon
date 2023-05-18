<?php
    session_start();   
    //if (!isset($_SESSION['PDVDb'])) 
    //{
        $_SESSION['PDVDb']  = $_POST['db'];
        $_SESSION['namedb'] = $_POST['dbname'];
    //}
    include('../../../cnx_data.php');
    include("../funciones.php");


    $QuerySln = mysqli_query($conn, "SELECT slnnombre FROM btysalon WHERE slncodigo = '".$_POST['slncodigo']."' ");

    $NombreSln = mysqli_fetch_array($QuerySln);
    $_SESSION['PDVslnNombre'] = $NombreSln['slnnombre'];
    $_SESSION['PDVslncodigo'] = $_POST['slncodigo'];
  

    $SqlUsuario =  "SELECT * FROM btyusuario WHERE usulogin = '".$_POST['user']."' AND usuestado='1'";
    
    $QueryUsuario = mysqli_query($conn, $SqlUsuario);



    if (mysqli_num_rows($QueryUsuario) > 0) 
    {        

        $SqlClave =  "SELECT * FROM btyusuario WHERE usulogin = '".$_POST['user']."' AND usuestado='1' and usuclave=MD5('".$_POST['pass']."')";
        
        $QueryClave = mysqli_query($conn, $SqlClave);

                    $user_agent     = $_SERVER['HTTP_USER_AGENT'];
                    $user_os        = getOS();
                    $user_browser   = getBrowser(); 
                    $f              = mysqli_query($conn, "SELECT MAX(sescodigo)AS max FROM btysesiones")or die(mysqli_error($conn));
                    $g              = mysqli_fetch_array($f);
                    $idsesion       = $g[0] + 1;
                    $RsUsuario      = mysqli_fetch_array($QueryUsuario);

            if (mysqli_num_rows($QueryClave) == 0)
            {  


                   
                    
                $RsSesion=mysqli_query($conn, "INSERT INTO btysesiones (sescodigo, sesmodulo, usucodigo, seslogin, sesdireccionipv4wan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado) VALUES('".$idsesion."', 'PUNTO DE VENTA','".$RsUsuario['usucodigo']."', '".$RsUsuario['usulogin']."', '$ip', '$user_os', '$user_browser', CURDATE(), CURTIME(), CURDATE(), CURTIME(), 1, 0)")or die(mysqli_error($conn));
                    echo 1;
            }
            else
            { 

                $_SESSION['PDVtipo_u']        = $RsUsuario['tiucodigo'];
                $_SESSION['PDVcodigoUsuario'] = $RsUsuario['usucodigo'];
                $_SESSION['PDVuser_session']  = $RsUsuario['usulogin'];
                $_SESSION['PDVdocumento']     = $RsUsuario['trcdocumento']; 
                $_SESSION['PDVusuemail']        = $RsUsuario['usuemail'];                   
                $_SESSION['PDVnumeroSesion']  = $idsesion;


               

                $QueryAcc = mysqli_query($conn, "SELECT * FROM btyusuario_salon usln WHERE usln.usucodigo =  '".$RsUsuario['usucodigo']."' AND usln.slncodigo = '".$_POST['slncodigo']."' AND usln.ussestado = 1");

                $QueryNombreUsu = mysqli_query($conn, "SELECT a.trcnombres FROM btytercero a WHERE a.trcdocumento = '".$RsUsuario['trcdocumento']."' ");
                $fetch = mysqli_fetch_array($QueryNombreUsu);
                $_SESSION['PDVnombreCol'] = $fetch['trcnombres'];


                if (mysqli_num_rows($QueryAcc) > 0) 
                {
                    $fecthQuery = mysqli_fetch_array($QueryAcc);

                    if ($fecthQuery['usshasta'] == null) 
                    {
                    

                            $sql=mysqli_query($conn, "INSERT INTO btysesiones (sescodigo, sesmodulo, usucodigo, seslogin, sesdireccionipv4wan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado) VALUES('".$_SESSION['PDVnumeroSesion']."', 'PUNTO DE VENTA', '".$_SESSION['PDVcodigoUsuario']."', '".$_SESSION['PDVuser_session']."', '$ip', '$user_os', '$user_browser', CURDATE(), CURTIME(), CURDATE(), CURTIME(), 0, 1)")or die(mysqli_error($conn));

                                if ($sql) 
                                {
                                    echo 3;
                                }
                    }
                    else
                    {
                        if ($fecthQuery['usshasta'] < date('Y-m-d')) 
                        {
                            echo 6;//FECHA VENCIDA
                        }
                        else
                        {
                            $sql=mysqli_query($conn, "INSERT INTO btysesiones (sescodigo, sesmodulo, usucodigo, seslogin, sesdireccionipv4wan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado) VALUES('".$_SESSION['PDVnumeroSesion']."', 'PUNTO DE VENTA', '".$_SESSION['PDVcodigoUsuario']."', '".$_SESSION['PDVuser_session']."', '$ip', '$user_os', '$user_browser', CURDATE(), CURTIME(), CURDATE(), CURTIME(), 0, 1)")or die(mysqli_error($conn));

                                if ($sql) 
                                {
                                    echo 3;
                                }
                        }
                    }
                }
                else
                {
                    echo 5;
                }                                       
                        
            }                       
        
    }           
    else
    {
        echo 4;//usuario equivocado
    }

    mysqli_close($conn);

?>