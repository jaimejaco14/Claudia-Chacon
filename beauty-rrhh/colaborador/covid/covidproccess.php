<?php 
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include"../../../cnx_data.php";

$opc=$_POST['opc'];
switch ($opc) {
	case 'loadcol':
		$txt=utf8_decode($_POST['txt']);
		$sql="SELECT c.clbcodigo,t.trcrazonsocial from  btycolaborador c
	    	join btytercero t on t.trcdocumento=c.trcdocumento where t.trcrazonsocial like '%".$txt."%' AND bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO'
	    	order by trcrazonsocial";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['clbcodigo'], 'nom'=>utf8_encode($row['trcrazonsocial'])));
		}
		echo json_encode($array);
	break;
	case 'search':
		$co = $_POST['co'];
		$fe = $_POST['fe'];
		$sql="SELECT p.cptxt as pre, if(if(p.cpsn=1,d.cpres+1,d.cpres)=1,'SI','NO') AS res
				FROM covid_encuesta e
				JOIN btycolaborador c ON c.trcdocumento=e.idnum
				JOIN covid_encuesta_detalle d ON d.cecod=e.cecod
				JOIN covid_pregunta p ON p.cpcod=d.cpcod
				WHERE e.cetipo='CO' AND e.ceinout='E' AND DATE(e.cefeho)='$fe' AND c.clbcodigo=$co";
		mysqli_set_charset($conn,'UTF8');				
		$res=$conn->query($sql);
		if($res->num_rows>0){
			while($row=$res->fetch_array()){
				$entrada[]=array('pre'=>$row['pre'],'res'=>$row['res']);
			}
		}else{
			$entrada[]=array('pre'=>0);
		}
		$sql2="SELECT p.cptxt as pre, if(if(p.cpsn=1,d.cpres+1,d.cpres)=1,'SI','NO') AS res
				FROM covid_encuesta e
				JOIN btycolaborador c ON c.trcdocumento=e.idnum
				JOIN covid_encuesta_detalle d ON d.cecod=e.cecod
				JOIN covid_pregunta p ON p.cpcod=d.cpcod
				WHERE e.cetipo='CO' AND e.ceinout='S' AND DATE(e.cefeho)='$fe' AND c.clbcodigo=$co";
		$res2=$conn->query($sql2);
		if($res2->num_rows>0){
			while($row2=$res2->fetch_array()){
				$salida[]=array('pre'=>$row2['pre'],'res'=>$row2['res']);
			}
		}else{
			$salida[]=array('pre'=>0);
		}
		echo json_encode(array('in'=>$entrada,'out'=>$salida));
	break;
	case 'loadsln':
		$sql="SELECT s.slncodigo AS cod, s.slnnombre AS nom FROM btysalon s WHERE s.slnextestado=1";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$sln[]=array('cod'=>$row['cod'],'nom'=>$row['nom']);
		}
		echo json_encode($sln);
	break;
	case 'sxsln':
		//$sln=$_POST['sln'];
		if($_POST['sln']=='T'){
			$sln=mysqli_fetch_array(mysqli_query($conn,"SELECT GROUP_CONCAT(s.slncodigo) FROM btysalon s WHERE s.slnextestado=1"))[0];
		}else{
			$sln=$_POST['sln'];
		}
		$feh=$_POST['feh'];
		$sql="SELECT concat(t.trcrazonsocial,' [',g.crgnombre, ']') AS col,
				IFNULL(colcovid_chk(t.trcdocumento,p.prgfecha,'E'),'NR') AS ent,
				IFNULL(colcovid_chk(t.trcdocumento,p.prgfecha,'S'),'NR') AS sal
				FROM btyprogramacion_colaboradores p
				JOIN btysalon s ON s.slncodigo=p.slncodigo
				JOIN btycolaborador c ON c.clbcodigo=p.clbcodigo
				JOIN btycargo g ON g.crgcodigo=c.crgcodigo
				JOIN btytercero t ON t.trcdocumento=c.trcdocumento AND t.tdicodigo=c.tdicodigo
				WHERE p.slncodigo in ($sln) AND p.prgfecha='$feh' AND p.tprcodigo IN (1,9)
				ORDER BY t.trcrazonsocial";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		/*while($row=$res->fetch_array()){
			$tb[]=array('col'=>$row['col'],'ent'=>$row['ent'],'sal'=>$row['sal']);
		}
		echo json_encode($tb);*/
		if(mysqli_num_rows($res) > 0){
            while($data = mysqli_fetch_assoc($res)){
                  $array['data'][] = $data;
            }                    
        }
        else{
              $array=array('data'=>'');
        }
        echo json_encode($array);
	break;
	case 'delenc':
		$col = $_POST['col'];
		$fe  = $_POST['fe'];
		if($fe==date("Y-m-d")){
			$sql="DELETE e FROM covid_encuesta e JOIN btycolaborador c ON c.trcdocumento=e.idnum
					WHERE c.clbcodigo=$col AND date(e.cefeho) = CURDATE()";
			if($conn->query($sql)){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 2;
		}
	break;
}
$conn->close();
?>