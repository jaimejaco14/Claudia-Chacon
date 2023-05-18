<?php 
	session_start();
	include("../../../cnx_data.php");

	$Db                 = $_POST['db'];
    $_SESSION['Db']     = $Db;
    $usuario            = $_POST['username'];
    $user_password      = $_POST['password'];
    $password           = MD5($user_password);
    $_SESSION['userr']  = $usuario;
    $salon              = $_POST['codsalon'];
    $Hoy                = date('Y-m-d');



    $QueryUsuario = mysqli_query($conn, "SELECT * FROM btyusuario WHERE usulogin = '$usuario'")or die("Error: " . mysqli_error($conn));

    if (mysqli_num_rows($QueryUsuario) > 0) 
    {
        echo "HAY UNO";
    }
    else
    {
        echo "CERO";
    }

    mysqli_close($conn);
 ?>