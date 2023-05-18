<?php
include 'conexion.php';
$nom = $_POST["marname"];
$sql = "SELECT marnombre FROM  btymarca_activo where marnombre = '$nom'";	
$result = $conn->query($sql);
if ($result->num_rows > 0) {
        echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este activo</font></div>';
}

