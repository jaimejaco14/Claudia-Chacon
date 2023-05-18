<?php
include '../cnx_data.php';
if ($codigo = $_POST['id_tipo']){
    $sql = "UPDATE `btygrupo` SET `gruestado`= 0 WHERE grucodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
             
                echo "TRUE";

                } else {

                    echo "Error updating record: ".$conn->error;
                    
                    }

                $conn->close();
}