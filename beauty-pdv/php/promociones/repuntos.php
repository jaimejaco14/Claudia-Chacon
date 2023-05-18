<?php 
include '../../../cnx_data.php'; 
$opc=$_POST['opc'];
switch($opc){
	case 'pto':
		$doc=$_POST['doc'];
		$sql="SELECT p.pccantidad AS pto FROM btypuntoscliente p WHERE p.cacedula=$doc";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		echo json_encode(array('pto'=>$row[0]));
	break;
	case 'red':
		$ced =$_POST['ced'];
		$ose =$_POST['ose'];
		$csln=$_POST['csln'];
		$pto =$_POST['pto'];
		$cus =$_POST['cus'];
		$dif =$_POST['dif'];
		$tpr =$_POST['tpr'];
		$sql ="INSERT INTO btyredencionpuntos (cacedula, pcoservicio, pcfeho, pcpuntos, usucod, slncodigo, pctipo) VALUES ('$ced', '$ose', NOW(), $pto, $cus, $csln,'$tpr')";
		if($conn->query($sql)){
			$upd="UPDATE btypuntoscliente SET pccantidad=$dif WHERE cacedula=$ced";
			if($conn->query($upd)){
				echo 1;
			}else{
				echo $upd;	
			}
		}else{
			echo $sql;
		}
	break;
	case 'reprint':
		$sln=$_POST['sln'];
		$sql="SELECT s.slnnombre AS sln, rp.pcoservicio AS ose, DATE_FORMAT(rp.pcfeho, '%d/%m/%Y %r') AS feho, rp.cacedula AS ced, CONCAT(SUBSTRING_INDEX(t.trcnombres,' ',1),' ', SUBSTRING_INDEX(t.trcapellidos,' ',1)) AS cli, rp.pcpuntos AS ptos, FORMAT((rp.pcpuntos*2),0) AS equi, t2.trcnombres AS usr
			FROM btyredencionpuntos rp
			JOIN btytercero t ON t.trcdocumento=rp.cacedula
			JOIN btysalon s ON s.slncodigo=rp.slncodigo
			JOIN btyusuario u ON u.usucodigo=rp.usucod
			JOIN btytercero t2 ON t2.trcdocumento=u.trcdocumento
			WHERE rp.slncodigo=2
			ORDER BY rp.pcfeho DESC
			LIMIT 1";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$row=$res->fetch_array();
			$array=array('sw'=>'1', 'sln'=>$row['sln'], 'ose'=>$row['ose'], 'feho'=>$row['feho'], 'ced'=>$row['ced'], 'cli'=>$row['cli'], 'rpto'=>$row['ptos'], 'equi'=>$row['equi'], 'usr'=>$row['usr']);
		}else{
			$array=array('sw'=>'0');
		}
		echo json_encode($array);
	break;
}

?>