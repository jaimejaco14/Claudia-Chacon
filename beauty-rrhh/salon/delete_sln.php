<?php
include '../../cnx_data.php';
if ($codigo = $_POST['id_sln']){
    $sql = "UPDATE `btysalon` SET `slnestado`= 0 WHERE slncodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
              //echo "Record updated successfully";
                echo "Salon eliminado";
                } else {
                    echo "Error updating record: " . $conn->error;
                    
                    }

                $conn->close();
}
