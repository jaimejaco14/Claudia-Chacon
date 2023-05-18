<?php
include '../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'cons':
		$nom=$_POST['nompru'];
		$id=$_POST['id'];
		$sql="SELECT * from btycodigobarras where procodigo=$id and cbrestado=1";
		$res=$conn->query($sql);
		$cn=mysqli_num_rows($res);
		if($cn>0){
			?>
			<table class="table table-hover">
			<tr><th colspan="3"><?php echo $nom;?></th></tr>
			<tr>
				<th>Código</th>
				<th>Agregado</th>
				<th>Acción</th>
			</tr>
			<?php
			while($row=$res->fetch_array()){
		?>
				<tr>
					<td><?php echo $row[1]?></td>
					<td><?php echo $row[2];?></td>
					<td><button class="btn btn-danger delete" data-id="<?php echo $id.','.$row[1]?>"><span class="fa fa-remove"></span></button></td>
				</tr>
		<?php
			}
			?>
			</table>
			<script>
			$(".delete").click(function(e){
				var fila=$(this);
			  	var datos=$(this).data('id');
			    var exploded=datos.split(',');
			    var id=exploded[0];
			    var barcode=exploded[1];
			    $.ajax({
			        url:'detbarcode.php',
			        type:'POST',
			        data:'id='+id+'&barcode='+barcode+'&opc=del',
			        dataType:'html',
			        success:function(res){
			            if(res=='true'){
			                fila.closest('tr').remove();
			            }else{
			            	swal('Error','Ha ocurrido un error, recargue la página e intentelo nuevamente.','error');
			            }
			        }
			    });
			});
			</script>
			<?php
		}else{
			echo 'No hay datos para mostrar';
		}
		?>
		<input type="hidden" id="idprod" value="<?php echo $id;?>">
		<input type="hidden" id="nomproducto" value="<?php echo $nom;?>">
		<?php
	break;

	case 'ins':
		$id=$_POST['id'];
		$barcode=$_POST['barcode'];
		$sqlseek="SELECT cb.*,pd.pronombre from btycodigobarras cb 
					natural join btyproducto pd
					where cb.cbrcodigo=$barcode";
		$ressk=$conn->query($sqlseek);
		if(mysqli_num_rows($ressk)>0){
			$rowsk=$ressk->fetch_array();
			if($rowsk[3]==0 && $rowsk[0]==$id){
				echo json_encode(array('res'=>'des','id'=>$id,'cobar'=>$rowsk[1]));
			}else if($rowsk[3]==0 && $rowsk[0]!=$id){
				echo json_encode(array('res'=>'des2','prod'=>$rowsk[4]));
			}else if($rowsk[3]==1){
				echo json_encode(array('res'=>'dup'));
			}
		}else{
			$sqlins="INSERT INTO btycodigobarras (procodigo,cbrcodigo,cbrfecha,cbrestado) VALUES ($id,$barcode,curdate(),1)";
			$res=$conn->query($sqlins);
			if($res){
				echo json_encode(array('res'=>'true'));
			}else{
				echo json_encode(array('res'=>'false'));
			}
		}
	break;

	case 'del':
		$id=$_POST['id'];
		$barcode=$_POST['barcode'];
		$sqldel="UPDATE btycodigobarras set cbrestado=0 where procodigo=$id and cbrcodigo=$barcode";
		if($conn->query($sqldel)){
			echo 'true';	
		}else{
			echo 'false';
		}
	break;

	case 'rea':
		$id=$_POST['id'];
		$barcode=$_POST['cobar'];
		$sqldel="UPDATE btycodigobarras set cbrestado=1 where procodigo=$id and cbrcodigo=$barcode";
		if($conn->query($sqldel)){
			echo 'true';	
		}else{
			echo 'false';
		}
	break;
}
?>