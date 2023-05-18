<?php 
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'listsln':
		$sql="SELECT concat('Tipo ',s.slntipo) as tipo ,s.slntipo as cod FROM btysalon s WHERE s.slnestado=1 GROUP BY s.slntipo";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$tipo[]=array('cod'=>$row['cod'],'nom'=>$row['tipo']);
		}
		$sql="SELECT slncodigo,slnnombre,slnadmi,slnalias FROM btysalon WHERE slnestado=1 ORDER BY slnnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$sln[]=array('cod'=>$row['slncodigo'],'nom'=>$row['slnnombre'],'cad'=>$row['slnadmi'],'aka'=>$row['slnalias']);
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
		$est 	=	$_POST['est'];
		switch($est){
			case 'D':
				$fdes	=	$_POST['fdes'];
				$fhas	=	$_POST['fhas'];
				$escala =	"a.fecha as escala";
				$rango	= 	"(a.fecha BETWEEN '$fdes' AND '$fhas')";
			break;
			case 'M':
				$fdes	=	$_POST['fdes'].'-01';
				$fhas	=	$_POST['fhas'].'-01';
				$escala =	"CONCAT(YEAR(a.fecha),'-', if(MONTH(a.fecha)<10,concat('0',MONTH(a.fecha)),MONTH(a.fecha))) AS escala";
				$rango	= 	"(a.fecha BETWEEN '$fdes' AND LAST_DAY('$fhas'))";
			break;
			case 'T':
				$tmtdm	=	substr($_POST['fdes'],6,1);//num trimestre desde
				$tmtda	=	substr($_POST['fdes'],0,4);//año desde
				$tmthm	=	substr($_POST['fhas'],6,1);//num trimestre hasta
				$tmtha	=	substr($_POST['fhas'],0,4);//año hasta
				$escala =	"CONCAT(YEAR(a.fecha),'-T',QUARTER(a.fecha)) AS escala";
				$rango	= 	"(year(a.fecha) BETWEEN '$tmtda' AND '$tmtha' AND QUARTER(a.fecha) BETWEEN $tmtdm AND $tmthm)";
				$rango	= 	"(a.fecha BETWEEN (MAKEDATE('$tmtda', 1) + INTERVAL $tmtdm QUARTER - INTERVAL 1 QUARTER ) and (MAKEDATE('$tmtha', 1) + INTERVAL $tmthm QUARTER - INTERVAL 1 DAY ))";
			break;
			case 'A':
				$fdes	=	$_POST['fdes'].'-01-01';
				$fhas	=	$_POST['fhas'].'-12-31';
				$escala =	"YEAR(a.fecha) as escala";
				$rango	= 	"(a.fecha BETWEEN '$fdes' AND '$fhas')";
			break;
		}

		$tdc 	=	$_POST['tdc'];
		$lin 	=	$_POST['lin'];
		$gru 	=	$_POST['gru'];
		$sgr 	=	$_POST['subg'];
		$car 	=	$_POST['cara'];
		$ume 	=	$_POST['ume'];


		$lin!=0?$where.=" AND a.linea='$lin' ":$where.="";
		$gru!=0?$where.=" AND a.grupo='$gru' ":$where.="";
		$sgr!=0?$where.=" AND a.subg='$sgr' ":$where.="";
		$ume!='0'?$where.=" AND a.unidad='$ume' ":$where.="";
		$car!=0?$where.=" AND a.carac='$car' ":$where.="";

		$sqlsln='';
		$sw 	=	$_POST['sw'];
		$tsln=array();
		$csln=array();
		$vsln=array();
		$join="";
		if($sw=='tpo'){
			$join=" JOIN btysalon s on s.slnadmi=a.salon";
			foreach ($sln as $key => $cod){
				$cd=implode(',',$cod);
				$acol=str_replace("-","",$cd);
				$sqlsln.=", SUM(CASE WHEN s.slntipo='$cd' THEN a.cantidad ELSE 0 end) AS c".$cd;
				$sqlsln.=", SUM(CASE WHEN s.slntipo='$cd' THEN (a.pmasiva*a.cantidad*1) ELSE 0 end) AS v".$cd;
				array_push($csln, 'c.c'.$cd);
				array_push($vsln, 'c.v'.$cd);
				array_push($tsln, 'c.c'.$cd);
				array_push($tsln, 'c.v'.$cd);
			}
			$sumc=implode('+',$csln);
			$sumv=implode('+',$vsln);
			$c=implode(',',$tsln);
		}else{
			$asln=explode(',', $sln);
			foreach ($asln as $key) {
				$sqlsln.=", SUM(CASE WHEN a.salon='".$key."' THEN a.cantidad ELSE 0 end) AS cs".$key;
				$sqlsln.=", SUM(CASE WHEN a.salon='".$key."' THEN (a.pmasiva*a.cantidad*1) ELSE 0 end) AS vs".$key;
				array_push($csln, 'c.cs'.$key);
				array_push($vsln, 'c.vs'.$key);
				array_push($tsln, 'c.cs'.$key);
				array_push($tsln, 'c.vs'.$key);
			}
			$sumc=implode('+',$csln);
			$sumv=implode('+',$vsln);
			$c=implode(',',$tsln);
		}

		mysqli_set_charset($conn,"utf8");
		$sql="SELECT c.escala,$c,($sumc) AS totalc, ($sumv) AS totalv FROM 
		(SELECT ".$escala.$sqlsln." FROM btyfromadmi a ".$join."
				WHERE ".$rango." AND a.estado='A' 
				AND a.td='$tdc' ".$where." group by escala) as c";
		
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
			$then="a.pmasiva*a.cantidad*1";
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
			$then="a.pmasiva*a.cantidad*1";
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