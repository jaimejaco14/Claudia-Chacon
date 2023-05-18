<?php 
	include("../../../cnx_data.php");
    include("../funciones.php");

    $Query = mysqli_query($conn, "SELECT a.clicodigo, a.trcdocumento, b.trcrazonsocial, a.cliemail, b.trctelefonomovil FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo WHERE a.clicodigo = '".$_POST['cliente']."' OR a.trcdocumento = '".$_POST['doc']."' ");




    $array = array();

    $row = mysqli_fetch_array($Query);

    if ($row['cliemail'] == null || $row['trctelefonomovil'] == null) 
    {

    	echo json_encode(array("res" => "incompleto", "codigo" => $row['clicodigo'], "doc" => $row['trcdocumento'], "nombre" => utf8_encode($row['trcrazonsocial']), "email" => $row['cliemail'], "movil" => $row['trctelefonomovil']));
    }
    else
    {
    	echo json_encode(array("res" => "completo"));
    }

?>