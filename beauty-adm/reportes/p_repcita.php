<?php
include '../../cnx_data.php';
$desde=$_POST['f1'];
$hasta=$_POST['f2'];
if($_POST['sln']!='null'){
	$salon=$_POST['sln'];
}else{
	$consln4="SELECT group_concat(slncodigo order by slnnombre) from btysalon";
	$res4=$conn->query($consln4);
	$row4=$res4->fetch_array();
	$salon=$row4[0];
}

$txtsln=$_POST['txtsln'];
$sln=explode(',',$salon);
?>

<table class="table table-stripped tablesorter" id="treporte">
	<thead>
		<th class="text-center">Salón</th>
		<th class="text-center"><span class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="Agendada por funcionario"></span></th>
		<th class="text-center"><span class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="Agendada por cliente"></span></th>
		<th class="text-center"><span class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="Cancelada"></span></th>
		<th class="text-center"><span class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="Recordada via SMS"></span></th>
		<th class="text-center"><span class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="Recordada via EMAIL"></span></th>
		<th class="text-center"><span class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="Confirmada telefónicamente"></span></th>
		<th class="text-center"><span class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="Reprogramada"></span></th>
		<th class="text-center"><span class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="Atendida"></span></th>
		<th class="text-center"><span class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="Inasistida"></span></th>
	</thead>
	<tbody>
		<?php
		for($i=0;$i<count($sln);$i++){
			?>
			<tr>
			<?php
			$sql0="SELECT sln.slnnombre from btysalon sln where sln.slncodigo=$sln[$i]";
			$res0=$conn->query($sql0);
			$row0=$res0->fetch_array();
			?>
			<td><?php echo $row0[0];?></td>
			<?php

			$sql="SELECT ec.esccodigo,ec.escnombre from btyestado_cita ec where ec.escestado=1";
			$res=$conn->query($sql);
			while($row=$res->fetch_array()){
				$sql2="SELECT count(nc.esccodigo) from btynovedad_cita nc
						join btycita ct on ct.citcodigo=nc.citcodigo
						where nc.esccodigo=$row[0] and ct.slncodigo=$sln[$i]
						and ct.citfecharegistro between '$desde' and '$hasta'";
				$res2=$conn->query($sql2);
				$row2=$res2->fetch_array();
				switch($row[0]){
					case 1:$col="label-info";
					break;
					case 2:$col="label-info";
					break;
					case 3:$col="label-danger";
					break;
					case 4:$col="label-primary";
					break;
					case 5:$col="label-primary";
					break;
					case 6:$col="label-primary";
					break;
					case 7:$col="label-warning";
					break;
					case 8:$col="label-success";
					break;
					case 9:$col="label-danger";
					break;
				}
					?>
					<td class="text-center"><a href="#" class="btnmodal" data-toggle="modal" data-id="<?php echo $row[0].','.$sln[$i];?>" data-target="#modaldetalle"><span class="label <?php echo $col;?>" style="font-size:small;" data-toggle="tooltip" data-placement="left" title="<?php echo $row[1];?>"><?php echo $row2[0]?></span></a></td>
					<?php
			}
			?>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<div id="modaldetalle" class="modal fade" tabindexditarm="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog"> 
		<div class="modal-content">
		<div class="color-line"></div>
                <div id="detallemodal"></div>
            
            <div class="modal-footer"> 
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div> 
        </div> 
    </div>
</div>
<script>
$(document).ready(function() 
    { 
        $("#treporte").tablesorter(); 
    } 
);
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
var f1='<?php echo $desde;?>';
var f2='<?php echo $hasta;?>';
$(".btnmodal").click(function(e){
    e.preventDefault();
    var datos=$(this).data('id');
    $.ajax({
        url:'reportes/modaldetcitas.php',
        type:'POST',
        data:'datos='+datos+'&f1='+f1+'&f2='+f2,
        dataType:'html',
        success:function(data){
            $("#detallemodal").html('');
            $("#detallemodal").html(data);
        }
    });
});
</script>