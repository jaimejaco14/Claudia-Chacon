<?php
include '../cnx_data.php';
if ($_POST['grupo'] != "") {
	$grupo = $_POST['grupo'];
	if ($grupo > 0) {
		$sql = "SELECT sbgcodigo codigo, sbgnombre nombre FROM btysubgrupo where grucodigo = $grupo AND sbgestado = 1 ORDER BY sbgnombre";
	} else {
		$sql = "SELECT sbgcodigo codigo, sbgnombre nombre FROM btysubgrupo where  sbgestado = 1 ORDER BY sbgnombre";
	}
} else if ($_POST['subgrupo'] != ""){
	$sbg = $_POST['subgrupo'];
	if ($sbg > 0) {
		$sql = "SELECT lincodigo codigo, linnombre nombre FROM btylinea where sbgcodigo = $sbg AND linestado = 1 ORDER BY linnombre";
	} else {
		$sql = "SELECT lincodigo codigo, linnombre nombre FROM btylinea where linestado = 1 ORDER BY linnombre";
	}
} else if ($_POST['linea'] != ""){
	$lin = $_POST['linea'];
	if ($lin > 0) {
		$sql = "SELECT sblcodigo codigo, sblnombre nombre FROM btysublinea where lincodigo = $lin AND sblestado = 1 ORDER BY sblnombre";
	} else {
		$sql = "SELECT sblcodigo codigo, sblnombre nombre FROM btysublinea where sblestado = 1 ORDER BY sblnombre";
	}
} else if ($_POST['sublinea'] != ""){
	$sbl = $_POST['sublinea'];
	if ($sbl > 0) {
		$sql = "SELECT crscodigo codigo, crsnombre nombre FROM btycaracteristica where sblcodigo = $sbl AND crsestado = 1 ORDER BY crsnombre";
	} else {
		$sql = "SELECT crscodigo codigo, crsnombre nombre FROM btycaracteristica where crsestado = 1 ORDER BY crsnombre";
	}
} 
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row['codigo'].'">'.utf8_encode($row['nombre']).'</option>';
    }
} else {
    echo "<option value=''>--no hay resultados--</option>";
}
$conn->close();