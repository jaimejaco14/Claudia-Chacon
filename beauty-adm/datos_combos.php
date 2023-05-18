<?php
include '../cnx_data.php';
 $linea = $_POST['linea'];
 $p = $_POST['puntero'];
 //echo $p.'estas dos'.$linea;
 
   $result = $conn->query("SELECT sblcodigo, sblnombre FROM btysublinea where lincodigo = $linea");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {                
            echo '<option value="'.$row['sblcodigo'].'">'.$row['sblnombre'].'</option>';
        }
    } else {
        $TRUE="";
        echo "<option value=''>--No hay resultados--</option>";
    }
 
 
    $conn->close();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

