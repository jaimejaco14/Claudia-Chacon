<?php 
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//session_start();
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'loadcrg':
		$fecha=$_POST['fecha'];
		$slncod=$_POST['slncod'];
		$crg_arr=array();
		$sql = mysqli_query($conn, "SELECT COUNT(b.crgcodigo)as count, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = $slncod AND a.prgfecha = '".$fecha."' AND a.tprcodigo IN (1,9,10) AND d.crgincluircolaturnos = 1 GROUP BY b.crgcodigo, d.crgnombre ORDER BY d.crgnombre ");
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

		$sql = mysqli_query($conn, "SELECT if(a.tprcodigo=10, CONCAT(c.trcnombres,'<br>[Domicilios]'),c.trcnombres) as trcnombres, a.clbcodigo, d.crgnombre, TIME_FORMAT(e.trndesde, '%H:%i') as tdesde,  TIME_FORMAT(e.trnhasta,'%H:%i') as thasta, TIME_FORMAT(e.trninicioalmuerzo, '%H:%i') as ialm, TIME_FORMAT(e.trnfinalmuerzo, '%H:%i') as falm
				FROM btyprogramacion_colaboradores a
				JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo
				JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo
				JOIN btycargo d ON d.crgcodigo=b.crgcodigo
				JOIN btyturno e ON e.trncodigo=a.trncodigo
				WHERE a.slncodigo = $slncod AND a.prgfecha = '".$fecha."' AND a.tprcodigo IN (1,9,10) AND d.crgincluircolaturnos = 1 ORDER BY d.crgnombre,a.tprcodigo,trcnombres");
		while ($rows = mysqli_fetch_array($sql)) 
		{
			$col_arr[]=array('nomcol'=>$rows[0],'codcol'=>$rows[1],'crgnom'=>$rows[2],'tdesde'=>$rows[3],'thasta'=>$rows[4],'ialm'=>$rows[5],'falm'=>$rows[6]);
		}

		$sqlcitas=mysqli_query($conn, "SELECT c.clbcodigo, TIME_FORMAT(c.cithora, '%H:%i') as citahora, TIME_FORMAT(addtime(c.cithora,SEC_TO_TIME(s.serduracion*60)), '%H:%i') as citahasta, convert(c.citcodigo,char) as citcod, bty_fnc_estadocita(c.citcodigo) as estado  FROM btycita c JOIN btyservicio s on s.sercodigo=c.sercodigo WHERE c.citfecha= '".$fecha."' AND c.slncodigo= $slncod and bty_fnc_estadocita(c.citcodigo) NOT IN (3,7) order by citahora");
		while($rowcita= mysqli_fetch_array($sqlcitas)){
			$cita_arr[]=array(
				'codcol'=>$rowcita[0],
				'cithora'=>$rowcita[1], 
				'cithasta'=>$rowcita[2], 
				'citcod'=>$rowcita[3], 
				'citestado'=>$rowcita[4]);
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
		$sql="SELECT a.clicodigo, b.trcrazonsocial, b.trcdocumento, b.trcdireccion, b.brrcodigo, b.trctelefonomovil FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo WHERE b.trcrazonsocial like '%".$txt."%' or b.trcdocumento like '%".$txt."%'";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['clicodigo'], 
				'nom'=>utf8_encode($row['trcrazonsocial']), 
				'ced'=>$row['trcdocumento'], 
				'address'=>utf8_encode($row['trcdireccion']), 
				'brr'=>$row['brrcodigo'], 
				'phone'=>$row['trctelefonomovil']));
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
		$codcol		=$_POST['codcol'];
		$clicod		=$_POST['clicod'];
		$fecha		=$_POST['fecha'];
		$hora		=$_POST['hora'];
		$sercod		=$_POST['sercod'];
		$obs		=$_POST['obs'];
		$slncod		=$_POST['slncod'];
		$usucod		=$_POST['usucod'];
		$tipocita	=$_POST['tipocita'];

		$address	=$_POST['address'];
		$barrio		=$_POST['barrio'];
		$celu		=$_POST['celu'];

		$vserv		=$_POST['vserv'];
		$vrcgo		=$_POST['vrcgo'];
		$vtrai		=$_POST['vtrai'];
		$vtrar		=$_POST['vtrar'];
		$total		=$_POST['total'];

		if($tipocita=='1'){
			$esc=10;
		}else{
			$esc=1;
		}
		$sqlupdter="UPDATE btytercero t JOIN btycliente c ON c.tdicodigo=t.tdicodigo AND c.trcdocumento=t.trcdocumento
					SET t.trcdireccion='$address', t.brrcodigo=$barrio, t.trctelefonomovil='$celu' WHERE c.clicodigo=$clicod";
		if($conn->query($sqlupdter)){
			/////////////////////////////////////////////////////////
			$id_cita=mysqli_fetch_array(mysqli_query($conn,'SELECT max(ct.citcodigo)+1 from btycita ct'));
			/////////////////////////////////////////////////////////
			$sql="INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES($id_cita[0], 1, $codcol, $slncod, $sercod, $clicod, $usucod,'".$fecha."','".$hora."', CURDATE(), CURTIME(), '".$obs."')";
			if($conn->query($sql)){ 
				$sqln="INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES ($esc, $id_cita[0], CURDATE(), CURTIME(), $usucod, '')";
				if($conn->query($sqln)){
					if($tipocita=='1'){
						$sqldom="INSERT INTO btydomicilio (citcodigo, dmvalser, dmvalrec, dmvaltrai, dmvaltrar, dmtotal) VALUES ($id_cita[0], $vserv, $vrcgo, $vtrai, $vtrar, $total)";
						if($conn->query($sqldom)){
							echo '1';
						}else{
							echo 'D';
						}
					}else{
						echo '1';
					}
				}else{
					echo 'N';
				}
			}else{
				echo 'C';
			}
		}else{
			echo 'T';
		}
	break;
	case 'editcita':
		$codcli	=$_POST['codcli'];
		$sercod	=$_POST['sercod'];
		$hora	=$_POST['hora'];
		$obs	=$_POST['obs']; 
		$citcod	=$_POST['citcodigo'];
		$dur	=$_POST['dur']-1;
		$fecha 	=$_POST['fecha'];
		$salon	=$_POST['salon'];
		$codcol	=$_POST['codcol'];
		$usucod	=$_POST['usucod'];

		$address	=$_POST['address'];
		$barrio		=$_POST['barrio'];
		$celu		=$_POST['celu'];

		$tcita 	=$_POST['tcita'];
		$ecod 	=$tcita==1?10:1;
		$vserv	=$_POST['vserv'];
		$vrcgo	=$_POST['vrcgo'];
		$vtrai	=$_POST['vtrai'];
		$vtrar	=$_POST['vtrar'];
		$total	=$_POST['total'];

		$sqlupdter="UPDATE btytercero t JOIN btycliente c ON c.tdicodigo=t.tdicodigo AND c.trcdocumento=t.trcdocumento
					SET t.trcdireccion='$address', t.brrcodigo=$barrio, t.trctelefonomovil='$celu' WHERE c.clicodigo=$codcli";
		if($conn->query($sqlupdter)){
			$sql="SELECT COUNT(*) FROM btycita c WHERE c.citfecha='".$fecha."' AND c.slncodigo=$salon AND (c.cithora BETWEEN TIME_FORMAT('".$hora."','%H:%i') AND TIME_FORMAT(ADDTIME(TIME_FORMAT('".$hora."','%H:%i'), SEC_TO_TIME(".$dur."*60)),'%H:%i')) AND c.citcodigo <> $citcod AND bty_fnc_estadocita(c.citcodigo) NOT IN (3,7) and c.clbcodigo=$codcol";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]==0){
				$sql2="UPDATE btycita c, btynovedad_cita n SET c.sercodigo=$sercod, c.clicodigo=$codcli, c.usucodigo=$usucod, c.cithora='".$hora."', n.esccodigo = $ecod WHERE c.citcodigo=n.citcodigo AND c.citcodigo=$citcod";
				if($conn->query($sql2)){
					$sqln2="INSERT INTO btydomicilio (citcodigo,dmvalser,dmvalrec,dmvaltrai,dmvaltrar,dmtotal) VALUES ($citcod,$vserv,$vrcgo,$vtrai,$vtrar,$total)
						ON DUPLICATE KEY UPDATE dmvalser=$vserv, dmvalrec=$vrcgo, dmvaltrai=$vtrai, dmvaltrar=$vtrar, dmtotal=$total";
					if($conn->query($sqln2)){
						echo 0;
					}else{
						echo 1;
					}
				}else{
					echo 1;
				}
			}else{
				echo 2;
			}
		}else{
			echo 'T';
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
									WHERE pc.prgfecha= '$fecha' AND pc.slncodigo=$sln AND pc.tprcodigo NOT IN (1,9,10) AND cg.crgincluircolaturnos=1
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
	case 'verAgenda':
		$codcita=$_POST['citcodigo'];
		$sql="SELECT c.trcdocumento,a.cithora, b.sernombre, d.trcrazonsocial, d.trcdireccion, br.brrcodigo, c.cliemail, d.trctelefonomovil, CONCAT(b.serduracion, ' ', 'MIN') AS serduracion, f.trcnombres AS usuarioAgendo,c.clicodigo AS clicod,a.sercodigo AS sercod, bty_fnc_estadocita(a.citcodigo) AS ecita, ifnull(dm.dmvalser,0) AS valser, ifnull(dm.dmvalrec,0) AS valrec, ifnull(dm.dmvaltrai,0) AS vtrai, ifnull(dm.dmvaltrar,0) AS vtrar, ifnull(dm.dmtotal,0) AS vtot, a.citobservaciones AS cov
			FROM btycita a
			JOIN btyservicio b ON a.sercodigo=b.sercodigo
			JOIN btycliente c ON c.clicodigo=a.clicodigo
			JOIN btytercero d ON d.tdicodigo=c.tdicodigo AND d.trcdocumento=c.trcdocumento
			JOIN btybarrio br ON d.brrcodigo=br.brrcodigo
			JOIN btyusuario e ON e.usucodigo=a.usucodigo
			JOIN btytercero f ON f.tdicodigo=e.tdicodigo AND f.trcdocumento=e.trcdocumento
			LEFT JOIN btydomicilio dm ON dm.citcodigo=a.citcodigo
			WHERE a.citcodigo = $codcita";
		mysqli_set_charset($conn,"utf8");
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		/*BUSQUEDA ENCUESTA COVID*/
			$sqlcovid="SELECT e.cefeho AS feho, MAX(d.cpres) AS sw FROM covid_encuesta e JOIN covid_encuesta_detalle d ON d.cecod=(SELECT MAX(en.cecod) FROM covid_encuesta en WHERE en.idnum=".$row['trcdocumento'].") WHERE e.idnum=".$row['trcdocumento']." AND DATE(e.cefeho)=CURDATE()";
			$rcovid=mysqli_fetch_array(mysqli_query($conn,$sqlcovid));
			$csw = $rcovid['sw'];
			$cfh = $rcovid['feho'];
		/*FIN BUSQUEDA ENCUESTA COVID*/
		/*BUSQUEDA FORMA DE PAGO*/
			$sqlfpgo="SELECT a.dctpago AS fpgo FROM btydomicitaApp a WHERE a.citcodigo LIKE '%".$codcita."%'";
			$resfpgo=mysqli_fetch_array(mysqli_query($conn,$sqlfpgo))[0];
			if($resfpgo=='OLN'){
				$fpgo='PAGO EN LINEA';
			}else{
				$fpgo='EFECTIVO / CONTRAENTREGA';
			}
		/*FIN BUSQUEDA FORMA DE PAGO*/
		
		$array = array();
		$array[] = array('hora' 	 => $row['cithora'], 
						'servicio' 	 => $row['sernombre'], 
						'cliente' 	 => $row['trcrazonsocial'], 
						'address' 	 => $row['trcdireccion'], 
						'barrio' 	 => $row['brrcodigo'], 
						'email' 	 => $row['cliemail'], 
						'movil' 	 => $row['trctelefonomovil'], 
						'duracion' 	 => $row['serduracion'], 
						'usuagenda'  => $row['usuarioAgendo'], 
						'clicod'	 => $row['clicod'], 
						'sercod'	 => $row['sercod'],
						'estadoCita' => $row['ecita'],
						'covid' 	 => $row['cov'],
						'valser' 	 => number_format($row['valser']),
						'valrec' 	 => number_format($row['valrec']),
						'vtrai' 	 => number_format($row['vtrai']),
						'vtrar' 	 => number_format($row['vtrar']),
						'vtot' 	 	 => number_format($row['vtot']),
						'csw'		 => $csw,
						'cfh' 		 => $cfh,
						'fpgo'		 => $fpgo);
		echo json_encode($array);
	break;
	case 'loadbarrio':
		$sql="SELECT b.brrcodigo, b.brrnombre FROM btybarrio b WHERE b.brrstado=1 ORDER BY b.brrnombre";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['brrcodigo'],'nom'=>$row['brrnombre']);
		}
		echo json_encode($array);
	break;
	case 'detDom':
		$codCita=$_POST['codCita'];
		mysqli_set_charset($conn,'UTF8');
		$sql="SELECT CONCAT(a.dcclinom,' ',a.dccliape) AS domcli, a.dcclidir AS domdir, a.dcclicel AS domtel, if(a.dctpago='EFE','EFECTIVO','PAGO EN LINEA') AS domfpago, a.citcodigo AS codcita, a.dccovid AS covid FROM btydomicitaApp a WHERE a.citcodigo LIKE '%".$codCita."%'";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		$kitc=0;
		if($row['covid']==1){
			$sqlkc="SELECT p.serprecio AS pre FROM appservicio s JOIN appservicio_precio p ON p.sercodigo=s.sercodigo WHERE s.sercodigo=91";
			$kitc=mysqli_fetch_array(mysqli_query($conn,$sqlkc))[0];
		}
		$datacli=array('domcli'=>$row['domcli'],'domdir'=>$row['domdir'],'domtel'=>$row['domtel'],'domfpago'=>$row['domfpago'], 'covid'=>$row['covid'], 'kit'=>$kitc);

		$sqlc="SELECT t.trcrazonsocial AS col, s.sernombre AS ser, p.serprecio AS pre
				FROM btycita ct
				JOIN btycolaborador co ON co.clbcodigo=ct.clbcodigo
				JOIN btytercero t ON t.trcdocumento=co.trcdocumento
				JOIN btyservicio s ON s.sercodigo=ct.sercodigo
				JOIN appservicio a ON s.sercodigo=a.serequi
				JOIN appservicio_precio p ON p.sercodigo=a.sercodigo AND p.slntipo='DOM'
				WHERE ct.citcodigo IN (".$row['codcita'].")";
		$resc=$conn->query($sqlc);
		while($rowc=$resc->fetch_array()){
			$dataser[]=array('col'=>$rowc['col'], 'ser'=>$rowc['ser'], 'pre'=>$rowc['pre']);
		}

		echo json_encode(array('datacli'=>$datacli,'dataser'=>$dataser));
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