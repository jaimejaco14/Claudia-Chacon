<?php
include '../../cnx_data.php';
$fecha1=$_POST['f1'];
$fecha2=$_POST['f2'];
$codcol=$_POST['col'];
$sql="SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
		FROM btyasistencia_procesada ap
		JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
		JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
		JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
		JOIN btysalon sl on sl.slncodigo=ap.slncodigo
		WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='ENTRADA' 
		AND (apt.aptcodigo=2 OR apt.aptcodigo=1) 
		UNION
		SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
		FROM btyasistencia_procesada ap
		JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
		JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
		JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
		JOIN btysalon sl on sl.slncodigo=ap.slncodigo
		WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='SALIDA' 
		AND (apt.aptcodigo=3 OR apt.aptcodigo=1) 
		UNION
		SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, null,null, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
		FROM btyasistencia_procesada ap
		JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
		JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
		JOIN btysalon sl on sl.slncodigo=ap.slncodigo
		WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol 
		AND ap.abmcodigo IS NULL and ap.aptcodigo=4
		UNION
		SELECT ap.prgfecha, CONCAT(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, IFNULL(NULL, IF((
		SELECT ab.abmnuevotipo
		FROM btyasistencia_procesada ap2
		JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo
		WHERE ap2.prgfecha = ap.prgfecha AND ap2.clbcodigo=ap.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA'))
						, NULL, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
		FROM btyasistencia_procesada ap
		JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
		JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
		JOIN btysalon sl on sl.slncodigo=ap.slncodigo
		WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ap.abmcodigo IS NULL AND ap.aptcodigo=6
		UNION
		SELECT ap.prgfecha, null,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
		FROM btyasistencia_procesada ap
		JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
		JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
		JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
		JOIN btysalon sl on sl.slncodigo=ap.slncodigo
		WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='SALIDA' AND apt.aptcodigo=5
		union
		SELECT ap.prgfecha, null,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
		FROM btyasistencia_procesada ap
		JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
		JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
		JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
		JOIN btysalon sl on sl.slncodigo=ap.slncodigo
		WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='ENTRADA' AND apt.aptcodigo=5
		ORDER BY prgfecha asc, abmnuevotipo asc";
$res=$conn->query($sql);
$sql2="SELECT concat('$',format(SUM(ap.apcvalorizacion),0))
		FROM btyasistencia_procesada ap
		WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol ";
$res2=$conn->query($sql2);
$row2=$res2->fetch_array();
?>
<h3 class="text-right"><b>Total: <?php echo $row2[0];?>  </b></h3>
<table class="table table-hover">
<tr>
	<th>FECHA</th>
	<th>TURNO</th>
	<th>SALON</th>
	<th>REGISTRO</th>
	<th>HORA REGISTRO</th>
	<th>RESULTADO</th>
	<th>VALOR</th>
</tr>
<?php
while($row=$res->fetch_array()){
?>
	<tr>
		<td><?php echo $row[0]?></td>
		<td><?php echo $row[1]?></td>
		<td><?php echo $row[2]?></td>
		<td><?php echo $row[3]?></td>
		<td><?php echo $row[4]?></td>
		<td><?php echo $row[5]?></td>
		<td class="text-right"><?php echo $row[6]?></td>
	</tr>
<?php
}
?>
</table>


