<?php
include '../cnx_data.php';
$lin = $_POST['cod'];
$sql = "select sblnombre, sblcodigo from btysublinea where sblestado = 1 and lincodigo = $lin";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo "<option value='".$row['sblcodigo']."'> ".$row['sblnombre']."</option>";
    }
 } else {
 	echo "<option value=''>--No hay resultados--</option>";
 } 
?>