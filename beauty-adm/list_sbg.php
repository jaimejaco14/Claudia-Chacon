<?php
include '../cnx_data.php';
$gru = $_POST['cod'];
$sql = "select sbgnombre, sbgcodigo from btysubgrupo where sbgestado = 1 and grucodigo = $gru";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo "<option value='".$row['sbgcodigo']."'> ".$row['sbgnombre']."</option>";
    }
 } else {
 	echo "<option value=''>--No hay resultados--</option>";
 } 
?>