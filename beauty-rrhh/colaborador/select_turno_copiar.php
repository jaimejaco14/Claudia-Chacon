<?php
include "../../cnx_data.php";



$dia = date('l', strtotime($_POST['fecha']));

$semana = array(
	'Monday'  	=> 'LUNES' ,
	'Tuesday' 	=> 'MARTES',
	'Wednesday' => 'MIERCOLES',
	'Thursday'  => 'JUEVES',
	'Friday' 	=> 'VIERNES',
	'Saturday' 	=> 'SABADO',
	'Sunday' 	=> 'DOMINGO',
);

$dia = $semana[$dia];

$festivos = mysqli_query($conn, "SELECT a.fescodigo, a.festipo, a.fesfecha, DAYNAME(a.fesfecha) AS dia FROM btyfechas_especiales a WHERE a.fesfecha = '".$_POST['fecha']."'");

if (mysqli_num_rows($festivos) > 0) 
{
	$SqlTurnos = "SELECT t.trncodigo, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' HASTA: ', DATE_FORMAT(t.trnhasta, '%H:%i'),  ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' A ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i'))AS turno FROM btyturno_salon AS ts, btyhorario AS h, btyturno AS t WHERE t.trncodigo=ts.trncodigo AND h.horcodigo=ts.horcodigo AND ts.slncodigo='".$_POST['salon']."' AND h.hordia='DOMINGO' ORDER BY t.trnnombre";
	echo 1;
}
else
{

	$SqlTurnos = "SELECT t.trncodigo, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' HASTA: ', DATE_FORMAT(t.trnhasta, '%H:%i'),  ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' A ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i'))AS turno FROM btyturno_salon AS ts, btyhorario AS h, btyturno AS t WHERE t.trncodigo=ts.trncodigo AND h.horcodigo=ts.horcodigo AND ts.slncodigo='".$_POST['salon']."' AND h.hordia='".$dia."' ORDER BY t.trnnombre";
}


$RsTurnos = $conn->query($SqlTurnos);



if ($RsTurnos->num_rows > 0) 	
{
	echo"<option value=''>Seleccione Turno</option>";
	while ($row = $RsTurnos->fetch_assoc()) 
	{	
		echo "<option value='".$row['trncodigo']."'>".$row['turno']."</option>";
	}
}

?>