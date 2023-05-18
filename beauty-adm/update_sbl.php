<?php
include '../cnx_data.php';
if ($_POST['cod'] != "") {
	$codigo = $_POST['cod'];
	$nombre = $_POST['upnombre'];
	$alias = $_POST['upalias'];
	$desc = $_POST['updesc'];
        $lin = $_POST['sblcodigo'];
	if ( "" != $_FILES['upImagen']['name']){
		$ruta = "imagenes/sublinea/";
        $img_name = $_FILES['upImagen']['name'];
        $archivo = $_FILES['upImagen']['tmp_name']; 
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        //rename($archivo, $ruta.$new_name.".".$extension);
        //$ruta = "images/galeria_servicios";
        move_uploaded_file($archivo,$ruta.$codigo.".".$extension);
        $img_name = $codigo.".".$extension;
        $sql = "UPDATE `btysublinea` SET `lincodigo`=$lin,`sblnombre`='$nombre',`sblalias`='$alias',`sbldescripcion`='$desc',`sblimagen`='$img_name' WHERE   sblcodigo = $codigo";
} else {
	$sql = "UPDATE `btysublinea` SET `lincodigo`=$lin,`sblnombre`='$nombre',`sblalias`='$alias',`sbldescripcion`='$desc' WHERE   sblcodigo = $codigo";
}
if ($conn->query($sql)) {
	echo "TRUE";
}
}