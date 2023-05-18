<?php
include '../cnx_data.php';
$tipo = $_POST['cod'];
$sql = "select grunombre, grucodigo from btygrupo where gruestado = 1 and tpocodigo = $tipo";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo "<option value='".$row['grucodigo']."'> ".$row['grunombre']."</option>";
    }
 } else {
 	echo "<option value=''>--No hay resultados--</option>";
 } 
?>