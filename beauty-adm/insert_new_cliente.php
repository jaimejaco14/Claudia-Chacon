<?php
include '../cnx_data.php';
$sql= "SELECT trcdocumento from btycliente where trcdocumento =".$documento;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} 
else {

    $sql = "SELECT * from btytercero where trcdocumento = ".$documento;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            $v1 = $row["trcdocumento"];
            $v2 = $row["tdicodigo"];
            $v3 = $sexo;
            $v4 = $email;
            //$v5 = $fecha;
            if($fecha==""){
                $v5="null";
            }else{
                $v5="'".$fecha."'";
            }
            $fecha_registro=date("Y-m-d");
        }
        $sqlmax ="SELECT MAX(clicodigo) as m FROM `btycliente` ";
        $result = $conn->query($sqlmax);
        if ($result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
            $codigo = $row["m"];
        }}
        $codigo = $codigo + 1;
        if ($externo == 'si') {
            $sql1= "INSERT INTO btycliente (clicodigo, trcdocumento, tdicodigo, clisexo, ocucodigo, cliemail, clifechanacimiento, clinotificacionemail, clinotificacionmovil, cliempresa, clifecharegistro, cliimagen, cliextranjero, clitiporegistro, cliestado) VALUES ('$codigo', '$v1','$v2', '$v3', '$ocupacion', '$v4', $v5, '$nemail', '$nmovil', '$empresa', '$fecha_registro', 'default.jpg', '$extr', 'EXTERNO' , '1')";
        }else {
            $sql1= "INSERT INTO btycliente (clicodigo, trcdocumento, tdicodigo, clisexo, ocucodigo, cliemail, clifechanacimiento, clinotificacionemail, clinotificacionmovil, cliempresa, clifecharegistro, cliimagen, cliextranjero, clitiporegistro, cliestado) VALUES ('$codigo', '$v1','$v2', '$v3', '$ocupacion', '$v4', $v5, '$nemail', '$nmovil', '$empresa', '$fecha_registro', 'default.jpg', '$extr', 'INTERNO' , '1')";
    }
    
    if (mysqli_query($conn, $sql1)) {
        echo $v5;
    } else {

        echo "Error: " . $sql1 . "" . mysqli_error($conn);
    }
} else {
    echo "0 results";

}

}
?>