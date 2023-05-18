<?php
include '../cnx_data.php';
if ( "" != $_POST['tipo_name']) {
	$name = $_POST['tipo_name'];
	$sql = "select tpocodigo, tponombre from btytipo  where tponombre like '".$name."%' and tpoestado = 1";
} else {

	$sql = "select sblcodigo, sblnombre from btysublinea  where sblnombre like '".$name."%' and sblestado = 1";

 }
 $result = $conn->query($sql);
if ($result->num_rows > 0) {
 	while ($row = $result->fetch_assoc()) {
    	echo "<option value='".$row['tpocodigo']."' >".$row['tponombre']."</option>";
	}
} else {
	echo "<option value=''>No hay resultados</option>";
}