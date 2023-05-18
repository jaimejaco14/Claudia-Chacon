<?php
include '../../cnx_data.php';
$id=$_GET['id'];
$oper=$_GET['opc'];
$fecha1=$_GET['f1'];
$fecha2=$_GET['f2'];
$col0="";
$col1="";
$col2="";
$col3="";
$col4="";
$col5="";
$head1="<thead>
	<tr>
		<th class='text-center col-xs-2 colth' id='col0'>FECHA</th>
		<th class='text-center col-xs-2 colth' id='col1'>HORARIO</th>
		<th class='text-center col-xs-2 colth' id='col2'>SALON</th>
		<th class='text-center col-xs-2 colth' id='col3'>REGISTRO</th>
		<th class='text-center col-xs-2 colth' id='col4'>HORA REGISTRO</th>
		<th class='text-center col-xs-2 colth' id='col5'>DIFERENCIA</th>
		<th class='text-center col-xs-2 colth' id='col6'>RESULTADO</th>
		<th class='text-center col-xs-2 colth' id='col7'>VALOR</th>
		<th class='text-center col-xs-2 colth' id='col8'>OBSERVACIONES</th>
	</tr>
</thead>";
$head2="<thead>
	<tr>
		<th class='text-center col-xs-2 colth'>FECHA</th>
		<th class='text-center col-xs-2 colth'>HORA </th>
		<th class='text-center col-xs-2 colth'>SALON</th>
		<th class='text-center col-xs-2 colth'>REGISTRADO COMO</th>
		<th class='text-center col-xs-2 colth'>CORREGIDO</th>
		<th class='text-center col-xs-2 colth'>TIPO DE ERROR</th>
	</tr>
</thead>";
$head3="<thead>
	<tr>
		<th class='text-center col-xs-2 colth'>FECHA</th>
		<th class='text-center col-xs-2 colth'>SALON</th>
		<th class='text-center col-xs-2 colth'>RESULTADO</th>
	</tr>
</thead>";
$head4="<thead>
	<tr>
		<th class='text-center col-xs-2 colth' id='col0'>FECHA</th>
		<th class='text-center col-xs-2 colth' id='col1'>HORARIO</th>
		<th class='text-center col-xs-4 colth' id='col2'>SALON</th>
		<th class='text-center col-xs-2 colth' id='col3'>REGISTRO</th>
		<th class='text-center col-xs-2 colth' id='col4'>RESULTADO</th>
		<th class='text-center col-xs-2 colth' id='col6'>VALOR</th>
		<th class='text-center col-xs-2 colth' id='col7'>OBSERVACIONES</th>
	</tr>
</thead>";


switch($oper){
	case 1:
	//llegadas tarde
	$oper2=2;
		$head=$head1;
		$sql="SELECT ap.prgfecha, tn.trndesde,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, subtime(ab.abmhora,tn.trndesde), apt.aptnombre,concat('$',format(ap.apcvalorizacion,0)),ap.apcobservacion
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				join btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha between '$fecha1' and '$fecha2' AND ap.clbcodigo=$id AND ab.abmnuevotipo='ENTRADA' AND apt.aptcodigo=2 order by ap.prgfecha asc";
	break;
	case 2:
	//salidas temprano
	$oper2=3;
		$head=$head1;
		$sql="SELECT ap.prgfecha, tn.trnhasta,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, subtime(tn.trnhasta,ab.abmhora), apt.aptnombre, concat('$',format(ap.apcvalorizacion,0)),ap.apcobservacion
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				join btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha between '$fecha1' and '$fecha2' AND ap.clbcodigo=$id AND ab.abmnuevotipo='SALIDA' AND apt.aptcodigo=3 order by ap.prgfecha asc";
	break;
	case 3:
	//incompletos
	$oper2=6;
		$col4="display:none;";
		$col5="display:none;";
		$head=$head4;
		$sql="SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, IFNULL(NULL, IF((
				SELECT ab.abmnuevotipo
				FROM btyasistencia_procesada ap2
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo
				WHERE ap2.prgfecha = ap.prgfecha AND ap2.clbcodigo=ap.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA'))
				,null,null, apt.aptnombre AS estado, concat('$',format(ap.apcvalorizacion,0)),ap.apcobservacion
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				join btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha between '$fecha1' and '$fecha2' AND ap.clbcodigo=$id AND ap.abmcodigo IS NULL and ap.aptcodigo=6 order by ap.prgfecha asc";
	break;
	case 4:
	//ausencias
	$oper2=4;
		$col3="display:none;";
		$col4="display:none;";
		$col5="display:none;";
		$head=$head1;
		$sql="SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta),sl.slnnombre, null,null,null, apt.aptnombre, concat('$',format(ap.apcvalorizacion,0)),ap.apcobservacion
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				join btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha between '$fecha1' and '$fecha2' AND ap.clbcodigo=$id AND ap.abmcodigo IS NULL and ap.aptcodigo=4 order by ap.prgfecha asc";
	break;
	case 5:
	//errores
	$oper2=0;
		$head=$head2;
		$sql="SELECT ab.abmfecha,ab.abmhora,sl.slnnombre,if(ab.abmtipo='','OTRO',ab.abmtipo),ab.abmnuevotipo,ab.abmtipoerror 
				from btyasistencia_biometrico ab 
				join btysalon sl on sl.slncodigo=ab.slncodigo
				where ab.clbcodigo=$id
				and ab.abmerroneo=1
				and ab.abmfecha between '$fecha1' and '$fecha2'";
	break;
	case 6:
	//pres no prog
	$oper2=5;
		$col1="display:none;";
		$col3="display:none;";
		$col4="display:none;";
		$head=$head3;
		$sql="SELECT DISTINCT(ap.prgfecha), null,sl.slnnombre, NULL, NULL, apt.aptnombre 
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				join btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha between '$fecha1' and '$fecha2' AND ap.clbcodigo=$id AND apt.aptcodigo=5";
	break;
}

$result=$conn->query($sql);
$cont=mysqli_num_rows($result);
$sql2="SELECT concat('$',format(SUM(ap.apcvalorizacion),0))	FROM btyasistencia_procesada ap
		WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.aptcodigo=$oper2 AND ap.clbcodigo=$id";
$restotal=$conn->query($sql2);
$rowto=$restotal->fetch_array();
$styletb='table-fixed2';
if($cont<5){
	$styletb='';
}
?> 
<style>
 .table-fixed2  {
  height: 200px;
  overflow-y: auto;
 }  
</style>
<?php 

?>
<h4 class="text-right">Total: <?php echo $rowto[0];?></h4>
<div class="<?php echo $styletb?>">
<table id="tablamodal" class="table table-striped ">
<?php echo $head;?>
<tbody>
<?php
if($cont>0){	
	while($row=$result->fetch_array()){
	?>
	<tr>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col0;?>"><?php echo $row[0];?></td>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col1;?>"><?php echo $row[1];?></td>
		<td class="text-center col-xs-2 coltd col2" style="<?php echo $col2;?>"><?php echo $row[2];?></td>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col3;?>"><?php echo $row[3];?></td>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col4;?>"><?php echo $row[4];?></td>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col5;?>"><?php echo $row[5];?></td>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col6;?>"><?php echo $row[6];?></td>
		<td class="text-right col-xs-2 coltd" style="<?php echo $col7;?>"><?php echo $row[7];?></td>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col8;?>"><?php echo $row[8];?></td>
	</tr>
	<?php
	}
}
else{?>
	<tr><td colspan="9" class="text-center"><h4>No hay registros</h4></td></tr>
	<?php
}
?>
</tbody>

</table>
<div>
