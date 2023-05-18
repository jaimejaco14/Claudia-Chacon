<?php
include "../cnx_data.php";
if ( "" != $_POST['lin_name']) {
	$cod_lin = $_POST['lin_name'];
	$name = $_POST['sbl_name'];
	$sql = "select sblcodigo, sblnombre from btysublinea  where sblnombre like '".$name."%' and sblestado = 1 and lincodigo = $cod_lin";
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