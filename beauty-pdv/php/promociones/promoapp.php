<?php 
include '../../../cnx_data.php'; 
$ced=$_POST['ced'];
$cod=$_POST['cod'];
$sln=$_POST['sln'];
$sqlsk="SELECT a.careden, a.cacodigo FROM btyclienteApp a WHERE a.cacedula='$ced' AND a.capasswd='$cod'";//buscar estado en tb btyclienteApp
$res=$conn->query($sqlsk);
if($res->num_rows>0){
	$sk=$res->fetch_array();
	$cacod=$sk['cacodigo'];
	if($sk['careden']==0){
		$sqlupd="UPDATE btyclienteApp SET careden=1 WHERE cacedula='$ced' AND capasswd='$cod'";
		if($conn->query($sqlupd)){
			$sqlins="INSERT INTO btyclienteApp_redencion (cacodigo,carsalon,carfecha) VALUES ($cacod,$sln,NOW())";
			if($conn->query($sqlins)){
				echo json_encode(array('x'=>'OK'));//redencion registrada exitosamente
			}else{
				echo json_encode(array('x'=>'EI'));//error insersion DB
			}
		}else{
			echo json_encode(array('x'=>'EU'));//error Upd DB
		}
	}else if($sk['careden']==''){
		echo json_encode(array('x'=>'ER'));//error cedula/codigo
	}else if($sk['careden']==1){
		$sqldp="SELECT s.slnnombre, DATE_FORMAT(a.carfecha, '%Y-%m-%d / %h:%i %p') AS feho
				FROM btyclienteApp_redencion a
				JOIN btysalon s ON s.slncodigo=a.carsalon
				WHERE a.cacodigo=$cacod";
		$resdp=$conn->query($sqldp);
		$dt=$resdp->fetch_array();
		echo json_encode(array('x'=>'RO','sln'=>$dt['slnnombre'],'feho'=>$dt['feho']));//error cedula/codigo
	}else if($sk['careden']==2){
		echo json_encode(array('x'=>'NV'));//error cedula/codigo
	}
}else{
	echo json_encode(array('x'=>'ER'));//error cedula/codigo
}
?>