<?php
include '../cnx_data.php';
if ($codigo = $_POST['id_tipo']){
    $sql = "UPDATE `btysublinea` SET `sblestado`= 0 WHERE sblcodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
             
                echo "TRUE";

                } else {

                    echo "Error updating record: ".$conn->error;
                    
                    }

                $conn->close();
}