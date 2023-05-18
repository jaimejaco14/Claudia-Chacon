<?php
include '../cnx_data.php';
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
            $ruta       = "../contenidos/imagenes/colaborador/".$_SESSION['Db']."/";

            if ( "" != $_FILES['imagen']['name'])
            {

                $img_name = $_FILES['imagen']['name'];
                $archivo = $_FILES['imagen']['tmp_name'];
         
                $partes_nombre = explode('.', $img_name);
                $extension = end( $partes_nombre );
                $new_name = $id_usuario;
                 move_uploaded_file($archivo,$ruta.$v1.".".$extension);
                 $img_name = $v1.".".$extension;
            } 
            else 
            {
                    $img_name = "default.jpg";

            }


           /* if ($_POST['cod_biometric'] == " " || $_POST['cod_biometric'] == null) 
            {
                $biometrico = null;
            }
            else
            {
                $biometrico = $_POST['cod_biometric'];
            }*/

            echo $_SESSION['biometrico'];



            $sql1 = "INSERT INTO btycolaborador (clbcodigo, trcdocumento, tdicodigo, clbsexo, crgcodigo, ctccodigo, clbemail, clbfechanacimiento, clbnotificacionemail, clbnotificacionmovil, clbfechacreacion, clbultactualizacion, clbfechaingreso, `cblimagen`, clbclave, clbacceso, clbestado, clbtiposangre) VALUES ('$codigo', '$v1','$v2', '$v3', '$cargo', '$categoria', '$v4', '$v5', '$nemail', '$nmovil', CURDATE(), CURDATE(), '$fecha_registro', '$img_name', NULL, 0, '1', '')";
            
            if (mysqli_query($conn, $sql1)) 
            {
                echo "TRUE";
            } 
            else 
            {
                echo "Error: " . $sql1 . "" . mysqli_error($conn);
            }
    } 
    else 
    {
        //echo "0 results";
    }

}  