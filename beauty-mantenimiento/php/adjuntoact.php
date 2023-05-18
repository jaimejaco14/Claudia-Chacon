<?php
$actcod=$_POST['id'];
include '../../cnx_data.php';
?>
<table class="table table-bordered">
    <tr>
        <th class="text-center">Tipo Adjunto</th>
        <th class="text-center">Nombre</th>
        <th class="text-center">Descripción</th>
        <th class="text-center">Opciones</th>
    </tr>
        <?php
        $sqlda="SELECT t.tadnombre,a.adjnombre,a.adjdescricpcion,a.actcodigo,a.adjarchivo,a.adjcodigo
                from btyactivo_adjunto a
                join btyactivo_tipoadjunto t on t.tadcodigo=a.tadcodigo
                where a.actcodigo=$actcod";
        $resda=$conn->query($sqlda);
        if(mysqli_num_rows($resda)>0){
            while($rowda=$resda->fetch_array()){
            ?>
            <tr>
                <td><?php echo $rowda['tadnombre'];?></td>
                <td><?php echo $rowda['adjnombre'];?></td>
                <td><?php echo $rowda['adjdescricpcion'];?></td>
                <td class="text-center">
                    <button id="" data-toggle="tooltip" data-placement="top" title="Ver Adjunto" class="btn btn-info btn-xs verdoc" data-act="<?php echo $rowda['actcodigo']?>" data-file="<?php echo $rowda['adjarchivo']?>"><span class="fa fa-eye"></span></button>
                    <!-- <button id="" data-toggle="tooltip" data-placement="top" title="Editar Adjunto" class="btn btn-info btn-xs edtdoc" data-id="<?php echo $rowda[0]?>"><span class="fa fa-edit"></span></button> -->
                    <button id="" data-toggle="tooltip" data-placement="top" title="Eliminar Adjunto" class="btn btn-danger btn-xs deldoc" data-adj="<?php echo $rowda['adjcodigo']?>"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
            <?php
            }
        }else{
            ?>
            <tr>
            <td colspan="4" class="text-center">No hay archivos adjuntos</td>
            </tr>
            <?php
        }
        ?>
</table>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
$(".verdoc").click(function(e){
    e.preventDefault();
    var file=$(this).data('file');
    var act=$(this).data('act');
    window.open('../contenidos/activos/'+act+'/'+file);
});

$(".edtdoc").click(function(e){
    e.preventDefault();
    var numdoc=$(this).data('id');
    $.ajax({
        url:'php/operadjuntoact.php',
        type:'POST',
        dataType:'html',
        data:'opc=upd&numdoc='+numdoc,
        success:function(res){
        	var data=JSON.parse(res);
            $("#seltidoc2").val(data.tipo);
            $("#txtobserv2").val(data.obs);
            $("#daccol").val(data.numdoc);
    		$("#modal_newdoc2").modal('show');
        }
    });
});

$(".deldoc").click(function(e){
    e.preventDefault();
	var fila=$(this);
    var adj=$(this).data('adj');
    /****************************************************************/
    swal({
        title: "¿Eliminar Adjunto?",
        text: "Esta acción eliminará el adjunto permanentemente."+"\n"+" Esta acción NO puede deshacerse, desea continuar?",
        type: "warning",
        confirmButtonText: "Aceptar",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, Cancelar"
      },function(){  
        $.ajax({
            url:'php/operadjuntoact.php',
            type:'POST',
            dataType:'html',
            data:'opc=del&adj='+adj,
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