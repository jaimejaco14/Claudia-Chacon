<?php
include '../../cnx_data.php';
$desde=$_POST['desde'];
$hasta=$_POST['hasta'];
$sql="SELECT lg.lgbfecha,lg.lgbhora,ter.trcrazonsocial,lg.lgbregistros_total,lg.lgbregistros_insertados,lg.lgbregistros_error from btylog_biometrico_cargacsv lg 
		natural join btyusuario us
		natural join btytercero ter
		where lgbfecha between '$desde' and '$hasta'
		order by lg.lgbcodigo desc ";
$res=$conn->query($sql);
$cn=mysqli_num_rows($res);
if($cn>6){
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
        <th>Fecha</th>
        <th class="text-center">Hora</th>
        <th>Usuario</th>
        <th>Total Registros</th>
        <th>Insertados</th>
        <th>Errores</th>
    </tr>                    
<?php
if($cn>0){
while ($row=$res->fetch_array()){
?>
<tr>
<td><?php echo $row[0];?></td>
<td class="text-center"><?php echo $row[1];?></td>
<td><?php echo $row[2];?></td>
<td class="text-center"><?php echo $row[3];?></td>
<td class="text-center"><?php echo $row[4];?></td>
<td class="text-center"><?php echo $row[5];?></td>
</tr>
	<?php
}
}else{
	?>
	<tr><td colspan="6" class="text-center">No hay datos registrados en estas fechas</td></tr>
	<?php
}
?>
