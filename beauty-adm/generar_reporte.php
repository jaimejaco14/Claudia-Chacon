<?php
//include("conexion.php");
include("php/funciones.php");
$mes=$_POST['mes'];
$salon=$_POST['salon'];

$cal="SELECT distinct(pc.prgfecha) as fecha 
		from btyprogramacion_colaboradores pc 
		where month(pc.prgfecha)=$mes 
		and pc.prgfecha<=(SELECT max(ab.abmfecha) from btyasistencia_biometrico ab where month(ab.abmfecha)=$mes)
		order by pc.prgfecha asc";

$rowcal=$conn->query($cal);

while($dia=$rowcal->fetch_array()){//cada dia del mes 

	$querycol="SELECT distinct(pc.clbcodigo) as col from btyprogramacion_colaboradores pc where pc.slncodigo=$salon and month(pc.prgfecha)=$mes";
	$rowcol=$conn->query($querycol);

	while($col=$rowcol->fetch_array()){

		$sql="SELECT col.clbcodigo,tn.trncodigo,col.horcodigo,ab.slncodigo, col.prgfecha,ab.abmcodigo, 
			(case
			when (time_to_Sec(subtime(tn.trndesde,ab.abmhora))<-(ap.abmingresodespues*60)) then '2'
			when (time_to_Sec(subtime(tn.trndesde,ab.abmhora))>(ap.abmingresoantes*60)) then '1'
			when col.tprcodigo <> 1 then '5'
			else '1'
			end ) as res
			FROM btyasistencia_parametros ap
			JOIN btyprogramacion_colaboradores col 
			JOIN btyturno tn ON col.trncodigo=tn.trncodigo
			JOIN btyasistencia_biometrico ab ON col.clbcodigo=ab.clbcodigo and col.prgfecha=ab.abmfecha
			where col.prgfecha='$dia[0]' and ab.abmnuevotipo='ENTRADA' and ab.slncodigo='$salon' and ab.clbcodigo=$col[0]
			and ab.abmcodigo NOT IN(
                            SELECT n1.abmcodigo
                            FROM btyasistencia_biometrico n1, btyasistencia_biometrico n2
                            WHERE n1.clbcodigo = n2.clbcodigo 
                            AND n1.abmnuevotipo=n2.abmnuevotipo 
                            AND n1.abmfecha=n2.abmfecha 
                            AND n1.abmhora > n2.abmhora 
                            AND n1.abmnuevotipo='ENTRADA' AND n1.slncodigo=$salon)
			UNION
			(SELECT col.clbcodigo,tn.trncodigo,col.horcodigo,ab.slncodigo, col.prgfecha,ab.abmcodigo, 
			(case
			when (time_to_Sec(subtime(ab.abmhora,tn.trnhasta))<-(ap.abmsalidaantes*60)) then '3'
			when (time_to_Sec(subtime(ab.abmhora,tn.trnhasta))>(ap.abmsalidadespues*60)) then '1'
			when col.tprcodigo <> 1 then '5'
			else '1'
			end ) as res
			FROM btyasistencia_parametros ap
			JOIN btyprogramacion_colaboradores col 
			JOIN btyturno tn ON col.trncodigo=tn.trncodigo
			JOIN btyasistencia_biometrico ab ON col.clbcodigo=ab.clbcodigo and col.prgfecha=ab.abmfecha
			where col.prgfecha='$dia[0]' and ab.abmnuevotipo='SALIDA' and ab.slncodigo='$salon' and ab.clbcodigo=$col[0]
			and ab.abmcodigo NOT IN(
                            SELECT n1.abmcodigo
                            FROM btyasistencia_biometrico n1, btyasistencia_biometrico n2
                            WHERE n1.clbcodigo = n2.clbcodigo 
                            AND n1.abmnuevotipo=n2.abmnuevotipo 
                            AND n1.abmfecha=n2.abmfecha 
                            AND n1.abmhora < n2.abmhora 
                            AND n1.abmnuevotipo='SALIDA' AND n1.slncodigo=$salon))";

		$row=$conn->query($sql);
		$cont=mysqli_num_rows($row);
		//echo $cont;
		if($cont==0)
		{
			$prog="SELECT * FROM btyprogramacion_colaboradores WHERE clbcodigo=$col[0] AND slncodigo=$salon AND prgfecha='$dia[0]' and tprcodigo=1";
			$resp=$conn->query($prog);
			$cont2=mysqli_num_rows($resp);
			if($cont2>0){
				$progrow=$resp->fetch_array();
				$funpro1=procesarbiometrico($progrow[0],$progrow[1],$progrow[2],$progrow[3],$dia[0],'null',4,$conn);
				//echo $funpro;
				if($funpro1=='ok'){
					$ins1="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo) 
							VALUES($progrow[0],$progrow[1],$progrow[2],$progrow[3],'$dia[0]',null,4)";
					//echo $ins1;
					$conn->query($ins1);
				}
			}
			else
			{
				// no tiene registro biometrico ni programacion
			}
		}
		else if($cont==2)
		{
			while($proc=$row->fetch_array()){
				$funpro2=procesarbiometrico($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$proc[6],$conn);
				//echo $funpro;
				if($funpro2=='no')
				{
					//$ins2="UPDATE btyasistencia_procesada SET trncodigo=$proc[1],horcodigo=$proc[2],slncodigo=$proc[3],aptcodigo=$proc[6] WHERE clbcodigo=$proc[0] AND prgfecha='$proc[4]' AND abmcodigo=$proc[5]";
				}
				else
				{
					$ins2="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo) VALUES($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',$proc[5],$proc[6])";
				}

				$conn->query($ins2);
				//echo $ins;
			}
		}
		else if($cont==1)
		{
			while($proc=$row->fetch_array()){
				$funpro3=procesarbiometrico($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$proc[6],$conn);
				//echo $funpro3;
				if($funpro3=='no')
				{
					//$ins3="UPDATE btyasistencia_procesada SET trncodigo=$proc[1],horcodigo=$proc[2],slncodigo=$proc[3],aptcodigo=$proc[6] WHERE clbcodigo=$proc[0] AND prgfecha='$proc[4]' AND abmcodigo=$proc[5]";
				}
				else
				{
					$ins3="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo) VALUES($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',$proc[5],$proc[6]),($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',null,6)";
				}

				$conn->query($ins3);
				//echo $ins3;
			}
		}
		
	}
}




/*******************************************************************************************************************************/
$sql0="SELECT distinct(ab.clbcodigo), t.trcrazonsocial, cg.crgnombre
		from btyasistencia_procesada ab
		join btycolaborador c on c.clbcodigo=ab.clbcodigo
		join btytercero t on t.trcdocumento=c.trcdocumento
		join btycargo cg on cg.crgcodigo=c.crgcodigo
		where month(ab.prgfecha)='$mes' and ab.slncodigo='$salon'
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
<table class="table table-hover table-fixed tablesorter" id="listado">
	<thead style="cursor: pointer;" id="tablehead">
		<tr>
			<th class="text-center col-xs-3 colnombre" data-toggle="tooltip" data-placement="top" title="Click para ordenar"><span class="fa fa-sort"></span> Nombre colaborador</th>
			<th class="text-center col-xs-2 coldatos" data-toggle="tooltip" data-placement="top" title="Click para ordenar"><span class="fa fa-sort"></span> Llegadas tarde</th>
			<th class="text-center col-xs-2 coldatos" data-toggle="tooltip" data-placement="top" title="Click para ordenar"><span class="fa fa-sort"></span> Salidas temprano</th>
			<th class="text-center col-xs-2 coldatos" data-toggle="tooltip" data-placement="top" title="Click para ordenar"><span class="fa fa-sort"></span> Ausencias</th>
			<th class="text-center col-xs-2 coldatos" data-toggle="tooltip" data-placement="top" title="Click para ordenar"><span class="fa fa-sort"></span> Incompletos</th>
			<th class="text-center col-xs-1 coldatos" data-toggle="tooltip" data-placement="top" title="Click para ordenar"><span class="fa fa-sort"></span> Errores</th>
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
						AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." 
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']." 
						and ap.aptcodigo = 3
						AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." 
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 4
						AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." 
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 6
						AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." 
						union
						select null,count(*) from btyasistencia_biometrico ab 
						where ab.abmerroneo=1 and ab.clbcodigo=".$row['clbcodigo']." 
						AND ab.slncodigo=".$salon." AND MONTH(ab.abmfecha)=".$mes;

				$res3=$conn->query($sql3);
				$detalle="";
				while($deta=$res3->fetch_array()){
					$detalle.=$deta[1].",";
				}
				$det=explode(',',$detalle);
				?>
				<tr>
					<td class="col-xs-3 nombrecol"><?php echo utf8_encode($row['trcrazonsocial'])." (".$row['crgnombre'].")";?></td>
					<td class="text-center col-xs-2">
						<a href="#" class="btntarde" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle" ><span class="label label-success tddatos" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Click para ver detalles"><?php if($det[0]==''){echo "0";}else{echo $det[0];}?></span></a>
					</td>
					<td class="text-center col-xs-2">
						<a href="#" class="btntemprano" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-info" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Click para ver detalles"><?php if($det[1]==''){echo "0";}else{echo $det[1];}?></span></a>
					</td>
					<td class="text-center col-xs-2">
						<a href="#" class="btnausencia" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-primary" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Click para ver detalles"><?php if($det[2]==''){echo "0";}else{echo $det[2];}?></span></a>
					</td>
					<td class="text-center col-xs-2">
						<a href="#" class="btnnomark" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-warning" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Click para ver detalles"><?php if($det[3]==''){echo "0";}else{echo $det[3];}?></span></a>
					</td>
					<td class="text-center col-xs-1">
						<a href="#" class="btnerror" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-danger" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Click para ver detalles"><?php if($det[4]==''){echo "0";}else{echo $det[4];}?></span></a>
					</td>
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
    <div class="modal-dialog modal-lg"> 
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
$("#tablehead").click(function(e){
	$('[data-toggle="tooltip"]').tooltip('hide')
});
$(document).ready(function() 
    { 
        $("#listado").tablesorter(); 
    } 
);
$(".btntarde").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=1&mes=<?php echo $mes;?>',
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
        url:'modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=2&mes=<?php echo $mes;?>',
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
        url:'modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=3&mes=<?php echo $mes;?>',
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-clock-o text-warning"></i> REGISTROS NO MARCADOS');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
            $("#col3").hide();
           	$(".colth").removeClass('col-xs-2').addClass('col-xs-3');
           	$(".coltd").removeClass('col-xs-2').addClass('col-xs-3');
        }

    });
});
$(".btnausencia").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=4&mes=<?php echo $mes;?>',
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-user-times text-primary"></i> AUSENCIAS');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
            $("#col2").hide();
            $("#col3").hide();
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
        url:'modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=5&mes=<?php echo $mes;?>',
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-times-circle text-danger"></i> USO INCORRECTO DEL BIOMÉTRICO');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
        }

    });
});
function nombre(este){
	var nombrecol=" • ";
    nombrecol+=$(este).parents("tr").find(".nombrecol").html();
	return nombrecol;
}

</script>