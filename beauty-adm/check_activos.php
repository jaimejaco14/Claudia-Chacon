
<?php

include '../cnx_data.php';

$nom = $_POST["nombre"];
$sql = "SELECT actnombre FROM  btyactivo where actnombre = '$nom'";	
$result = $conn->query($sql);
if ($result->num_rows > 0) {
        echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este activo</font></div>';
}


