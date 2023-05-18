<?php 
	include("../../../cnx_data.php");
    include("../funciones.php");



    $QueryUpdMov = mysqli_query($conn, "UPDATE btytercero SET trctelefonomovil = '".$_POST['movil']."' WHERE trcdocumento = '".$_POST['doc']."'");

    $QueryUpdEmail = mysqli_query($conn, "UPDATE btycliente SET cliemail = '".$_POST['email']."' WHERE trcdocumento = '".$_POST['doc']."'");

    if ($QueryUpdMov && $QueryUpdEmail) 
    {
        echo 1;
    }

    mysqli_close($conn);
?>



