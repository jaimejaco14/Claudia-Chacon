<?php 
	include("../../../cnx_data.php");

	$sql = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon")or die(mysqli_error($conn));
	$html='';

	while ($row = mysqli_fetch_array($sql)) {
		$html.='
			<option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>			
		';
	}

	echo $html;

	mysqli_close($conn);
 ?>