<?php 
include("../../../cnx_data.php");
$opc=$_POST['opc'];
switch($opc){
	case 'listimg':
		//mysql_query("SET NAMES 'utf8'", $conn);
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT imgcodigo,imgnomarchivo,imgdescripcion,imgestado FROM btyimg_pantalla ORDER BY imgestado DESC, imgnomarchivo";
		$res=$conn->query($sql);
		$array = array();
		if($res->num_rows>0){
			while($data = mysqli_fetch_assoc($res)){
				$array['data'][] = $data;
			}
		}else{
			$array=array('data'=>'');
		}
		echo json_encode($array);
	break;
	case 'uplimg':
		$path=$_SERVER['DOCUMENT_ROOT'] .'/beauty/externo/screen/contenidos/';
		$fileName = utf8_decode($_FILES['fileUpload']['name']);
		$desc=utf8_decode($_POST['descripimg']);
		$sourcePath = $_FILES['fileUpload']['tmp_name'];
        $targetPath = $path.$fileName;
        $sqlsk="SELECT COUNT(*) FROM btyimg_pantalla WHERE imgnomarchivo='$filename'";
        $res=mysqli_fetch_array(mysqli_query($conn,$sqlsk));
        if($res[0]==0){
	        if(move_uploaded_file($sourcePath,$targetPath)){
	            $sql="INSERT INTO btyimg_pantalla (imgnomarchivo,imgdescripcion,imgestado) VALUES ('$fileName','$desc',1)";
	            if($conn->query($sql)){
	            	echo 1;
	            }else{
	            	echo 2;
	            }
	        }else{
	        	echo 0;
	        }
        }else{
        	echo 3;
        }
		//$sql="";
	break;
	case 'delimg':
		$cod=$_POST['cod'];
		$sql="UPDATE btyimg_pantalla SET imgestado=0 WHERE imgcodigo=$cod";
		if($conn->query($sql)){
			$sql="DELETE FROM btyimg_pantalla_salon WHERE imgcodigo=$cod";
			if($conn->query($sql)){
				echo 1;
			}
		}else{
			echo 0;
		}
	break;
	case 'react':
		$cod=$_POST['cod'];
		$sql="UPDATE btyimg_pantalla SET imgestado=1 WHERE imgcodigo=$cod";
		if($conn->query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'loadsalon':
		$sql="SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado=1 ORDER BY slnnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['slncodigo'], 'nom'=>$row['slnnombre']);
		}
		echo json_encode($array);
	break;
	case 'assign':
		if($_POST['sln']==''){
			$sqlsln="SELECT slncodigo FROM btysalon WHERE slnestado=1";
			$rsln=$conn->query($sqlsln);
			while($rowsln=$rsln->fetch_array()){
				$sln[]=$rowsln[0];
			}
		}else{
			$sln=$_POST['sln'];
		}
		$desde=$_POST['desde'];
		$hasta=$_POST['hasta'];
		$img=$_POST['img'];
		$c=0;
		foreach ($sln as $salon) {
			$sql="INSERT INTO btyimg_pantalla_salon (slncodigo,imgcodigo,ipsdesde,ipshasta) VALUES ($salon,$img,'$desde','$hasta')";
			if($conn->query($sql)){
				$c++;
			}else{
				$sql="UPDATE btyimg_pantalla_salon SET ipsdesde='$desde', ipshasta='$hasta' WHERE slncodigo=$salon AND imgcodigo=$img";
				if($conn->query($sql)){$c++;}
			}
		}
		if($c==count($sln)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'listsln':
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT s.slncodigo, s.slnnombre, SUM(IF (ips.slncodigo IS NULL,0,1)) AS cant
				FROM btysalon s
				LEFT JOIN btyimg_pantalla_salon ips ON s.slncodigo=ips.slncodigo
				LEFT JOIN btyimg_pantalla i ON i.imgcodigo=ips.imgcodigo
				WHERE s.slnestado=1
				GROUP BY s.slncodigo
				ORDER BY s.slnnombre";
		$res=$conn->query($sql);
		$array = array();
		if($res->num_rows>0){
			while($data = mysqli_fetch_assoc($res)){
				$array['data'][] = $data;
			}
		}else{
			$array=array('data'=>'');
		}
		echo json_encode($array);
	break;
	case 'imgsln':
		$sln=$_POST['sln'];
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT ip.imgcodigo,ip.imgnomarchivo,ip.imgdescripcion, ips.ipsdesde,ips.ipshasta, IF(ips.slncodigo=$sln,1,0) as estado
				FROM btyimg_pantalla ip
				LEFT JOIN btyimg_pantalla_salon ips ON ips.imgcodigo=ip.imgcodigo AND ips.slncodigo=$sln
				WHERE ip.imgestado=1";
		$res=$conn->query($sql);
		$array = array();
		if($res->num_rows>0){
			while($data = mysqli_fetch_assoc($res)){
				$array['data'][] = $data;
			}
		}else{
			$array=array('data'=>'');
		}
		echo json_encode($array);
	break;
	case 'delimgsln';
		$sln=$_POST['slncod'];
		$img=$_POST['imgcod'];
		$sql="DELETE FROM btyimg_pantalla_salon WHERE slncodigo=$sln AND imgcodigo=$img";
		if($conn->query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'seekimg':
		mysqli_set_charset($conn,"utf8");
		$txt=($_POST['txt']);
		$sln=$_POST['sln'];
		$sql="SELECT p.imgcodigo, p.imgnomarchivo, ifnull(p.imgdescripcion,'Sin descripción') as imgdescripcion
				FROM btyimg_pantalla p
				WHERE p.imgestado=1 ";
				//AND (p.imgnomarchivo LIKE '%".$txt."%' OR p.imgdescripcion LIKE '%".$txt."%')
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['imgcodigo'], 'nom'=>utf8_encode($row['imgnomarchivo']), 'des'=>$row['imgdescripcion']));
		}
		echo json_encode($array);
	break;
	case 'addimgsln':
		$img=$_POST['img'];
		$sln=$_POST['sln'];
		$desde=$_POST['desde'];
		if($_POST['hasta']==''){
			$hasta='2099-12-31';
		}else{
			$hasta=$_POST['hasta'];
		}
		$sql="INSERT INTO btyimg_pantalla_salon (slncodigo,imgcodigo,ipsdesde,ipshasta) VALUES ($sln,$img,'$desde','$hasta')";
		if($conn->query($sql)){
			echo 1;
		}else{
			echo $sql;
		}
	break;
	case 'deleteold':
		$sln=$_POST['sln'];
		$sql="DELETE FROM btyimg_pantalla_salon WHERE ipshasta < curdate() and slncodigo=$sln";
		if($conn->query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'eventosyt':
		mysqli_set_charset($conn,"utf8");
		$sql="SELECT ipecodigo,ipenombre,ipedescrip,ipeenlace,TIME_FORMAT(ipehoraini, '%H:%i') as hini, TIME_FORMAT(ipehorafin, '%H:%i') as hfin, ipedefault, ipeestado FROM btyimg_pantalla_evento ORDER BY ipeestado DESC";
		$res=$conn->query($sql);
		$array = array();
		if($res->num_rows>0){
			while($data = mysqli_fetch_assoc($res)){
				$array['data'][] = $data;
			}
		}else{
			$array=array('data'=>'');
		}
		echo json_encode($array);
	break;
	case 'offevt':
		$evtcod=$_POST['evtcod'];
		$sql="UPDATE btyimg_pantalla_evento SET ipeestado=0 WHERE ipecodigo=$evtcod";
		if($conn->query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'onevt':
		$evtcod=$_POST['evtcod'];
		$sql="UPDATE btyimg_pantalla_evento SET ipeestado=IF(ipecodigo=$evtcod,1,0)";
		if($conn->query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'delevt':
		$evtcod=$_POST['evtcod'];
		$sql="DELETE FROM btyimg_pantalla_evento WHERE ipecodigo=$evtcod";
		if($conn->query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'saveevt':
		$evt=$_POST['evt'];
		$nom=$_POST['nom'];
		$des=$_POST['des'];
		$tpo=$_POST['tpo'];
		$link=$_POST['link'];
		$hini=$_POST['hini'];
		$hfin=$_POST['hfin'];
		if($evt==''){
			$sql="INSERT INTO btyimg_pantalla_evento (ipenombre,ipedescrip,ipeenlace,ipetipo,ipehoraini, ipehorafin, ipedefault, ipeestado) VALUES ('$nom','$des','$link','$tpo','$hini','$hfin',0,0)";
		}else{
			$sql="UPDATE btyimg_pantalla_evento SET ipenombre='$nom',ipedescrip='$des',ipeenlace='$link', ipetipo='$tpo',ipehoraini='$hini', ipehorafin='$hfin' WHERE ipecodigo=$evt";
		}
		mysqli_set_charset($conn,"utf8");
		if($conn->query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'loadedtevt':
		mysqli_set_charset($conn,"utf8");
		$evtcod=$_POST['evtcod'];
		$sql="SELECT ipecodigo,ipenombre,ipedescrip,ipeenlace,TIME_FORMAT(ipehoraini, '%H:%i') as hini, TIME_FORMAT(ipehorafin, '%H:%i') as hfin, ipedefault, ipeestado, ipetipo FROM btyimg_pantalla_evento WHERE ipecodigo=$evtcod";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$row=$res->fetch_array();
		}else{
			$row=null;
		}
		echo json_encode(array('info'=>$row));
	break;
}
?>
