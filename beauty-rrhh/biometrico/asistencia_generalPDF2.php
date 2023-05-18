<?php
include '../../cnx_data.php';
$fecha1=$_GET['f1'];
$fecha2=$_GET['f2'];
$cg=$_GET['cg'];
if($cg!=0){
	$cargo=" and cg.crgcodigo IN ($cg)";
}else{
	$cargo="";
}

/*$sln='';
if($_GET['sln']){
    $sln=" and ab.slncodigo=".$_GET['sln']." ";
    $txtsl=$_GET['txtsl'];
}*/

if($_GET['sln']){
	$salones=$_GET['sln'];
}else{
	$consln4="SELECT group_concat(slncodigo order by slnnombre) from btysalon";
	$res4=$conn->query($consln4);
	$row4=$res4->fetch_array();
	$slncod=$row4[0];
	$salones=explode(',',$slncod);
}


require_once '../../lib/fpdf/fpdf.php';

class PDF extends FPDF{

	function Header(){

		$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(0, 10, "REPORTE DE ASISTENCIA ".$_GET['txtsl']." Del ".$_GET['f1']." al ".$_GET['f2'], 0, 2, 'R');
		$this->SetFont("Arial", "", 8);
		$this->Ln(12);
		
	}

	function Footer(){

		$this->SetY(-13);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
		$this->Cell(0, 5, "Generado a las ".date("h:i:sA")." del ".date("d-m-Y")." mediante Beauty Soft ERP", 0, 2, 'C');
	}
}
$reportePdf = new PDF();
$reportePdf->AddPage("L", "legal");
foreach($salones as $salon){
	$sqlnomsal="SELECT slnnombre from btysalon where slncodigo=$salon";
	$resnomsal=$conn->query($sqlnomsal);
	$nomsal=$resnomsal->fetch_array();
	$reportePdf->SetFillColor(151, 130, 45);
	$reportePdf->SetTextColor(255);
	$reportePdf->SetFont("Arial", "B", 8);
	//ENCABEZADOS**************************************************
	$reportePdf->Cell(335, 6, "ASISTENCIA SALON ".$nomsal[0], 1, 0, "C", 1);
	$reportePdf->Ln(6);
	$reportePdf->Cell(75, 6, "COLABORADOR", 1, 0, "C", 1);
	$reportePdf->Cell(35, 6, "SALON BASE", 1, 0, "C", 1);
	$reportePdf->Cell(30, 6, "LLEGADA TARDE", 1, 0, "C", 1);
	$reportePdf->Cell(30, 6, "SALIDA TEMPRANO", 1, 0, "C", 1);
	$reportePdf->Cell(20, 6, "AUSENCIA", 1, 0, "C", 1);
	$reportePdf->Cell(20, 6, "INCOMPLETO", 1, 0, "C", 1);
	$reportePdf->Cell(50, 6, "PRESENCIA NO PROGRAMADA", 1, 0, "C", 1);
	$reportePdf->Cell(20, 6, "ERRORES", 1, 0, "C", 1);
	$reportePdf->Cell(20, 6, "NOVEDADES", 1, 0, "C", 1);
	$reportePdf->Cell(20, 6, "PERMISOS", 1, 0, "C", 1);
	$reportePdf->Cell(15, 6, "VALOR", 1, 0, "C", 1);
	//color, tipo y tamaño de letra
	$reportePdf->SetTextColor(0);
	$reportePdf->SetFont("Arial", "", 7);
	//fin color, tipo y tamaño de letra
	//FIN ENCABEZADOS**********************************************
	$reportePdf->Ln(6);

	$sql="SELECT distinct(ab.clbcodigo), t.trcrazonsocial, cg.crgnombre,sl.slnnombre
		from btyasistencia_procesada ab
		join btycolaborador c on c.clbcodigo=ab.clbcodigo
		join btytercero t on t.trcdocumento=c.trcdocumento
		join btycargo cg on cg.crgcodigo=c.crgcodigo
		join btysalon_base_colaborador sbc on sbc.slncodigo=ab.slncodigo
		join btysalon sl on sl.slncodigo=sbc.slncodigo
		where ab.prgfecha between '$fecha1' and '$fecha2' ".$cargo." and ab.slncodigo=$salon
		order by t.trcrazonsocial asc";
	$res=$conn->query($sql);
	$numrow=mysqli_num_rows($res);
	$i=0;
	$it=0;$st=0;$au=0;$pnp=0;$err=0;$inc=0;$nov=0;$per=0;
	if($numrow>0){
		while($row=$res->fetch_array()){
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
					select null,count(*) from btyasistencia_biometrico ab 
					where ab.abmerroneo=1 and ab.clbcodigo=".$row['clbcodigo']." 
					AND ab.abmfecha between '$fecha1' and '$fecha2'
					union
	                SELECT 'VALOR',concat('$',format(sum(ap.apcvalorizacion),0))
	                FROM btyasistencia_procesada ap
	                WHERE ap.clbcodigo=".$row['clbcodigo']." AND ap.prgfecha BETWEEN '$fecha1' and '$fecha2'
					union
					select 'NOVEDADES',count(*) 
					from btynovedades_programacion_detalle pd
					natural join btynovedades_programacion np
					where pd.clbcodigo=".$row['clbcodigo']." and (np.nvpfecha between '$fecha1' and '$fecha2') and np.nvpestado <> 'ELIMINADO'
					union
					select 'PERMISOS',ifnull(count(*),0) as cper
					from btypermisos_colaboradores pc 
					where pc.clbcodigo=".$row['clbcodigo']." AND ((pc.perfecha_desde between '$fecha1' and '$fecha2') or (pc.perfecha_hasta between '$fecha1' and '$fecha2'))  and pc.perestado='AUTORIZADO'";

			$res3=$conn->query($sql3);
			$detalle="";
			while($deta=$res3->fetch_array()){
				$detalle.=$deta[1]."•";
			}
			$det=explode('•',$detalle);
			$i++;
			if(($i % 2) == 0){

				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{

				$reportePdf->SetFillColor(255);
			}
			$reportePdf->Cell(75, 5, $row[1]."  (".$row[2].")", 1, 0, "L", 1);
			$reportePdf->Cell(35, 5, $row[3], 1, 0, "C", 1);
			$reportePdf->Cell(30, 5, $det[0], 1, 0, "C", 1);$it+= $det[0];
			$reportePdf->Cell(30, 5, $det[1], 1, 0, "C", 1);$st+= $det[1];
			$reportePdf->Cell(20, 5, $det[2], 1, 0, "C", 1);$au+= $det[2];
			$reportePdf->Cell(20, 5, $det[3], 1, 0, "C", 1);$inc+=$det[3];
			$reportePdf->Cell(50, 5, $det[4], 1, 0, "C", 1);$pnp+=$det[4];
			$reportePdf->Cell(20, 5, $det[5], 1, 0, "C", 1);$err+=$det[5];
			$reportePdf->Cell(20, 5, $det[7], 1, 0, "C", 1);$nov+=$det[7];
			$reportePdf->Cell(20, 5, $det[8], 1, 0, "C", 1);$per+=$det[8];
			$reportePdf->Cell(15, 5, $det[6], 1, 0, "R", 1);
			$reportePdf->Ln(5);
		}	
			$tit+=$it;
			$tst+=$st;
			$tau+=$au;
			$tinc+=$inc;
			$tpnp+=$pnp;
			$terr+=$err;
			$tnov+=$nov;
			$tper+=$per;
		$i++;
		if(($i % 2) == 0){
			$reportePdf->SetFillColor(255, 246, 210);
		}
		else{
			$reportePdf->SetFillColor(255);
		}
		$reportePdf->SetFont("Arial", "B", 10);
			$reportePdf->Cell(110, 5, "TOTALES", 1, 0, "C", 1);
			$reportePdf->Cell(30, 5, $it, 1, 0, "C", 1);
			$reportePdf->Cell(30, 5, $st, 1, 0, "C", 1);
			$reportePdf->Cell(20, 5, $au, 1, 0, "C", 1);
			$reportePdf->Cell(20, 5, $inc, 1, 0, "C", 1);
			$reportePdf->Cell(50, 5, $pnp, 1, 0, "C", 1);
			$reportePdf->Cell(20, 5, $err, 1, 0, "C", 1);
			$reportePdf->Cell(20, 5, $nov, 1, 0, "C", 1);
			$reportePdf->Cell(20, 5, $per, 1, 0, "C", 1);
			$reportePdf->Cell(15, 5,"" , 1, 0, "R", 1);
			$reportePdf->Ln(5);
		$i++;
		if(($i % 2) == 0){
			$reportePdf->SetFillColor(255, 246, 210);
		}
		else{
			$reportePdf->SetFillColor(255);
		}
		$sqltotal="SELECT concat('$',format(SUM(ab.apcvalorizacion),0)),SUM(ab.apcvalorizacion)
					FROM btyasistencia_procesada ab
					JOIN btycolaborador c ON c.clbcodigo=ab.clbcodigo
					JOIN btytercero t ON t.trcdocumento=c.trcdocumento
					JOIN btycargo cg ON cg.crgcodigo=c.crgcodigo
					WHERE ab.prgfecha BETWEEN '$fecha1' AND '$fecha2'".$cargo." and ab.slncodigo=$salon";
		$restotal=$conn->query($sqltotal);
		$rowtotal=$restotal->fetch_array();
		$reportePdf->SetFont("Arial", "B", 10);
		$reportePdf->Cell(300, 5, "TOTAL VALORIZACION", 1, 0, "R", 1);
		$reportePdf->Cell(35, 5, $rowtotal[0], 1, 0, "R", 1);
		$reportePdf->Ln(10);
		$tval+=$rowtotal[1];
	}else{
		$reportePdf->SetFillColor(255);
		$reportePdf->Cell(335, 5, "No hay registros en este salon.", 1, 0, "C", 1);
		$reportePdf->Ln(10);
	}
}
	$reportePdf->SetFillColor(151, 130, 45);
	$reportePdf->SetTextColor(255);
	$reportePdf->SetFont("Arial", "B", 8);
	$reportePdf->Cell(335, 6, "CONSOLIDADO GENERAL", 1, 0, "C", 1);
	$reportePdf->Ln(6);
	$reportePdf->Cell(45, 6, "LLEGADA TARDE", 1, 0, "C", 1);
	$reportePdf->Cell(45, 6, "SALIDA TEMPRANO", 1, 0, "C", 1);
	$reportePdf->Cell(30, 6, "AUSENCIA", 1, 0, "C", 1);
	$reportePdf->Cell(30, 6, "INCOMPLETO", 1, 0, "C", 1);
	$reportePdf->Cell(50, 6, "PRESENCIA NO PROGRAMADA", 1, 0, "C", 1);
	$reportePdf->Cell(30, 6, "ERRORES", 1, 0, "C", 1);
	$reportePdf->Cell(30, 6, "NOVEDADES", 1, 0, "C", 1);
	$reportePdf->Cell(30, 6, "PERMISOS", 1, 0, "C", 1);
	$reportePdf->Cell(45, 6, "VALOR", 1, 0, "C", 1);
	$reportePdf->Ln(5);
	$reportePdf->SetTextColor(0);
	$reportePdf->SetFillColor(255);
	$reportePdf->SetFont("Arial", "B", 10);
	$reportePdf->Cell(45, 5, $tit, 1, 0, "C", 1);
	$reportePdf->Cell(45, 5, $tst, 1, 0, "C", 1);
	$reportePdf->Cell(30, 5, $tau, 1, 0, "C", 1);
	$reportePdf->Cell(30, 5, $tinc, 1, 0, "C", 1);
	$reportePdf->Cell(50, 5, $tpnp, 1, 0, "C", 1);
	$reportePdf->Cell(30, 5, $terr, 1, 0, "C", 1);
	$reportePdf->Cell(30, 5, $tnov, 1, 0, "C", 1);
	$reportePdf->Cell(30, 5, $tper, 1, 0, "C", 1);
	$reportePdf->Cell(45, 5, "$ ".number_format($tval, 0), 1, 0, "R", 1);
	$reportePdf->Ln(5);
	$reportePdf->Output("Reporte general de asistencia.pdf", "I");
