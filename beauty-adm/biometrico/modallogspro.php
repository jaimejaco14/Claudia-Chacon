<?php
include '../../cnx_data.php';
$sqllog="SELECT l.lgbmes,l.lgbfecha,l.lgbhora,ter.trcrazonsocial,sl.slnnombre
			FROM btylog_biometrico_procesamiento l
			NATURAL JOIN btyusuario us
			NATURAL JOIN btytercero ter
			NATURAL JOIN btysalon sl
			ORDER BY l.lgbfecha DESC, l.lgbhora DESC";
$reslog=$conn->query($sqllog);
$cn=mysqli_num_rows($reslog);

if($cn>5){
	$sty="tam";
}else{
	$sty='';
}
?>
<style>
	.tam{
		max-height: 200px;
		overflow-y: auto;
	}
</style>
<div class="<?php echo $sty;?>">
	<table class="table">
	    <tr>
	        <th>Mes procesado</th>
	        <th class="text-center">Fecha</th>
	        <th class="text-center">Hora</th>
	        <th>Procesado por</th>
	        <th>Salón</th>
	    </tr>                    
	<?php
	if($cn>0){
		while ($row=$reslog->fetch_array()){
		?>
			<tr>
				<td><?php echo $row[0];?></td>
				<td class="text-center"><?php echo $row[1];?></td>
				<td class="text-center"><?php echo $row[2];?></td>
				<td><?php echo $row[3];?></td>
				<td><?php echo $row[4];?></td>
			</tr>
		<?php
		}
	}else{
		?>
		<tr>
			<td colspan="5" class="text-center">No hay datos para mostrar</td>
		</tr>
	<?php
	}
	?>                  
	</table>
</div>