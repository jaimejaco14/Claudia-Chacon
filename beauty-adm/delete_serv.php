<?php
include 'conexion.php';
if ($codigo = $_POST['id_servicio']){
    $sql = "UPDATE `btyservicio` SET `serstado`= 0 WHERE sercodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
              //echo "Record updated successfully";
                echo "Servicio eliminado";
                } else {
                    echo "Error updating record: " . $conn->error;
                    
                    }

                $conn->close();
}
