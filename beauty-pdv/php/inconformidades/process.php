<?php 
include '../../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'loadcli':
		$txt=utf8_decode($_POST['txt']);
		$sql="SELECT a.clicodigo, b.trcrazonsocial, b.trcdocumento FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo ".$join." WHERE b.trcrazonsocial like '%".$txt."%' or b.trcdocumento like '%".$txt."%'";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['clicodigo'], 'nom'=>utf8_encode($row['trcrazonsocial']), 'ced'=>$row['trcdocumento']));
		}
		echo json_encode($array);
	break;
	case 'loadcol':
		$txt=utf8_decode($_POST['txt']);
		$sql="SELECT c.clbcodigo, t.trcrazonsocial, cg.crgnombre
				FROM btycolaborador c
				JOIN btytercero t ON t.trcdocumento=c.trcdocumento and t.tdicodigo=c.tdicodigo
				JOIN btycargo cg on cg.crgcodigo=c.crgcodigo
				WHERE t.trcrazonsocial like '%".$txt."%'";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['clbcodigo'], 'nom'=>utf8_encode($row['trcrazonsocial']), 'ced'=>$row['crgnombre']));
		}
		echo json_encode($array);
	break;
	case 'loadtinc':
		$sql="SELECT * FROM btyinconformidad_tipo WHERE intestado=1 order by intnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['intcodigo'], 'nom'=>$row['intnombre']));
		}
		echo json_encode($array);
	break;
	case 'saveinc':
		$cli=$_POST['cli'];
		$clb=$_POST['clb'];
		$tin=$_POST['tin'];
		$des=$_POST['des'];
		$sln=$_POST['sln'];
		$usu=$_POST['usu'];
		$max=mysqli_fetch_array(mysqli_query($conn,"SELECT ifnull(MAX(i.inccodigo)+1,1) FROM btyinconformidad i"));
		$sql="INSERT INTO btyinconformidad (inccodigo,slncodigo,clicodigo,clbcodigo,usucodigo,incdescripcion,incfecha) VALUES ($max[0],$sln,$cli,$clb,$usu,'$des',now())";
		$i=0;
		if($conn->query($sql)){
			foreach($tin as $ti){
				$conn->query("INSERT INTO btyinconformidad_tipo_reg (itrcodigo,inccodigo,intcodigo,itrestado) VALUES ((SELECT ifnull(MAX(it.itrcodigo)+1,1) FROM btyinconformidad_tipo_reg it),$max[0],$ti,0)");
				$i++;
			}
			if($i==count($tin)){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	break;
}
?>