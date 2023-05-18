<?php 
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'gentb':
		$sql="SELECT CONCAT(a.canombre,' ',a.caapellido) AS nomcli, s.slnnombre AS salon, DATE_FORMAT(c.carfecha,'%Y-%m-%d') AS fecha,  DATE_FORMAT(c.carfecha,'%H:%i') AS hora FROM btyclienteApp_redencion c
			JOIN btyclienteApp a ON a.cacodigo=c.cacodigo
			JOIN btysalon s ON s.slncodigo=c.carsalon
			ORDER BY fecha DESC, hora desc";
		mysqli_set_charset($conn,'UTF8');
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