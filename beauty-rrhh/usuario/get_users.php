<?php
include '../../cnx_data.php';
$sql = "SELECT u.`usucodigo`, u.`trcdocumento`, u.`tdicodigo`, u.`tiucodigo`, u.`usuemail`, u.`usulogin`, t.trcnombres, t.trcapellidos, t.trcdireccion, t.trctelefonofijo, t.trctelefonomovil, t.brrcodigo FROM `btyusuario` u INNER JOIN btytercero t ON t.trcdocumento = u.trcdocumento AND u.tdicodigo =t.tdicodigo WHERE u.usucodigo = ".$_POST['codigo'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo $row['usucodigo'].","; 	//0
		echo $row['trcnombres'].","; 	//1
		echo $row['trcapellidos'].","; 	//2
		echo $row['tdicodigo'].","; 	//3
		echo $row['trcdocumento'].",";	//4
		echo $row['usulogin'].",";		//5
		echo $row['brrcodigo'].",";		//6
		echo $row['trcdireccion'].",";	//7
		echo $row['trctelefonofijo'].",";//8
		echo $row['trctelefonomovil'].",";//9
		echo $row['tiucodigo'].","; //10
		echo $row['usuemail'].","; //11
	}
} else {
	echo "string";
}