<?php 
session_start();
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'unlock':
		$pass=$_POST['pass'];
		$sql="SELECT * FROM btyactivo_personal WHERE apseccodigo=".$pass;
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$row=$res->fetch_array();
		  	$_SESSION['auth']='OK';
		  	$_SESSION['executer']=$row['apnombre'];
			echo 'OK';
		}else{
			echo 'boom';
		}
	break;
	case 'seek':
		if(isset($_SESSION['auth'])){
			$idact=$_POST['idact'];
			echo 'php/ejecutar.php?idact='.$idact;
		}else{
			session_destroy();
			session_unset();
			echo 'www.claudiachacon.com';
		}
	break;
	case 'exe':
		$pgmcon=$_POST['pgmcon'];
		$obs=$_POST['obs'];
		$exec=$_SESSION['executer'];
		$sql="UPDATE btyactivo_programacion SET pgmobservaciones='$obs', pgmestado='EJECUTADO', pgmfechaestado=NOW(), pgmejecuta='$exec' WHERE pgmconsecutivo=$pgmcon";
		if($conn->query($sql)){
			echo 'OK';
		}else{
			echo $sql;
		}
	break;
}
?>