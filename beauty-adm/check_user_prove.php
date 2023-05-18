<?php 
include '../cnx_data.php';
 $id=$_POST['no_documento'];
 $sql="SELECT * FROM `btytercero` WHERE trcdocumento=$id";
 $result = $conn->query($sql);
 if ($result->num_rows > 0) {
 	$sqlb="SELECT u.trcdocumento, p.prvcodigo FROM  btyproveedor p INNER JOIN btytercero u on u.trcdocumento = p.trcdocumento where u.trcdocumento=$id";
 	 $resultt = $conn->query($sqlb);
 		if ($resultt->num_rows > 0) {
 			echo "PROVEDOR";
 		}else{
 			echo "EXIST";
 		}

 }else{
 	echo "NOEXIST";
 }

 ?>