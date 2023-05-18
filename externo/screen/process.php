<?php
include '../../cnx_data.php'; 
$sln=$_POST['sln'];
$crg=$_POST['crg'];
$clb=$_POST['clb'];
$array=array();
$sql2="SELECT SUBSTRING_INDEX(t.trcnombres,' ',1) as nombre,col.cblimagen,col.clbcodigo,cc.ctccolor,pt.ptrnombre
	FROM btycola_atencion ca
	JOIN btycolaborador col ON col.clbcodigo=ca.clbcodigo
	JOIN btytercero t ON t.trcdocumento=col.trcdocumento
	JOIN btycargo cg ON cg.crgcodigo=col.crgcodigo
	JOIN btycategoria_colaborador cc on cc.ctccodigo=col.ctccodigo
	JOIN btyprogramacion_colaboradores pc ON pc.clbcodigo=ca.clbcodigo AND pc.prgfecha= CURDATE()
	JOIN btypuesto_trabajo pt ON pt.ptrcodigo=pc.ptrcodigo
	WHERE ca.slncodigo=$sln AND ca.coldisponible=1 AND ca.tuafechai= CURDATE() AND ca.colhorasalida IS NULL AND col.crgcodigo=$crg
	ORDER BY ca.colposicion
	LIMIT 8";
$res2=$conn->query($sql2);
if($res2->num_rows>0){
	while($row2=$res2->fetch_array()){
		$codcol=$row2['clbcodigo'];
		$nomcol=utf8_encode($row2['nombre']);
		$fotcol=$row2['cblimagen'];
		$color=$row2['ctccolor'];
		$pto=$row2['ptrnombre'];
		$array[]=(array('codcol'=>$codcol,'nomcol'=>$nomcol,'foto'=>$fotcol,'colr'=>$color,'pto'=>$pto));
	}
}else{
	$codcol=0;
	$nomcol='';
	$fotcol='default.jpg';
	$color='';
	$pto='';
	$array[]=(array('codcol'=>$codcol,'nomcol'=>$nomcol,'foto'=>$fotcol,'colr'=>$color,'pto'=>$pto));
}
echo json_encode($array);
?>

