<?php 
include '../../cnx_data.php';
require_once '../../lib/fpdf/fpdf.php';
$codigo = $_GET['id_act'];
$sql = "SELECT  a.actcodigo,a.actnombre,a.marcodigo,ma.marnombre,a.actmodelo,a.actespecificaciones,a.actgenerico,a.actimagen,a.actserial,a.actdescripcion,a.actfechacompra,a.prvcodigo,ter.trcrazonsocial,a.fabcodigo,fa.fabnombre,a.paicodigo,pa.painombre,a.actfechainicio,a.actcodigoexterno,a.actcosto_base,a.actcosto_impuesto,a.sbgcodigo,tp.tianombre,st.sbtnombre,ga.granombre,sg.sbganombre,sg.sbgubicacionetiqueta,a.pracodigo,pr.pranombre,a.actreq_mant_prd,a.actfreq_mant,a.actreq_rev_prd,a.actfreq_rev,a.actgtia_tiempo,a.actgtia_tiempo_valor,a.unacodigo_tiempo,un.unanombre un1,a.actgtia_uso,a.actgtia_uso_valor,a.unacodigo_uso,un2.unanombre un2,a.actreq_insumos,a.actreq_repuestos
    FROM btyactivo a
    join btyactivo_subgrupo sg on sg.sbgcodigo=a.sbgcodigo
    join btyactivo_grupo ga on ga.gracodigo=sg.gracodigo
    join btyactivo_subtipo st on st.sbtcodigo=ga.sbtcodigo
    join btyactivo_tipo tp on tp.tiacodigo=st.tiacodigo
    join btyactivo_marca ma on ma.marcodigo=a.marcodigo
    join btyactivo_fabricante fa on fa.fabcodigo=a.fabcodigo
    join btyactivo_prioridad pr on pr.pracodigo=a.pracodigo
    join btypais pa on pa.paicodigo=a.paicodigo
    join btyproveedor po on po.prvcodigo=a.prvcodigo
    join btyactivo_unidad un on a.unacodigo_tiempo=un.unacodigo
    join btyactivo_unidad un2 on a.unacodigo_uso=un2.unacodigo
    join btytercero ter on po.trcdocumento=ter.trcdocumento
    WHERE a.actcodigo =".$codigo;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
        # code...
        $codigo   = $row['actcodigo'];
        $nombre   = $row['actnombre'];
        $marca    = $row['marcodigo'];
        $nommarca = $row['marnombre'];
        $modelo   = $row['actmodelo'];
        $espec    = $row['actespecificaciones'];
        $img      =$row['actimagen'];
        $gener    =$row['actgenerico'];
        if($gener==0){
        	$gener='NO';
        }else{
        	$gener='SI';
        }
        $serial   = $row['actserial'];
        $descr    = strtoupper($row['actdescripcion']);
        
        $fecha    = $row['actfechacompra'];
        $prove    = $row['trcrazonsocial'];
        $fab      = $row['fabnombre'];
        $pais     = $row['painombre'];
        $fechini  = $row['actfechainicio'];
        $cod_ext  = $row['actcodigoexterno'];
        $costo    = $row['actcosto_base'];
        $impu     = $row['actcosto_impuesto'];

        $nomtia   = $row['tianombre'];
        $subtia   =$row['sbtnombre'];
        $nomgru   =$row['granombre'];
        $subgru   =$row['sbganombre'];
        $ubicQR   =$row['sbgubicacionetiqueta'];

        $rqmtto   =$row['actreq_mant_prd'];
        if($rqmtto==0){
        	$rqmtto='NO';
        }else{
        	$rqmtto='SI';
        }
        $fqmtto   =$row['actfreq_mant'];

        $rqrev    =$row['actreq_rev_prd'];
        if($rqrev==0){
        	$rqrev='NO';
        }else{
        	$rqrev='SI';
        }
        $fqrev    =$row['actfreq_rev'];

        $pri      = $row['pracodigo'];
        $prinom   = $row['pranombre'];

        $garti    =$row['actgtia_tiempo'];
        if($garti==0){
        	$garti='NO';
        }else{
        	$garti='SI';
        }
        $gartival =$row['actgtia_tiempo_valor'];
        $gartiuni =$row['un1'];

        $garuso   =$row['actgtia_uso'];
        if($garuso==0){
        	$garuso='NO';
        }else{
        	$garuso='SI';
        }
        $garusoval=$row['actgtia_uso_valor'];
        $garusouni=$row['un2'];

        $insu     =$row['actreq_insumos'];
        $repu     =$row['actreq_repuestos'];
     
}
class PDF extends FPDF{

	function Header(){

		$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(0, 10, "REPORTE INDIVIDUAL DE ACTIVO", 0, 2, 'R');
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

$reportePdf->AddPage("P", "LEGAL");

$reportePdf->SetFillColor(151, 130, 45);
$reportePdf->SetTextColor(255);
$reportePdf->SetFont("Arial", "B", 7);
//////////datos generales////////////////////////////////////////
	$reportePdf->Cell(190, 7, "DATOS GENERALES", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->SetTextColor(0);
	$reportePdf->Cell(29, 7, "CODIGO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(19, 7, $codigo, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(28, 7, "NOMBRE", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(114, 7, utf8_decode($nombre), 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(48, 7, "MARCA", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(47, 7, $nommarca, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(25, 7, "MODELO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(70, 7, $modelo, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Ln(7);
	$reportePdf->Cell(48, 7, "SERIAL", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(47, 7, $serial, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(25, 7, "CODIGO EXTERNO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(23, 7, $cod_ext, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(25, 7, "GENERICO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(22, 7, $gener, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Ln(7);
	$reportePdf->Cell(48, 7, "ESPECIFICACIONES", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(142, 7, utf8_decode($espec), 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Ln(7);
	$reportePdf->Cell(48, 7, "DESCRIPCION", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(142, 7, utf8_decode($descr), 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Ln(7);
//////////////datos de compra/////////////////////////////////////
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(151, 130, 45);
	$reportePdf->SetTextColor(255);
	$reportePdf->Cell(190, 7, "DATOS DE COMPRA", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->SetTextColor(0);
	$reportePdf->Cell(48, 7, "FECHA DE COMPRA", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(47, 7, $fecha, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(48, 7, "FECHA INICIO DE USO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(47, 7, $fechini, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Ln(7);
	$reportePdf->Cell(22, 7, "PROVEEDOR", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(41, 7, $prove, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(22, 7, "FABRICANTE", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(42, 7, $fab, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(27, 7, "PAIS DE ORIGEN", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(36, 7, $pais, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Ln(7);
	$reportePdf->Cell(48, 7, "COSTO BASE", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(47, 7, $costo, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(48, 7, "IMPUESTO BASE", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(47, 7, $impu, 1, 0, "C", 1);
	$reportePdf->Ln(7);
//////////////////////////ubicacion/////////////////////////////////
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(151, 130, 45);
	$reportePdf->SetTextColor(255);
	$reportePdf->Cell(190, 7, "UBICACION", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetTextColor(0);
	$sql="SELECT l.lugnombre,a.arenombre,m.arecodigo_nue
				FROM btyactivo_movimiento m
				join btyactivo_area a on a.arecodigo=m.arecodigo_nue
				join btyactivo_lugar l on l.lugcodigo=a.lugcodigo
				WHERE m.actcodigo=$codigo
				and m.mvaconsecutivo=(select max(ma.mvaconsecutivo) from btyactivo_movimiento ma where ma.actcodigo=$codigo and ma.mvaestado='EJECUTADO')";
	$res=$conn->query($sql);
	$row=$res->fetch_array();
	$lugar=$row[0];
	$area=$row[1];
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(25, 7, "LUGAR", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(70, 7, utf8_decode($lugar), 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(25, 7, "AREA", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(70, 7, utf8_decode($area), 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Ln(7);
//////////CLASIFICACION//////////////////////////////////////////////////
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(151, 130, 45);
	$reportePdf->SetTextColor(255);
	$reportePdf->Cell(190, 7, "CLASIFICACION", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetTextColor(0);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(26, 7, "TIPO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(69, 7, utf8_decode($nomtia), 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(26, 7, "SUBTIPO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(69, 7, utf8_decode($subtia), 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Ln(7);
	$reportePdf->Cell(26, 7, "GRUPO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(69, 7, utf8_decode($nomgru), 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(26, 7, "SUBGRUPO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(69, 7, utf8_decode($subgru), 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Ln(7);
	$reportePdf->Cell(30, 7, "UBICACION DEL QR", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(160, 7, utf8_decode($ubicQR), 1, 0, "C", 1);
	$reportePdf->Ln(7);
///////////////////mantenimiento/////////////////////////////////////
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(151, 130, 45);
	$reportePdf->SetTextColor(255);
	$reportePdf->Cell(190, 7, "MANTENIMIENTO Y REVISION", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetTextColor(0);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(23, 7, "MANTENIMIENTO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(15, 7, $rqmtto, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(20, 7, "FRECUENCIA", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(20, 7, $fqmtto.' dias', 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(21, 7, "REVISIONES", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(15, 7, $rqrev, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(20, 7, "FRECUENCIA", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(20, 7, $fqrev.' dias', 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(18, 7, "PRIORIDAD", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(18, 7, $prinom, 1, 0, "C", 1);
	$reportePdf->Ln(7);
///////////////////GARANTIA//////////////////////////////
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(151, 130, 45);
	$reportePdf->SetTextColor(255);
	$reportePdf->Cell(190, 7, "GARANTIA", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->SetTextColor(0);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(20, 7, "POR TIEMPO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(16, 7, $garti, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(15, 7, "CANTIDAD", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(14, 7, $gartival, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(15, 7, "UNIDAD", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(18, 7, utf8_decode($gartiuni), 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(15, 7, "POR USO", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(16, 7, $garuso, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(15, 7, "CANTIDAD", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(14, 7, $garusoval, 1, 0, "C", 1);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->Cell(15, 7, "UNIDAD", 1, 0, "L", 1);
	$reportePdf->SetFillColor(255, 255, 255);
	$reportePdf->Cell(17, 7, utf8_decode($garusouni), 1, 0, "C", 1);
	$reportePdf->Ln(7);
////////////////////INSUMOS///////////////////////////////
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(151, 130, 45);
	$reportePdf->SetTextColor(255);
	$reportePdf->Cell(190, 7, "INSUMOS", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->SetTextColor(0);
	$reportePdf->Cell(30, 7, "REFERENCIA", 1, 0, "C", 1);
	$reportePdf->Cell(40, 7, "NOMBRE", 1, 0, "C", 1);
	$reportePdf->Cell(100, 7, "ESPECIFICACIONES", 1, 0, "C", 1);
	$reportePdf->Cell(20, 7, "CANTIDAD", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(255, 255, 255);
	$sql="SELECT id.inscodigo,i.insnombre,i.insreferencia,i.insespecificaciones,id.indcantidad
					FROM btyactivo_insumo_detalle id
					JOIN btyactivo_insumo i ON i.inscodigo=id.inscodigo
					where id.actcodigo=$codigo and id.indestado=1 order by i.insnombre";
	$res=$conn->query($sql);
	if($res->num_rows>0){
		while($row=$res->fetch_array()){
			$reportePdf->Cell(30, 7, $row['insreferencia'], 1, 0, "C", 1);
			$reportePdf->Cell(40, 7, utf8_decode($row['insnombre']), 1, 0, "C", 1);
			$reportePdf->Cell(100, 7, utf8_decode($row['insespecificaciones']), 1, 0, "C", 1);
			$reportePdf->Cell(20, 7, $row['indcantidad'], 1, 0, "C", 1);
			$reportePdf->Ln(7);
		}
	}else{
		$reportePdf->Cell(190, 7, "No hay Insumos asignados", 1, 0, "C", 1);
		$reportePdf->Ln(7);
	}
////////////////////REPUESTOS///////////////////////////////
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(151, 130, 45);
	$reportePdf->SetTextColor(255);
	$reportePdf->Cell(190, 7, "REPUESTOS", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(255, 246, 210);
	$reportePdf->SetTextColor(0);
	$reportePdf->Cell(30, 7, "REFERENCIA", 1, 0, "C", 1);
	$reportePdf->Cell(40, 7, "NOMBRE", 1, 0, "C", 1);
	$reportePdf->Cell(100, 7, "ESPECIFICACIONES", 1, 0, "C", 1);
	$reportePdf->Cell(20, 7, "CANTIDAD", 1, 0, "C", 1);
	$reportePdf->Ln(7);
	$reportePdf->SetFillColor(255, 255, 255);
	$sql="SELECT id.repcodigo,i.repnombre,i.repreferencia,i.repespecificaciones,id.redcantidad
					FROM btyactivo_repuesto_detalle id
					JOIN btyactivo_repuesto i ON i.repcodigo=id.repcodigo
					where id.actcodigo=$codigo and id.redestado=1 order by i.repnombre";
	$res=$conn->query($sql);
	if($res->num_rows>0){
		while($row=$res->fetch_array()){
			$reportePdf->Cell(30, 7, $row['repreferencia'], 1, 0, "C", 1);
			$reportePdf->Cell(40, 7, utf8_decode($row['repnombre']), 1, 0, "C", 1);
			$reportePdf->Cell(100, 7, utf8_decode($row['repespecificaciones']), 1, 0, "C", 1);
			$reportePdf->Cell(20, 7, $row['redcantidad'], 1, 0, "C", 1);
			$reportePdf->Ln(7);
		}
	}else{
		$reportePdf->Cell(190, 7, "No hay Repuestos asignados", 1, 0, "C", 1);
		$reportePdf->Ln(7);
	}



$reportePdf->Output("Reporte general de Activos.pdf", "I");

?>