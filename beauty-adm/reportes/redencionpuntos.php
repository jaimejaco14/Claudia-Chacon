<?php 
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'gentb':
		$sql="SELECT CONCAT(a.canombre,' ',a.caapellido) AS nomcli, s.slnnombre AS salon, DATE_FORMAT(p.pcfeho,'%Y-%m-%d') AS fecha,  DATE_FORMAT(p.pcfeho,'%H:%i') AS hora, p.pcoservicio AS orden, p.pctipo AS tipo, p.pcpuntos AS punto, (p.pcpuntos*2) AS monto, CONCAT(SUBSTRING_INDEX(t.trcnombres, ' ',1),' ',SUBSTRING_INDEX(t.trcapellidos,' ',1)) AS user
			FROM btyredencionpuntos p
			JOIN btyclienteApp a ON a.cacedula=p.cacedula
			JOIN btysalon s ON p.slncodigo=s.slncodigo
			JOIN btyusuario u ON p.usucod=u.usucodigo
			JOIN btytercero t ON u.tdicodigo=t.tdicodigo AND u.trcdocumento=t.trcdocumento
			ORDER BY p.pcfeho desc";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		if($res->num_rows>0){
			while($data = mysqli_fetch_assoc($res)){
	             $array['data'][] = $data;
	        }  
		}else{
			$array=array('data'=>'');
		}
		echo json_encode($array);
	break;
}
?>