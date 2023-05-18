<?php
include "../cnx_data.php";
if ($_POST['fecha'] != "") 
{
	$fecha = $_POST['fecha'];
} 
else 
{
	$fecha = date("Y-m-d");
}

if ($_POST['salon'] != "") 
{
	$sln = $_POST['salon'];
}

$dia = date('l', strtotime($fecha));
$semana = array(
	'Monday'  	=> 'LUNES' ,
	'Tuesday' 	=> 'MARTES',
	'Wednesday' => 'MIERCOLES',
	'Thursday'  => 'JUEVES',
	'Friday' 	=> 'VIERNES',
	'Saturday' 	=> 'SABADO',
	'Sunday' 	=> 'DOMINGO',
);



$cons = mysqli_query($conn, "SELECT * FROM btyfechas_especiales WHERE fesfecha = '$fecha'");


if (mysqli_num_rows($cons) > 0) 
{
	while ($fr = mysqli_fetch_array($cons)) 
	{
		if ($fecha == $fr['fesfecha']) 
		{

			$de = mysqli_query($conn, "SELECT hs.horcodigo, h.hordia, h.hordesde, h.horhasta FROM btyhorario_salon hs JOIN btyhorario h ON h.horcodigo = hs.horcodigo WHERE hs.slncodigo = $sln AND h.hordia = '".$fr['festipo']."' AND h.horestado = 1");			

						if (mysqli_num_rows($de) > 0) 
						{
							while ($row = mysqli_fetch_array($de)) 
							{

								echo "<option value='".$row['horcodigo']."'>".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
							}
						}

		}
		else
		{
			$dia = $semana[$dia];
			$de = mysqli_query($conn, "SELECT hs.horcodigo, h.hordia, h.hordesde, h.horhasta FROM btyhorario_salon hs JOIN btyhorario h ON h.horcodigo = hs.horcodigo WHERE hs.slncodigo = $sln AND h.hordia = '$dia' AND h.horestado = 1");

						if (mysqli_num_rows($de) > 0) {
							 while ($row = mysqli_fetch_array($de)) {
							 	echo "<option value='".$row['horcodigo']."'>".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
							 }
						}
		}
	}
}
else
{
	$dia = $semana[$dia];
		$de = mysqli_query($conn, "SELECT hs.horcodigo, h.hordia, h.hordesde, h.horhasta FROM btyhorario_salon hs JOIN btyhorario h ON h.horcodigo = hs.horcodigo WHERE hs.slncodigo = $sln AND h.hordia = '$dia' AND h.horestado = 1");

						if (mysqli_num_rows($de) > 0) 
						{
							 while ($row = mysqli_fetch_array($de)) 
							 {
							 	echo "<option value='".$row['horcodigo']."'>".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
							 }
						}
}

/*
$sql = "SELECT hs.`horcodigo`, h.hordia, h.hordesde, h.horhasta FROM `btyhorario_salon` hs JOIN btyhorario h ON h.horcodigo = hs.horcodigo WHERE slncodigo = $sln AND (h.hordia = '$dia' OR h.hordia = 'FESTIVO' OR h.hordia = 'ESPECIAL') AND h.horestado = 1";


$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while ($row=$result->fetch_assoc()) {
    	
        echo "<option value='".$row['horcodigo']."'>".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
    }
} else {
    echo "<option value=''>--No hay resultados--</option>";
}

*/

/*$cons = mysqli_query($conn, "SELECT * FROM btyfechas_especiales WHERE fesfecha = '$fecha'");

if (mysqli_num_rows($cons) > 0) {
	$rs = mysqli_fetch_array($cons);
	if ($rs['festipo'] == 'FESTIVO') {		

        $valfes = "SELECT hs.`horcodigo`, h.hordia, h.hordesde, h.horhasta FROM `btyhorario_salon` hs JOIN btyhorario h ON h.horcodigo = hs.horcodigo WHERE slncodigo = $sln AND h.hordia = 'FESTIVO' OR h.hordia = 'ESPECIAL' AND h.horestado = 1";


        	$res = $conn->query($valfes);
			if ($res->num_rows > 0) {
			    while ($row=$res->fetch_assoc()) {
			    	
			        echo "<option value='".$row['horcodigo']."'>".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
			    }
			}


	}
}else{

}
*/

/*$dia = $semana[$dia];
$sql = "SELECT hs.`horcodigo`, h.hordia, h.hordesde, h.horhasta FROM `btyhorario_salon` hs JOIN btyhorario h ON h.horcodigo = hs.horcodigo WHERE slncodigo = $sln AND (h.hordia = '$dia' OR h.hordia = 'FESTIVO' OR h.hordia = 'ESPECIAL') AND h.horestado = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row=$result->fetch_assoc()) {
    	
        echo "<option value='".$row['horcodigo']."'>9999".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
    }
} else {
    echo "<option value=''>--No hay resultados--</option>";
}*/
?>