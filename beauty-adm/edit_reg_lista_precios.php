<?php
//header( 'Content-Type: application/json' );
include '../cnx_data.php';

	$codigo = $_POST['codigo'];
	$html='';
    //$sql = "SELECT lprnombre, lprtipo, lprobservaciones FROM `btylista_precios` WHERE lprcodigo = '$codigo'";

    $sql = mysqli_query($conn, "SELECT lprcodigo, lprnombre, lprtipo, lprobservaciones FROM `btylista_precios` WHERE lprcodigo = '$codigo'");

        				
	$array = array();
	  while ($obj = mysqli_fetch_object($sql)) {
	     $array[] =  array('id'            => $obj->lprcodigo,
	                       'nombre'        => $obj->lprnombre,
	                       'tipo'          => $obj->lprtipo,
	                       'observaciones' => $obj->lprobservaciones,
	                 );
	 }

	echo json_encode($array);

?>