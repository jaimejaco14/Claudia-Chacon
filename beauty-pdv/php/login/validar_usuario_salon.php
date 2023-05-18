<?php 
	session_start();
	include("../../../cnx_data.php");

	$user = $_POST['user'];
	$pass = MD5($_POST['pass']);
	$sal  = $_POST['sal'];
	$hoy  = date("Y-m-d");

	$sql = mysqli_query($conn, "SELECT a.usucodigo, a.usulogin, a.usuclave, a.usuestado, b.slncodigo, b.ussdesde, b.usshasta, b.ussestado FROM btyusuario a JOIN btyusuario_salon b ON a.usucodigo=b.usucodigo WHERE a.usulogin = '$user' AND a.usuclave = '$pass' AND b.slncodigo = $sal AND b.ussestado = 1");

	if (mysqli_num_rows($sql) > 0) 
	{
		while($row = mysqli_fetch_array($sql))
		{
			$_SESSION['cod_usuario'] 	= $row['usucodigo'];
			$_SESSION['nombre']			= $row['usulogin'];
			$_SESSION['cod_salon']		= $row['slncodigo'];

					
			if ($row['usshasta'] == null) 
			{
			    echo 1;
			    return;
		    	}
		    	else
		    	{
		    		if ($hoy <= $row['usshasta']) 
		    		{
				   	echo 1;
			    	}
			    	else
			    	{
			    		echo 2;
			    	}
		    	}									
        	}	
		
	}
	else
	{
		echo 2;
	}


	mysqli_close($conn);
 ?>