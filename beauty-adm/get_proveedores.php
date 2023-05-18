<?php
include '../cnx_data.php';
$sql="SELECT u.trcdocumento, t.tdialias, p.prvemail, u.tdicodigo, u.trcrazonsocial, u.trcnombres, u.trcapellidos, u.trcdireccion, u.trctelefonofijo, u.trctelefonomovil, b.brrcodigo, b.brrnombre, c.loccodigo, c.locnombre, d.depcodigo, d.depombre FROM btytercero u INNER JOIN  btybarrio b on b.brrcodigo=u.brrcodigo INNER JOIN btylocalidad c on c.loccodigo = b.loccodigo INNER JOIN btydepartamento d on d.depcodigo=c.depcodigo INNER JOIN btyproveedor p on p.trcdocumento=u.trcdocumento INNER JOIN btytipodocumento t on t.tdicodigo = u.tdicodigo where p.prvestado=1 and u.trcdocumento = ".$_POST['codigo'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo $row['trcrazonsocial'].","; 	//0
		echo $row['tdialias'].","; 	//1
		echo $row['trcdocumento'].","; 	//2
		echo $row['prvemail'].","; 	//3
		echo $row['trcdireccion'].",";	//4
		echo $row['depombre'].",";		//5
		echo $row['locnombre'].",";		//6
		echo $row['brrnombre'].",";	//7
		echo $row['trctelefonofijo'].",";//8
		echo $row['trctelefonomovil'].","; //9
	}
} else {
	echo "string";
}
?>