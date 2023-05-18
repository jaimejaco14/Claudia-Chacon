<?php 
	include '../../cnx_data.php';

	$html="";
	$sql = mysqli_query($conn, "SELECT * FROM btysalon");

	$html.='<option value="0" selected>Seleccione Salón</option>';
	while ($row = mysqli_fetch_array($sql)) {
		$html.='
			<option value="'.$row['slncodigo'].'"> '.utf8_decode($row['slnnombre']).' </option>
		';
	}

	echo $html;

	//mysqli_close($conn);
 ?>