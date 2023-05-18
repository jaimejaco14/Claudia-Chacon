<?php 
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'cancel':
		$pgmcon=$_POST['pgmcon'];
		$obs=$_POST['obs'];
		$sql="UPDATE btyactivo_programacion SET pgmobservaciones='$obs', pgmestado='CANCELADO', pgmfechaestado=NOW() WHERE pgmconsecutivo=$pgmcon";
		if($conn->query($sql)){
			echo 'OK';
		}else{
			echo $sql;
		}
	break;
	case 'repro':
		$pgmcon=$_POST['pgmcon'];
		$newfec=$_POST['newfec'];
		$codact=$_POST['codact'];
		$cons="SELECT COUNT(*) FROM btyactivo_programacion p WHERE p.pgmfecha='$newfec' AND p.actcodigo=$codact AND p.pgmestado NOT IN ('EJECUTADO','CANCELADO')";
		$rcons=$conn->query($cons);
		$result=$rcons->fetch_array();
		if($result[0]==0){
			$sql="UPDATE btyactivo_programacion SET pgmfecha='$newfec', pgmestado='RE-PROGRAMADO' WHERE pgmconsecutivo=$pgmcon";
			if($conn->query($sql)){
				echo 'OK';
			}else{
				echo $sql;
			}
		}else{
			echo 'dupli';
		}
	break;
	case 'info':
		$pgmcon=$_POST['pgmcon'];
		$sql="SELECT pgmobservaciones, pgmfechaestado, pgmejecuta FROM btyactivo_programacion WHERE pgmconsecutivo=$pgmcon";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$row=$res->fetch_array();
			echo json_encode(array("res"=>"OK","obs"=>$row[0],"fechaexe"=>$row[1],"executer"=>$row[2]));
		}else{
			echo json_encode(array("res"=>"error"));
		}		
	break;
}
?>