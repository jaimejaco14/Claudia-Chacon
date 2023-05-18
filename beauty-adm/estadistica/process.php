<?php 
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'listsln':
		$sql="SELECT concat('Tipo ',s.slntipo) as tipo ,GROUP_CONCAT(s.slncodigo) as cod FROM btysalon s WHERE s.slnestado=1 GROUP BY s.slntipo";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$tipo[]=array('cod'=>$row['cod'],'nom'=>$row['tipo']);
		}
		$sql="SELECT slncodigo,slnnombre FROM btysalon WHERE slnestado=1 ORDER BY slnnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$sln[]=array('cod'=>$row['slncodigo'],'nom'=>$row['slnnombre']);
		}
		echo json_encode(array('tipo'=>$tipo,'sln'=>$sln));
	break;
	case 'stat1':
		$ts=$_POST['ts'];
		$sln=$_POST['selsln'];
		if($sln!=''){
			$sl=implode(',',$sln);
			$wrsln=" and s.slncodigo in ($sl)";
			if($ts=='tpo'){
				$slnom=" concat('S. Tipo ',s.slntipo) as slnnombre";
				$wrsln2=" and s2.slncodigo in ($sl)";
				$groupby=" group by s.slntipo";
			}else{
				$slnom=" s.slnnombre";
				$wrsln2=" and s2.slncodigo = s.slncodigo";
				$groupby=" group by s.slnnombre";
			}
		}
		$fd=$_POST['fdesde'];
		$fh=$_POST['fhasta'];
		$sql="SELECT SUM(a.efectivo) AS efectivo, SUM(a.valortare) AS tarjeta, SUM(a.otrospagos) AS otrosp, SUM(a.valor) AS total,
					(SELECT COUNT(*)
					FROM btyfromadmi f
					JOIN btysalon s2 ON s2.slnadmi=f.salon
					WHERE f.estado='A' AND f.linea='01' AND f.fecha BETWEEN '$fd' AND '$fh' AND f.td='FS' ".$wrsln2.") AS csc 
				FROM btyfromadmi2 a
				JOIN btysalon s ON s.slnadmi=a.centro
				WHERE a.fecha BETWEEN '$fd' AND '$fh' AND a.td IN ('fs')".$wrsln;
		//echo $sql;
		$res=$conn->query($sql);
		$vlr=0; $otr=0; $eft=0; $trj=0; $csc=0;
		$row=$res->fetch_array();
		$vlr=$row['total'];
		$otr=$row['otrosp'];
		$eft=$row['efectivo'];
		$trj=$row['tarjeta'];
		$csc=$row['csc'];
			
		$total=array('tvlr'=>number_format($vlr), 'totr'=>number_format($otr), 'teft'=>number_format($eft), 'ttrj'=>number_format($trj), 'tcsc'=>$csc);

		echo json_encode($total);
	break;
	case 'detsvc':
		$sln=$_POST['selsln'];
		$sl=implode(',',$sln);
		if($sln!=''){
			$wrsln=" and s.slncodigo in ($sl) ";
		}
		$sl=implode(',',$sln);
		$fd=$_POST['fdesde'];
		$fh=$_POST['fhasta'];
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT f.descripcio as nser, COUNT(*) AS cant
				FROM btyfromadmi f
				JOIN btysalon s ON s.slnadmi=f.salon
				WHERE f.estado='A' AND f.linea='01' AND f.fecha BETWEEN '$fd' AND '$fh' ".$wrsln." GROUP BY f.referencia ORDER BY cant DESC";
		//echo $sql;
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('nser'=>$row['nser'],'cant'=>$row['cant']);
		}
		echo json_encode($array);
	break;
	case 'dettrj':
		$sln=$_POST['selsln'];
		$sl=implode(',',$sln);
		if($sln!=''){
			$wrsln=" and s.slncodigo in ($sl) ";
		}
		$sl=implode(',',$sln);
		$fd=$_POST['fdesde'];
		$fh=$_POST['fhasta'];
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT if(a.tarjeta='','OTRAS',a.tarjeta) as ntrj, SUM(a.valortare) AS vtrj
				FROM 
				btyfromadmi2 a
				JOIN btysalon s ON s.slnadmi=a.centro
				WHERE a.fecha BETWEEN '$fd' AND '$fh' ".$wrsln." GROUP BY ntrj HAVING vtrj>0 order by vtrj desc";
		//echo $sql;
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('ntrj'=>$row['ntrj'],'vtrj'=>number_format($row['vtrj']));
		}
		echo json_encode($array);
	break;
	case 'detvta':
		$sln=$_POST['selsln'];
		$sl=implode(',',$sln);
		if($sln!=''){
			$wrsln=" and s.slncodigo in ($sl) ";
		}
		$fd=$_POST['fdesde'];
		$fh=$_POST['fhasta'];
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT b.ndocu,b.nombre,b.serv,b.prod,b.dct,(b.efectivo+b.valortare) as total,if(b.efectivo>0 and b.valortare>0,'MIXTO',if(b.efectivo>0,'EFECTIVO','TARJETA')) as medpag
				FROM
				(SELECT distinct
				a.ndocu,a.nombre,
				SUM(CASE WHEN a.linea='01' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS serv,
				SUM(CASE WHEN a.linea='02' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS prod,
				SUM(CASE WHEN a.linea in ('01','02') THEN (a.pmasiva*a.cantidad*a.pordes)/100 ELSE 0 END) AS dct,
				CAST(a2.efectivo as INTEGER) as efectivo,
				CAST(a2.valortare as INTEGER) as valortare
				FROM btyfromadmi a
				JOIN btyfromadmi2 a2 ON a2.nfactura=a.ndocu AND a2.td=a.td
				JOIN btysalon s ON s.slnadmi=a2.centro
				WHERE a.estado='A' AND a.fecha BETWEEN '$fd' AND '$fh' and a.td='FS' ".$wrsln."
				GROUP BY a.ndocu 
				) AS b";
		//echo $sql;
		/*$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('ndocu'=>$row['ndocu'],'nombre'=>$row['nombre'],'serv'=>number_format($row['serv']),'prod'=>number_format($row['prod']),'dct'=>number_format($row['dct']),'total'=>number_format($row['total']),'medpag'=>$row['medpag']);
		}
		echo json_encode($array);*/
		$params = $columns = $totalRecords = $data = array();

		$params = $_REQUEST;

		//define index of column
		$columns = array( 
			0 =>'ndocu',
			1 =>'nombre', 
			2 => 'serv',
			3 => 'prod',
			4 => 'dct',
			5 => 'total',
			6 => 'medpag'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" WHERE ";
			$where .=" ( nombre LIKE '".$params['search']['value']."%' ";    
			$where .=" OR ndocu LIKE '".$params['search']['value']."%' ";
			$where .=" OR medpag LIKE '".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		//$sql = "SELECT * FROM `employee` ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}


	 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

		$queryTot = mysqli_query($conn, $sqlTot) or die("database error:". mysqli_error($conn));


		$totalRecords = mysqli_num_rows($queryTot);

		$queryRecords = mysqli_query($conn, $sqlRec) or die("error to fetch sale data");

		//iterate on results row and create new index array of data
		while( $row = mysqli_fetch_row($queryRecords) ) { 
			$data[] = $row;
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $data   // total data array
				);

		echo json_encode($json_data);
		//echo $sqlRec;
	break;
	case 'detfact':
		$nfact=$_POST['nfact'];
		mysqli_set_charset($conn,"utf8");
		/*------------------------DATOS DE FACTURA-------------------------------------------------*/
		$sql="SELECT a.fecha,TIME_FORMAT(b.horafactu,'%h:%i %p') as hora,a.efectivo,a.valortare,a.tarjeta,b.nombre,(a.efectivo+a.valortare) as total
				FROM btyfromadmi2 a
				JOIN btyfromadmi b ON b.ndocu=a.nfactura
				WHERE a.nfactura='$nfact'
				LIMIT 1";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		$array0=array(	'fecha'		=>$row['fecha'],
						'hora'		=>$row['hora'],
						'cliente'	=>$row['nombre'],
						'efectivo'	=>number_format($row['efectivo']),
						'valortare'	=>number_format($row['valortare']),
						'total'		=>number_format($row['total']),
						'tarjeta'	=>$row['tarjeta']);

		/*------------------------DETALLE DE FACTURA-------------------------------------------------*/
		$sql="SELECT  b.nomesti,b.descripcio,(b.serv+b.prod) as valor, b.dct
				FROM
				(SELECT 
				a.ndocu,a.nomesti,a.descripcio,
				SUM(CASE WHEN a.linea='01' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS serv,
				SUM(CASE WHEN a.linea='02' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS prod,
				SUM(CASE WHEN a.linea in('01','02') THEN (a.pmasiva*a.cantidad*a.pordes)/100 ELSE 0 END) AS dct
				FROM btyfromadmi a
				JOIN btyfromadmi2 a2 ON a2.nfactura=a.ndocu AND a2.td=a.td
				WHERE a.estado='A' and a.td='FS' and a.ndocu='$nfact'
				GROUP BY a.estilista,a.horatique
				) AS b
				having valor>0";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array1[]=array('nomesti'	=>$row['nomesti'],
							'nomser'	=>$row['descripcio'],
							'valor'		=>number_format($row['valor']),
							'tdct'		=>number_format($row['dct']));
		}
		

		echo json_encode(array('infofact'=>$array0,'detfact'=>$array1));
	break;
	case 'detcol':
		$sln=$_POST['selsln'];
		$sl=implode(',',$sln);
		if($sln!=''){
			$wrsln=" and s.slncodigo in ($sl) ";
		}
		$fd=$_POST['fdesde'];
		$fh=$_POST['fhasta'];
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT b.nomesti,b.estilista,b.crgnombre,b.serv,b.prod,b.qcos,b.tqt,b.ins,b.dct,if(b.serv>0,(b.serv-b.qcos-b.tqt-b.ins-b.dct),0) AS bliq
				FROM
				(SELECT
				a.nomesti,a.estilista,cg.crgnombre,
				SUM(CASE WHEN a.linea='01' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS serv,
				SUM(CASE WHEN a.linea='02' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS prod,
				SUM(CASE WHEN a.linea='03' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS qcos,
				SUM(CASE WHEN a.linea='04' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS tqt,
				SUM(CASE WHEN a.linea='05' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS ins,
				SUM(CASE WHEN a.linea in ('01','02') THEN (a.pmasiva*a.cantidad*a.pordes)/100 ELSE 0 END) AS dct
				FROM btyfromadmi a
				join btytercero t on t.trcdocumento=a.estilista
				join btycolaborador c on c.trcdocumento=t.trcdocumento and c.tdicodigo=t.tdicodigo
				join btycargo cg on cg.crgcodigo=c.crgcodigo
				JOIN btysalon s ON s.slnadmi=a.salon
				WHERE a.estado='A' and a.fecha between '$fd' and '$fh' and a.td='FS' ".$wrsln."
				GROUP BY a.estilista
				#having serv>0
				) AS b
				ORDER BY b.nomesti";
		$res=$conn->query($sql);
		/*while($row=$res->fetch_array()){
			$array[]=array('nomesti'=>$row['nomesti'],'idesti'=>$row['estilista'],'crgnombre'=>$row['crgnombre'],'serv'=>number_format($row['serv']),'prod'=>number_format($row['prod']),'qcos'=>number_format($row['qcos']),'tqt'=>number_format($row['tqt']),'ins'=>number_format($row['ins']),'dct'=>number_format($row['dct']),'bliq'=>number_format($row['bliq']));
		}*/
		while($data = mysqli_fetch_assoc($res)){
             $array['data'][] = $data;
        }  
		echo json_encode($array);
	break;
	case 'liqcol':
		$sln=$_POST['selsln'];
		$sl=implode(',',$sln);
		if($sln!=''){
			$wrsln=" and s.slncodigo in ($sl) ";
		}
		$fd=$_POST['fdesde'];
		$fh=$_POST['fhasta'];
		$idcol=$_POST['idcol'];
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT
				b.fecha,b.ndocu,b.serv,b.prod,b.qcos,b.tqt,b.ins,b.dct,if(b.serv>0,(b.serv-b.qcos-b.tqt-b.ins-b.dct),0)as bliq
				FROM(SELECT
				a.fecha,a.ndocu,
				SUM(CASE WHEN a.linea='01' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS serv,
				SUM(CASE WHEN a.linea='02' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS prod,
				SUM(CASE WHEN a.linea='03' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS qcos,
				SUM(CASE WHEN a.linea='04' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS tqt,
				SUM(CASE WHEN a.linea='05' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS ins,
				SUM(CASE WHEN a.linea in ('01','02') THEN (a.pmasiva*a.cantidad*a.pordes)/100 ELSE 0 END) AS dct
				FROM btyfromadmi a
				JOIN btysalon s ON s.slnadmi=a.salon
				WHERE a.estado='A'  and a.td='FS' and a.estilista='$idcol' and a.fecha between '$fd' and '$fh' ".$wrsln."
				GROUP BY a.ndocu) as b";
		$res=$conn->query($sql);
		/*while($row=$res->fetch_array()){
			$array[]=array('fecha'=>$row['fecha'],'ndocu'=>$row['ndocu'],'serv'=>number_format($row['serv']),'prod'=>number_format($row['prod']),'qcos'=>number_format($row['qcos']),'tqt'=>number_format($row['tqt']),'ins'=>number_format($row['ins']),'dct'=>number_format($row['dct']),'bliq'=>number_format($row['bliq']));
		}*/
		while($data = mysqli_fetch_assoc($res)){
             $array['data'][] = $data;
        }
		echo json_encode($array);
	break;
	case 'comp':
		$sln=$_POST['sln'];

		if($sln!=''){
			$wrsln=" and s.slncodigo in ($sln)";
		}
		$fd=$_POST['desde'];
		$fh=$_POST['hasta'];
		$ts=$_POST['ts'];
		$tv=$_POST['tv'];
		if($tv==1){
			$sql1="(SELECT SUM(a.valor) FROM btyfromadmi2 a JOIN btysalon s ON s.slnadmi=a.centro
			WHERE a.fecha BETWEEN '$fd' AND '$fh' AND a.td='FS' ".$wrsln.") AS valor";
		}else{
			$sql1='null';
		}
		if($ts==1){
			$sql2="(SELECT COUNT(*) FROM btyfromadmi f JOIN btysalon s ON s.slnadmi=f.salon
			WHERE f.estado='A' AND f.linea='01' AND f.fecha BETWEEN '$fd' AND '$fh' AND f.td='FS' ".$wrsln.") AS csc";
		}else{
			$sql2='null';
		}
		$sql="SELECT ".$sql1." , ".$sql2;
		//echo $sql;
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		echo json_encode(array('tvta'=>number_format($row['valor']),'tsvc'=>$row['csc']));
	break;
	case 'loadcol':
		$sql="SELECT c.clbcodigo,t.trcrazonsocial
				FROM btycolaborador c
				JOIN btytercero t ON t.tdicodigo=c.tdicodigo AND t.trcdocumento=c.trcdocumento
				WHERE bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO' AND c.clbestado=1
				ORDER BY t.trcrazonsocial";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['clbcodigo'],'nom'=>$row['trcrazonsocial']);
		}
		echo json_encode($array);
	break;
	case 'loadsvc':
		$sql="SELECT s.sercodigoanterior,s.sernombre FROM btyservicio s WHERE s.serstado=1 ORDER BY s.sernombre";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['sercodigoanterior'],'nom'=>$row['sernombre']);
		}
		echo json_encode($array);
	break;
	case 'rpgen':
		$tipo=$_POST['tipo'];
		$selitem=$_POST['selitem'];
		$fd=$_POST['fdesde'];
		$fh=$_POST['fhasta'];
		$ts=$_POST['ts'];
		switch($tipo){
			case 'xcol':
				$col=implode(',',$selitem);
				$sql="SELECT b.nomesti,b.estilista,b.crgnombre,b.cserv,b.serv,b.prod,b.qcos,b.tqt,b.ins,b.dct, IF(b.serv>0,(b.serv-b.prod-b.qcos-b.tqt-b.ins-b.dct),0) AS bliq FROM
						(SELECT a.nomesti,a.estilista,cg.crgnombre, 
						SUM(CASE WHEN a.linea='01' THEN 1 ELSE 0 END) AS cserv, 
						SUM(CASE WHEN a.linea='01' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS serv, 
						SUM(CASE WHEN a.linea='02' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS prod, 
						SUM(CASE WHEN a.linea='03' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS qcos, 
						SUM(CASE WHEN a.linea='04' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS tqt, 
						SUM(CASE WHEN a.linea='05' THEN (a.pmasiva*a.cantidad) ELSE 0 END) AS ins, 
						SUM(CASE WHEN a.linea IN ('01','02') THEN (a.pmasiva*a.cantidad*a.pordes)/100 ELSE 0 END) AS dct
						FROM btyfromadmi a
						JOIN btytercero t ON t.trcdocumento=a.estilista
						JOIN btycolaborador c ON c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo
						JOIN btycargo cg ON cg.crgcodigo=c.crgcodigo
						JOIN btysalon s ON s.slnadmi=a.salon
						WHERE a.estado='A' AND a.fecha BETWEEN '$fd' and '$fh' AND a.td='FS' AND c.clbcodigo in ($col)
						GROUP BY a.estilista)
						AS b ORDER BY b.nomesti";
				mysqli_set_charset($conn,'UTF8');
				$res=$conn->query($sql);
				if($res->num_rows>0){
					while($row=$res->fetch_array()){
						$array[]=array('info'=>1,'col'=>$row['nomesti'].' ['.$row['crgnombre'].']','tsrv'=>$row['cserv'],'tfact'=>number_format($row['bliq']));
					}
				}else{
					$array[]=array('info'=>null);
				}
				echo json_encode($array);
			break;
			case 'xsln':
				if($selitem!=''){
					$sl=implode(',',$selitem);
					$wrsln=" and s.slncodigo in ($sl)";
					if($ts=='tpo'){
						$slnom=" concat('S. Tipo ',s.slntipo) as slnnombre";
						$wrsln2=" and s2.slntipo=s.slntipo";
						$groupby=" group by s.slntipo";
					}else{
						$slnom=" s.slnnombre";
						$wrsln2=" and s2.slncodigo = s.slncodigo";
						$groupby=" group by s.slnnombre";
					}
				}
				$sql="SELECT ".$slnom.", SUM(a.efectivo) AS efectivo, SUM(a.valortare) AS tarjeta, SUM(a.otrospagos) AS otrosp, SUM(a.valor) AS total,
						(SELECT COUNT(*)
						FROM btyfromadmi f
						JOIN btysalon s2 ON s2.slnadmi=f.salon
						WHERE f.estado='A' AND f.linea='01' AND f.fecha BETWEEN '$fd' AND '$fh' AND f.td='FS' ".$wrsln2.") AS csc 
					FROM btyfromadmi2 a
					JOIN btysalon s ON s.slnadmi=a.centro
					WHERE a.fecha BETWEEN '$fd' AND '$fh' AND a.td IN ('fs')".$wrsln.$groupby;
					//echo $sql;
				$res=$conn->query($sql);
				if($res->num_rows>0){
					while($row=$res->fetch_array()){
						$array[]=array('info'=>1,'tvta'=>number_format($row['total']),'tefc'=>number_format($row['efectivo']),'ttrj'=>number_format($row['tarjeta']),'totr'=>number_format($row['otrosp']),'tsrv'=>$row['csc'],'sln'=>$row['slnnombre']);
					}
				}else{
					$array[]=array('info'=>null);
				}
				echo json_encode($array);
			break;
			case 'xsrv':

			break;
		}
	break;
	case 'loadpro':
		$txt=utf8_decode($_POST['txt']);
		$sql="SELECT a.referencia, a.descripcio FROM btyfromadmi a
				WHERE a.linea='02' AND a.descripcio LIKE '%".$txt."%' GROUP BY a.referencia ORDER BY a.descripcio";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['referencia'], 'nom'=>utf8_encode($row['descripcio'])));
		}
		echo json_encode($array);
	break;
	//start admi filters
	case 'loadlinea':
		$sql="SELECT alcod,alnom FROM btyadmi_linea";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['alcod'], 'nom'=>utf8_encode($row['alnom'])));
		}
		echo json_encode($array);
	break;
	case 'loadgru':
		$sql="SELECT agcod,agnombre FROM btyadmi_grupo";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['agcod'], 'nom'=>utf8_encode($row['agnombre'])));
		}
		echo json_encode($array);
	break;
	case 'loadsubgru':
		$sql="SELECT asgcod,asgnom FROM btyadmi_subgrupo";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['asgcod'], 'nom'=>utf8_encode($row['asgnom'])));
		}
		echo json_encode($array);
	break;
	case 'loadcara':
		$sql="SELECT accod,acnom FROM btyadmi_cara";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['accod'], 'nom'=>utf8_encode($row['acnom'])));
		}
		echo json_encode($array);
	break;
	//end admi filter
	//start admi proccess
	//start admi proccess
}
?>