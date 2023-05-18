<?php 
include "../cnx_data.php";
$sercod=$_GET['idser'];
$sqlsp="SELECT sp.sercodigo,sp.procodigo, sv.sernombre,pd.pronombre,sp.spcantidad,sp.sprequierecantidad from btyservicio_producto sp
		join btyservicio sv on sp.sercodigo=sv.sercodigo
		join btyproducto pd on pd.procodigo=sp.procodigo
		where sp.sprstado=1 AND sp.sercodigo=$sercod";
if(($_GET['filtro']) && ($_GET['filtro']!='')){
	$filtro=$_GET['filtro'];
	$sqlsp.=" and pd.pronombre like '%".$filtro."%'";
}
$sqlsp.=" order by sv.sernombre";
//echo $sqlsp;
$ressp=$conn->query($sqlsp);
$canreg=mysqli_num_rows($ressp);
						$sqlfil=$sqlsp;
                        $num_total_registros2 = $canreg;
                        
                        $rowsPerPage2         = 4;
                        $pageNum2             = 1;

                        if(isset($_POST['page'])) {
                            
                            $pageNum2 = $_POST['page'];
                        }

                        $offset2        = ($pageNum2 - 1) * $rowsPerPage2;
                        $total_paginas2 = ceil($num_total_registros2 / $rowsPerPage2);
                        $sqlfil           = $sqlfil." limit $offset2, $rowsPerPage2";
                        $ressp2        = $conn->query($sqlfil);
?>

<table id="table" class="table table-hover">

	<thead>

		<th>Insumo</th>
		<th class="text-center">Cantidad</th>
		<th class="text-center">Requiere Cantidad</th>
		<th class="text-center">Accion</th>
	</thead>
	<tbody>
		<?php
		if($canreg>0){
			while($rowsp=$ressp2->fetch_array()){
			?>
			<tr>

				<td><?php echo $rowsp[3];?></td>
				<td class="text-center"><?php echo $rowsp[4];?></td>
				<td class="text-center"><?php if($rowsp[5]==0){echo 'NO';}else{echo 'SI';}?></td>
				<td class="text-center">
				 	<button class="btn btn-default btn-sm edit" data-id="<?php echo $rowsp[0].'•'.$rowsp[1].'•'.$rowsp[2].'•'.$rowsp[4].'•'.$rowsp[5];?>" data-toggle="tooltip" title="Editar" data-placement="top"><span class="fa fa-edit text-info"></span></button>
				 	<button class="btn btn-default btn-sm trash" data-id="<?php echo $rowsp[0].','.$rowsp[1];?>" data-toggle="tooltip" title="Borrar" data-placement="top"><span class="fa fa-trash text-info"></span></button>
				</td>						
			</tr>
			<?php
			}
		}else{?>
			<tr><td colspan="5" class="text-center">No hay insumos asignados</td></tr>
			<?php
		}
		?>
	</tbody>
</table>
<?php
if ($total_paginas2 > 1) {
    echo '<br><center><div class="col-lg-12"><div class="pagination">';
    echo '<ul class="pagination pull-right"></ul>';
        if ($pageNum2 != 1) {
            echo '<li><a class="paginate" onclick="paginar2('.($pageNum2-1).');" data="'.($pageNum2-1).'">Anterior</a></li>';
        }
            for ($i=1;$i<=$total_paginas2;$i++) {
                if ($pageNum2 == $i) {
                    //si muestro el índice de la página actual, no coloco enlace
                    echo '<li class="active"><a onclick="paginar2('.$i.');">'.$i.'</a></li>';
                } else if ($pageNum2 > ($i + 2) or $pageNum2 < $i - 2) {
                    //echo '<li hiddenn><a class="paginate" onclick="paginar('.$i.');" data="'.$i.'">'.$i.'</a></li>';

                } else {
                    //si el índice no corresponde con la página mostrada actualmente,
                    //coloco el enlace para ir a esa página
                    echo '<li><a class="paginate" onclick="paginar2('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                }
            }
        if ($pageNum2 != $total_paginas2) {
            echo '<li><a class="paginate" onclick="paginar2('.($pageNum2+1).');" data="'.($pageNum2+1).'">Siguiente</a></li>';    
        }
   echo '</ul>';
   echo '</div> </div></center> <br>';
}
?>



<script>
$(document).ready(function() {
	$("#titulo").append('<?php echo $rowsp[2];?>');
});
$(".edit").click(function(e) {
	var ext=$(this).data('id');
	var datos = ext.split('•');
	var ser=datos[0];
	var pro=datos[1];
	var sernom=datos[2];
	var can=datos[3];
	var req=datos[4];
	if(req==1){
		$("#reqcantedt").prop('checked', true).change();
		$("#cantedt").attr('disabled','disabled');
	}else{
		$("#reqcantedt").prop('checked', false).change();
		$("#cantedt").removeAttr('disabled','disabled');
	}
	$("#nomser").val(sernom);
	$("#selseredt").val(ser);
	$("#selproedt").select2("val", pro);
	$("#oldpro").val(pro);
	$("#cantedt").val(can);
	$("#modaleditserpro").modal('show');
});


$(".trash").click(function(e){
	var fila=$(this);
	var ext=$(this).data('id');
	var datos = ext.split(',');
	var ser=datos[0];
	var pro=datos[1];
	swal({
        title: "¿Eliminar registro?",
        text: "Esta acción eliminará el registro permanentemente."+"\n"+" Esta acción NO puede deshacerse, desea continuar?",
        type: "warning",
        confirmButtonText: "Aceptar",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, Cancelar"
      },function(){  
        $.ajax({
            url:'serprooper.php',
            type:'POST',
            dataType:'html',
            data:'opc=del&ser='+ser+'&pro='+pro,
            success:function(res){
                if(res=='true'){
                     fila.closest('tr').remove();
                }else{
                    swal('ERROR','Ha ocurrido un error inesperado, por favor recargue la página e intentelo nuevamente.','error');
                }
            }
        });                        
    });
});
</script>
