<?php
include '../cnx_data.php';
$cod 		= $_POST['cod'];
$nombre 	= $_POST['name'];
$sln 		= $_POST['sln'];
$tipo 		= $_POST['tipo'];
$ubica 		= $_POST['Ubicacion'];
$planta 	= $_POST['planta'];
$chk_mult 	= $_POST['chk_mult'];

if ($chk_mult =="") {
	$chk_mult = 0;
}

//UPDATE PUESTO
if ($cod != "") {
	if ("" != $_FILES['up_imagen']['name']){
		$ruta = "../contenidos/imagenes/puesto_trabajo/";
		$img_name = $_FILES['up_imagen']['name'];
		$archivo = $_FILES['up_imagen']['tmp_name']; 
		$partes_nombre = explode('.', $img_name);
		$extension = end( $partes_nombre );
		move_uploaded_file($archivo,$ruta.$cod.".".$extension);
		$i_nom = ($cod).".".$extension;
		$sql = "UPDATE `btypuesto_trabajo` SET `tptcodigo`='$tipo',`ptrnombre`='$nombre',`ptrubicacion`='$ubica',`slncodigo`='$sln', ptrimagen = '$i_nom', `ptrplanta`='$planta', ptrmultiple = $chk_mult WHERE ptrcodigo = $cod";
		if ($conn->query($sql)) {
			echo "TRUE";
		} else {	
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}else{
		if ($_FILES['up_imagen']['name'] == "") {
			$sql = "UPDATE `btypuesto_trabajo` SET `tptcodigo`='$tipo',`ptrnombre`='$nombre',`ptrubicacion`='$ubica',`slncodigo`='$sln', `ptrplanta`='$planta', ptrmultiple = $chk_mult WHERE ptrcodigo = $cod";
			if ($conn->query($sql)) {
				echo "TRUE";
			} else {	
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}

	}




	//INSERT PUESTO
} else if ($nombre != ""){
			$sqlmax = "SELECT MAX(ptrcodigo) m FROM btypuesto_trabajo";
			$result = $conn->query($sqlmax);
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					# code...
					if ($row['m'] == NULL) {
						$cod = 0;
					} else {
						$cod = $row['m'];
					}		
				}
			} 
			$cod = $cod + 1;
			if ("" != $_FILES['imagen']['name']){
				$ruta = "../contenidos/imagenes/puesto_trabajo/";
				$img_name = $_FILES['imagen']['name'];
				$archivo = $_FILES['imagen']['tmp_name']; 
				$partes_nombre = explode('.', $img_name);
				$extension = end( $partes_nombre );
				move_uploaded_file($archivo,$ruta.$cod.".".$extension);
				$i_nom = ($cod).".".$extension;
			} else {
				$i_nom = "default.jpg";
			}

			if ($chk_mult <> 1) {
				$chk_mult = 0;
			}
			$sql = "INSERT INTO `btypuesto_trabajo` (`ptrcodigo`, `tptcodigo`, `ptrnombre`, `ptrubicacion`, `slncodigo`, ptrimagen, ptrplanta, ptrmultiple, `ptrestado`) VALUES ($cod,'$tipo','$nombre','$ubica', $sln, '$i_nom', '$planta', $chk_mult, 1)";
			if ($conn->query($sql)) {
				echo "TRUE";
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
}