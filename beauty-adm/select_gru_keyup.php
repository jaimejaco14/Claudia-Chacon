<?php
include "../cnx_data.php";
if ( "" != $_POST['sbl_cod']) {
	$cod_sbl = $_POST['sbl_cod'];
	$name = $_POST['sbl_name'];
	$sql = "select grucodigo, grunombre from btygrupo  where grunombre like '".$name."%' and sblestado = 1 and sblcodigo = $cod_sbl";
} else {

	$sql = "select sblcodigo, sblnombre from btysublinea  where sblnombre like '".$name."%' and sblestado = 1";

 }
 $result = $conn->query($sql);
    if ($result->num_rows > 0) {
     	while ($row = $result->fetch_assoc()) {
        	echo "<option value='".$row['sblcodigo']."' >".$row['sblnombre']."</option>";
    	}
    } else {
    	echo "<option value=''>No hay resultados</option>";
    }