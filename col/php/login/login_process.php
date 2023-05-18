<?php
    session_start();   
    include '../../../cnx_data.php';
    include("../funciones.php");
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $user_os= getOS();
    $user_browser =getBrowser(); 
    $f = mysqli_query($conn, "SELECT MAX(sescodigo)AS max FROM btysesiones_colaborador")or die(mysqli_error($conn));
    $g = mysqli_fetch_array($f);
    $idsesion = $g[0] + 1;
    $sw=$_POST['sw'];
    $SqlUsuario =  "SELECT * FROM btycolaborador WHERE trcdocumento = '".$_POST['user']."' AND clbestado= 1";
    
    $QueryUsuario = mysqli_query($conn, $SqlUsuario);


    if (mysqli_num_rows($QueryUsuario) > 0) 
    {        

        
        $QueryAcceso = mysqli_query($conn, "SELECT a.clbcodigo, a.trcdocumento, b.trcnombres, c.crgnombre, cat.ctcnombre, b.trcapellidos, c.crgincluircolaturnos, a.clbclave FROM btycolaborador AS a, btytercero AS b, btycargo AS c, btycategoria_colaborador AS cat WHERE a.trcdocumento=b.trcdocumento AND a.trcdocumento = '".$_POST['user']."' AND a.tdicodigo=b.tdicodigo AND cat.ctccodigo=a.ctccodigo AND c.crgcodigo=a.crgcodigo AND a.clbacceso = 1");



        if (mysqli_num_rows($QueryAcceso) > 0) 
        {
            $Rows =mysqli_fetch_array($QueryAcceso);

            if ($Rows['clbclave'] == null) 
            {
                //echo "Clave Vacia";
                echo "1";
            }
            else
            {
               $QueryEstado = mysqli_query($conn, "SELECT bty_fnc_estado_colaborador('".$Rows["clbcodigo"]."') AS estado");

                $estado = mysqli_fetch_array($QueryEstado);

                if ($estado['estado'] == 'VINCULADO') 
                {

                    $QueryPass = mysqli_query($conn, "SELECT clbclave FROM btycolaborador WHERE trcdocumento = '".$_POST['user']."' AND clbclave = md5('".$_POST['pass']."') ");


                    if (mysqli_num_rows($QueryPass) > 0) 
                    {
                        $_SESSION['clbcodigo']        = $Rows['clbcodigo'];
                        $_SESSION['trcdocumento']     = $Rows['trcdocumento'];
                        $_SESSION['nombre']           = $Rows['trcnombres'];
                        $_SESSION['apellido']         = $Rows['trcapellidos'];
                        $_SESSION['incluturno']       = $Rows['crgincluircolaturnos'];
                        $_SESSION['cargo']            = $Rows['crgnombre'];
                        $_SESSION['email']            = $Rows['clbemail'];
                        $_SESSION['categoria']        = $Rows['ctcnombre'];

                        if($sw==1){
                            $jsoncookie->codcol     = $_SESSION['clbcodigo'];
                            $jsoncookie->idnum      = $_SESSION['trcdocumento'];
                            $jsoncookie->nombre     = $_SESSION['nombre'];           
                            $jsoncookie->apellido   = $_SESSION['apellido'];         
                            $jsoncookie->sb         = $_SESSION['incluturno'];       
                            $jsoncookie->cargo      = $_SESSION['cargo'];           
                            $jsoncookie->email      = $_SESSION['email'];            
                            $jsoncookie->categoria  = $_SESSION['categoria'];   
                            $jsoncookie->logstatus  = 1;
                            setcookie('datacookie', json_encode($jsoncookie), time()+31556926 ,'/');
                        }


                        $sql="INSERT INTO btysesiones_colaborador (sescodigo, sesmodulo, clbcodigo, seslogin, sesdireccionipv4wan, sesdireccionipv4lan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado) VALUES('".$idsesion."', 'COLABORADOR', '".$_SESSION['clbcodigo']."', '".$_SESSION['trcdocumento']."', '$ip', '$localIP', '$user_os', '$user_browser', CURDATE(), CURTIME(), CURDATE(), CURTIME(), 0, 1)";
                        $conn->query($sql);
                        echo "3";
                    }
                    else
                    {
                        $RsSesion=mysqli_query($conn, "INSERT INTO btysesiones_colaborador (sescodigo, sesmodulo, clbcodigo, seslogin, sesdireccionipv4wan, sesdireccionipv4lan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado) VALUES('".$idsesion."', 'COLABORADOR','".$Rows['clbcodigo']."', '".$Rows['trcdocumento']."', '$ip', '$localIP', '$user_os', '$user_browser', CURDATE(), CURTIME(), CURDATE(), CURTIME(), 1, 0)")or die(mysqli_error($conn));
                        echo "2";
                    }
                }
                else
                {
                    echo "5";
                }
            }            
            
        }
        else
        {
            echo "6";
        }
                                              
        
    }           
    else
    {
        echo 4;
    }

    mysqli_close($conn);

?>