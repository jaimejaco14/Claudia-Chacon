<?php 
    include("../../../cnx_data.php");

    $id = $_POST['id'];
    $html="";
    $sql = mysqli_query($conn, "SELECT sercodigo, sernombre FROM btyservicio WHERE sercodigo = $id");

    $row = mysqli_fetch_array($sql);

    $html.='
		<option value="'.$row['sercodigo'].'">'.utf8_encode($row['sernombre']).'</option>
    ';

    echo $html;


    mysqli_close($conn);

 ?>