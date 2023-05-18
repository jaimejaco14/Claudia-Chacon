<?php
include '../cnx_data.php';
if ($codigo = $_POST['id_puesto']){
    $sql = "UPDATE `btypuesto_trabajo` SET `ptrestado`= 0 WHERE ptrcodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
              //echo "Record updated successfully";
                echo "puesto eliminado";
                } else {
                    echo "Error updating record: " . $conn->error;
                    
                    }

                $conn->close();
}