<?php
  include '../cnx_data.php';

  $dia = $_POST['dia'];
  $desde = $_POST['desde'];
  $hasta = $_POST['hasta'];


  $query = "SELECT COUNT(*) FROM btyhorario WHERE hordia = '".$dia."' AND hordesde = '".$desde."' AND horhasta = '".$hasta."'";


  $res = $conn->query($query);


  if($res == 1){
      
    $sql = "UPDATE btyhorario SET horestado = 1 WHERE hordia = '".$dia."' AND hordesde = '".$desde."' AND horhasta = '".$hasta."'";

    if ($conn->query($sql)) {
        echo "TRUE";
      }
    }