<?php 
include '../../../cnx_data.php'; 
$opc=$_POST['opc'];
switch($opc){
	case 'loadpromo':
		mysqli_set_charset($conn, 'UTF8');
		$sln=$_POST['sln'];
		$sql="SELECT p.pmocodigo,pt.tpmnombre,p.pmonombre,p.pmocondyrestric,p.pmreqregistro
				FROM btypromocion p
				JOIN btypromocion_tipo pt ON pt.tpmcodigo=p.tpmcodigo
				JOIN btypromocion_detalle pd ON pd.pmocodigo=p.pmocodigo
				WHERE pd.slncodigo=$sln and p.pmoestado=1 AND (p.lgbfechafin IS NULL OR p.lgbfechafin>=CURDATE())
				GROUP BY pmocodigo";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row[0], 'nom'=>$row[1].' '.$row[2], 'cond'=>$row[3], 'reqreg'=>$row[4]));
		}
		echo json_encode($array);
	break;
	case 'loadser':
		$txt=utf8_decode($_POST['txt']);
		$sql="SELECT s.sercodigo,s.sernombre
				FROM btyservicio s
				WHERE s.sernombre LIKE '%".$txt."%'";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['sercodigo'], 'nom'=>utf8_encode($row['sernombre'])));
		}
		echo json_encode($array);
	break;
	case 'loadcli':
		$txt=utf8_decode($_POST['txt']);
		$rrg=$_POST['reqreg'];
		$pmo=$_POST['pmo'];
		if($rrg==1){
			$join=" JOIN btypromoregistro r on r.clicodigo=a.clicodigo";
			$rreg=" and r.proestado=1";
		}else{
			$rreg="";
		}
		if($pmo==3){
			$join2=" JOIN btypromouniversidad u on u.puncodigo=r.prodato";
			$uninom=", u.punnombre as datoadic";
		}else{
			$join2="";
			$uninom="";
		}
		$sql="SELECT a.clicodigo, b.trcrazonsocial, b.trcdocumento".$uninom." FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo ".$join.$join2." WHERE b.trcrazonsocial like '%".$txt."%' or b.trcdocumento like '%".$txt."%'".$rreg;
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			if(!isset($row['datoadic'])){
				$data="";
			}else{
				$data=$row['datoadic'];
			}
			$array[]=(array('cod'=>$row['clicodigo'], 'nom'=>utf8_encode($row['trcrazonsocial']), 'ced'=>$row['trcdocumento'], 'adic'=>$data));
		}
		echo json_encode($array);
	break;
	case 'regis':
		$pro=$_POST['pro'];
		$ser=$_POST['ser'];
		$cli=$_POST['cli'];
		$usr=$_POST['usr'];
		$sln=$_POST['sln'];
		$sql="INSERT INTO btyredencion_promo (repcodigo,pmocodigo,clicodigo,sercodigo,slncodigo,usucodigo,repfecha) VALUES ((SELECT IFNULL(MAX(rp.repcodigo)+1,1) FROM btyredencion_promo rp),$pro,$cli,$ser,$sln,$usr,NOW())";
		if($conn->query($sql)){
			echo 0;
		}else{
			echo 1;
		}
	break;
}

?>
