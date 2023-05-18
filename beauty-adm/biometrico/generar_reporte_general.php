<?php
include '../../cnx_data.php';
include("../php/funciones.php");
$fecha1=$_POST['f1'];
$fecha2=$_POST['f2'];
$cg=$_POST['cg'];
if($cg!=0){
    $cargo=" and cg.crgcodigo IN ($cg)";
}else{
    $cargo="";
}
$sln='';
if($_POST['sln']){
    $sln=" and sl.slncodigo=".$_POST['sln']." ";
}

$sql0="SELECT distinct(ab.clbcodigo), t.trcrazonsocial, cg.crgnombre,sl.slnnombre
        from btyasistencia_procesada ab
        join btycolaborador c on c.clbcodigo=ab.clbcodigo
        join btytercero t on t.trcdocumento=c.trcdocumento
        join btycargo cg on cg.crgcodigo=c.crgcodigo
        join btysalon_base_colaborador sbc on sbc.slncodigo=ab.slncodigo
        join btysalon sl on sl.slncodigo=sbc.slncodigo
        where ab.prgfecha between '$fecha1' and '$fecha2' ".$sln.$cargo."
        order by t.trcrazonsocial asc";
$res=$conn->query($sql0);
?>
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
<br><br>
<table class="table table-hover  tablesorter" id="listado">
    <thead style="cursor: pointer;" id="tablehead">
        <tr>
            <th class="text-center col-xs-4 colnombre">Colaborador</th>
            <th class="text-center">Salón Base</th>
            <th class="text-center  coldatos" data-toggle="tooltip" data-placement="top" data-container="body" title="Llegada tarde"><span class="fa fa-sort"></span></th>
            <th class="text-center  coldatos" data-toggle="tooltip" data-placement="top" data-container="body" title="Salida temprano"><span class="fa fa-sort"></span></th>
            <th class="text-center  coldatos" data-toggle="tooltip" data-placement="top" data-container="body" title="Ausencia"><span class="fa fa-sort"></span></th>
            <th class="text-center  coldatos" data-toggle="tooltip" data-placement="top" data-container="body" title="Registro Incompleto"><span class="fa fa-sort"></span></th>
            <th class="text-center  coldatos" data-toggle="tooltip" data-placement="top" data-container="body" title="Presencia no programada"><span class="fa fa-sort"></span></th>
            <th class="text-center  coldatos" data-toggle="tooltip" data-placement="top" data-container="body" title="Errores"><span class="fa fa-sort"></span></th>
            <th class="text-center  coldatos" data-toggle="tooltip" data-placement="top" data-container="body" title="Valor">Valor</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $numrow=mysqli_num_rows($res);
    if($numrow>0){
        while($row=$res->fetch_assoc()){
                $sql3="SELECT apt.aptnombre,count(ap.aptcodigo) as cantidad
                        from btyasistencia_procesada ap 
                        join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
                        where ap.clbcodigo=".$row['clbcodigo']." 
                        and ap.aptcodigo = 2
                        AND ap.prgfecha between '$fecha1' and '$fecha2'
                        union
                        select apt.aptnombre,count(ap.aptcodigo) as cantidad
                        from btyasistencia_procesada ap 
                        join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
                        where ap.clbcodigo=".$row['clbcodigo']." 
                        and ap.aptcodigo = 3
                        AND ap.prgfecha between '$fecha1' and '$fecha2'
                        union
                        select apt.aptnombre,count(ap.aptcodigo) as cantidad
                        from btyasistencia_procesada ap 
                        join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
                        where ap.clbcodigo=".$row['clbcodigo']."
                        and ap.aptcodigo = 4
                        AND ap.prgfecha between '$fecha1' and '$fecha2'
                        union
                        select apt.aptnombre,count(ap.aptcodigo) as cantidad
                        from btyasistencia_procesada ap 
                        join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
                        where ap.clbcodigo=".$row['clbcodigo']."
                        and ap.aptcodigo = 6
                        AND ap.prgfecha between '$fecha1' and '$fecha2'
                        union
                        select apt.aptnombre,count(DISTINCT(ap.prgfecha)) as cantidad
                        from btyasistencia_procesada ap 
                        join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
                        where ap.clbcodigo=".$row['clbcodigo']."
                        and ap.aptcodigo = 5
                        AND ap.prgfecha between '$fecha1' and '$fecha2'
                        union
                        select 'ERRORES',count(*) from btyasistencia_biometrico ab 
                        where ab.abmerroneo=1 and ab.clbcodigo=".$row['clbcodigo']." 
                        AND ab.abmfecha between '$fecha1' and '$fecha2'
                        union
                        SELECT 'VALOR',concat('$',format(sum(ap.apcvalorizacion),0))
                        FROM btyasistencia_procesada ap
                        WHERE ap.clbcodigo=".$row['clbcodigo']." AND ap.prgfecha BETWEEN '$fecha1' and '$fecha2'";

                $res3=$conn->query($sql3);
                $detalle="";
                while($deta=$res3->fetch_array()){
                    $detalle.=$deta[1]."•";
                }
                $det=explode('•',$detalle);
                ?>
                <tr>
                    <td class="col-xs-4 nombrecol"><?php echo utf8_encode($row['trcrazonsocial'])." (".$row['crgnombre'].")";?></td>
                    <td class="text-center"><?php echo $row['slnnombre']?></td>
                    <td class="text-center">
                        <a href="#" class="btntarde" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle" ><span class="label label-success tddatos" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Llegadas tarde"><?php if($det[0]==''){echo "0";}else{echo $det[0];}?></span></a>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btntemprano" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-info" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Salidas temprano"><?php if($det[1]==''){echo "0";}else{echo $det[1];}?></span></a>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btnausencia" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-primary" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Ausencias"><?php if($det[2]==''){echo "0";}else{echo $det[2];}?></span></a>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btnnomark" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-warning" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Registros Incompletos"><?php if($det[3]==''){echo "0";}else{echo $det[3];}?></span></a>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btnnoprog" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-danger" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Presencia NO programada"><?php if($det[4]==''){echo "0";}else{echo $det[4];}?></span></a>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btnerror" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-danger" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Registros erroneos"><?php if($det[5]==''){echo "0";}else{echo $det[5];}?></span></a>
                    </td>
                    <td class="text-center" data-toggle="tooltip" data-placement="left" title="Total valor faltas"><?php if($det[6]==''){echo "0";}else{echo $det[6];}?></td>
                </tr>
                <?php

        }
    }else{
        ?>
        <tr><td colspan="6" class="text-center col-xs-12">No hay datos para mostrar</td></tr>
        <?php
    }
    ?>
    </tbody>
</table>
<div id="modaldetalle" class="modal fade" tabindexditarm="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 80% !important;"> 
        <div class="modal-content"> 

            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h5 class="modal-title" id="titulomodal"></h5> 
                <h5 id="colab"></h5> 
            </div> 
            <div class="modal-body">
                <div id="detallemodal"></div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div> 
        </div> 
    </div>
</div>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
/*$("#tablehead").click(function(e){
    $('[data-toggle="tooltip"]').tooltip('hide')
});*/
$(document).ready(function() 
    { 
        $("#listado").tablesorter(); 
    } 
);
var f1='<?php echo $fecha1;?>';
var f2='<?php echo $fecha2;?>';
$(".btntarde").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistenciageneral.php',
        type:'GET',
        data:'id='+id+'&opc=1&f1='+f1+'&f2='+f2,
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-sign-in text-success"></i> LLEGADAS TARDE');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
        }

    });
});
$(".btntemprano").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistenciageneral.php',
        type:'GET',
        data:'id='+id+'&opc=2&f1='+f1+'&f2='+f2,
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-sign-out text-info"></i> SALIDAS ANTES DE TIEMPO');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
        }

    });
});
$(".btnnomark").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistenciageneral.php',
        type:'GET',
        data:'id='+id+'&opc=3&f1='+f1+'&f2='+f2,
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-clock-o text-warning"></i> REGISTROS INCOMPLETOS');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
            $(".col2").removeClass('col-xs-2').addClass('col-xs-4');
        }

    });
});
$(".btnausencia").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistenciageneral.php',
        type:'GET',
        data:'id='+id+'&opc=4&f1='+f1+'&f2='+f2,
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-user-times text-primary"></i> AUSENCIAS');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
            $("#col3").hide();
            $("#col4").hide();
            $("#col5").hide();
            $(".colth").removeClass('col-xs-2').addClass('col-xs-4');
            $(".coltd").removeClass('col-xs-2').addClass('col-xs-4');
        }

    });
});
$(".btnerror").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistenciageneral.php',
        type:'GET',
        data:'id='+id+'&opc=5&f1='+f1+'&f2='+f2,
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-times-circle text-danger"></i> USO INCORRECTO DEL BIOMÉTRICO');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
        }

    });
});
$(".btnnoprog").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistenciageneral.php',
        type:'GET',
        data:'id='+id+'&opc=6&f1='+f1+'&f2='+f2,
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-times-circle text-danger"></i> PRESENCIA NO PROGRAMADA');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
            $("#col3").hide();
            $("#col4").hide();
            $("#col5").hide();
            $(".colth").removeClass('col-xs-2').addClass('col-xs-4');
            $(".coltd").removeClass('col-xs-2').addClass('col-xs-4');
        }

    });
});
function nombre(este){
    var nombrecol=" • ";
    nombrecol+=$(este).parents("tr").find(".nombrecol").html();
    return nombrecol;
}

</script>