<?php
$fecha = $_POST['fecha'];
$sln = $_POST['codigo'];
include '../../cnx_data.php';
$sql = "SELECT t.trnnombre, s.slnnombre, trc.trcrazonsocial, tp.tprnombre, pc.`clbcodigo`, pc.`trncodigo`, pc.`horcodigo`, pc.`slncodigo`, pc.`ptrcodigo`, pc.`prgfecha`, pc.`tprcodigo` FROM `btyprogramacion_colaboradores` pc INNER JOIN btyturno t ON pc.trncodigo = t.trncodigo INNER JOIN btysalon s ON pc.slncodigo = s.slncodigo INNER JOIN btycolaborador c ON c.clbcodigo = pc.clbcodigo INNER JOIN btytercero trc ON trc.trcdocumento = c.trcdocumento INNER JOIN btytipo_programacion tp ON tp.tprcodigo = pc.tprcodigo WHERE pc.prgfecha = '$fecha' AND pc.slncodigo = $sln ORDER BY t.trnnombre, trc.trcrazonsocial";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<h5>Programaci&oacute;n <strong>".$fecha."</strong> - sal&oacute;n <strong>".$_POST['salon']."</strong></h5>";
	// echo "<a onclick='copiar(\"".$fecha."\");' title='Copiar programaci&oacute;n' class='pull-right'> <i class='btn-lg pe-7s-copy-file text-info'> </i></a>";
	echo '<table class="table table-hover table-bordered table-striped">
            <thead>
                <th>Turno</th>
                <th>Colaborador</th>
                <th>Estado</th>
            </thead>    
            <tbody>';
	while ($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row['trnnombre']."</td>";
		echo "<td>".$row['trcrazonsocial']."</td>";
		echo "<td>".$row['tprnombre']."</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
} else {
	echo "<h5>No hay programacion para la fecha ".$fecha."</h5>";
}

?>
