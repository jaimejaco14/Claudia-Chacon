<?php 
	include '../cnx_data.php';

	$linea = $_POST['linea'];
	$html="";
	$sql = mysqli_query($conn, "SELECT sblcodigo, lincodigo, sblnombre FROM btysublinea WHERE lincodigo = $linea ");

	if (mysqli_num_rows($sql) > 0) {
		$html.='
			<option selected>Seleccione Sublínea</option>
        ';
		while ($row = mysqli_fetch_array($sql)) {
			$html.='
			     <option value="'.$row['sblcodigo'].'">'.$row['sblnombre'].'</option>
		    ';
		}
		 
	}else{
		$html.='
			<option> No hay registros disponibles </option>
		';
	}

	echo $html;

	//mysqli_close($conn);

 ?>