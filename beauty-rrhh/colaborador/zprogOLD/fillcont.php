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
					WHERE t.trcrazonsocial LIKE '%".$txt."%' AND cg.crgincluircolaturnos=0 AND  c.clbestado=1";
		}else{
			$sql="SELECT c.clbcodigo, t.trcrazonsocial
					FROM btycolaborador c
					JOIN btytercero t ON t.trcdocumento=c.trcdocumento
					WHERE t.trcrazonsocial like '%".$txt."%' and c.crgcodigo IN (".$crg.") and c.clbestado=1";
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
		$sql="SELECT t.trncodigo, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(t.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i')) AS turno, t.trncolor AS color,h.horcodigo as horario
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
			$array[] = (array('codigo' => $row['trncodigo'], 'nombre' => $row['turno'], 'color' => $row['color'], 'horario' => $row['horario'], 'orden' => $numtrn));
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
	case 'prevmonth':
		
	break;
}
?>