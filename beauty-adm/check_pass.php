<?php
include '../cnx_data.php';
$documento = $_POST["nombre"];

//$sql = "SELECT brrnombre FROM btybarrio";
if($documento != NULL) {

$sql = "SELECT usulogin, usuclave FROM btyusuario where usulogin= '$documento'";  //and usuclave = sha1($user_password);
/* @var $result type */
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
} else {
    
        echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Usuario no existe</font></div>';
    //echo '<div id="Success">Well</div>';
}
$conn->close();
}
$user = $_POST["username"];
if($user != NULL){//$sql = "SELECT brrnombre FROM btybarrio";
    
}