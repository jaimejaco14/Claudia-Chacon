<?php
include '../../cnx_data.php';
$sql= "SELECT trcdocumento from btycolaborador where trcdocumento =".$documento;
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    //I don´t know what to do here  xD
   
} 
else 
{

    $sql = "SELECT * from btytercero where trcdocumento = ".$documento;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {

        // output data of each row
        while($row = $result->fetch_assoc()) 
        {        
            $v1 = $row["trcdocumento"];
            $v2 = $row["tdicodigo"];
            $v3 = $sexo;
            $v4 = $email;
            $v5 = $fecha;
            $fecha_registro=$_POST['fecha_in'];
            
        }

        $sqlmax ="SELECT MAX(clbcodigo) as m FROM `btycolaborador` ";
        $result = $conn->query($sqlmax);
        
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {   
                $codigo = $row["m"];
            }
        }

            $codigo = $codigo + 1;
            $ruta       = "../../contenidos/imagenes/colaborador/beauty_erp/";

            if ( "" != $_FILES['imagen']['name'])
            {

                $img_name = $_FILES['imagen']['name'];
                $archivo = $_FILES['imagen']['tmp_name'];
         
                $partes_nombre = explode('.', $img_name);
                $extension = end( $partes_nombre );
                $new_name = $id_usuario;
                if(move_uploaded_file($archivo , $ruta.$v1.".".$extension)){
                    $img_name = $v1.".".$extension;
                }else{
                    $img_name = "noupload.jpg";
                }
            } 
            else 
            {
                    $img_name = "default.jpg";

            }

            $sql1 = "INSERT INTO btycolaborador (clbcodigo, trcdocumento, tdicodigo, clbsexo, crgcodigo, ctccodigo, clbemail, clbfechanacimiento, clbnotificacionemail, clbnotificacionmovil, clbfechacreacion, clbultactualizacion, clbfechaingreso, `cblimagen`, clbclave, clbacceso, clbestado, clbtiposangre) VALUES ('$codigo', '$v1','$v2', '$v3', '$cargo', '$categoria', '$v4', '$v5', '$nemail', '$nmovil', CURDATE(), CURDATE(), '$fecha_registro', '$img_name', NULL, 0, '1', '')";
            
            if (mysqli_query($conn, $sql1)){
                $clecod=mysqli_fetch_array(mysqli_query($conn,"SELECT IFNULL(MAX(c.clecodigo)+1,1) FROM btyestado_colaborador c"));
                $sql2="INSERT INTO btyestado_colaborador (clecodigo,clbcodigo,clefecha,cleobservaciones,cletipo,cleestado) VALUES ($clecod[0],$codigo,curdate(),'En espera de aprobacion de ingreso','PENDIENTE APROBACION',1)";
                if($conn->query($sql2)){
                    $sql3="INSERT INTO btycolaborador_vinculacion (tivcodigo,vincodigo,clecodigo) values ($tivincu,$vinculador,$clecod[0])";
                    if($conn->query($sql3)){
                        echo "TRUE";
                    }else{
                        echo $sql3;
                    }
                }else{
                    echo 'estado';
                }
            } 
            else{
                echo "Error: " . $sql1 . "" . mysqli_error($conn);
            }
    } 
    else 
    {
        //echo "0 results";
    }

}  