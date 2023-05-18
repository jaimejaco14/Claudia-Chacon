<?php
//include 'conexion.php';
if ($codigo = $_POST['id_mar']){
    $sql = "UPDATE `btymarca_activo` SET `marestado`= 0 WHERE marcodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
             
                echo "Activo eliminado";

                } else {

                    echo "Error updating record: ".$conn->error;
                    
                    }

                $conn->close();
}
