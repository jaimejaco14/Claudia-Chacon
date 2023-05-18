<?php 
	include '../cnx_data.php';

	$gru = $_POST['gru'];
	$html="";
	$sql = mysqli_query($conn, "SELECT sbgcodigo, grucodigo, sbgnombre FROM btysubgrupo WHERE grucodigo = $gru ");

	if (mysqli_num_rows($sql) > 0) {
		$html.='
			<option value="0" selected>Seleccione Subgrupo</option>
        ';
		while ($row = mysqli_fetch_array($sql)) {
			$html.='
			     <option value="'.$row['sbgcodigo'].'">'.$row['sbgnombre'].'</option>
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