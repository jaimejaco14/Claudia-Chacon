<?php
include '../../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'veract':
		$clb=$_POST['clb'];
		$sql="SELECT (
				SELECT cdp.cdpfecha
				FROM btycolaborador_datosper cdp
				WHERE cdp.clbcodigo=$clb AND cdp.cdpaprobado=1 order by cdp.cdpfecha desc limit 1) AS cdp,
				(
				SELECT cs.csfecha
				FROM btycolaborador_salud cs
				WHERE cs.clbcodigo=$clb AND cs.csaprobado=1 order by cs.csfecha desc limit 1) AS cs,
				(
				SELECT cif.ciffecha
				FROM btycolaborador_infofa cif
				WHERE cif.clbcodigo=$clb AND cif.cifaprobado=1 order by cif.ciffecha desc limit 1) AS cif";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		$array=array('cdp'=>$row['cdp'],'cs'=>$row['cs'],'cif'=>$row['cif']);
		echo json_encode($array);
	break;
	case 'loadcdp':
		$clb=$_POST['clb'];
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT c.cdpdireccion,b.brrnombre,c.cdpcelular,c.cdpmail
			FROM btycolaborador_datosper c
			JOIN btybarrio b on b.brrcodigo=c.cdpbrrcodigo
			WHERE clbcodigo=$clb and c.cdpestado=1 and c.cdpaprobado=0";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$row=$res->fetch_array();
			$array=array('res'=>1,'address'=>$row['cdpdireccion'],'barrio'=>$row['brrnombre'],'celu'=>$row['cdpcelular'],'mail'=>$row['cdpmail']);
		}else{
			$array=array('res'=>0);
		}
		echo json_encode($array);
	break;
	case 'appcdp':
		$clb=$_POST['clb'];
		$upd="UPDATE btycolaborador_datosper SET cdpaprobado=1 WHERE cdpestado=1 and clbcodigo=$clb";
		if($conn->query($upd)){
			$sel="SELECT cd.cdpdireccion,cd.cdpbrrcodigo,cd.cdpcelular,cd.cdpmail,t.trcdocumento
					FROM btycolaborador_datosper cd
					JOIN btycolaborador c on c.clbcodigo=cd.clbcodigo
					JOIN btytercero t on t.tdicodigo=c.tdicodigo and t.trcdocumento=c.trcdocumento
					WHERE cd.cdpaprobado=1 AND cd.cdpestado=1 AND cd.clbcodigo=$clb";
			$res=$conn->query($sel);
			$row=$res->fetch_array();
			$updt="UPDATE btycolaborador c JOIN btytercero t ON t.tdicodigo=c.tdicodigo AND t.trcdocumento=c.trcdocumento SET c.clbemail='$row[3]', t.trcdireccion='$row[0]', t.trctelefonomovil='$row[2]', t.brrcodigo=$row[1] WHERE c.clbcodigo=$clb";
			if($conn->query($updt)){
				echo json_encode(array('res'=>1,'ced'=>$row['trcdocumento']));
			}else{
				echo json_encode(array('res'=>0));
			}
		}else{
			echo json_encode(array('res'=>2));
		}
	break;
	case 'reccdp':
		$clb=$_POST['clb'];
		$sql="UPDATE btycolaborador_datosper SET cdpaprobado=2 WHERE cdpestado=1 and clbcodigo=$clb";
		if($conn->query($sql)){
			$array=array('res'=>1);
		}else{
			$array=array('res'=>0);
		}
		echo json_encode($array);
	break;
	case 'loadsabi':
		$clb=$_POST['clb'];
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT e.epsnombre,f.afpnombre,(CASE WHEN s.csestsalud=1 THEN 'EXCELENTE' WHEN s.csestsalud=2 THEN 'BUENO' WHEN s.csestsalud=3 THEN 'REGULAR' WHEN s.csestsalud=4 THEN 'MALO' ELSE '' END) AS estsalud, IF(s.csenfermedad=1,'SI','NO') enfact, IF(s.csenfermedad=1,s.csdescenfermedad,'N/A') AS desenf, IF(s.csrestriccion=1,'SI','NO') AS restmed, IF(s.csrestriccion=1,s.csdescrestriccion,'N/A') AS descrest, IF(s.cscirugia=1,'SI','NO') AS ciru, IF(s.cscirugia=1,s.csdesccirugia,'N/A') AS desciru, IF(s.cshospital=1,'SI','NO') AS hosp, IF(s.cshospital=1,s.csdeschospital,'N/A') AS deshosp, IF(s.cstratamiento=1,'SI','NO') AS trata, IF(s.cstratamiento=1,s.csdesctratamiento,'N/A') AS desctra,cc.cemnombre,cc.cemparentesco,cc.cemtelefono,cc.cemdireccion,s.cstcam,s.cstpan,s.cstgua, IF(s.csjudi=1,'SI','NO') AS judi, IF(s.csjudi=1,s.csdetjudi,'N/A') AS detjudi
			FROM btycolaborador_salud s
			JOIN btycolaborador_afp f ON f.afpcodigo=s.afpcodigo
			JOIN btycolaborador_eps e ON e.epscodigo=s.epscodigo
			JOIN btycolaborador_contacto cc ON cc.cemcodigo=s.cemcodigo
			WHERE s.clbcodigo=$clb AND cc.cemestado=1 AND s.csestado=1 and s.csaprobado=0";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$row=$res->fetch_array();
			$array=array('res'=>1,'info'=>$row);
		}else{
			$array=array('res'=>0);
		}
		echo json_encode($array);
	break;
	case 'appsb':
		$clb=$_POST['clb'];
		$upd="UPDATE btycolaborador_salud SET csaprobado=1 WHERE csestado=1 AND clbcodigo=$clb";
		if($conn->query($upd)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'recsb':
		$clb=$_POST['clb'];
		$upd="UPDATE btycolaborador_salud SET csaprobado=2 WHERE csestado=1 AND clbcodigo=$clb";
		if($conn->query($upd)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'loadif':
		$clb=$_POST['clb'];
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT i.cifestadocivil,i.cifconyunom,i.cifconyutel,i.cifconyuocu,i.cifhijos,i.cifnompadre,i.ciftelpadre,i.cifnommadre,i.ciftelmadre,i.cifdireccpadres,b.brrnombre,i.cifhermanos,i.cifcodigo
				FROM btycolaborador_infofa i
				JOIN btybarrio b ON b.brrcodigo=i.cifbrrcodigo
				WHERE i.clbcodigo=$clb AND i.cifestado=1 AND i.cifaprobado=0";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$row=$res->fetch_array();
			if($row[4]==1){
				$sqls="SELECT h.chnombre,h.chfechana
						FROM btycolaborador_hijos h
						WHERE h.clbcodigo=$clb AND h.cifcodigo=$row[12]";
				$ress=$conn->query($sqls);
				if($ress->num_rows>0){
					while($rowson=$ress->fetch_array()){
						$son[]=array('nom'=>$rowson[0],'fec'=>$rowson[1]);
					}
				}else{
					$son[]=null;
				}
			}else{
				$son[]=null;
			}
			if($row[11]==1){
				$sqlh="SELECT h.chenombre,h.cheocupacion,h.chetelefono,h.cheedad
						FROM btycolaborador_hermano h
						WHERE h.clbcodigo=$clb AND h.cifcodigo=$row[12]";
				$resh=$conn->query($sqlh);
				if($resh->num_rows>0){
					while($rowhno=$resh->fetch_array()){
						$hno[]=array('nom'=>$rowhno[0],'ocu'=>$rowhno[1],'tel'=>$rowhno[2],'age'=>$rowhno[3]);
					}
				}else{
					$hno[]=null;
				}
			}else{
				$hno[]=null;
			}
			$array=array('res'=>1,'info'=>$row,'ison'=>$son,'ihno'=>$hno);
		}else{
			$array=array('res'=>0);
		}
		echo json_encode($array);
	break;
	case 'appif':
		$clb=$_POST['clb'];
		$upd="UPDATE btycolaborador_infofa SET cifaprobado=1 WHERE cifestado=1 AND clbcodigo=$clb";
		if($conn->query($upd)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'recif':
		$clb=$_POST['clb'];
		$upd="UPDATE btycolaborador_infofa SET cifaprobado=2 WHERE cifestado=1 AND clbcodigo=$clb";
		if($conn->query($upd)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'countact':
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT c.trcdocumento,t.trcrazonsocial
				FROM btycolaborador c
				JOIN btytercero t ON t.tdicodigo=c.tdicodigo AND t.trcdocumento=c.trcdocumento
				LEFT JOIN btycolaborador_datosper dp ON dp.clbcodigo=c.clbcodigo
				LEFT JOIN btycolaborador_salud s ON s.clbcodigo=c.clbcodigo
				LEFT JOIN btycolaborador_infofa i ON i.clbcodigo=c.clbcodigo
				WHERE (dp.cdpestado=1 AND dp.cdpaprobado=0) OR (s.csestado=1 AND s.csaprobado=0) OR (i.cifestado=1 AND i.cifaprobado=0)
			GROUP BY c.clbcodigo ORDER BY t.trcrazonsocial";
		$res=$conn->query($sql);
		$nr=$res->num_rows;
		if($nr>0){
			while($row=$res->fetch_array()){
				$datos[]=array('ced'=>$row[0],'nom'=>$row[1]);
			}
		}else{
			$datos=null;
		}
		echo json_encode(array('cant'=>$nr,'datos'=>$datos));
	break;
	case 'catpend':
		$clb=$_POST['clb'];
		$sql="SELECT (
				SELECT count(*)
				FROM btycolaborador_datosper cdp
				WHERE cdp.clbcodigo=$clb AND cdp.cdpaprobado=0 AND cdp.cdpestado=1
				ORDER BY cdp.cdpfecha DESC
				LIMIT 1) AS cdp,
								(
				SELECT count(*)
				FROM btycolaborador_salud cs
				WHERE cs.clbcodigo=$clb AND cs.csaprobado=0 AND cs.csestado=1
				ORDER BY cs.csfecha DESC
				LIMIT 1) AS cs,
								(
				SELECT count(*)
				FROM btycolaborador_infofa cif
				WHERE cif.clbcodigo=$clb AND cif.cifaprobado=0 AND cif.cifestado=1
				ORDER BY cif.ciffecha DESC
				LIMIT 1) AS cif";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		$array=array('cdp'=>$row[0],'cs'=>$row[1],'cif'=>$row[2]);
		echo json_encode($array);
	break;
}
?>