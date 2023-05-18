<?php
include "../cnx_data.php";
if ($_POST['salon'] != "") {
   $sln = $_POST['salon'];
}
if ($_POST['horario']) {
    $horario = $_POST['horario'];
}


$sql = "SELECT ts.trncodigo, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(t.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i')) AS turno FROM btyturno_salon as ts, btyturno as t WHERE  t.trncodigo=ts.trncodigo AND ts.slncodigo = $sln AND ts.horcodigo = $horario AND t.trnestado = 1 ORDER BY turno";



//print_r($_POST);
//echo $sql;

$result = $conn->query($sql);
if ($result->num_rows > 0) 	{
	echo"<option value=''>Seleccione Turno</option>";
	while ($row = $result->fetch_assoc()) {
		# code...
		echo "<option value='".$row['trncodigo']."'>".$row['turno']." </option>";
	}
}/* else {
	echo"<option value=''>--No hay resultados--</option>";
}*/