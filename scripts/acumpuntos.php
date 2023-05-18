<?php 
include(dirname(__FILE__).'/../cnx_data.php');
$ins=0;$err=0;
$sql="SELECT a.cacedula as cli
		FROM btyclienteApp a
		WHERE a.cacedula NOT IN (SELECT p.cacedula FROM btypuntoscliente p)";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$cli=$row['cli'];
	$sqlp="SELECT IFNULL(SUM(z.cant)/100,0) AS puntos FROM 
			(SELECT DISTINCT(d.ndocu) AS fact, d2.valor AS cant
			FROM btyfromadmi d
			JOIN btyfromadmi2 d2 ON d.ndocu=d2.nfactura
			WHERE d.fecha BETWEEN '2019-07-01' AND CURDATE() AND d.td='FS' AND d.estado='A' AND d.cliente='$cli') AS z";
	$resp=$conn->query($sqlp);
	$rowp=$resp->fetch_array();
	$pto=$rowp['puntos'];
	$sqlins="INSERT INTO btypuntoscliente(cacedula, pccantidad) VALUES ($cli, $pto)";
	if($conn->query($sqlins)){
		$ins++;
	}else{
		$err++;
	}
}
echo ''.date("Y-m-d").' | Insertados: '.$ins.' | Errores: '.$err.PHP_EOL;
?>