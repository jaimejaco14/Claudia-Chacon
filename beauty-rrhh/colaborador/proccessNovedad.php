<?php 
	include '../../cnx_data.php';

	//print_r($_POST);
	//print_r($_SESSION);

	$detalles  = json_decode($_POST['datos'],true);

	$cons = mysqli_query($conn, "SELECT MAX(nvpcodigo) FROM btynovedades_programacion");
	$r = mysqli_fetch_array($cons);
	$max = $r[0]+1;

   
    if (is_array($detalles) || is_object($detalles))
    {

        $r = "INSERT INTO btynovedades_programacion (nvpcodigo, tnvcodigo, nvpfecharegistro, nvphoraregistro, nvpfechadesde, nvpfechahasta, nvpobservacion, nvphoradesde, nvphorahasta, usucodigo, slncodigo, nvpestado) VALUES($max, '".$_POST['tipo']."',  CURDATE(), CURTIME(), '".$_POST['fecha']."', '".$_POST['fechah']."', '".utf8_decode(strtoupper($_POST['obser']))."', '".$_POST['horad']."','".$_POST['horah']."', '".$_SESSION['codigoUsuario']."', '".$_POST['salon']."', 'REGISTRADO')";

        //echo $r;
        $QueryNov = mysqli_query($conn, $r);

        if ($QueryNov) 
        {
            echo json_encode(array("res" => "ok", "consecutivo" => $max));         
            foreach($detalles as $obj)
            {

                $clbcodigo = $obj['codCol'];                    

                $sql = mysqli_query($conn, "INSERT INTO btynovedades_programacion_detalle (nvpcodigo, clbcodigo) VALUES($max, $clbcodigo)")or die(mysqli_error($conn));

            }
        }
    }
    else
    {
      echo "No es arreglo u objeto";
    }

?>



 
 

