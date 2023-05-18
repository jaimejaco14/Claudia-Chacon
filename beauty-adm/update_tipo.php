<?php
include '../cnx_data.php';
if ($_POST['cod'] != "") {
	$codigo = $_POST['cod'];
	$nombre = $_POST['upnombre'];
	$alias = $_POST['upalias'];
	$desc = $_POST['updesc'];
	if ( "" != $_FILES['upImagen']['name']){
		$ruta = "imagenes/tipo/";
        $img_name = $_FILES['upImagen']['name'];
        $archivo = $_FILES['upImagen']['tmp_name']; 
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        //rename($archivo, $ruta.$new_name.".".$extension);
        //$ruta = "images/galeria_servicios";
        move_uploaded_file($archivo,$ruta.$codigo.".".$extension);
        $img_name = $codigo.".".$extension;
        $sql = "UPDATE `btytipo` SET `tponombre`='$nombre',`tpoalias`='$alias',`tpodescripcion`='$desc',`tpoimagen`='$img_name' WHERE tpocodigo = $codigo";
} else {
	$sql = "UPDATE `btytipo` SET `tponombre`='$nombre',`tpoalias`='$alias',`tpodescripcion`='$desc' WHERE tpocodigo = $codigo";
}
if ($conn->query($sql)) {
	echo "TRUE";
}
}
