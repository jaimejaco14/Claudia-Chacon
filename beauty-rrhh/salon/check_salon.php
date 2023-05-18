<?php
include '../../cnx_data.php';
$sernombre = $_POST["nombre"];

//$sql = "SELECT brrnombre FROM btybarrio";
if($sernombre != NULL) {

$sql = "SELECT slnnombre FROM btysalon where slnnombre = '$sernombre'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      
    }
      echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este salon </font></div>';
} else {
}
$conn->close();
}
$user = $_POST["username"];
if($user != NULL){//$sql = "SELECT brrnombre FROM btybarrio";
    
}

