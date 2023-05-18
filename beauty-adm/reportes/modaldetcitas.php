<?php
include '../../cnx_data.php';
$datos=$_POST['datos'];
$desde=$_POST['f1'];
$hasta=$_POST['f2'];
$data=explode(',' , $datos);
$sqltit="SELECT ec.escnombre,sl.slnnombre FROM btyestado_cita ec,btysalon sl WHERE ec.esccodigo=$data[0] and sl.slncodigo=$data[1]";
$restit=$conn->query($sqltit);
$rowtit=$restit->fetch_array();
$sql="SELECT distinct(ct.sercodigo),sv.sernombre,count(ct.sercodigo) as con from btycita ct
			join btyservicio sv on ct.sercodigo=sv.sercodigo
			join btynovedad_cita nc on ct.citcodigo=nc.citcodigo
			where nc.esccodigo=$data[0]
			and ct.slncodigo=$data[1] 
			and ct.citfecharegistro between '$desde' and '$hasta'
			group by ct.sercodigo order by con desc";
$res=$conn->query($sql);
$nr=mysqli_num_rows($res);

if($nr>7){
	$sty="table table-fixed";
}else{
	$sty="table";
}
?>
<div class="modal-header"> 
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button> 
    <h3 class="text-left"><b>DETALLE DE CITAS <?php echo $rowtit[0]?></b></h3> 
    <h4>Salón: <?php echo $rowtit[1];?></h4>
</div> 
<style>
 .table-fixed thead {
  width: 99%;
 }
 .table-fixed tbody {
  height: 250px;
  overflow-y: auto;
  width: 100%;
  white-space: nowrap;
 }
 .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
 }
 .table-fixed tbody td, .table-fixed thead > tr> th {
  float: left;
  border-bottom-width: 0;
 }  
</style>
<div class="modal-body">
<?php
if($nr>0){
	?>
	<table class="<?php echo $sty;?>">
		<thead>
			<tr>
				<th class="col-xs-9">SERVICIO</th>
				<th class="col-xs-3">CANTIDAD</th>
			</tr>
		</thead>
		<tbody>
		<?php
		
		while($row=$res->fetch_array()){
			?>
			<tr>
				<td class="col-xs-9"><?php echo utf8_encode($row[1]);?></td>
				<td class="col-xs-3 text-center"><?php echo $row[2];?></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<?php
}else{
	echo 'No hay datos';
}?>
</div>