<?php 
	include '../cnx_data.php';

	$sql = mysqli_query($conn, "SELECT slncodigo, slnnombre, slnalias, slndireccion FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");
	echo "<option value='' selected>Seleccione Salón</option>";
	while ($row = mysqli_fetch_array($sql)) {
		echo "<option value=' ".$row['slncodigo']." '>". $row['slnnombre'] ." </option>";
	}

	//mysqli_close($conn);
 ?>