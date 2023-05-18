<?php
include '../cnx_data.php';

if ($_POST['no_documento'] != " ") {

//DATOS TERCERO
$tdicodigo = $_POST['tipo_documento'];
$cc = $_POST['no_documento'];
$dv = $_POST['dv'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$dir = $_POST['direccion'];
$tfijo = $_POST['telefono_fijo'];
$tmovil = $_POST['telefono_movil'];
$brr = $_POST['barrio'];
//DATOS USUARIO
$tiu_cod = $_POST['tiu'];
$email = $_POST['email'];
$clave = md5($_POST['password']);
$usu = $_POST['username'];
$today = date("Y-m-d");

$sql = "SELECT `tdicodigo`, `trcdocumento`, `trcdigitoverificacion`, `trcnombres`, `trcapellidos`, `trcrazonsocial`, `trcdireccion`, `trctelefonofijo`, `trctelefonomovil`, `brrcodigo`, `trcestado` FROM `btytercero` WHERE trcdocumento = $cc";
$result = $conn->query($sql);
if ($result->num_rows > 0){

	while ($row = $result->fetch_assoc()) {
			$tdicodigo=$row['tdicodigo'];
	$sqlmax = "SELECT MAX(`usucodigo`) as m FROM `btyusuario`";
	$max = $conn->query($sqlmax);
	if ($max->num_rows > 0) {
		while ($row = $max->fetch_assoc()) {
			$cod = $row['m'];
		} 
	} else {
		$cod = 0;
	}
	$cod = $cod +1;

	$sql = "INSERT INTO `btyusuario`(`usucodigo`, `trcdocumento`, `tdicodigo`, `tiucodigo`, `usuemail`, `usulogin`, `usuclave`, `usufechaprimerlogin`, `usufechaultcambioclave`, `usufecharegistro`, `usuestado`) VALUES ($cod, $cc, $tdicodigo, $tiu_cod, '$email', '$usu', '$clave', '$today', '$today', '$today',1)";
	if ($conn->query($sql)) {
		echo "TRUE";
	} else {

		echo "Error: " . $sql . "" . mysqli_error($conn);

	}
	}

} else {

$sql = "INSERT INTO `btytercero`(`tdicodigo`, `trcdocumento`, `trcdigitoverificacion`, `trcnombres`, `trcapellidos`, `trcrazonsocial`, `trcdireccion`, `trctelefonofijo`, `trctelefonomovil`, `brrcodigo`, `trcestado`) VALUES ($tdicodigo, $cc , $dv, '$nombres', '$apellidos', '".$nombres." ".$apellidos."', '$dir', $tfijo, $tmovil, '$brr', 1)";
if ($conn->query($sql)){
	$sqlmax = "SELECT MAX(`usucodigo`) as m FROM `btyusuario`";
	$max = $conn->query($sqlmax);
	if ($max->num_rows > 0) {
		while ($row = $max->fetch_assoc()) {
			$cod = $row['m'];
		} 
	} else {
		$cod = 0;
	}
	$cod = $cod +1;
	$sql = "INSERT INTO `btyusuario`(`usucodigo`, `trcdocumento`, `tdicodigo`, `tiucodigo`, `usuemail`, `usulogin`, `usuclave`, `usufechaprimerlogin`, `usufechaultcambioclave`, `usufecharegistro`, `usuestado`) VALUES ($cod, $cc, $tdicodigo, $tiu_cod, '$email', '$usu', '$clave', '$today', '$today', '$today',1)";
	if ($conn->query($sql)) {
		echo "TRUE";
	} else {

		echo "Error: " . $sql . "" . mysqli_error($conn);

	}	
} else {
	echo "Errorrrrrr: " . $sql . "" . mysqli_error($conn);
}
}
}else{
	echo"estoy 'Vacio'";
}
?>
