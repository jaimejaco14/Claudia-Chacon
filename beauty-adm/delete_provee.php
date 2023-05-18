<?php
include '../cnx_data.php';
if ($codigo = $_POST['id_prv']){
	echo' tiene'.$codigo;
    $sql = "UPDATE btyproveedor SET prvestado = 0 WHERE trcdocumento = $codigo";
    if ($conn->query($sql)) {
              //echo "Record updated successfully";
                echo "Proveedor eliminado";
                } else {
                    echo "Error updating record: " . $conn->error;
                    
                    }

                $conn->close();
}

?>