<?php 
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	/*LOAd HISTO SOLICITUDES*/
		case 'loadsol':
			$sql="SELECT s.solcodigo as scod,st.soltinombre AS tipo,t.trcrazonsocial AS col,(SELECT l.sollogfecha FROM btysolicitudes_log l WHERE l.solescod=1 AND l.solcodigo=sl.solcodigo) AS ferad,sr.solresnombre as solres,se.solesnombre as est, sl.solescod as cest,sl.solrescod as rsol,s.soldescripcion as sdesc,sl.sollogcomentarios as comm,sl.sollogfecha as feres,IF(sl.solescod <> 3, CONCAT(TIMESTAMPDIFF(DAY, (SELECT ferad), NOW()),'d ', LPAD(MOD(TIMESTAMPDIFF(HOUR, (SELECT ferad), NOW()), 24), 2, '0'), 'h'),'N/A') AS tac
					FROM btysolicitudes s
					JOIN btysolicitudes_tipo st ON st.solticod=s.solticod
					JOIN btysolicitudes_log sl ON sl.solcodigo=s.solcodigo
					JOIN btysolicitudes_estado se on se.solescod=sl.solescod
					JOIN btycolaborador c ON c.clbcodigo=s.clbcodigo
					JOIN btytercero t ON t.tdicodigo=c.tdicodigo AND t.trcdocumento=c.trcdocumento
					JOIN btysolicitudes_responsable sr on s.solrescod=sr.solrescod
					JOIN btyusuario u on u.usucodigo=sr.usucodigo
					WHERE sl.sollogestado=1 order by est asc,tac asc";
			mysqli_set_charset($conn,'utf8');
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
		case 'selfiltro':
			$sql="SELECT se.solescod,se.solesnombre FROM btysolicitudes_estado se WHERE se.selesestado=1";
			$res=$conn->query($sql);
			while($row=$res->fetch_array()){
				$array[]=array('cod'=>$row['solescod'],'nom'=>$row['solesnombre']);
			}
			echo json_encode($array);
		break;
	/*OPER DPTO*/
		case 'loaddpto':
			$sql="SELECT sr.solrescod,sr.solresnombre,t.trcrazonsocial,u.usuemail
					FROM btysolicitudes_responsable sr
					JOIN btyusuario u ON u.usucodigo=sr.usucodigo
					JOIN btytercero t ON t.trcdocumento=u.trcdocumento AND t.tdicodigo=u.tdicodigo
					WHERE sr.solresestado=1 order by solresnombre";
			mysqli_set_charset($conn,'UTF8');
			$res=$conn->query($sql);
			while($row=$res->fetch_array()){
				$array[]=array('nomdp'=>$row['solresnombre'],'user'=>$row['trcrazonsocial'],'mail'=>$row['usuemail'],'cod'=>$row['solrescod']);
			}
			echo json_encode($array);
		break;
		case 'loaddptousr':
			$sql="SELECT u.usucodigo,t.trcrazonsocial,u.usuemail
					FROM btyusuario u
					JOIN btytipousuario tu ON tu.tiucodigo=u.tiucodigo
					JOIN btytercero t ON t.tdicodigo=u.tdicodigo AND t.trcdocumento=u.trcdocumento
					WHERE u.usuestado=1 AND tu.tiuoficina=1
					order by trcrazonsocial";
			mysqli_set_charset($conn,'UTF8');
			$res=$conn->query($sql);
			while($row=$res->fetch_array()){
				$array[]=array('cod'=>$row['usucodigo'],'nom'=>$row['trcrazonsocial'],'mail'=>$row['usuemail']);
			}
			echo json_encode($array);
		break;
		case 'newdpto':
			$dptonom=utf8_decode($_POST['dptonom']);
			$dptousr=$_POST['dptousr'];
			$vrf="SELECT COUNT(*) FROM btysolicitudes_responsable WHERE (solresnombre='$dptonom' or usucodigo=$dptousr) and solresestado=1 ";
			$rvrf=$conn->query($vrf);
			$cvrf=$rvrf->fetch_array();
			if($cvrf[0]==0){
				$sql="INSERT INTO btysolicitudes_responsable (solresnombre,usucodigo) VALUES ('$dptonom',$dptousr)";
				echo ($conn->query($sql))?1:0;
			}else{
				echo 'D';
			}
		break;
		case 'deldpto':
			$srcod=$_POST['srcod'];
			$sql="SELECT COUNT(*) FROM btysolicitudes_log sl
					WHERE sl.solrescod=$srcod AND sl.sollogestado=1 AND sl.solescod IN (1,2,4)";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 2;
			}else{
				$del="UPDATE btysolicitudes_responsable SET solresestado=0 WHERE solrescod=$srcod";
				echo ($conn->query($del)?1:0);
			}
		break;
		case 'preedt':
			$srcod=$_POST['srcod'];
			$sql="SELECT COUNT(*) FROM btysolicitudes_log sl
					WHERE sl.solrescod=$srcod AND sl.sollogestado=1 AND sl.solescod IN (1,2,4)";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 1;
			}else{
				echo 0;
			}
		break;
		case 'edtdpto':
			$dptonom=$_POST['dptonom'];
			$dptousr=$_POST['dptousr'];
			$srcod=$_POST['srcod'];
			$vrf="SELECT COUNT(*) FROM btysolicitudes_responsable WHERE (solresnombre='$dptonom' or usucodigo=$dptousr) and solresestado=1  and solrescod <> $srcod";
			$rvrf=$conn->query($vrf);
			$cvrf=$rvrf->fetch_array();
			if($cvrf[0]==0){
				$sql="UPDATE btysolicitudes_responsable SET solresnombre='$dptonom',usucodigo=$dptousr WHERE solrescod=$srcod";
				echo ($conn->query($sql))?1:0;
			}else{
				echo 'D';
			}
		break;
	/*OPER TIPO SOLICITUD*/
		case 'loadtisol':
			$sql="SELECT st.solticod,st.soltinombre,sr.solresnombre, IFNULL(t.trcrazonsocial,'NO DEFINIDO') AS user
					FROM btysolicitudes_tipo st
					JOIN btysolicitudes_responsable sr ON sr.solrescod=st.solrescod
					LEFT JOIN btyusuario u ON u.usucodigo=sr.usucodigo
					LEFT JOIN btytercero t ON t.tdicodigo=u.tdicodigo AND t.trcdocumento=u.trcdocumento
					WHERE st.soltiestado=1";
			mysqli_set_charset($conn,'UTF8');
			$res=$conn->query($sql);
			while($row=$res->fetch_array()){
				$array[]=array('codtisol'=>$row['solticod'],'nomtisol'=>$row['soltinombre'],'dptonom'=>$row['solresnombre'],'restisol'=>$row['user']);
			}
			echo json_encode($array);
		break;
		case 'savenewts':
			$nomts=utf8_decode($_POST['nomts']);
			$dpto=$_POST['dpto'];
			$vrf="SELECT COUNT(*) FROM btysolicitudes_tipo WHERE soltinombre='$nomts' and soltiestado=1";
			$rvrf=$conn->query($vrf);
			$cvrf=$rvrf->fetch_array();
			if($cvrf[0]==0){
				$sql="INSERT INTO btysolicitudes_tipo (soltinombre,solrescod) VALUES ('$nomts',$dpto)";
				echo ($conn->query($sql))?1:0;
			}else{
				echo 'D';
			}
		break;
		case 'deltisol':
			$tscod=$_POST['tscod'];
			$sql="UPDATE btysolicitudes_tipo SET soltiestado=0 WHERE solticod=$tscod";
			echo ($conn->query($sql))?1:0;
		break;
		case 'saveedtts':
			$nomts=utf8_decode($_POST['nomts']);
			$tscod=$_POST['tscod'];
			$dpto=$_POST['dpto'];
			$vrf="SELECT COUNT(*) FROM btysolicitudes_tipo WHERE soltinombre='$nomts' and soltiestado=1 and solticod <> $tscod";
			$rvrf=$conn->query($vrf);
			$cvrf=$rvrf->fetch_array();
			if($cvrf[0]==0){
				$sql="UPDATE btysolicitudes_tipo SET solrescod=$dpto WHERE solticod=$tscod";
				echo ($conn->query($sql))?1:0;
			}else{
				echo 'D';
			}
		break;
}
?>