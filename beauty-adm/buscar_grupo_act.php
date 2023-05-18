<?php
include '../cnx_data.php';
 $tia_cod = $_POST["codigo"];
 
 
 
   $result = $conn->query("SELECT gracodigo, granombre FROM btygrupo_activo where tiacodigo = $tia_cod");
    if ($result->num_rows > 0) {
        $TRUE=" selected='TRUE'";
        while ($row = $result->fetch_assoc()) {                
            echo '<option value="'.$row['gracodigo'].'">'.$row['granombre'].'</option>';
        }
    } else {

        echo '<option value="">--no hay resultados--</option>';
        
    }
