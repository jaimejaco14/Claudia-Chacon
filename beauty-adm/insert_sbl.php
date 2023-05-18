<?php
include '../cnx_data.php';
if ($_POST['nombre'] != "") {
	$nombre = $_POST['nombre'];
	$alias = $_POST['alias'];
	$desc = $_POST['desc'];
	$lin = $_POST['Linea'];
	$max = "SELECT MAX(sblcodigo) as m FROM `btysublinea`";
	$result = $conn->query($max);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$codigo = $row['m'] + 1;
		}
	} else {
		$codigo = 1;
	}
	if ( "" != $_FILES['Imagen']['name']){
		$ruta = "imagenes/sublinea/";
        $img_name = $_FILES['Imagen']['name'];
        $archivo = $_FILES['Imagen']['tmp_name']; 
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        //rename($archivo, $ruta.$new_name.".".$extension);
        //$ruta = "images/galeria_servicios";
        move_uploaded_file($archivo,$ruta.$codigo.".".$extension);
        $img_name = $codigo.".".$extension;
} else {
	$img_name = "default.jpg";
}
$sql = "INSERT INTO `btysublinea`(`sblcodigo`, `lincodigo`, `sblnombre`, `sblalias`, `sbldescripcion`, `sblimagen`, `sblestado`) VALUES ($codigo, $lin, '$nombre', '$alias', '$desc','$img_name',1)";	
if ($conn->query($sql)) {
	echo "TRUE";
}
}