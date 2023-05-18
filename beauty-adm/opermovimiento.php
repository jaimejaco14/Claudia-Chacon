<?php 
/*session_start();
include 'conexion.php';
$opc=$_POST['opc'];*/
switch($opc){
	case 'selact':
		$txt=$_POST['key'];
		$sql="SELECT actcodigo,actnombre FROM btyactivo where actestado=1 order by actnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array("id"=>$row['actcodigo'], "name"=>utf8_encode($row['actnombre'])));
		} 
		echo json_encode($array);
	break;

	case 'selug2':
		$txt=$_POST['key'];
		$sql="SELECT lugcodigo,lugnombre FROM btyactivo_lugar where lugestado=1 AND lugcodigo <> 0 order by lugnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array("id"=>$row['lugcodigo'], "name"=>utf8_encode($row['lugnombre'])));
		} 
		echo json_encode($array);
	break;

	case 'selusu':
		$txt=$_POST['key'];
		$sql="SELECT u.usucodigo,t.trcrazonsocial from btyusuario u natural join btytercero t where u.usuestado=1 ORDER BY trcrazonsocial";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array("id"=>$row['usucodigo'], "name"=>utf8_encode($row['trcrazonsocial'])));
		} 
		echo json_encode($array);
	break;

	case 'selarea':
		$id=$_POST['id'];
		$sql="SELECT a.arecodigo,a.arenombre from btyactivo_area a where a.lugcodigo=$id AND  a.areestado=1 ORDER BY arenombre";
		$res=$conn->query($sql);
		if(mysqli_num_rows($res)>0){
			while($row=$res->fetch_array()){
				echo '<option value="'.$row['arecodigo'].'">'.$row['arenombre'].'</option>';
			} 
		}else{
			echo '<option value="">Este lugar NO tiene áreas creadas</option>';
		}
	break;

	case 'loadlugarea':
		$id=$_POST['id'];
		$sqlla="SELECT l.lugnombre,a.arenombre,m.arecodigo_nue
				FROM btyactivo_movimiento m
				join btyactivo_area a on a.arecodigo=m.arecodigo_nue
				join btyactivo_lugar l on l.lugcodigo=a.lugcodigo
				WHERE m.actcodigo=$id
				and m.mvaconsecutivo=(select max(ma.mvaconsecutivo) from btyactivo_movimiento ma where ma.actcodigo=$id and ma.mvaestado='EJECUTADO')";
		$resla=$conn->query($sqlla);
		$lugareact=$resla->fetch_array();
		$lugar=$lugareact[0];
		$area=$lugareact[1];
		$codarea=$lugareact[2];
		if($lugar==''){$lugar='LUGAR BASE';}
		if($area==''){$area='AREA BASE';$codarea=0;}	
		echo json_encode(array('lugar'=>$lugar , 'area'=>$area , 'codarea'=>$codarea));
	break;

	case 'registrar':
		$fechaeje=$_POST['fechaeje'];
		$horaeje=$_POST['horaeje'];
		$codact=$_POST['selact'];
		if($_POST['selar']){
			$areaant=$_POST['selar'];
		}else{
			$areaant=0;
		}
		$areanew=$_POST['selar2'];
		$desc=$_POST['descrip'];
		$usureg=$_SESSION['codigoUsuario'];
		$usueje=$_POST['selusu'];

		$sqlconf="SELECT COUNT(*) FROM btyactivo_movimiento where actcodigo=$codact and mvaestado='REGISTRADO'";
		$resconf=$conn->query($sqlconf);
		$conf=$resconf->fetch_array();
		if($conf[0] == 0){
			$selmax="SELECT if(MAX(c.mvaconsecutivo) is null,1,MAX(c.mvaconsecutivo)+1) FROM btyactivo_movimiento c";
			$resmax=$conn->query($selmax);
			$max=$resmax->fetch_array();

			$sql="INSERT INTO btyactivo_movimiento (mvaconsecutivo,mvafecharegistro,mvahoraregistro,mvafechaejecucion,mvahoraejecucion,actcodigo,arecodigo_ant,arecodigo_nue,mvadescripcion,usucodigo_registro,usucodigo_ejecuta,mvaestado) VALUES($max[0],curdate(),curtime(),'$fechaeje','$horaeje',$codact,$areaant,$areanew,'$desc',$usureg,$usueje,'REGISTRADO')";
			if($conn->query($sql)){
				$sql2="INSERT INTO btyactivo_ubicacion (actcodigo,arecodigo,ubcdesde,ubchasta,mvaconsecutivo) VALUES ($codact,$areanew,curdate(),null,$max[0])";
				if($conn->query($sql2)){
					echo 'true';
				}
			}else{
				echo $sql;
			}
		}else{
			echo 'open';
		}
	break;

	case 'exemov':
		$id=$_POST['idmov'];
		$idact=$_POST['idact'];
		$sql="UPDATE btyactivo_ubicacion 
					SET ubchasta=curdate() 
					where mvaconsecutivo=(select max(m.mvaconsecutivo) from btyactivo_movimiento m where m.mvaestado='EJECUTADO' and m.actcodigo=$idact)";
		if($conn->query($sql)){
			$sql2="UPDATE btyactivo_movimiento m
				SET m.mvaestado='EJECUTADO'
				WHERE m.mvaconsecutivo=$id";
			if($conn->query($sql2)){
				echo 'true';
			}
		}else{
			echo 'false';
		}
	break;

	case 'canmov':
		$id=$_POST['idmov'];
		$sql="UPDATE btyactivo_movimiento m
				SET m.mvaestado='CANCELADO'
				WHERE m.mvaconsecutivo=$id";
		if($conn->query($sql)){
			echo 'true';
		}else{
			echo 'false';
		}
	break;
}
?>