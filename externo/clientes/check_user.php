<?php
 include '../../cnx_data.php';
$documento = $_POST["no_documento"];

if($documento != NULL) {
    $sql1 = "SELECT * FROM btytercero as t WHERE t.trcdocumento = '$documento' ";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
      
        $sql2 = "SELECT t.*, c.* FROM btytercero as  t , btycliente as c WHERE t.trcdocumento = '$documento' and t.trcdocumento=c.trcdocumento";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
              $row = $result2->fetch_assoc();
              echo $row['tdicodigo'].",";       // 0
              echo $row['trcdocumento'].",";      // 1
              echo $row['trcdigitoverificacion'].","; // 2
              echo $row['trcnombres'].",";      // 3
              echo $row['trcapellidos'].",";      // 4
              echo $row['trcrazonsocial'].",";    // 5
              echo $row['trcdireccion'].",";      // 6
              echo $row['trctelefonofijo'].",";     // 7
              echo $row['trctelefonomovil'].",";    // 8
              echo $row['brrcodigo'].",";  //9  
              echo $row['clisexo'].",";   // 10
              echo $row['cliextranjero'].",";   // 11
              echo $row['cliemail'].",";   // 12
              echo $row['clifechanacimiento'].",";   // 13
              echo $row['clinotificacionemail'].",";   // 14
              echo $row['clinotificacionmovil'].",";   // 15
              echo $row['cliempresa'].",";   // 16
              echo $row['clifecharegistro'].",";   // 17
              echo $row['cliimagen'].",";   // 18
              echo $row['clitiporegistro'].",";  // 19
              echo $row['ocucodigo'];//20
        }
        else{
          $row = $result1->fetch_assoc();
          echo $row['tdicodigo'].",";       // 0
          echo $row['trcdocumento'].",";      // 1
          echo $row['trcdigitoverificacion'].","; // 2
          echo $row['trcnombres'].",";      // 3
          echo $row['trcapellidos'].",";      // 4
          echo $row['trcrazonsocial'].",";    // 5
          echo $row['trcdireccion'].",";      // 6
          echo $row['trctelefonofijo'].",";     // 7
          echo $row['trctelefonomovil'].",";    // 8
          echo $row['brrcodigo'].",";       // 9
        }   
    }
}













