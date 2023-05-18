<?php 

	include("../../../cnx_data.php");

	if (isset($_POST['cod'])) {
		$codColaborador = $_POST['cod'];
	}else{
		$codColaborador ="";
	}

	$nombreServicio = $_POST["servicio"];


		$sql = "SELECT servicio.sercodigo, servicio.sernombre, servicio.seralias, servicio.serduracion, servicio.serpreciofijo, caracteristica.crscodigo, caracteristica.crsnombre, colaborador.clbcodigo, tercero.trcrazonsocial, colaborador.cblimagen, cargo.crgnombre FROM btyservicio_colaborador INNER JOIN btycolaborador colaborador ON btyservicio_colaborador.clbcodigo = colaborador.clbcodigo INNER JOIN btytercero tercero ON colaborador.trcdocumento = tercero.trcdocumento INNER JOIN btyservicio servicio ON btyservicio_colaborador.sercodigo = servicio.sercodigo INNER JOIN btycaracteristica caracteristica ON servicio.crscodigo = caracteristica.crscodigo JOIN btycargo cargo ON colaborador.crgcodigo=cargo.crgcodigo WHERE servicio.sernombre LIKE '%$nombreServicio%' AND colaborador.clbcodigo = $codColaborador AND servicio.serstado = 1";

	$query_num_col = $sql;
 
	$result = $conn->query($query_num_col);
	$num_total_registros = $result->num_rows;

	$rowsPerPage = 4;
	$pageNum = 1;

	if(isset($_POST['page'])) {
	   $pageNum = $_POST['page'];
	}

  
	$offset = ($pageNum - 1) * $rowsPerPage;
	$total_paginas = ceil($num_total_registros / $rowsPerPage);
	$sql = $sql." limit $offset, $rowsPerPage";
	$result = $conn->query($sql);

?>




<?php include "../paginate.php";?>


