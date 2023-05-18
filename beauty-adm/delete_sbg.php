<?php
include '../cnx_data.php';
if ($codigo = $_POST['id_tipo']){
    $sql = "UPDATE `btysubgrupo` SET `sbgestado`= 0 WHERE sbgcodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
             
                echo "TRUE";

                } else {

                    echo "Error updating record: ".$conn->error;
                    
                    }

                $conn->close();
}