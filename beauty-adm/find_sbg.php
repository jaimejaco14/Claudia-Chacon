<?php
include '../cnx_data.php';
if ($_POST['subgrupo_name'] != ""){
    $name = $_POST['subgrupo_name'];
    if ($_POST['grupo_codigo'] != "") {
        $cod = $_POST['grupo_codigo'];
        $sql = "SELECT `sbgcodigo`, `sbgnombre` FROM `btysubgrupo` where sbgnombre like '%".$name."%' and grucodigo = $cod";  
    } else {
        $sql = "SELECT `sbgcodigo`, `sbgnombre` FROM `btysubgrupo` where sbgnombre like '%".$name."%'";
    }  
}
$result = $conn->query($sql);
    if ($result->num_rows > 0) {
     	while ($row = $result->fetch_assoc()) {
        	echo "<option value='".$row['sbgcodigo']."' >".$row['sbgnombre']."</option>";
    	}
    } else {
    	echo "<option value=''>No hay resultados</option>";
    }