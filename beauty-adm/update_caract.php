<?php
include '../cnx_data.php';
if ($_POST['cod'] != "") {
	$codigo = $_POST['cod'];
	$nombre = $_POST['upnombre'];
	$alias = $_POST['upalias'];
	$desc = $_POST['updesc'];
        $sbl = $_POST['sblcodigo'];
	if ( "" != $_FILES['upImagen']['name']){
		$ruta = "imagenes/caracteristica/";
        $img_name = $_FILES['upImagen']['name'];
        $archivo = $_FILES['upImagen']['tmp_name']; 
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        //rename($archivo, $ruta.$new_name.".".$extension);
        //$ruta = "images/galeria_servicios";
        move_uploaded_file($archivo,$ruta.$codigo.".".$extension);
        $img_name = $codigo.".".$extension;
        $sql = "UPDATE `btycaracteristica` SET `sblcodigo`=$sbl,`crsnombre`='$nombre',`crsalias`='$alias',`crsdescripcion`='$desc',`crsimagen`='$img_name' WHERE  crscodigo = $codigo";
} else {
	$sql = "UPDATE `btycaracteristica` SET `sblcodigo`=$sbl,`crsnombre`='$nombre',`crsalias`='$alias',`crsdescripcion`='$desc' WHERE  crscodigo = $codigo";
}
if ($conn->query($sql)) {
	echo "TRUE";
}
}