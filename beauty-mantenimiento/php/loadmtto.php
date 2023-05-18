<?php
include "../../cnx_data.php";
$today= date("Y-m-d");
if($_POST['actcod']){
	$act=" AND actcodigo=".$_POST['actcod'];
}else{
	$act='';
}
//filtro tipo
if($_POST['tipo']!=''){
	$tipo=" AND p.pgmtipo='".$_POST['tipo']."'";
}else{
	$tipo='';
}
//filtro estado
if($_POST['estado']!=''){
	$estado="AND p.pgmestado='".$_POST['estado']."'";
}else{
	$estado='';
}
//filtro fecha
if(($_POST['fecha']!='•') && ($_POST['fecha']!='')){
	$fecha=explode('•',$_POST['fecha']);
	$desde="'".$fecha[0]."'";
	$hasta="'".$fecha[1]."'";
}else{
	$desde='CURDATE()';
	$hasta='CURDATE()';
}
$sql="SELECT p.pgmconsecutivo,a.actcodigo,a.actnombre,p.pgmfecha,p.pgmtipo,concat(al.lugnombre,' - ',aa.arenombre) as ubicacion, p.pgmestado, $desde as desde , $hasta as hasta
		FROM btyactivo_programacion p
		join btyactivo a on a.actcodigo=p.actcodigo
		join btyactivo_ubicacion au on au.actcodigo=a.actcodigo and au.ubchasta is null
		join btyactivo_area aa on aa.arecodigo=au.arecodigo
		join btyactivo_lugar al on al.lugcodigo=aa.lugcodigo
		WHERE  p.pgmfecha BETWEEN $desde AND $hasta".$tipo.$act.$estado." ORDER BY p.pgmfecha";
$res=$conn->query($sql);
?>
<table class="table table-bordered">
	<thead>
		<tr>
			<th colspan="7" class="text-center">PROGRAMACIÓN DE ACTIVIDADES DEL: <b id="rango"><?php echo $today; ?></b></th>
		</tr>
		<tr>
			<th class="text-center">Cod</th>
			<th class="text-center">Nombre Activo</th>
			<th class="text-center">Ubicación</th>
			<th class="text-center">Actividad</th>
			<th class="text-center">Fecha Programada</th>
			<th class="text-center">Estado</th>
			<th class="text-center">Opciones</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($res->num_rows>0){
		while($row=$res->fetch_assoc()){
			?>
			<tr>
				<td class="text-center actcodigo"><?php echo $row['actcodigo'];?></td>
				<td class="actnombre"><?php echo $row['actnombre'];?></td>
				<td class="actubic"><?php echo $row['ubicacion'];?></td>
				<td class="text-center pgmtipo"><?php echo $row['pgmtipo'];?></td>
				<td class="text-center pgmfecha"><?php echo $row['pgmfecha'];?></td>
				<?php 
				switch($row['pgmestado']){
					case 'PROGRAMADO':
						$class='text-primary';
					break;
					case 'RE-PROGRAMADO':
						$class='text-warning';
					break;
					case 'EJECUTADO':
						$class='txt-success';
					break;
					case 'CANCELADO':
						$class='text-danger';
					break;
				}
				?>
				<td class="text-center estado <?php echo $class;?>"><b><?php echo $row['pgmestado'];?></b></td>
				<?php 
				switch($row['pgmestado']){
					case 'PROGRAMADO':
					case 'RE-PROGRAMADO':
						?>
						<td class="text-center">
							<a class="btncancel" data-pgmcon="<?php echo $row['pgmconsecutivo'];?>" data-toggle="tooltip" data-placement="top" title="Cancelar"><span class="fa fa-times text-danger"></span></a>
							<a class="btnrepro" data-pgmcon="<?php echo $row['pgmconsecutivo'];?>" data-toggle="tooltip" data-placement="top" title="Reprogramar"><span class="fa fa-refresh txt-success"></span></a>
						</td>
						<?php
					break;
					case 'EJECUTADO':
					case 'CANCELADO':
						?>
						<td class="text-center">
							<a class="btnver" data-pgmcon="<?php echo $row['pgmconsecutivo'];?>" data-toggle="tooltip" data-placement="top" title="Ver detalles"><span class="fa fa-eye text-info"></span></a>
						</td>
						<?php
					break;
				}
				?>
			</tr>
			<?php
		}
	}else{
		?>
		<tr>
			<td colspan="7" class="text-center">No hay actividades de mantenimiento correspondientes a los filtros actuales</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>