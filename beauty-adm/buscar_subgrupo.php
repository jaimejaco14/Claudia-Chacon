<?php
include '../cnx_data.php';
 $grupo = $_POST['grupo'];
 $p = $_POST['puntero'];
 //echo $p.'estas dos'.$linea;
 
   $result = $conn->query("SELECT sbgcodigo, sbgnombre FROM btysubgrupo where grucodigo = $grupo ORDER BY sbgnombre");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {                
            echo '<option value="'.$row['sbgcodigo'].'">'.$row['sbgnombre'].'</option>';
        }
    } else {
        $TRUE="";
        echo "<option value=''>--no hay resultados--</option>";
    }
 
 
   