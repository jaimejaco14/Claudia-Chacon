<?php
include '../cnx_data.php';
$sbg = $_POST['cod'];
$sql = "select linnombre, lincodigo from btylinea where linestado = 1 and sbgcodigo = $sbg";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo "<option value='".$row['lincodigo']."'> ".$row['linnombre']."</option>";
    }
 } else {
 	echo "<option value=''>--No hay resultados--</option>";
 } 
?>