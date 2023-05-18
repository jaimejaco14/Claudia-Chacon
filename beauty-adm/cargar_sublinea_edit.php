<?php 
	include '../cnx_data.php';

	$car = $_POST['car'];
	$html="";
	$sql = mysqli_query($conn, "SELECT crscodigo, sblcodigo, crsnombre FROM btycaracteristica WHERE sblcodigo = $car ");

	if (mysqli_num_rows($sql) > 0) {
		$html.='
			<option value="0" selected>Seleccione Característica</option>
        ';
		while ($row = mysqli_fetch_array($sql)) {
			$html.='
			     <option value="'.$row['crscodigo'].'">'.$row['crsnombre'].'</option>
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