
<?php
//include '../cnx_data.php';
if ($codigo = $_POST['codigos']){
    $sql = "UPDATE `btymarca_activo` SET `marestado`= 0 WHERE marcodigo = '$codigo'";
    if ($conn->query($sql) === TRUE) {
              //echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                    
                    }

                $conn->close();
}




?>

