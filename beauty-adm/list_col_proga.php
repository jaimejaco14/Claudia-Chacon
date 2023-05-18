<div class="hpanel">
<div class="panel-body">
<h3 class="table-title">Colaboradores programados</h3>
<table class="table table-hover table-bordered table-striped">
 <thead>
  <th>Nombre</th>
  <th>Acciones</th>           
  </thead>
  <tbody>                       
<?php
$turn = $_POST['turno'];
$salon = $_POST['sln'];
$fecha = $_POST['fecha'];
$col = $_POST['col'];
include '../cnx_data.php';
$sql = "SELECT p.`clbcodigo`, p.`trncodigo`, p.`prgfecha`, t.trcrazonsocial FROM `btyprogramacion_colaboradores` p INNER JOIN btycolaborador c ON p.clbcodigo = c.clbcodigo INNER JOIN btytercero t ON c.trcdocumento = t.trcdocumento where trncodigo = '$turn' and prgfecha = '$fecha'";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		# code...
		echo "<tr>";
        echo '<td>' . $row['trcrazonsocial'] . '</td>';
        echo '<td><button class="btn btn-default" title="Eliminar servicio" onclick="eliminar('.$row['clbcodigo'].', '.$row['trncodigo'].', \''.$row['prgfecha'].'\', this)"><i class="pe-7s-trash text-info"></i></button></td>';
        echo "</tr>";
	}
} else {
	# code...

}
?>
</tbody>
</table>
</div>
</div>