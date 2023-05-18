<?php 
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'gentb':
		$sql="SELECT a.dacodigo as numor, CONCAT(a.dcclinom, ' ', a.dccliape) as nomcli, a.dccliced, a.dcservicio, a.dctipo, IF(a.dcsalon=0,'-',s.slnnombre) AS salon, a.dcfhreg AS fehoagen, ifnull(CONCAT(c.citfecharegistro,' ',c.cithoraregistro),'-') AS fehoges, a.daestado, IF(a.dctipo='CITA','c','d') AS tipo, a.dacodigo AS id, a.dcfhdom AS fehocd,  if(a.dctpago='EFE','CONTRAENTREGA','EN LINEA') AS tpgo, a.dcfhdom AS reserv
			FROM btydomicitaApp a
			LEFT JOIN btycita c ON c.citcodigo=a.citcodigo
			JOIN btysalon s ON a.dcsalon=s.slncodigo
			WHERE a.dctipo <> '' ORDER BY a.dcfhreg desc";
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
	case 'detacido':
		$id=$_POST['id'];
		$sql="SELECT a.dcclicel, a.dcfhdom, IF(a.dcobser='','Ninguna',a.dcobser) AS dcobser, IF(a.dcclidir='','N/A',a.dcclidir) AS clidir, a.citcodigo, a.dccliced AS cliced
			FROM btydomicitaApp a
			JOIN btyclienteApp c ON c.cacedula=a.dccliced
			WHERE a.dacodigo=$id";
		//mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		$dtcc=array('cel'=>$row['dcclicel'],'fhcd'=>$row['dcfhdom'],'obs'=>$row['dcobser'],'dir'=>$row['clidir'], 'ced'=>$row['cliced']);
		$codcita=explode(',',$row['citcodigo']);
		foreach($codcita as $cc){
			$sql="SELECT s.sernombre AS ser, t.trcrazonsocial AS col, g.crgnombre AS crg, col.clbcodigo AS ccol 
					FROM btycita c
					JOIN btyservicio s ON s.sercodigo=c.sercodigo
					JOIN btycolaborador col ON c.clbcodigo=col.clbcodigo
					JOIN btytercero t ON t.trcdocumento=col.trcdocumento AND t.tdicodigo=col.tdicodigo
					JOIN btycargo g ON col.crgcodigo=g.crgcodigo
					WHERE c.citcodigo=$cc";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			$dtsc[]=array('ser'=>utf8_encode($row['ser']),'col'=>utf8_encode($row['col']),'crg'=>$row['crg'],'ccol'=>$row['ccol'],'cita'=>$cc);
		}
		echo json_encode(array('dtcc'=>$dtcc,'dtsc'=>$dtsc));
	break;
	case 'delct':
		$cct  = $_POST['cct'];
		$capp = $_POST['capp'];
		$sql="DELETE FROM btycita WHERE citcodigo IN ($cct)";
		if($conn->query($sql)){
			$upd="UPDATE btydomicitaApp SET daestado=0, citcodigo='', dcsalon=0 WHERE dacodigo=$capp";
			$conn->query($upd);
			echo '1';
		}else{
			echo '0';
		}
	break;
	case 'cancelcd':
		$id=$_POST['id'];
		$mc=$_POST['mc'];
		$sql="UPDATE btydomicitaApp SET daestado=3 WHERE dacodigo=$id";
		if($conn->query($sql)){
			$ins="INSERT INTO btydomicitaAppCancel (dacodigo,cancodigo,canfeho) VALUES ($id,$mc,NOW())";
			if($conn->query($ins)){
				echo 1;
			}else{
				echo 2;
			}
		}else{
			echo 0;
		}
	break;
	case 'enc1':
	break;
}
?>