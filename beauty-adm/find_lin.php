<?php
include '../cnx_data.php';
if ($_POST['linea_name'] != ""){
    $name = $_POST['linea_name'];
    if ($_POST['sbg_codigo'] != "") {
        $cod = $_POST['sbg_codigo'];
        $sql = "SELECT `lincodigo`, `linnombre` FROM `btylinea` where linnombre like '%".$name."%' and sbgcodigo = $cod";  
    } else {
        $sql = "SELECT `lincodigo`, `linnombre` FROM `btylinea` where linnombre like '%".$name."%'";
    }  
}
echo $sql;
$result = $conn->query($sql);
    if ($result->num_rows > 0) {
     	while ($row = $result->fetch_assoc()) {
        	echo "<option value='".$row['lincodigo']."' >".$row['linnombre']."</option>";
    	}
    } else {
    	echo "<option value=''>No hay resultados</option>";
    }