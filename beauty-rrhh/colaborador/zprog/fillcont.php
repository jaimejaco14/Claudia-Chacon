<?php 
include'../../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'sln':
		$sql="SELECT slncodigo,slnnombre FROM btysalon WHERE slnestado=1";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['slncodigo'], 'nom'=>$row['slnnombre']));
		}
		echo json_encode($array);
	break;
	case 'crg':
		$sql="SELECT crgcodigo,crgnombre FROM btycargo WHERE crgestado=1 and crgincluircolaturnos=1";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['crgcodigo'], 'nom'=>$row['crgnombre']));
		}
		echo json_encode($array);
	break;
	case 'clb':
		$txt=utf8_decode($_POST['txt']);
		$crg=$_POST['crg'];
		if($crg=='adm'){
			$sql="SELECT c.clbcodigo, t.trcrazonsocial
					FROM btycolaborador c
					JOIN btytercero t ON t.trcdocumento=c.trcdocumento
					JOIN btycargo cg on cg.crgcodigo=c.crgcodigo
					WHERE t.trcrazonsocial LIKE '%".$txt."%' AND cg.crgincluircolaturnos=0 AND  c.clbestado=1 and bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO'";
		}else{
			$sql="SELECT c.clbcodigo, t.trcrazonsocial
					FROM btycolaborador c
					JOIN btytercero t ON t.trcdocumento=c.trcdocumento
					WHERE t.trcrazonsocial like '%".$txt."%' and c.crgcodigo IN (".$crg.") and c.clbestado=1 and bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO'";
		}
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['clbcodigo'], 'nom'=>utf8_encode($row['trcrazonsocial'])));
		}
		echo json_encode($array);
	break;
	case 'fes':
		$m=$_POST['mes'];
		$a=$_POST['yr'];
		$sql="SELECT group_concat(day(f.fesfecha)) FROM btyfechas_especiales f WHERE f.festipo='FESTIVO' AND (month(f.fesfecha)=$m and year(f.fesfecha)=$a)";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		echo $row[0];
	break;
	case 'esp':
		$m=$_POST['mes'];
		$a=$_POST['yr'];
		$sql="SELECT group_concat(day(f.fesfecha)) FROM btyfechas_especiales f WHERE f.festipo='ESPECIAL' AND (month(f.fesfecha)=$m and year(f.fesfecha)=$a)";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		echo $row[0];
	break;
	case 'pto':
		$sln=$_POST['sln'];
		$crg=explode(' ',$_POST['crg']);
		if($crg[0]=='Administradoras'){
			$filtro=" AND (pt.ptrnombre LIKE 'R%' AND pt.ptrnombre NOT LIKE 'RE%')";
		}elseif ($crg[0]=='MANICURISTA') {
			$filtro=" AND (pt.ptrnombre LIKE 'M%' or pt.ptrnombre LIKE 'REL%')";
		}elseif ($crg[0]=='ESTETICISTA') {
			$filtro=" AND (pt.ptrnombre LIKE 'C%' or pt.ptrnombre LIKE 'REL%')";
		}elseif ($crg[0]=='ESTILISTA') {
			$filtro=" AND (pt.ptrnombre LIKE 'T%' or pt.ptrnombre LIKE 'REL%')"; 
		}
		$sql="SELECT pt.ptrcodigo, pt.ptrnombre FROM btypuesto_trabajo pt WHERE pt.slncodigo = $sln and pt.ptrestado = 1 ".$filtro." order by pt.ptrnombre asc";
		$res=$conn->query($sql);
		$array = array();
		while($row=$res->fetch_array())
		{
			$array[] = (array('codigo' => $row['ptrcodigo'], 'nombre' => $row['ptrnombre']));
		}
		echo json_encode($array);
	break;
	case 'trn':
		$sw=$_POST['sw'];
		$sln=$_POST['sln'];
		$tdia=$_POST['tdia'];
		if($tdia=='fs'){
			$diasem='Fes';
		}else if($tdia=='sp'){
			$diasem='Esp';
		}else{
			$diasem=$_POST['diasem'];
		}
		if($sw==1){
			$filtro=" and t.trnnombre like 'T%' ";
		}else{
			$filtro=" and t.trnnombre not like 'T%' ";
		}
		if($tdia=='sp'){
			$filtro='';
		}
		$sql="SELECT t.trncodigo, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(t.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i')) AS turno, t.trncolor AS color,h.horcodigo as horario, DATE_FORMAT(t.trndesde, '%H:%i') as tdesde, DATE_FORMAT(t.trnhasta, '%H:%i') as thasta
			FROM btyhorario h
			JOIN btyhorario_salon hs ON hs.horcodigo=h.horcodigo
			JOIN btyturno_salon ts ON ts.horcodigo=hs.horcodigo AND hs.slncodigo=ts.slncodigo
			JOIN btyturno t ON t.trncodigo=ts.trncodigo
			WHERE hs.slncodigo=$sln AND h.hordia LIKE '".$diasem."%' ".$filtro."
			ORDER BY trnnombre,trndesde";
		$res=$conn->query($sql);
		$array = array();
		$numtrn=0;
		while($row=$res->fetch_array())
		{
			$array[] = (array('codigo' => $row['trncodigo'], 'nombre' => $row['turno'], 'color' => $row['color'], 'horario' => $row['horario'], 'orden' => $numtrn, 'tdesde' => $row['tdesde'], 'thasta' => $row['thasta']));
			$numtrn++;
		}
		echo json_encode($array);
	break;
	case 'tilab':
		$sql="SELECT tprcodigo,tprnombre FROM btytipo_programacion WHERE tprestado=1";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['tprcodigo'], 'nom'=>$row['tprnombre']));
		}
		echo json_encode($array);
	break;
	case 'horsln':
		$sln=$_POST['sln'];
		$sql="SELECT SUBSTRING(h.hordia, 1,3) AS dia, DATE_FORMAT(h.hordesde, '%H:%i') AS hdesde, DATE_FORMAT(h.horhasta, '%H:%i') AS hhasta
				FROM btyhorario_salon hs
				JOIN btyhorario h ON h.horcodigo=hs.horcodigo
				WHERE (h.hordia LIKE 'LUN%' OR h.hordia LIKE 'SAB%' OR h.hordia LIKE 'DOM%' OR h.hordia LIKE 'FES%' OR h.hordia LIKE 'ESP%') AND hs.slncodigo=$sln
				ORDER BY FIELD (h.hordia,'LUNES','SABADO','DOMINGO','FESTIVO','ESPECIAL')";
		$res=$conn->query($sql);
		$array = array();
		while($row=$res->fetch_array()){
			$array[] = (array('dia' => $row['dia'], 'hdesde' => $row['hdesde'], 'hhasta' => $row['hhasta']));
		}
		echo json_encode($array);
	break;
	case 'trndia':
		$fecha=$_POST['fecha'];
		$diasem=$_POST['diasem'];
		$sln=$_POST['sln'];
		$crg=$_POST['crg'];

		//comprueba si la fecha es festivo o especial, de lo contrario devuelve DN 'dia normal'
		$sql="SELECT IF(count(*)=0,'DN', SUBSTRING(f.festipo,1,3)) AS tdia FROM btyfechas_especiales f WHERE f.fesfecha='".$fecha."'";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		if($row[0]!='DN'){
			$diasem=$row[0];
		}

		//se comprueba el cargo antes de buscar horarios
		$sql2="SELECT c.crgincluircolaturnos FROM btycargo c WHERE c.crgcodigo=$crg";
		$res2=$conn->query($sql2);
		$row2=$res2->fetch_array();
		if($row2[0]==0){
			$filtro=" and t.trnnombre like 'T%' ";
		}else{
			$filtro=" and t.trnnombre not like 'T%' ";
		}

		//se realiza la consulta aplicando los filtros anteriores
		$sql3="SELECT t.trncodigo, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(t.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i')) AS turno, t.trncolor AS color,h.horcodigo as horario, DATE_FORMAT(t.trndesde, '%H:%i') as tdesde, DATE_FORMAT(t.trnhasta, '%H:%i') as thasta
		FROM btyhorario h
		JOIN btyhorario_salon hs ON hs.horcodigo=h.horcodigo
		JOIN btyturno_salon ts ON ts.horcodigo=hs.horcodigo AND hs.slncodigo=ts.slncodigo
		JOIN btyturno t ON t.trncodigo=ts.trncodigo
		WHERE hs.slncodigo=$sln AND h.hordia LIKE '".$diasem."%' ".$filtro."
		ORDER BY trnnombre,trndesde,trninicioalmuerzo";
		$res3=$conn->query($sql3);
		$array = array();
		$numtrn=0;
		while($row3=$res3->fetch_array())
		{
			$array[] = (array('codigo' => $row3['trncodigo'], 'nombre' => $row3['turno'], 'color' => $row3['color'], 'horario' => $row3['horario'], 'tdesde' => $row3['tdesde'], 'thasta' => $row3['thasta']));
			$numtrn++;
		}
		echo json_encode($array);
	break;
	case 'modprog':
		$usu=$_POST['usucod'];
		$clb=$_POST['clb'];
		$sln=$_POST['sln'];
		$fecha=$_POST['fecha'];
		$action=$_POST['action'];
		$comment=$_POST['comment'];

		if($action=='DEL'){
			$sql="SELECT pc.trncodigo,pc.horcodigo,pc.ptrcodigo,pc.tprcodigo FROM btyprogramacion_colaboradores pc WHERE pc.clbcodigo=$clb AND pc.prgfecha='".$fecha."'";
			$res=$conn->query($sql);
			if($res->num_rows>0){
				$row=$res->fetch_array();
				$sql2="INSERT INTO btyprogramacion_colaboradores_log (usucodigo,clbcodigo,slncod,oldtrncod,oldhorcod,ptrcodigo,prgfecha,oldtprcodigo,logcoment,logdatetime,logtipo) 
				VALUES ($usu,$clb,$sln,$row[0],$row[1],$row[2],'$fecha',$row[3],'$comment',now(),'ELIMINADO')";
				if($conn->query($sql2)){
					$sql3="DELETE FROM btyprogramacion_colaboradores WHERE clbcodigo=$clb and slncodigo=$sln AND prgfecha='".$fecha."'";
					if($conn->query($sql3)){
						//deleting exitoso
						echo 1;
					}else{
						//error deleting
						echo 4;
					}
				}else{
					//error insert log
					echo 3;
				}
			}else{
				//no tiene programacion / está en otro salon en la fecha dada
				echo 2;
			}
		}else{
			$trn=$_POST['trn'];
			$hor=$_POST['hor'];
			$tpr=$_POST['tiprog'];
			$sql="SELECT pc.trncodigo,pc.horcodigo,pc.ptrcodigo,pc.tprcodigo FROM btyprogramacion_colaboradores pc WHERE pc.clbcodigo=$clb AND pc.slncodigo=$sln AND pc.prgfecha='".$fecha."'";
			$res=$conn->query($sql);
			if($res->num_rows>0){
				$row=$res->fetch_array();
				$sql2="INSERT INTO btyprogramacion_colaboradores_log (usucodigo,clbcodigo,slncod,oldtrncod,oldhorcod,newtrncod,newhorcod,ptrcodigo,prgfecha,oldtprcodigo,newtprcodigo,logcoment,logdatetime,logtipo) 
				VALUES ($usu,$clb,$sln,$row[0],$row[1],$trn,$hor,$row[2],'$fecha',$row[3],$tpr,'$comment',now(),'EDITADO')";
				if($conn->query($sql2)){
					$sql3="UPDATE btyprogramacion_colaboradores SET trncodigo=$trn, horcodigo=$hor, tprcodigo=$tpr WHERE clbcodigo=$clb and slncodigo=$sln AND prgfecha='".$fecha."'";
					if($conn->query($sql3)){
						//updating exitoso
						echo 1;
					}else{
						//error updating
						echo 4;
					}
				}else{
					//error insert log
					echo 3;
				}
			}else{
				//no tiene programacion en la fecha dada
				echo 2;
			}
		}
	break;
	case 'seelog':
		$col=$_POST['col'];
		$sln=$_POST['sln'];
		$fecha=$_POST['fecha'];
		$sql="SELECT l.logtipo as tipo,l.prgfecha as fecha, CONCAT(tn.trnnombre, ' DE: ', DATE_FORMAT(tn.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(tn.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(tn.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(tn.trnfinalmuerzo, '%H:%i'),' - ',tp.tprnombre) AS orig, ifnull(CONCAT(tn2.trnnombre, ' DE: ', DATE_FORMAT(tn2.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(tn2.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(tn2.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(tn2.trnfinalmuerzo, '%H:%i'),' - ',tp2.tprnombre), 'ELIMINADO' )AS cambio,l.logcoment as motivo,l.logdatetime as datecam,t.trcnombres as usuario
			FROM btyprogramacion_colaboradores_log l
			JOIN btyusuario u ON u.usucodigo=l.usucodigo
			JOIN btytercero t ON t.trcdocumento=u.trcdocumento AND u.tdicodigo=t.tdicodigo
			JOIN btytipo_programacion tp ON tp.tprcodigo=l.oldtprcodigo
			LEFT JOIN btytipo_programacion tp2 ON tp2.tprcodigo=l.newtprcodigo
			JOIN btyturno tn ON tn.trncodigo=l.oldtrncod
			LEFT JOIN btyturno tn2 ON tn2.trncodigo=l.newtrncod
			WHERE l.clbcodigo=$col AND l.slncod=$sln and month(l.prgfecha) = month('".$fecha."') and year(l.prgfecha) = year('".$fecha."') 
			ORDER BY l.prgfecha";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('tipo'=>$row['tipo'],'fecha'=>$row['fecha'],'orig'=>$row['orig'],'cambio'=>$row['cambio'],'motivo'=>$row['motivo'],'datecam'=>$row['datecam'],'usuario'=>$row['usuario']);
		}
		echo json_encode($array);
	break;
	case 'contlog':
		$sln=$_POST['sln'];
		$fecha=$_POST['fecha'];
		$sql="SELECT COUNT(*) FROM btyprogramacion_colaboradores_log l WHERE l.slncod=$sln AND MONTH(l.prgfecha) = MONTH('".$fecha."') AND YEAR(l.prgfecha) = YEAR('".$fecha."')";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		echo $row[0];
	break;
	case 'ocu':
		$sln=$_POST['sln'];
		$fecha=$_POST['fecha'];
		$sql="SELECT p.ptrnombre, IF(pc.clbcodigo>0,1,0) AS ocu,cg2.crgnombre as crg
				FROM btypuesto_trabajo p
				JOIN btycargo cg ON cg.crgcodigo=p.tptcodigo
				LEFT JOIN btyprogramacion_colaboradores pc ON p.ptrcodigo=pc.ptrcodigo AND pc.prgfecha= '$fecha' and pc.tprcodigo in (1,9)
				left join btycolaborador c on c.clbcodigo=pc.clbcodigo
				left join btycargo cg2 on cg2.crgcodigo=c.crgcodigo
				WHERE p.slncodigo=$sln AND p.ptrestado=1 AND cg.crgincluircolaturnos=1
				ORDER BY p.ptrnombre,cg2.crgnombre desc";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			if($row['crg']==null){
				$row['crg']='';
			}
			$array[]=array('pto'=>$row['ptrnombre'],'ocu'=>$row['ocu'], 'crg'=>$row['crg']);
		}
		echo json_encode($array);
	break;
}
?>