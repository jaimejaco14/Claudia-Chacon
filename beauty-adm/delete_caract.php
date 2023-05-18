<?php
include '../cnx_data.php';
if ($codigo = $_POST['id_tipo']){
    $sql = "UPDATE `btycaracteristica` SET `crsestado`= 0 WHERE crscodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
             
                echo "TRUE";

                } else {

                    echo "Error updating record: ".$conn->error;
                    
                    }

                $conn->close();
}