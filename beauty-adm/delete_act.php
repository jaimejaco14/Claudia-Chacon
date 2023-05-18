<?php
//include 'conexion.php';
if ($codigo = $_POST['id_act']){
    $sql = "UPDATE `btyactivo` SET `actestado`= 0 WHERE actcodigo = '$codigo'";
    if ($conn->query($sql)) {
             
                echo "true";

                } else {

                    echo "Error updating record: ".$conn->error;
                    
                    }

               
}
