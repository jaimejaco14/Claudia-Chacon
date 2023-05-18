<?php
include '../../cnx_data.php';
$today = date("Y-m-d");
$colaborador = $_POST['txtColaborador'];

//old data
$salon_base = $_POST['txtSalonBase'];
$oldfecha_desde = $_POST['txtFechaUltimo'];

//NEW DATA 
$salon = $_POST['selectSalonBase'];
$observa= $_POST['observaciones'];
$fecha = $_POST['fechaDesde'];
$sol = (strtotime($fecha) - 3600); 
$hasta = date('Y-m-d', $sol);

//print_r($_POST);
//print_r($_SESSION);

//update old data
	$sql = "UPDATE `btysalon_base_colaborador` SET `slchasta`='$hasta' WHERE clbcodigo = $colaborador and slncodigo = $salon_base and slcdesde = '$oldfecha_desde' and slchasta IS NULL";
	if ($conn->query($sql)) {
		
	} else {

	}

//INSERT NEW data
	$sql = "INSERT INTO `btysalon_base_colaborador`(`clbcodigo`, `slncodigo`, `slcobservaciones`, `slcdesde`, `slccreacion`) VALUES ($colaborador,$salon,'$observa','".$fecha."', CURDATE())";
	if ($conn->query($sql)) {
		echo "TRUE";
	} else {
		echo "FALSE";
	}




