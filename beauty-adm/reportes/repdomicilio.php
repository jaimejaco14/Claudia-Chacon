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
$sql="SELECT t.trcrazonsocial AS nomcli, t.trctelefonomovil AS telcli, CONCAT(t.trcdireccion,' ',b.brrnombre ) AS dircli, sl.slnnombre AS salon, CONCAT(c.citfecharegistro,' ',c.cithoraregistro) AS fechareg, t2.trcrazonsocial AS nomcol, s.sernombre AS serv, CONCAT(c.citfecha,' ',c.cithora) AS fechaaten, d.dmvalser AS valser, d.dmvalrec AS valrec, d.dmvaltrai AS valtrai, d.dmvaltrar AS valtrar, d.dmtotal AS valtotal, if(bty_fnc_estadocita(c.citcodigo) IN (1,10),'AGENDADA',ec.escnombre) AS estado
	FROM btydomicilio d
	JOIN btycita c ON d.citcodigo=c.citcodigo
	JOIN btyestado_cita ec ON ec.esccodigo=bty_fnc_estadocita(c.citcodigo)
	JOIN btycliente cl ON c.clicodigo=cl.clicodigo
	JOIN btytercero t ON t.tdicodigo=cl.tdicodigo AND t.trcdocumento=cl.trcdocumento
	JOIN btybarrio b ON t.brrcodigo=b.brrcodigo
	JOIN btycolaborador col ON c.clbcodigo=col.clbcodigo
	JOIN btytercero t2 ON t2.tdicodigo=col.tdicodigo AND t2.trcdocumento=col.trcdocumento
	JOIN btyservicio s ON c.sercodigo=s.sercodigo
	JOIN btysalon sl ON c.slncodigo=sl.slncodigo
	WHERE c.citfecha BETWEEN '$f1' AND '$f2' ".$wrsln;
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
//echo $sql;
?>