<?php 
include(dirname(__FILE__).'/../cnx_data.php');
$sql="INSERT INTO btypuntoscliente(cacedula, pccantidad) 
		SELECT z.cedula, z.valor FROM 
		(SELECT distinct(p.cacedula) AS cedula, (b.valor/100) AS valor
		FROM btyfromadmi2 b
		JOIN btyfromadmi a on a.ndocu=b.nfactura AND a.fecha=b.fecha
		JOIN btyclienteApp p ON p.cacedula=a.cliente
		WHERE b.fecha=CURDATE() AND a.estado='A'
		) AS z
		ON DUPLICATE KEY UPDATE pccantidad=pccantidad+z.valor";

if($conn->query($sql)){
	echo 'OK - '.date("Y-m-d").PHP_EOL;
}else{
	echo '**** F A I L **** '.date("Y-m-d").PHP_EOL;
}	
?>