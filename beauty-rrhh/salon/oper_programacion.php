<?php
include '../../cnx_data.php';
$op=$_POST['oper'];
switch($op){
	//INSERTAR NUEVO TIPO DE PROGRAMACION*********************************************************
	case "NEW":
		$nombre=$_POST['nombre'];
		$alias=$_POST['alias'];
		$lab=$_POST['lab'];
		$color=$_POST['color'];
		$sql1="SELECT * FROM btytipo_programacion WHERE tprnombre='$nombre' OR tpralias='$alias'";
		$result = $conn->query($sql1);
		if($ntr = $result->num_rows>0){
			$row = mysqli_fetch_array($result);
			if($row['tprestado']==0){
				echo json_encode(array("RES" => "INACT", "codigo" => $row['tprcodigo']));
			}else{
				echo json_encode(array("RES" => "DUPLI"));
			}
			
		}else{
			$sql2="SELECT MAX(tprcodigo)+1 as cod FROM btytipo_programacion";
			$result = $conn->query($sql2);
			$row=$result->fetch_assoc();
			$cod=$row['cod'];

			$sql3="INSERT INTO btytipo_programacion (tprcodigo,tprnombre,tpralias,tprlabora,tprcolor,tprestado) VALUES ('$cod','$nombre','$alias','$lab','$color','1')";
			if($conn->query($sql3)){
				echo json_encode(array("RES"=>"TRUE"));
			}else{
				echo json_encode(array("RES"=>"FALSE"));
			}
		}	
	break;
	//BORRAR TIPO DE PROGRAMACION*********************************************************************
	case "DEL":
		$cod=$_POST['codigo'];
		$sql="UPDATE btytipo_programacion SET tprestado=0 WHERE tprcodigo='$cod'";
			if($conn->query($sql)){
				echo "TRUE";
			}else{
				echo "FALSE";
			}
	break;
	//REACTIVAR TIPO DE PROGRAMACION*******************************************************************
	case "RAC":
		$cod=$_POST['codigo'];
		$sql="UPDATE btytipo_programacion SET tprestado=1 WHERE tprcodigo='$cod'";
			if($conn->query($sql)){
				echo "TRUE1";
			}else{
				echo "FALSE1";
			}
	break;
	//BUSCAR TIPO DE PROGRAMACION**********************************************************************
	case "BUS":
		$cod=$_POST['codigo'];
		$sql="SELECT * FROM btytipo_programacion WHERE tprcodigo='$cod'";
			if($result=$conn->query($sql)){
				$row=$result->fetch_assoc();
				echo json_encode(array("NOM" => $row['tprnombre'], "ALI" => $row['tpralias'], "COD" => $row['tprcodigo'], "LAB" => $row['tprlabora'], "COL" => $row['tprcolor']));
			}else{
				echo json_encode(array("RES"=>"FALSE"));
			}
	break;
	//EDITAR TIPO DE PROGRAMACION*************************************************************************
	case "UPD":
		$nombre=$_POST['nombre'];
		$alias=$_POST['alias'];
		$lab=$_POST['lab'];
		$color=$_POST['color'];
		$cod=$_POST['codigo'];
		$sql="SELECT * FROM btytipo_programacion WHERE tprnombre ='$nombre' OR tpralias ='$alias'";
		$result = $conn->query($sql);
		$ntr = $result->num_rows;
		if($ntr>1){
			echo "DUPLI";
		}else{
			$sql="UPDATE btytipo_programacion SET tprnombre ='$nombre',tpralias ='$alias',tprlabora ='$lab',tprcolor ='$color' WHERE tprcodigo ='$cod'";
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