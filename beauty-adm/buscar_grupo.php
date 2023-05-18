<?php
include '../cnx_data.php';
 $sublinea = $_POST['sublinea'];
 $p = $_POST['puntero'];
 //echo $p.'estas dos'.$linea;
 
   $result = $conn->query("SELECT grucodigo, grunombre FROM btygrupo where sblcodigo = $sublinea");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {                
            echo '<option value="'.$row['grucodigo'].'">'.$row['grunombre'].'</option>';
        }
    } else {
        echo "<option value=''>--No hay resultados--</option>";
    }
