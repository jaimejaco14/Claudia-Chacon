<?php
include '../../cnx_data.php';
$desde=$_POST['f1'];
$hasta=$_POST['f2'];
$datos=$_POST['datos'];
$data=explode(',' , $datos);
$sln=$data[0];
$opc=$data[1];
$sqlsln="SELECT slnnombre from btysalon where slncodigo=$sln";
$ressln=$conn->query($sqlsln);
$rowsln=$ressln->fetch_array();
/*	$sql0="SELECT ta.tuafechai, ta.tuahorai,ter.trcrazonsocial
			from btyturnos_atencion ta
			join btyusuario us on us.usucodigo=ta.usucodigoi
			join btytercero ter on ter.trcdocumento=us.trcdocumento
			where ta.tuafechai between '$desde' and '$hasta'
			and ta.slncodigo=$sln
			order by ta.tuafechai";
	$sql1="SELECT ta.tuafechai, ta.tuahoraf,ter.trcrazonsocial
			from btyturnos_atencion ta
			join btyusuario us on us.usucodigo=ta.usucodigof
			join btytercero ter on ter.trcdocumento=us.trcdocumento
			where ta.tuafechai between '$desde' and '$hasta'
			and ta.tuahorai <> ta.tuahoraf
			and ta.slncodigo=$sln
			order by ta.tuafechaf";
	$sql2="SELECT ta.tuafechai,' -- ',' -- '
			from btyturnos_atencion ta
			where ta.tuafechai between '$desde' and '$hasta'
			and ta.tuahorai = ta.tuahoraf
			and ta.slncodigo=$sln
			order by ta.tuafechai";*/
$sql0="SELECT ca.tuafechai, ta.tuahorai, ter.trcrazonsocial, count(ca.clbcodigo),if(ta.tuaobservacionesi='','Sin comentarios',ta.tuaobservacionesi)
		FROM btycola_atencion ca
		join btyturnos_atencion ta on ta.slncodigo=ca.slncodigo and ta.tuafechai=ca.tuafechai
		join btyusuario us on us.usucodigo=ta.usucodigoi 
		join btytercero ter on ter.trcdocumento=us.trcdocumento
		WHERE ca.slncodigo=$sln AND ca.tuafechai BETWEEN '$desde' AND '$hasta'
		group by ca.tuafechai,ter.trcrazonsocial";
$sql1="SELECT ca.tuafechai, ta.tuahoraf, ter.trcrazonsocial, count(ca.clbcodigo),if(ta.tuaobservacionesf='','Sin comentarios',ta.tuaobservacionesf)
		FROM btycola_atencion ca
		join btyturnos_atencion ta on ta.slncodigo=ca.slncodigo and ta.tuafechai=ca.tuafechai
		join btyusuario us on us.usucodigo=ta.usucodigof 
		join btytercero ter on ter.trcdocumento=us.trcdocumento
		WHERE ca.slncodigo=$sln AND ca.tuafechai BETWEEN '$desde' AND '$hasta'
		and ta.tuahorai <> ta.tuahoraf
		group by ca.tuafechai,ter.trcrazonsocial";
$sql2="SELECT ca.tuafechai, ' -- ',' -- ', count(ca.clbcodigo),'--'
		FROM btycola_atencion ca
		join btyturnos_atencion ta on ta.slncodigo=ca.slncodigo and ta.tuafechai=ca.tuafechai
		join btyusuario us on us.usucodigo=ta.usucodigof 
		join btytercero ter on ter.trcdocumento=us.trcdocumento
		WHERE ca.slncodigo=$sln AND ca.tuafechai BETWEEN '$desde' AND '$hasta'
		and ta.tuahorai = ta.tuahoraf
		group by ca.tuafechai,ter.trcrazonsocial";
$res=$conn->query(${'sql'.$opc});
$nr=mysqli_num_rows($res);
if($nr>7){
	$sty="table-fixed2";
}else{
	$sty="";
}
switch($opc){
	case 0:
		$titu="GESTIONADO"; 
	break;
	case 1:
		$titu="CERRADOS"; 
	break;
	case 2:
		$titu="ABIERTOS"; 
	break;
}
?>
<style>
	.table-fixed2  {
		height: 250px;
		overflow-y: auto;

	}

</style>
<div class="modal-header"> 
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button> 
	<h4 class="text-left"><b>REPORTE DE SUBE Y BAJA: <?php echo $titu;?></b></h4> 
	<h5>Salón: <?php echo $rowsln[0];?></h5>
</div> 

<div class="modal-body <?php echo $sty;?>">
	<table class="table table-stripped">
		<thead>
			<th class="col-xs-2">Fecha</th>
			<th class="col-xs-2 text-center">Hora</th>
			<th class="col-xs-4 text-center">Usuario</th>
			<th class="col-xs-2 text-center">Colaboradores</th>
			<th class="col-xs-2 text-left">Comentarios</th>
		</thead>
		<?php
		if($nr>0){
			while($row=$res->fetch_array()){
				?>
				<tr>
					<td class="col-xs-2"><?php echo $row[0];?></td>
					<td class="col-xs-2 text-center"><?php echo $row[1];?></td>
					<td class="col-xs-4 text-left"><?php echo utf8_encode($row[2]);?></td>
					<td class="col-xs-2 text-center"><?php echo $row[3]?></td>
					<td class="col-xs-2 text-left"><?php echo $row[4]?></td>
				</tr>
				<?php
			}
		}else{?>
			<td colspan="4" class="text-center">No hay datos</td>
			<?php
		}

		?>
	</table>
</div>
