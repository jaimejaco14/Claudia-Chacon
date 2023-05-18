<?php
include '../../cnx_data.php';
$desde=$_POST['desde'];
$hasta=$_POST['hasta'];
$sql="SELECT l.lgbmes,l.lgbfecha,l.lgbhora,ter.trcrazonsocial,sl.slnnombre
		FROM btylog_biometrico_procesamiento l
		NATURAL JOIN btyusuario us
		NATURAL JOIN btytercero ter
		NATURAL JOIN btysalon sl
		where l.lgbfecha between '$desde' and '$hasta'
		ORDER BY l.lgbfecha DESC, l.lgbhora DESC";
$res=$conn->query($sql);
$cn=mysqli_num_rows($res);
if($cn>5){
	$sty="tam";
}else{
	$sty='';
}
?>
<style>
	.tam{
		max-height: 250px;
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
		while ($row=$res->fetch_array()){
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