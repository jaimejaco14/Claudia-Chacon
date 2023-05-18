<?php
include '../cnx_data.php';
$op=$_POST['oper'];
switch($op){
	//INSERTAR NUEVO TIPO DE PUESTO*********************************************************
	case "NEW":
		$nombre=$_POST['nombre'];
		$alias=$_POST['alias'];
		$sql1="SELECT * FROM btytipo_puesto WHERE tptnombre='$nombre' OR tptalias='$alias'";
		$result = $conn->query($sql1);
		if($ntr = $result->num_rows>0){
			$row = mysqli_fetch_array($result);
			if($row['tptestado']==0){
				echo json_encode(array("RES" => "INACT", "codigo" => $row['tptcodigo']));
			}else{
				echo json_encode(array("RES" => "DUPLI"));
			}
			
		}else{
			$sql2="SELECT MAX(tptcodigo)+1 as cod FROM btytipo_puesto";
			$result = $conn->query($sql2);
			$row=$result->fetch_assoc();
			$cod=$row['cod'];

			$sql3="INSERT INTO btytipo_puesto (tptcodigo,tptnombre,tptalias,tptimagen,tptestado) VALUES ('$cod','$nombre','$alias','','1')";
			if($conn->query($sql3)){
				echo json_encode(array("RES"=>"TRUE"));
			}else{
				echo json_encode(array("RES"=>"FALSE"));
			}
		}	
	break;
	//BORRAR TIPO DE PUESTO*********************************************************************
	case "DEL":
		$cod=$_POST['codigo'];
		$sql="UPDATE btytipo_puesto SET tptestado=0 WHERE tptcodigo='$cod'";
			if($conn->query($sql)){
				echo "TRUE";
			}else{
				echo "FALSE";
			}
	break;
	//REACTIVAR TIPO DE PUESTO*******************************************************************
	case "RAC":
		$cod=$_POST['codigo'];
		$sql="UPDATE btytipo_puesto SET tptestado=1 WHERE tptcodigo='$cod'";
			if($conn->query($sql)){
				echo "TRUE1";
			}else{
				echo "FALSE1";
			}
	break;
	//BUSCAR TIPO DE PUESTO**********************************************************************
	case "BUS":
		$cod=$_POST['codigo'];
		$sql="SELECT * FROM btytipo_puesto WHERE tptcodigo='$cod'";
			if($result=$conn->query($sql)){
				$row=$result->fetch_assoc();
				echo json_encode(array("NOM" => $row['tptnombre'], "ALI" => $row['tptalias'], "COD" => $row['tptcodigo']));
			}else{
				echo json_encode(array("RES"=>"FALSE"));
			}
	break;
	//EDITAR TIPO DE PUESTO*************************************************************************
	case "UPD":
		$nombre=$_POST['nombre'];
		$alias=$_POST['alias'];
		$cod=$_POST['codigo'];
		$sql="SELECT * FROM btytipo_puesto WHERE tptnombre='$nombre' OR tptalias='$alias'";
		$result = $conn->query($sql);
		$ntr = $result->num_rows;
		if($ntr>1){
			echo "DUPLI";
		}else{
			$sql="UPDATE btytipo_puesto SET tptnombre='$nombre',tptalias='$alias' WHERE tptcodigo='$cod'";
			if($conn->query($sql)){
				echo "OK";
			}else{
				echo "FALSE";
			}
		}
	break;
}
$conn->close();
?>