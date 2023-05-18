<?php 
include '../cnx_data.php';
$fecha=$_GET['fecha'];
$sql="SELECT t.trcrazonsocial AS cliente, c.cliemail AS mail, t.trctelefonomovil AS celular, s.slnnombre AS salon, t2.trcrazonsocial AS usuario, c.clifecharegistro
		FROM btycliente c
		JOIN  btysalon s ON s.slncodigo=c.slncodigo
		JOIN btytercero t ON t.trcdocumento=c.trcdocumento
		JOIN btyusuario u ON u.usucodigo=c.usucodigo
		JOIN btytercero t2 ON t2.trcdocumento=u.trcdocumento
		WHERE c.usucodigo NOT IN (0,1) AND ((LENGTH(SUBSTRING_INDEX(c.cliemail,'@',1))<=3 OR c.cliemail LIKE '%correo%' OR c.cliemail LIKE 'NO%') OR (LENGTH(t.trctelefonomovil)<10 OR SUBSTRING(t.trctelefonomovil,1,1) <> 3 OR SUBSTRING(t.trctelefonomovil,2,1) NOT IN (0,1,2,5))) and c.clifecharegistro='$fecha'
		order by s.slnnombre";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$cont.='<tr>
	<td>'.utf8_encode($row[0]).'</td>
	<td>'.$row[1].'</td>
	<td>'.$row[2].'</td>
	<td>'.$row[3].'</td>
	<td>'.utf8_encode($row[4])	.'</td>
	<td>'.$row[5].'</td></tr>';
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<title>Registro de clientes por salón</title>
	<link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />
	<script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
	<script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="content">
		<div class="container">
			<h2 class="text-center"><b>Detalle de registros de clientes con datos inconsistentes</b></h2>
			<p>Tenga en cuenta que los datos inconsistentes pueden ser: 
				<br>• Correo electrónico (correo@correo, notiene@correo, etc)
				<br>• Número celular (longitud inferior a 10 digitos, que no empiece por 3, numero de un fijo, etc)
				<br>• Ambos datos (Puede que ambos datos estén mal)
				<br>• Falso positivo (el filtro detecta correos que empicen por 'NO' un falso positivo seria 'NOHEMI')</p>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr class="info">
							<th>Nombre Cliente</th>
							<th>E-Mail</th>
							<th>Celular</th>
							<th>Salón</th>
							<th>Usuario que registró</th>
							<th>Fecha registro</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $cont; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>