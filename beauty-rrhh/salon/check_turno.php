<?php
include '../../cnx_data.php';
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$nombre = $_POST['turno_name'];
$alm_inicio = $_POST['start'];
$alm_fin = $_POST['end'];
$sql = "SELECT * FROM `btyturno` WHERE  trnhasta = '$hasta' and trndesde = '$desde' and trninicioalmuerzo='$alm_inicio' and trnfinalmuerzo='$alm_fin'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$data=mysqli_fetch_array($result);
	if($data['trnestado']=='0'){
		echo "FALSE";
	}else{
		if($nombre==$data['trnnombre']){
			echo "OTHER";
		}else{
			echo "OTHER2";
		}	
	}
} else {
	echo "TRUE";
}