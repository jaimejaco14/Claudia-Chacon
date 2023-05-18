<?php 
	include '../cnx_data.php';

	$sql = mysqli_query($conn, "SELECT bodcodigo, bodnombre FROM btybodega WHERE bodestado = 1");
	$html='';
	$html.='
		 <option value="0" selected>Seleccione Bodega</option>
	';
	while ($row = mysqli_fetch_array($sql)) {
		$html.='
			<option value="'.$row['bodcodigo'].'">'.utf8_decode($row['bodnombre']).'</option>
		';
	}

	echo $html;


?>