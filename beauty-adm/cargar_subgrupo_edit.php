<?php 
	include '../cnx_data.php';
	$subgru = $_POST['subgru'];
	$html="";
	$sql = mysqli_query($conn, "SELECT lincodigo, sbgcodigo, linnombre FROM btylinea WHERE sbgcodigo = $subgru ");

	if (mysqli_num_rows($sql) > 0) {
		$html.='
			     <option selected>Seleccione Línea</option>
		    ';
		while ($row = mysqli_fetch_array($sql)) {
			$html.='
			     <option value="'.$row['lincodigo'].'">'.$row['linnombre'].'</option>
		    ';
		}
		 
	}else{
		$html.='
			<option> No hay registros disponibles </option>
		';
	}

	echo $html;

	mysqli_close($conn);

 ?>