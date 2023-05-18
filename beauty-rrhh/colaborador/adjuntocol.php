<?php
include '../../cnx_data.php';
$codigo_colaborador=$_POST['id'];
?>
<table class="table">
    <tr>
        <th>Tipo documento</th>
        <th>Descripcion</th>
        <th>Comentarios</th>
        <th>Fecha/Hora adjunto</th>
        <th>Accion</th>
    </tr>
        <?php
        $sqlda="SELECT dac.daccodigo,tac.tacnombre,tac.tacdescripcion,dac.dacobseracion, concat(dac.dacfecharegistro,' - ',dac.dachoraregistro)
                FROM btydocumento_adjunto_colaborador dac 
                natural join btytipo_adjunto_colaborador tac
                WHERE dac.clbcodigo=$codigo_colaborador AND dac.dacestado=1";
        $resda=$conn->query($sqlda);
        if(mysqli_num_rows($resda)>0){
            while($rowda=$resda->fetch_array()){
            ?>
            <tr>
                <td><?php echo $rowda[1];?></td>
                <td><?php echo $rowda[2];?></td>
                <td><?php echo $rowda[3];?></td>
                <td class="text-center"><?php echo $rowda[4];?></td>
                <td class="text-center">
                    <button id="" data-toggle="tooltip" data-placement="top" title="Ver Documento" class="btn btn-info btn-xs verdoc" data-id="<?php echo $rowda[0]?>"><span class="fa fa-eye"></span></button>
                    <button id="" data-toggle="tooltip" data-placement="top" title="Editar Documento" class="btn btn-info btn-xs edtdoc" data-id="<?php echo $rowda[0]?>"><span class="fa fa-edit"></span></button>
                    <button id="" data-toggle="tooltip" data-placement="top" title="Eliminar Documento" class="btn btn-danger btn-xs deldoc" data-id="<?php echo $rowda[0]?>"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
            <?php
            }
        }else{
            ?>
            <tr>
            <td colspan="5">No hay datos para mostrar</td>
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
    var numdoc=$(this).data('id');
    window.open('../../contenidos/documentos_colaborador/'+numdoc+'.pdf?'+Math.floor((Math.random() * 1000) + 1));
});

$(".edtdoc").click(function(e){
    var numdoc=$(this).data('id');
    $.ajax({
        url:'operadjuntocol.php',
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
	var fila=$(this);
    var numdoc=$(this).data('id');
    /****************************************************************/
    swal({
        title: "¿Eliminar documento?",
        text: "Esta acción eliminará el documento permanentemente."+"\n"+" Esta acción NO puede deshacerse, desea continuar?",
        type: "warning",
        confirmButtonText: "Aceptar",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, Cancelar"
      },function(){  
        $.ajax({
            url:'operadjuntocol.php',
            type:'POST',
            dataType:'html',
            data:'opc=del&numdoc='+numdoc,
            success:function(res){
                if(res=='true'){
                     fila.closest('tr').remove();
                }else{
                    swal('ERROR','Ha ocurrido un error inesperado, por favor recargue la página e intentelo nuevamente.','error');
                }
            }
        });                        
      });
    /****************************************************************/
    /*$.ajax({
        url:'operadjuntocol.php',
        type:'POST',
        dataType:'html',
        data:'opc=del&numdoc='+numdoc,
        success:function(res){
            if(res=='true'){
            	 fila.closest('tr').remove();
            }else{
            	swal('ERROR','Ha ocurrido un error inesperado, por favor recargue la página e intentelo nuevamente.','error');
            }
        }
    });
*/
});
</script>