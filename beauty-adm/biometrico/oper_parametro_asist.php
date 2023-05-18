<?php
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	/*CREAR NUEVO PARAMETRO DE ASISTENCIA*/
	case "NEW":
		$enttemp=$_POST['enttemp'];
		$enttar=$_POST['enttar'];
		$saltem=$_POST['saltem'];
		$saltar=$_POST['saltar'];
		$sql="INSERT INTO btyasistencia_parametros (abmingresoantes,abmsalidadespues,abmingresodespues,abmsalidaantes) VALUES ($enttemp,$saltar,$enttar,$saltem)";
		if($conn->query($sql)){
			echo "TRUE";
		}
		else{
			echo "FALSE";
		}
	break;
	/*CARGA LOS DATOS ACTUALES EN EL MODAL EDITAR PARAMETRO DE ASISTENCIA*/
	case "BUS":
		$sql="SELECT * FROM btyasistencia_parametros";
		$res=$conn->query($sql);
		$row=$res->fetch_assoc();
		echo json_encode(array("enttemp"=>$row['abmingresoantes'],"enttar"=>$row['abmingresodespues'],"saltem"=>$row['abmsalidaantes'],"saltar"=>$row['abmsalidadespues']));
	break;
	/*GUARDA LOS CAMBIOS HECHOS EN EL MODAL EDITAR PARAMETRO DE ASISTENCIA*/
	case "EDIT":
		$enttemp=$_POST['enttemp2'];
		$enttar=$_POST['enttar2'];
		$saltem=$_POST['saltem2'];
		$saltar=$_POST['saltar2'];
		$sql="UPDATE btyasistencia_parametros SET abmingresoantes=$enttemp, abmsalidadespues=$saltar, abmingresodespues=$enttar, abmsalidaantes=$saltem";
		if($conn->query($sql)){
			echo "TRUE";
		}
		else{
			echo "FALSE";
		}
	break;
}
?>