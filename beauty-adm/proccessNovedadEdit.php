<?php 
	include '../cnx_data.php';

	//print_r($_POST);
	//print_r($_SESSION);

	$detalles  = json_decode($_POST['datos'],true);

    //$jsonExcluir = array();

    
    if(!is_numeric($_POST['newtipo'])) 
    {
        $tipo = $_POST['oldtipo'];
    }
    else
    {
        $tipo = $_POST['newtipo'];
    }

    if ($_POST['oldfecha'] != $_POST['newfecha']) 
    {
        $fecha = $_POST['newfecha'];
    }
    else
    {
         $fecha = $_POST['oldfecha'];
    }

    if ($_POST['oldfechah'] != $_POST['newfechah']) 
    {
        $fechah = $_POST['newfechah'];
    }
    else
    {
         $fechah = $_POST['oldfechah'];
    }

    if ($_POST['olddesde'] != $_POST['horad']) 
    {
        $desde = $_POST['horad'];
    }
    else
    {
        $desde = $_POST['olddesde'];
    }

    if ($_POST['horah'] != $_POST['oldhasta']) 
    {
        $hasta = $_POST['horah'];
    }
    else
    {
        $hasta = $_POST['oldhasta'];
    }

    if ($_POST['salon'] == 0) 
    {
        $salon = $_POST['oldsalon'];
    }
    else
    {
        $salon = $_POST['salon'];
    }


    





    if (is_array($detalles) || is_object($detalles))
    {

        $r = "UPDATE btynovedades_programacion SET tnvcodigo = '".$tipo."', nvpfechadesde = '".$fecha."', nvpfechahasta = '".$fechah."',  nvpobservacion = '".utf8_decode(strtoupper($_POST['obser']))."', nvphoradesde = '".$desde."', nvphorahasta = '".$hasta."', usucodigo = '".$_SESSION['codigoUsuario']."', slncodigo = '".$salon."', nvpestado = 'MODIFICADO' WHERE nvpcodigo = '".$_POST['idnovedad']."'";

        //echo $r;

        $QueryNov = mysqli_query($conn, $r)or die(mysqli_error($conn));

        if ($QueryNov) 
        {
            echo json_encode(array("res" => "ok"));         
        }
        
        $del = mysqli_query($conn, "DELETE FROM btynovedades_programacion_detalle WHERE nvpcodigo = '".$_POST['idnovedad']."'");

            foreach($detalles as $obj)
            {

                $clbcodigo = $obj['codCol']; 


                $sql = mysqli_query($conn, "INSERT IGNORE INTO btynovedades_programacion_detalle (nvpcodigo, clbcodigo) VALUES('".$_POST['idnovedad']."', $clbcodigo)")or die(mysqli_error($conn));

            }
    }
    else
    {
      echo "No es arreglo u objeto";
    }

?>



 
 

