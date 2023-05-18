<?php 
include '../../cnx_data.php';
//mysqli_set_charset($conn,'utf8');
$opc=$_POST['opc'];
switch($opc){
	case 'loadcol':
		$txt=utf8_decode($_POST['txt']);
		$sql="SELECT c.clbcodigo, t.trcrazonsocial
				FROM btycolaborador c
				JOIN btytercero t ON t.trcdocumento=c.trcdocumento
				WHERE t.trcrazonsocial like '%".$txt."%' and c.clbestado=1 and crgcodigo in (4,5,6,7,8)";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['clbcodigo'], 'nom'=>utf8_encode($row['trcrazonsocial'])));
		}
		echo json_encode($array);
	break;
	case 'calcular':
		$clb=$_POST['clb'];
		$fd=$_POST['fd'];
		$fh=$_POST['fh'];
		$des=0;
		$nla=0;
		$sql="SELECT b.slnnombre,  
				SUM(CASE WHEN b.tprcodigo=1 THEN 1 ELSE 0 END) AS lab,
				SUM(CASE WHEN b.tprcodigo=2 THEN 1 ELSE 0 END) AS des,
				SUM(CASE WHEN b.tprcodigo=1 AND b.aptcodigo IS NULL THEN 1 ELSE 0 END) AS aus,
				SUM(CASE WHEN b.tprcodigo not in (1,2,9) AND b.aptcodigo IS NULL THEN 1 ELSE 0 END) AS otr
				FROM(
				SELECT DISTINCT pc.prgfecha,pc.tprcodigo,ap.aptcodigo,s.slnnombre
				FROM btyprogramacion_colaboradores pc
				LEFT JOIN btyasistencia_procesada ap ON ap.prgfecha=pc.prgfecha AND ap.clbcodigo=pc.clbcodigo AND ap.aptcodigo IN (1,2)
				JOIN btysalon s ON s.slncodigo=pc.slncodigo
				WHERE pc.prgfecha BETWEEN '$fd' AND '$fh' AND pc.clbcodigo=$clb
				GROUP BY pc.prgfecha) AS b
				GROUP BY b.slnnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_assoc()){
			$array[]=array('sln'=>$row['slnnombre'],'cd'=>$row['lab'],'au'=>$row['aus']);
			$des+=$row['des'];
			$nla+=$row['otr'];
		}
		$array[]=array('sln'=>'DESCANSOS','cd'=>$des,'au'=>0);
		$array[]=array('sln'=>'PERMISOS/VACACIONES/OTROS','cd'=>$nla,'au'=>0);
		echo json_encode($array);
	break;
}
?>