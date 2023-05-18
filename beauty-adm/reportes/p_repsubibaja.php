<?php
include '../../cnx_data.php';
$desde=$_POST['f1'];
$hasta=$_POST['f2'];
if($_POST['sln']!='null'){
	$salon=$_POST['sln'];
}else{
	$consln0="SELECT group_concat(slncodigo order by slnnombre) from btysalon";
	$res0=$conn->query($consln0);
	$row0=$res0->fetch_array();
	$salon=$row0[0];
}

$sln=explode(',',$salon);
$sqlsln="SELECT group_concat(slnnombre order by slnnombre) from btysalon where slncodigo in($salon)";
$ressln=$conn->query($sqlsln);
$rowsln=$ressln->fetch_array();
$txtsln=explode(',' , $rowsln[0]);
?>
<table class="table table-hover tablesorter" id="treporte">
	<thead>
		<th class="text-center">Salón</th>
		<th class="text-center"><span class="fa fa-sort"></span> GESTIONADOS</th>
		<th class="text-center"><span class="fa fa-sort"></span> CERRADOS</th>
		<th class="text-center"><span class="fa fa-sort"></span> ABIERTOS</th>
	</thead>
	<tbody>
	<?php 
	for($i=0;$i<count($sln);$i++){
		$sql1="SELECT 'abi',count(*) from btyturnos_atencion ta
				where ta.slncodigo=$sln[$i]
				and ta.tuafechai between '$desde' and '$hasta' 
				union
				select 'cerr',count(*) from btyturnos_atencion ta
				where ta.slncodigo=$sln[$i]
				and ta.tuafechai between '$desde' and '$hasta' and ta.tuahorai <> ta.tuahoraf
				union
				select 'nocerr',count(*) from btyturnos_atencion ta
				where ta.slncodigo=$sln[$i]
				and ta.tuafechai between '$desde' and '$hasta' and ta.tuahorai = ta.tuahoraf";
		$res1=$conn->query($sql1);
		?>
		<tr>
		<td><?php echo $txtsln[$i];?></td>
			<?php
			$j=0;
			while($row1=$res1->fetch_array()){
				switch($j){
					case 0:$col="label label-primary"; $msj="GESTIONADOS";
					break;
					case 1:$col="label label-warning"; $msj="CERRADOS";
					break;
					case 2:$col="label label-danger"; $msj="ABIERTOS";
					break;
				}
				?>
				<td class="text-center">
					<a href="#" class="btnmodal" data-toggle="modal" data-id="<?php echo $sln[$i].','.$j;?>" data-target="#modaldetalle"><span class="<?php echo $col;?>" style="font-size:medium;" data-toggle="tooltip" data-placement="left" title="<?php echo $msj?>"><?php echo $row1[1];?></span></a>
				</td>
				<?php
				$j++;
			}
			?>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>
<div id="modaldetalle" class="modal fade" tabindexditarm="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 80% !important;"> 
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
        url:'reportes/modaldetsubibaja.php',
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