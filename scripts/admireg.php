<?php 
include(dirname(__FILE__).'/../cnx_data.php');

$ter=0; $cli=0; $errcli=0; $errter=0; $errsql='';
$sql="SELECT DISTINCT(a.cliente) as ced,a.apellido1 AS ape1, a.apellido2 AS ape2, a.nombre1 AS nom1, a.nombre2 AS nom2, a.telefono as tel, a.direccion as dir, a.cumple as fna, s.slncodigo as sln, a.fecha as fre, a.sexo as sex
	FROM btyfromadmi a
	JOIN btysalon s ON s.slnadmi=a.salon
	WHERE  a.estado='A' AND a.td='fs' AND a.porce ='S' AND a.fecha=CURDATE()";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$ced	= preg_replace('/[^0-9]/','', $row['ced']);
	$ape	= str_replace('*', '', $row['ape1'].' '.$row['ape2']);
	$nom	= str_replace('*', '', $row['nom1'].' '.$row['nom2']);
	$rs		= $nom.' '.$ape;
	$tel	= preg_replace("/[^0-9]/",'', $row['tel']);
		$cel = strlen($tel)==10?$tel:''; 
	$dir	= str_replace('*','',$row['dir']);
	$fna	= preg_replace("/[^0-9]/",'', $row['fna']);
		$fnac = strlen($fna)==8?substr($fna,4,4).'-'.substr($fna,2,2).'-'.substr($fna,0,2):'';
	$sln	= $row['sln'];
	$fre	= $row['fre'];
	$sex 	= $row['sex'];
	$sql="INSERT INTO btytercero (tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, brrcodigo, trcestado) VALUES (2,$ced,0,'$nom','$ape','$rs','$dir','','$tel',0,1) ON DUPLICATE KEY UPDATE trcnombres='$nom', trcapellidos='$ape', trcrazonsocial='$rs', trcdireccion= '$dir', trctelefonomovil=IF(trctelefonomovil = '' OR LENGTH(trctelefonomovil)<>10 OR LENGTH('$tel')=10, '$tel', trctelefonomovil)";
	if($conn->query($sql)){
		$ter++;
		$sql="INSERT INTO btycliente (clicodigo, trcdocumento, tdicodigo, slncodigo, clisexo, ocucodigo, clifechanacimiento, clifecharegistro, clitiporegistro, cliestado, usucodigo) VALUES ((select max(c.clicodigo)+1 from btycliente c),'$ced', 2, $sln, '$sex', 0, '$fnac', '$fre', 'INTERNO-PDF417', 1, 0) ON DUPLICATE KEY UPDATE clisexo=IF('$sex'='M' OR '$sex'='F','$sex',clisexo), clifechanacimiento=IF(LENGTH('$fnac')=10,'$fnac',clifechanacimiento), clitiporegistro='INTERNO-PDF417'";
		if($conn->query($sql)){
			$cli++;
		}else{
			$errcli++;
			$errsql.='|'.$sql.'|';
		}
	}else{
		$errter++;
		$errsql.='|'.$sql.'|';
	}
}
echo 'cli:'.$cli.' / Errcli:'.$errcli.' | ter:'.$ter.'/ Errter: '.$errter.'| '.date("Y-m-d").PHP_EOL;
//echo $errsql;
?>