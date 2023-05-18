<?php
//include 'conexion.php';
if ($codigo = $_POST['codigos']){
    $sql = "UPDATE `btytipo_activo` SET `tiaestado`= 0 WHERE tiacodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
              //echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                    
                    }

                $conn->close();
}
