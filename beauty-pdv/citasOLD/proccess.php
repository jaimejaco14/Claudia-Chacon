<?php 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'loadcrg':
		$fecha=$_POST['fecha'];
		$slncod=$_POST['slncod'];
		$crg_arr=array();
		$sql = mysqli_query($conn, "SELECT COUNT(b.crgcodigo)as count, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = $slncod AND a.prgfecha = '".$fecha."' AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY b.crgcodigo, d.crgnombre ORDER BY d.crgnombre ");
		while ($rows = mysqli_fetch_array($sql)) 
		{
			$crg_arr[]=array('crgcount'=>$rows[0],'crgnombre'=>$rows[1]);
		}
		echo json_encode($crg_arr);
	break;
	case 'loadcol':
		$fecha=$_POST['fecha'];
		$slncod=$_POST['slncod'];
		$col_arr=array();
		$cita_arr=array();

		$sql = mysqli_query($conn, "SELECT c.trcnombres, a.clbcodigo, d.crgnombre, TIME_FORMAT(e.trndesde, '%H:%i') as tdesde,  TIME_FORMAT(e.trnhasta,'%H:%i') as thasta, TIME_FORMAT(e.trninicioalmuerzo, '%H:%i') as ialm, TIME_FORMAT(e.trnfinalmuerzo, '%H:%i') as falm
				FROM btyprogramacion_colaboradores a
				JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo
				JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo
				JOIN btycargo d ON d.crgcodigo=b.crgcodigo
				JOIN btyturno e ON e.trncodigo=a.trncodigo
				WHERE a.slncodigo = $slncod AND a.prgfecha = '".$fecha."' AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 ORDER BY d.crgnombre");
		while ($rows = mysqli_fetch_array($sql)) 
		{
			$col_arr[]=array('nomcol'=>$rows[0],'codcol'=>$rows[1],'crgnom'=>$rows[2],'tdesde'=>$rows[3],'thasta'=>$rows[4],'ialm'=>$rows[5],'falm'=>$rows[6]);
		}

		$sqlcitas=mysqli_query($conn, "SELECT c.clbcodigo, TIME_FORMAT(c.cithora, '%H:%i') as citahora, TIME_FORMAT(addtime(c.cithora,SEC_TO_TIME(s.serduracion*60)), '%H:%i') as citahasta, convert(c.citcodigo,char) as citcod, bty_fnc_estadocita(c.citcodigo) as estado  FROM btycita c JOIN btyservicio s on s.sercodigo=c.sercodigo WHERE c.citfecha= '".$fecha."' AND c.slncodigo= $slncod and bty_fnc_estadocita(c.citcodigo) NOT IN (3,7) order by citahora");
		while($rowcita= mysqli_fetch_array($sqlcitas)){
			$cita_arr[]=array('codcol'=>$rowcita[0],'cithora'=>$rowcita[1], 'cithasta'=>$rowcita[2], 'citcod'=>$rowcita[3], 'citestado'=>$rowcita[4]);
		}
		echo json_encode(array('turnos'=>$col_arr,'citas'=>$cita_arr));
	break;
	case 'loadhsalon':
		$slncod=$_POST['slncod'];
		$fecha=$_POST['fecha'];
		$res=mysqli_query($conn,"SELECT festipo FROM btyfechas_especiales fe WHERE fe.fesfecha='".$fecha."' and fesestado=1");
		if($res->num_rows>0){
			$row=$res->fetch_array();
			$tipodia="'".$row[0]."'";
		}else{
			$tipodia="DAYNAME('".$fecha."')";
		}
		mysqli_query($conn, "SET lc_time_names = 'es_CO'");
		$sql2 = "SELECT TIME_FORMAT(h.hordesde, '%H:%i') AS desde, TIME_FORMAT(h.horhasta, '%H:%i')AS horhasta FROM btyhorario h JOIN btyhorario_salon hs ON h.horcodigo=hs.horcodigo WHERE hs.slncodigo = $slncod AND h.hordia =".$tipodia;
		$res2=$conn->query($sql2);
		$row2=$res2->fetch_array();
		$turno=(array('hdesde'=>$row2[0],'hhasta'=>$row2[1]));
		echo json_encode($turno);
	break;
	case 'loadcli':
		$txt=utf8_decode($_POST['txt']);
		$sql="SELECT a.clicodigo, b.trcrazonsocial, b.trcdocumento FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo WHERE b.trcrazonsocial like '%".$txt."%' or b.trcdocumento like '%".$txt."%'";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['clicodigo'], 'nom'=>utf8_encode($row['trcrazonsocial']), 'ced'=>$row['trcdocumento']));
		}
		echo json_encode($array);
	break;
	case 'loadser':
		$codcol=$_POST['codcol'];
		$sqlcol="SELECT b.clbcodigo, a.trcrazonsocial, b.crgcodigo, crg.crgnombre FROM btytercero a JOIN btycolaborador b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo WHERE b.clbcodigo =$codcol";
		$rescol=$conn->query($sqlcol);
		$rowcol=$rescol->fetch_array();

		$sql="SELECT a.sercodigo, a.sernombre, a.serduracion FROM btyservicio a JOIN btyservicio_colaborador b ON a.sercodigo=b.sercodigo WHERE b.clbcodigo = $codcol order by sernombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['sercodigo'], 'nom'=>utf8_encode($row['sernombre']), 'dur'=>$row['serduracion']));
		}
		echo json_encode(array('ser'=>$array,'nomcol'=>utf8_encode($rowcol[1])));
	break;
	case 'valtime':
		$codcol=$_POST['codcol'];
		$dur=$_POST['dur']-1;
		$slncod=$_POST['slncod'];
		$fecha=$_POST['fecha'];
		$hora=$_POST['hora'];
		$sql="SELECT COUNT(*) FROM btycita c WHERE bty_fnc_estadocita(c.citcodigo) NOT IN (3,7) AND c.slncodigo=$slncod AND c.citfecha= '".$fecha."' AND c.clbcodigo=$codcol AND c.cithora BETWEEN '".$hora."' AND ADDTIME('".$hora."', SEC_TO_TIME(".$dur."*60))";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		echo $row[0];
	break;
	case 'inscita':
		$codcol=$_POST['codcol'];
		$clicod=$_POST['clicod'];
		$fecha=$_POST['fecha'];
		$hora=$_POST['hora'];
		$sercod=$_POST['sercod'];
		$obs=$_POST['obs'];
		$slncod=$_POST['slncod'];
		$usucod=$_POST['usucod'];
		$sql="INSERT INTO btycita (citcodigo,meccodigo,clbcodigo,slncodigo,sercodigo,clicodigo,usucodigo,citfecha,cithora,citfecharegistro,cithoraregistro,citobservaciones) VALUES((SELECT max(ct.citcodigo)+1 from btycita ct),1,$codcol,$slncod,$sercod,$clicod,$usucod,'".$fecha."','".$hora."',CURDATE(),CURTIME(),'".$obs."')";
		if($conn->query($sql)){
			$sqln="INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (1, (SELECT max(ct.citcodigo) from btycita ct), CURDATE(), CURTIME(), $usucod, '')";
			if($conn->query($sqln)){
				echo '1';
			}else{
				echo '0';
			}
		}else{
			echo '0';
		}
	break;
	case 'editcita':
		$codcli=$_POST['codcli'];
		$sercod=$_POST['sercod'];
		$hora=$_POST['hora'];
		$obs=$_POST['obs']; 
		$citcod=$_POST['citcodigo'];
		$dur=$_POST['dur']-1;
		$fecha=$_POST['fecha'];
		$salon=$_POST['salon'];
		$codcol=$_POST['codcol'];
		$usucod=$_POST['usucod'];

		$sql="SELECT COUNT(*) FROM btycita c WHERE c.citfecha='".$fecha."' AND c.slncodigo=$salon AND (c.cithora BETWEEN TIME_FORMAT('".$hora."','%H:%i') AND TIME_FORMAT(ADDTIME(TIME_FORMAT('".$hora."','%H:%i'), SEC_TO_TIME(".$dur."*60)),'%H:%i')) AND c.citcodigo <> $citcod AND bty_fnc_estadocita(c.citcodigo) NOT IN (3,7) and c.clbcodigo=$codcol";
		//echo $sql;
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		if($row[0]==0){
			$sql2="UPDATE btycita set sercodigo=$sercod, clicodigo=$codcli, usucodigo=$usucod, cithora='".$hora."' where citcodigo=$citcod";
			if($conn->query($sql2)){
				//$sqln2="INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (10, $citcod, CURDATE(), CURTIME(), $usucod, '')";
				//echo $sqln2;
				//if($conn->query($sqln2)){
					echo 0;
				//}
			}else{
				echo 1;
			}
		}else{
			echo 2;
		}
	break;
	case 'loadpnp':
		$sln=$_POST['sln'];
		$fecha=$_POST['fecha'];
		$sql = mysqli_query($conn, "SELECT t.trcrazonsocial,cg.crgnombre,tp.tprnombre,c.clbcodigo
									FROM btyprogramacion_colaboradores pc
									JOIN btytipo_programacion tp ON tp.tprcodigo=pc.tprcodigo
									JOIN btycolaborador c ON c.clbcodigo=pc.clbcodigo
									JOIN btycargo cg ON cg.crgcodigo=c.crgcodigo
									JOIN btytercero t ON t.trcdocumento=c.trcdocumento AND t.tdicodigo=c.tdicodigo
									WHERE pc.prgfecha= '$fecha' AND pc.slncodigo=$sln AND pc.tprcodigo NOT IN (1,9) AND cg.crgincluircolaturnos=1
									ORDER BY t.trcrazonsocial");
		$array = array();
		if(mysqli_num_rows($sql) > 0){
		    while($data = mysqli_fetch_assoc($sql)){
			      $array['data'][] = $data;
			}        
	     		$array= utf8_converter($array);
		}
		else{			
		      $array=array('data'=>'');
		}
		echo json_encode($array);
	break;
	case 'swpnp':
		$codcol=$_POST['codcol'];
		$fecha=$_POST['fecha'];
		$sql="UPDATE btyprogramacion_colaboradores SET tprcodigo = 9 WHERE clbcodigo = $codcol AND prgfecha = '$fecha'";
		if($conn->query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	break;
}
function utf8_converter($array){
	array_walk_recursive($array, function(&$item, $key)
	{
		if(!mb_detect_encoding($item, 'utf-8', true))
		{
  			$item = utf8_encode($item);
		}
	});

	return $array;
}
?>