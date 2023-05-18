<?php
include '../cnx_data.php';
$salon 			 = 	$_POST['selectSalon'];
$puesto          =	$_POST['selectPuestoTrabajo'];
$colaborador     =	$_POST['selectColaborador'];
$tipo            =	$_POST['selectTipoProgramacion'];
$fecha           =	$_POST['fecha'];
$horario         =	$_POST['selectHorario'];
$turno           =	$_POST['selectTurno'];

//print_r($_POST);


$sql = mysqli_query($conn, "SELECT * FROM btyprogramacion_colaboradores WHERE clbcodigo = $colaborador AND prgfecha = '$fecha'");

if (mysqli_num_rows($sql) > 0) {
	
	echo "FALSEE";

}else{

	$r = mysqli_query($conn, "SELECT a.ptrcodigo as 'tipo', if(a.ptrmultiple = 0, 'no', 'si') as 'multiple' FROM btypuesto_trabajo a WHERE a.ptrcodigo =$puesto");

	$de = mysqli_fetch_array($r);

	if ($de['multiple'] == 'no') {

		$f = mysqli_query($conn, "SELECT a.ptrcodigo, a.prgfecha, a.tprcodigo FROM btyprogramacion_colaboradores a WHERE a.ptrcodigo= $puesto AND a.prgfecha = '$fecha' AND a.tprcodigo = $tipo");

		if (mysqli_num_rows($f) > 0) {

			echo "EXIST";
		}else{
			$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
			
				} else { 
					echo "FALSE";
				}
		}
		
	}else{

		$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
			
				} else { 
					echo "FALSE";
				}
	}

	


		/*$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
			
				} else { 
					echo "FALSE";
				}
		
			$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
				} else { 
					echo "FALSE";
				}*/
		
	

	/*if ($row['ptrmultiple'] == 0) {
		$sql3 = mysqli_query($conn, "SELECT * FROM btyprogramacion_colaboradores WHERE slncodigo = $salon AND ptrcodigo = $puesto AND prgfecha = CURDATE()");

		if (mysqli_num_rows($sql3) > 0) {
			
			$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
				} else { 
					echo "FALSE";
				}
		}else{
			$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
				} else { 
					echo "FALSE";
				}
		}
	}else{
		$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
				} else { 
					echo "FALSE";
				}
	}*/
}






	/*echo "NO ESTA EN LA BASE DE DATOS";

	$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
				} else { 
					echo "FALSE";
				}*/

	/*$sql = mysqli_query($conn, "SELECT ptrcodigo, ptrnombre, ptrmultiple FROM btypuesto_trabajo WHERE slncodigo = $salon AND ptrcodigo = $puesto");

	$row = mysqli_fetch_array($sql);

	if ($row['ptrmultiple'] == 1) {
		echo "ACEPTA MULTIPLE";
	}

	if (mysqli_num_rows($sql) > 0) {
		echo "NO ACEPTA MULTIPLE";
		$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
				} else { 
					echo "FALSE";
				}		
	}else{
		$sql = "INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES ($colaborador,$turno,$horario,$salon,$puesto,'$fecha',$tipo)";
				if ($conn->query($sql)) {
					echo "TRUE";
				} else { 
					echo "FALSE";
				}		
		
		
	}*/


?>