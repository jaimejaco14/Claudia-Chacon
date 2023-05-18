<?php 
	session_start();
	include("../../../cnx_data.php");

	$cod_salon = $_SESSION['PDVslncodigo'];
	$user      = $_SESSION['PDVcodigoUsuario'];


	$cons = mysqli_query($conn,"SELECT * FROM  btyturnos_atencion WHERE slncodigo = $codSalon AND tuafechai = CURDATE() ");

	if (mysqli_num_rows($cons) > 0) {
		echo 1;
	}else{

		$sql = mysqli_query($conn, "INSERT INTO btyturnos_atencion(slncodigo, tuafechai, tuafechaf, tuahorai, tuahoraf, usucodigoi, usucodigof, tuatotal, tuaobservacionesi, tuaobservacionesf)VALUES($cod_salon, CURDATE(), CURDATE(), CURTIME(), CURTIME(), $user, $user, '0', '' , '' )")or die(mysqli_error($conn));
		if ($sql) {
			echo 2;
		}
	}

	mysqli_close($conn);
?>
