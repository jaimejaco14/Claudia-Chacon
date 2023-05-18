<?php 
include '../cnx_data.php';

	$user = $_POST['user'];
	$pass = sha1($_POST['pass']);
	$sal  = $_POST['sal'];
	$hoy = date("Y-m-d");

	$sql = mysqli_query($conn, "SELECT a.usucodigo, a.usulogin, a.usuclave, a.usuestado, b.slncodigo, b.ussdesde, b.usshasta, b.ussestado FROM btyusuario a JOIN btyusuario_salon b ON a.usucodigo=b.usucodigo WHERE a.usulogin = '$user' AND a.usuclave = '$pass' AND b.slncodigo = $sal AND b.ussestado = 1 ");

	if (mysqli_num_rows($sql) > 0) {
		$row = mysqli_fetch_array($sql);
		
		$_SESSION['cod_usuario'] 	= $row['usucodigo'];
		$_SESSION['nombre']			= $row['usulogin'];
		$_SESSION['cod_salon']		= $row['slncodigo'];
		

		echo 1;
	}else{
		echo 2;
	}


	mysqli_close($conn);
 ?>