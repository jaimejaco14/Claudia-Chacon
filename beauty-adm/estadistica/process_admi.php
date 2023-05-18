<?php 
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'listsln':
		$sql="SELECT concat('Tipo ',s.slntipo) as tipo ,GROUP_CONCAT(s.slncodigo) as cod, GROUP_CONCAT(s.slnadmi) as cad FROM btysalon s WHERE s.slnestado=1 GROUP BY s.slntipo";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$tipo[]=array('cod'=>$row['cod'],'nom'=>$row['tipo'],'cad'=>$row['cad']);
		}
		$sql="SELECT slncodigo,slnnombre,slnadmi FROM btysalon WHERE slnestado=1 ORDER BY slnnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$sln[]=array('cod'=>$row['slncodigo'],'nom'=>$row['slnnombre'],'cad'=>$row['slnadmi']);
		}
		echo json_encode(array('tipo'=>$tipo,'sln'=>$sln));
	break;
//start admi filters
	case 'loadtido':
		$sql="SELECT atalias,concat(atnom,' (',atalias,')') as atnom FROM btyadmi_tipodoc order by atnom";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['atalias'], 'nom'=>utf8_encode($row['atnom'])));
		}
		echo json_encode($array);
	break;
	case 'loadlinea':
		$sql="SELECT alcod,alnom FROM btyadmi_linea order by alnom";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['alcod'], 'nom'=>utf8_encode($row['alnom'])));
		}
		echo json_encode($array);
	break;
	case 'loadgru':
		$sql="SELECT agcod,agnombre FROM btyadmi_grupo order by agnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['agcod'], 'nom'=>utf8_encode($row['agnombre'])));
		}
		echo json_encode($array);
	break;
	case 'loadsubgru':
		$sql="SELECT asgcod,asgnom FROM btyadmi_subgrupo order by asgnom";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['asgcod'], 'nom'=>utf8_encode($row['asgnom'])));
		}
		echo json_encode($array);
	break;
	case 'loadcara':
		$sql="SELECT accod,acnom FROM btyadmi_cara order by acnom";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['accod'], 'nom'=>utf8_encode($row['acnom'])));
		}
		echo json_encode($array);
	break;
	//end admi filter
//start admi proccess
	case 'generar':
		$sln 	=	$_POST['sln'];
		$fdes	=	$_POST['fdes'];
		$fhas	=	$_POST['fhas'];

		$tdc 	=	$_POST['tdc'];
		$lin 	=	$_POST['lin'];
		$gru 	=	$_POST['gru'];
		$sgr 	=	$_POST['subg'];
		$car 	=	$_POST['cara'];
		$ume 	=	$_POST['ume'];

		$trp	=	$_POST['trp'];
		if($trp=='c'){
			$then=" a.cantidad ";
			$und="a.unidad";
		}else if($trp=='v'){
			$then=" (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ";
			$und="'$'";
		}

		$lin!=0?$where.=" AND a.linea='$lin' ":$where.="";
		$gru!=0?$where.=" AND a.grupo='$gru' ":$where.="";
		$sgr!=0?$where.=" AND a.subg='$sgr' ":$where.="";
		$ume!='0'?$where.=" AND a.unidad='$ume' ":$where.="";
		$car!=0?$where.=" AND a.carac='$car' ":$where.="";

		$sqlsln='';
		$sw 	=	$_POST['sw'];
		$csln=array();
		if($sw=='t'){
			foreach ($sln as $key => $cod){
				$cd=implode(',',$cod);
				$acol=str_replace("-","",str_replace(",","",$cd));
				$sqlsln.=", SUM(CASE WHEN a.salon in (".str_replace('t-','',$cd).") THEN ".$then." ELSE 0 end) AS ".$acol;
				array_push($csln, 'c.'.$acol);
			}
			$sum=implode('+',$csln);
			$c=implode(',',$csln);
		}else{
			$asln=explode(',', $sln);
			foreach ($asln as $key) {
				$sqlsln.=", SUM(CASE WHEN a.salon='".$key."' THEN ".$then." ELSE 0 end) AS s".$key;
				array_push($csln, 'c.s'.$key);
			}
			$sum=implode('+',$csln);
			$c=implode(',',$csln);
		}

		mysqli_set_charset($conn,"utf8");
		$sql="SELECT c.ref,c.nom,c.gru,c.sgru,c.car,c.und,$c,($sum) AS total 
				FROM (SELECT s.spreferencia as ref, s.spnombre as nom, g.agnombre AS gru, sg.asgnom AS sgru, r.acnom AS car, ".$und." as und ".$sqlsln." FROM btyadmi_serpro s
				LEFT JOIN btyfromadmi a ON a.referencia=s.spreferencia
				LEFT JOIN btyadmi_grupo g ON g.agcod=s.spgrupo
				LEFT JOIN btyadmi_subgrupo sg ON sg.asgcod=s.spsubgrupo
				LEFT JOIN btyadmi_cara r ON r.accod=s.spcarac
				WHERE (a.fecha BETWEEN '$fdes' AND '$fhas') AND a.estado='A' 
				AND a.td='$tdc' ".$where." GROUP BY ref) AS c ORDER BY c.nom";
		
		//echo $sql;
		//echo $where;

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
	//end admi proccess
//consolidado colaborador
	case 'consolcol':
		//////////FIJOS////////
		$ccref=$_POST['ccref'];
		$ccsln=$_POST['ccsln'];
		$cctdc=$_POST['cctdc'];
		$cctrp=$_POST['cctrp'];
		$ccdes=$_POST['ccdes'];
		$cchas=$_POST['cchas'];
		///////VARIABLES///////
		$cclin=$_POST['cclin'];
		$ccgru=$_POST['ccgru'];
		$ccsgr=$_POST['ccsgr'];
		$cccar=$_POST['cccar'];
		$ccund=$_POST['ccund'];
		if($cctrp=='c'){
			$then="a.cantidad";
		}else if($cctrp=='v'){
			$then="a.pmasiva*a.cantidad*((100-a.pordes)/100)";
		}
		$cclin!=0?	$where.=" AND a.linea='$cclin' ":$where.="";
		$ccgru!=0?	$where.=" AND a.grupo='$ccgru' ":$where.="";
		$ccsgr!=0?	$where.=" AND a.subg='$ccsgr' ":$where.="";
		$cccar!=0?	$where.=" AND a.carac='$cccar' ":$where.="";
		$ccund!='0'?$where.=" AND a.unidad='$ccund' ":$where.="";
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT a.nomesti AS clbnom, sum($then) AS cant
				FROM btyfromadmi a 
				WHERE a.estado='A' and a.referencia='$ccref' AND a.salon IN ($ccsln) AND a.fecha BETWEEN '$ccdes' AND '$cchas' AND a.td='$cctdc' ".$where." GROUP BY a.estilista";
		//echo $sql;
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
	case 'consolgencol':
		//////////FIJOS////////
		$ccsln=$_POST['ccsln'];
		$cctdc=$_POST['cctdc'];
		$cctrp=$_POST['cctrp'];
		$ccdes=$_POST['ccdes'];
		$cchas=$_POST['cchas'];
		///////VARIABLES///////
		$cclin=$_POST['cclin'];
		$ccgru=$_POST['ccgru'];
		$ccsgr=$_POST['ccsgr'];
		$cccar=$_POST['cccar'];
		$ccund=$_POST['ccund'];
		if($cctrp=='c'){
			$then="a.cantidad";
		}else if($cctrp=='v'){
			$then="a.pmasiva*a.cantidad*((100-a.pordes)/100)";
		}
		$cclin!=0?	$where.=" AND a.linea='$cclin' ":$where.="";
		$ccgru!=0?	$where.=" AND a.grupo='$ccgru' ":$where.="";
		$ccsgr!=0?	$where.=" AND a.subg='$ccsgr' ":$where.="";
		$cccar!=0?	$where.=" AND a.carac='$cccar' ":$where.="";
		$ccund!='0'?$where.=" AND a.unidad='$ccund' ":$where.="";
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT a.nomesti AS clbnom, sum($then) AS cant
				FROM btyfromadmi a 
				WHERE a.estado='A' AND a.salon IN ($ccsln) AND a.fecha BETWEEN '$ccdes' AND '$cchas' AND a.td='$cctdc' ".$where." GROUP BY a.estilista";
		//echo $sql;
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
}
?>