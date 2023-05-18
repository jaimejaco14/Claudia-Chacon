<?php
include '../cnx_data.php';
if ($_POST['nombre'] != "") {
	$nombre = $_POST['nombre'];
	$alias = $_POST['alias'];
	$desc = $_POST['desc'];
	$sbg = $_POST['Subgrupo'];
	$max = "SELECT MAX(lincodigo) as m FROM `btylinea`";
	$result = $conn->query($max);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$codigo = $row['m'] + 1;
		}
	} else {
		$codigo = 1;
	}
	if ( "" != $_FILES['Imagen']['name']){
		$ruta = "imagenes/linea/";
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
$sql = "INSERT INTO `btylinea`(`lincodigo`, `sbgcodigo`, `linnombre`, `linalias`, `lindescripcion`, `linimagen`, `linestado`) VALUES ($codigo, $sbg, '$nombre', '$alias', '$desc','$img_name',1)";
if ($conn->query($sql)) {
	echo "TRUE";
}
}