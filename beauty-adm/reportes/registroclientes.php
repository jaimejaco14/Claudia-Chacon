<?php
include '../../cnx_data.php';
$f1=$_POST['f1'];
$f2=$_POST['f2'];
$sln=$_POST['sln'];
$wrsln='';
if($sln!=''){
	$sl=implode($sln,',');
	$wrsln=" and s.slncodigo in ($sl) ";
}
$sql="SELECT s.slnnombre AS sln,
		SUM(CASE WHEN c.clitiporegistro='INTERNO' THEN 1 ELSE 0 END) AS man,
		SUM(CASE WHEN c.clitiporegistro='INTERNO-PDF417' THEN 1 ELSE 0 END) AS scan,
		COUNT(*) AS total
		FROM btycliente c
		JOIN btysalon s ON s.slncodigo=c.slncodigo
		WHERE c.clifecharegistro BETWEEN '$f1' AND '$f2' AND s.slnestado=1 ".$wrsln."
		GROUP BY s.slncodigo ORDER BY s.slnnombre";
$res=$conn->query($sql);
if($res->num_rows>0){
	while($data = mysqli_fetch_assoc($res)){
	    $array['data'][] = $data;
	} 
}else{
	$array['data'][] = '';
}
echo json_encode($array);
//echo $sql;
?>