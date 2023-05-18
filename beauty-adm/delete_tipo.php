<?php
include '../cnx_data.php';
if ($codigo = $_POST['id_tipo']){
    $sql = "UPDATE `btytipo` SET `tpoestado`= 0 WHERE tpocodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
             
                echo "TRUE";

                } else {

                    echo "Error updating record: ".$conn->error;
                    
                    }

                $conn->close();
}