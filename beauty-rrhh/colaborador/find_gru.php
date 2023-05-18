<?php
include '../../cnx_data.php';
if ($_POST['grupo_name'] != "") {
    $name = $_POST['grupo_name'];
	# code...
	$sql= "select grucodigo, grunombre from btygrupo  where grunombre like '%".$name."%' and tpocodigo = 2";
  
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // echo "<option value=''>--seleccione grupo--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['grucodigo']."' >".$row['grunombre']."----</option>";
        }
    } else {
        echo "<option value=''>No hay resultados</option>";
    }

} else {
}

