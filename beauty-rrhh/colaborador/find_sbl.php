<?php
include '../../cnx_data.php';
if ($_POST['sbl_name'] != ""){
    $name = $_POST['sbl_name'];
    if ($_POST['lin_codigo'] != "") {
        $cod = $_POST['lin_codigo'];
        $sql = "SELECT `sblcodigo`, `sblnombre` FROM `btysublinea` where sblnombre like '%".$name."%' and lincodigo = $cod";  
    } else {
        $sql = "SELECT `sblcodigo`, `sblnombre` FROM `btysublinea` where sblnombre like '%".$name."%'";
    }  
}
$result = $conn->query($sql);
    if ($result->num_rows > 0) {
     	while ($row = $result->fetch_assoc()) {
        	echo "<option value='".$row['sblcodigo']."' >".$row['sblnombre']."</option>";
    	}
    } else {
    	echo "<option value=''>No hay resultados</option>";
    }