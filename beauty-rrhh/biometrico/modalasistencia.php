<?php
include '../../cnx_data.php';
$id=$_GET['id'];
$oper=$_GET['opc'];
$mes=$_GET['mes'];
$col0="";
$col1="";
$col2="";
$col3="";
$col4="";
$head1="<thead>
	<tr>
		<th class='text-center col-xs-2 colth' id='col0'>FECHA</th>
		<th class='text-center col-xs-2 colth' id='col1'>HORARIO</th>
		<th class='text-center col-xs-2 colth' id='col2'>REGISTRO</th>
		<th class='text-center col-xs-2 colth' id='col3'>HORA REGISTRO</th>
		<th class='text-center col-xs-3 colth' id='col4'>RESULTADO</th>
	</tr>
</thead>";
$head2="<thead>
	<tr>
		<th class='text-center col-xs-2 colth'>FECHA</th>
		<th class='text-center col-xs-2 colth'>HORA </th>
		<th class='text-center col-xs-2 colth'>REGISTRADO COMO</th>
		<th class='text-center col-xs-2 colth'>CORREGIDO</th>
		<th class='text-center col-xs-3 colth'>TIPO DE ERROR</th>
	</tr>
</thead>";
$head3="<thead>
	<tr>
		<th class='text-center col-xs-2 colth'>FECHA</th>
		<th class='text-center col-xs-2 colth'>RESULTADO</th>
	</tr>
</thead>";

switch($oper){
	case 1:
		$head=$head1;
		$sql="SELECT ap.prgfecha, tn.trndesde AS horario, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				WHERE MONTH(ap.prgfecha)=$mes and year(ap.prgfecha)=year(curdate()) AND ap.clbcodigo=$id AND ab.abmnuevotipo='ENTRADA' AND apt.aptcodigo=2 order by ap.prgfecha asc";
	break;
	case 2:
		$head=$head1;
		$sql="SELECT ap.prgfecha, tn.trnhasta AS horario, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				WHERE MONTH(ap.prgfecha)=$mes and year(ap.prgfecha)=year(curdate()) AND ap.clbcodigo=$id AND ab.abmnuevotipo='SALIDA' AND apt.aptcodigo=3 order by ap.prgfecha asc";
	break;
	case 3:
		$col3="display:none;";
		$head=$head1;
		$sql="SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario, IFNULL(NULL, IF((
				SELECT ab.abmnuevotipo
				FROM btyasistencia_procesada ap2
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo
				WHERE ap2.prgfecha = ap.prgfecha AND ap2.clbcodigo=ap.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA'))
				,null, apt.aptnombre AS estado
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				WHERE MONTH(ap.prgfecha)=$mes and year(ap.prgfecha)=year(curdate()) AND ap.clbcodigo=$id AND ap.abmcodigo IS NULL and ap.aptcodigo=6 order by ap.prgfecha asc";
	break;
	case 4:
		$col2="display:none;";
		$col3="display:none;";
		$head=$head1;
		$sql="SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario, null,null, apt.aptnombre AS estado
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				WHERE MONTH(ap.prgfecha)=$mes and year(ap.prgfecha)=year(curdate()) AND ap.clbcodigo=$id AND ap.abmcodigo IS NULL and ap.aptcodigo=4 order by ap.prgfecha asc";
	break;
	case 5:
		$head=$head2;
		$sql="SELECT ab.abmfecha,ab.abmhora,if(ab.abmtipo='','OTRO',ab.abmtipo),ab.abmnuevotipo,ab.abmtipoerror 
				from btyasistencia_biometrico ab 
				where ab.clbcodigo=$id
				and ab.abmerroneo=1
				and month(ab.abmfecha)=$mes and year(ab.abmfecha)=year(curdate())";
	break;
	case 6:
		$col1="display:none;";
		$col2="display:none;";
		$col3="display:none;";
		$head=$head3;
		$sql="SELECT DISTINCT(ap.prgfecha), null AS horario, NULL, NULL, apt.aptnombre AS estado
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				WHERE MONTH(ap.prgfecha)=$mes and year(ap.prgfecha)=year(curdate()) AND ap.clbcodigo=$id AND apt.aptcodigo=5";
	break;
}

$result=$conn->query($sql);
$cont=mysqli_num_rows($result);
$styletb='table-fixed2';
if($cont<5){
	$styletb='';
}
?> 
<table id="tablamodal" class="table table-striped <?php echo $styletb?>">
<?php echo $head;?>
<tbody>
<?php
if($cont>0){	
	while($row=$result->fetch_array()){
	?>
	<tr>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col0;?>"><?php echo $row[0];?></td>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col1;?>"><?php echo $row[1];?></td>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col2;?>"><?php echo $row[2];?></td>
		<td class="text-center col-xs-2 coltd" style="<?php echo $col3;?>"><?php echo $row[3];?></td>
		<td class="text-center col-xs-3 coltd" style="<?php echo $col4;?>"><?php echo $row[4];?></td>
	</tr>
	<?php
	}
}
else{?>
	<tr><td colspan="5" class="text-center"><h4>No hay registros</h4></td></tr>
	<?php
}
?>
</tbody>
<style>
 .table-fixed2 thead {
  width: 99%;
 }
 .table-fixed2 tbody {
  height: 160px;
  overflow-y: auto;
  width: 100%;
  white-space: nowrap;
 }
 .table-fixed2 thead, .table-fixed2 tbody, .table-fixed2 tr, .table-fixed2 td, .table-fixed2 th {
  display: block;
 }
 .table-fixed2 tbody td, .table-fixed2 thead > tr> th {
  float: left;
  border-bottom-width: 0;
 }  
</style>
</table>
