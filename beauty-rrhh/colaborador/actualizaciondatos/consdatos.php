<?php 
include '../../../cnx_data.php';
require_once '../../../lib/fpdf/fpdf.php';
//mysqli_set_charset($conn,"utf8");
$clb=$_GET['clb'];

		class PDF extends FPDF{

			function Header(){
				$this->Image('../../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 10);
				$this->Cell(0, 10, "CONSOLIDADO DE DATOS DE COLABORADOR", 0, 2, 'R');
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
		$reportePdf->AddPage("P", "letter"); /*Tamaños: LEGAL, A4, letter*/
		//Datos personales**************************************************
			$reportePdf->SetFillColor(151, 130, 45);
			$reportePdf->SetTextColor(0);
			$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->Cell(200, 6, "DATOS PERSONALES", 1, 0, "C", 1);
			$sql="SELECT td.tdialias,t.trcdocumento,t.trcrazonsocial,t.trcdireccion,b.brrnombre,t.trctelefonomovil,c.clbemail
				FROM btycolaborador c
				JOIN btytercero t ON t.trcdocumento=c.trcdocumento AND t.tdicodigo=c.tdicodigo
				JOIN btytipodocumento td on td.tdicodigo=t.tdicodigo
				JOIN btybarrio b on b.brrcodigo=t.brrcodigo
				where c.clbcodigo=$clb";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			$reportePdf->SetFillColor(255);
			$reportePdf->Ln(6);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(15, 5, "T. Doc", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(15, 5, $row['tdialias'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(15, 5, utf8_decode("Número"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(20, 5, $row['trcdocumento'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(15, 5, "Nombre", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(120, 5, $row['trcrazonsocial'], 1, 0, "L", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(15, 5, utf8_decode("Dirección"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $row['trcdireccion'], 1, 0, "L", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(15, 5, "Barrio", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(30, 5, $row['brrnombre'], 1, 0, "L", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(15, 5, utf8_decode("Teléfono"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(20, 5, $row['trctelefonomovil'], 1, 0, "L", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(15, 5, "E-Mail", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(40, 5, $row['clbemail'], 1, 0, "L", 1);
			$reportePdf->Ln(6);
		//fin datos personales
		//Informacion de salud y bienestar**********************************
			/*$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->SetFillColor(151, 130, 45);
			$reportePdf->Cell(200, 6, "SALUD Y BIENESTAR", 1, 0, "C", 1);
			$reportePdf->SetFillColor(255);
			$qsb="SELECT e.epsnombre,f.afpnombre,(CASE WHEN s.csestsalud=1 THEN 'EXCELENTE' WHEN s.csestsalud=2 THEN 'BUENO' WHEN s.csestsalud=3 THEN 'REGULAR' WHEN s.csestsalud=4 THEN 'MALO' ELSE '' END) AS estsalud, IF(s.csenfermedad=1,'SI','NO') enfact, IF(s.csenfermedad=1,s.csdescenfermedad,'N/A') AS desenf, IF(s.csrestriccion=1,'SI','NO') AS restmed, IF(s.csrestriccion=1,s.csdescrestriccion,'N/A') AS descrest, IF(s.cscirugia=1,'SI','NO') AS ciru, IF(s.cscirugia=1,s.csdesccirugia,'N/A') AS desciru, IF(s.cshospital=1,'SI','NO') AS hosp, IF(s.cshospital=1,s.csdeschospital,'N/A') AS deshosp, IF(s.cstratamiento=1,'SI','NO') AS trata, IF(s.cstratamiento=1,s.csdesctratamiento,'N/A') AS desctra,cc.cemnombre,cc.cemparentesco,cc.cemtelefono,cc.cemdireccion,s.cstcam,s.cstpan,s.cstgua, IF(s.csjudi=1,'SI','NO') AS judi, IF(s.csjudi=1,s.csdetjudi,'N/A') AS detjudi
				FROM btycolaborador_salud s
				JOIN btycolaborador_afp f ON f.afpcodigo=s.afpcodigo
				JOIN btycolaborador_eps e ON e.epscodigo=s.epscodigo
				JOIN btycolaborador_contacto cc ON cc.cemcodigo=s.cemcodigo
				WHERE s.clbcodigo=$clb AND s.csaprobado=1 order by s.cscodigo desc limit 1";
			$resb=$conn->query($qsb);
			$rsb=$resb->fetch_array();
			$reportePdf->Ln(6);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, "EPS", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rsb['epsnombre'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, "Fondo de pensiones", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rsb['afpnombre'], 1, 0, "C", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, "Estado de salud declarado", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(150, 5, $rsb['estsalud'], 1, 0, "C", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(40, 5, "Enfermedades", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(10, 5, $rsb['enfact'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(20, 5, utf8_decode("Descripción"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(130, 5, $rsb['desenf'], 1, 0, "L", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(40, 5, "Restricciones medicas", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(10, 5, $rsb['restmed'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(20, 5, utf8_decode("Descripción"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(130, 5, $rsb['descrest'], 1, 0, "L", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(40, 5, "Cirugias", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(10, 5, $rsb['ciru'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(20, 5, utf8_decode("Descripción"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(130, 5, $rsb['desciru'], 1, 0, "L", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(40, 5, "Hospitalizaciones", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(10, 5, $rsb['hosp'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(20, 5, "Motivo", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(130, 5, $rsb['deshosp'], 1, 0, "L", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(40, 5, "Tratamientos", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(10, 5, $rsb['trata'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(20, 5, utf8_decode("Descripción"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(130, 5, $rsb['desctra'], 1, 0, "L", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->Cell(200, 6, "CONTACTO EN CASO DE EMERGENCIA", 1, 0, "C", 1);
			$reportePdf->Ln(6);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, "Nombre", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rsb['cemnombre'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, "Parentesco", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rsb['cemparentesco'], 1, 0, "C", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, utf8_decode("Teléfono"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rsb['cemtelefono'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, utf8_decode("Dirección"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rsb['cemdireccion'], 1, 0, "C", 1);
			$reportePdf->Ln(6);
			$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->Cell(200, 6, utf8_decode("DOTACIÓN"), 1, 0, "C", 1);
			$reportePdf->Ln(6);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(55, 5, "Talla Camisa/Blusa", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(12, 5, $rsb['cstcam'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(55, 5, "Talla Pantalon", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(12, 5, $rsb['cstpan'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(55, 5, "Talla Guantes", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(11, 5, $rsb['cstgua'], 1, 0, "C", 1);
			$reportePdf->Ln(6);
			$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->Cell(200, 6, utf8_decode("INFORMACIÓN JUDICIAL"), 1, 0, "C", 1);
			$reportePdf->Ln(6);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(100, 5, "Problemas Judiciales Declarados", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(100, 5, $rsb['judi'], 1, 0, "C", 1);
			$reportePdf->Ln(5);
			if($rsb['judi']=='SI'){
				$reportePdf->SetFont("Arial", "", 7);
				$reportePdf->MultiCell(200, 5,utf8_decode("Descripción/Motivo: ").$rsb['detjudi'], 1, "L" ,0);
			}
			$reportePdf->Ln(1);*/
			//$reportePdf->Ln(5);
		//fin salud y bienestar
		//Información Familiar**********************************************
			$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->SetFillColor(151, 130, 45);
			$reportePdf->Cell(200, 6, utf8_decode("INFORMACIÓN FAMILIAR"), 1, 0, "C", 1);
			$reportePdf->SetFillColor(255);
			$reportePdf->Ln(6);
			$qif="SELECT i.cifestadocivil,i.cifconyunom,i.cifconyutel,i.cifconyuocu,i.cifhijos,i.cifnompadre,i.ciftelpadre,i.cifnommadre,i.ciftelmadre,i.cifdireccpadres,b.brrnombre,i.cifhermanos,i.cifcodigo
				FROM btycolaborador_infofa i
				JOIN btybarrio b ON b.brrcodigo=i.cifbrrcodigo
				WHERE i.clbcodigo=$clb AND i.cifaprobado=1 order by ciffecha desc limit 1";
			$resif=$conn->query($qif);
			$rif=$resif->fetch_array();
			switch($rif['cifestadocivil']){
                case '0':$ect='SOLTERO';break;
                case '1':$ect='CASADO';break;
                case '2':$ect='UNION LIBRE';break;
                case '3':$ect='SEPARADO';break;
                case '4':$ect='DIVORCIADO';break;
                case '5':$ect='VIUDO(a)';break;
            }
            switch($rif['cifhijos']){
                case '0':$hjt='NO';break;
                case '1':$hjt='SI';break;
            }
			switch($rif['cifhermanos']){
                case '0':$hnt='NO';break;
                case '1':$hnt='SI';break;
            }
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(100, 5, "ESTADO CIVIL", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(100, 5, $ect, 1, 0, "C", 1);
			$reportePdf->Ln(5);
			//info conyuge
				if(($rif['cifestadocivil']==1) || ($rif['cifestadocivil']==2)){
					$reportePdf->SetFont("Arial", "B", 7);
					$reportePdf->Cell(40, 5, utf8_decode("Nombre Conyuge/Compañero"), 1, 0, "C", 1);
					$reportePdf->SetFont("Arial", "", 7);
					$reportePdf->Cell(55, 5, $rif['cifconyunom'], 1, 0, "L", 1);
					$reportePdf->SetFont("Arial", "B", 7);
					$reportePdf->Cell(15, 5, utf8_decode("Ocupación"), 1, 0, "C", 1);
					$reportePdf->SetFont("Arial", "", 7);
					$reportePdf->Cell(45, 5, $rif['cifconyuocu'], 1, 0, "C", 1);
					$reportePdf->SetFont("Arial", "B", 7);
					$reportePdf->Cell(15, 5, utf8_decode("Teléfono"), 1, 0, "C", 1);
					$reportePdf->SetFont("Arial", "", 7);
					$reportePdf->Cell(30, 5, $rif['cifconyutel'], 1, 0, "C", 1);
					$reportePdf->Ln(6);
				}
			//fin conyuge
			//info hijos
				$reportePdf->SetFont("Arial", "B", 7);
				$reportePdf->Cell(100, 5, "HIJOS", 1, 0, "C", 1);
				$reportePdf->SetFont("Arial", "", 7);
				$reportePdf->Cell(100, 5, $hjt, 1, 0, "C", 1);
				$reportePdf->Ln(5);
				if($rif['cifhijos']==1){
					$sqls="SELECT h.chnombre,h.chfechana
							FROM btycolaborador_hijos h
							WHERE h.clbcodigo=$clb AND h.cifcodigo=$rif[12]";
					$ress=$conn->query($sqls);
					$i=1;
					while($rows=$ress->fetch_array()){
						$reportePdf->SetFont("Arial", "B", 7);
						$reportePdf->Cell(5, 5, $i, 1, 0, "C", 1);
						$reportePdf->Cell(25, 5, "Nombre", 1, 0, "C", 1);
						$reportePdf->SetFont("Arial", "", 7);
						$reportePdf->Cell(70, 5, $rows['chnombre'], 1, 0, "L", 1);
						$reportePdf->SetFont("Arial", "B", 7);
						$reportePdf->Cell(50, 5, "Fecha Nacimiento", 1, 0, "C", 1);
						$reportePdf->SetFont("Arial", "", 7);
						$reportePdf->Cell(50, 5, $rows['chfechana'], 1, 0, "C", 1);
						$reportePdf->Ln(5);
						$i++;
					}
					$reportePdf->Ln(1);
				}
			//fin hijos
			$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->Cell(200, 6, "NUCLEO FAMILIAR", 1, 0, "C", 1);
			$reportePdf->Ln(6);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, "Nombre Padre", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rif['cifnompadre'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, utf8_decode("Teléfono"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rif['ciftelpadre'], 1, 0, "C", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, "Nombre Madre", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rif['cifnommadre'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, utf8_decode("Teléfono"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rif['ciftelmadre'], 1, 0, "C", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, utf8_decode("Dirección"), 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rif['cifdireccpadres'], 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 7);
			$reportePdf->Cell(50, 5, "Barrio", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "", 7);
			$reportePdf->Cell(50, 5, $rif['brrnombre'], 1, 0, "C", 1);
			$reportePdf->Ln(5);
			//info HERMANOS
				$reportePdf->SetFont("Arial", "B", 7);
				$reportePdf->Cell(100, 5, "HERMANOS", 1, 0, "C", 1);
				$reportePdf->SetFont("Arial", "", 7);
				$reportePdf->Cell(100, 5, $hnt, 1, 0, "C", 1);
				$reportePdf->Ln(5);
				if($rif['cifhermanos']==1){
					$sqls="SELECT h.chenombre,h.cheocupacion,h.chetelefono,h.cheedad
						FROM btycolaborador_hermano h
						WHERE h.clbcodigo=$clb AND h.cifcodigo=$rif[12]";
					$ress=$conn->query($sqls);
					$j=1;
					while($rows=$ress->fetch_array()){
						$reportePdf->SetFont("Arial", "B", 7);
						$reportePdf->Cell(5, 10,  $j, 1, 0, "C", 1);
						$reportePdf->Cell(25, 5, "Nombre", 1, 0, "C", 1);
						$reportePdf->SetFont("Arial", "", 7);
						$reportePdf->Cell(70, 5, $rows['chenombre'], 1, 0, "L", 1);
						$reportePdf->SetFont("Arial", "B", 7);
						$reportePdf->Cell(50, 5, utf8_decode("Ocupación"), 1, 0, "C", 1);
						$reportePdf->SetFont("Arial", "", 7);
						$reportePdf->Cell(50, 5, $rows['cheocupacion'], 1, 0, "C", 1);
						$reportePdf->Ln(5);
						$reportePdf->Cell(5, 0,'', 0, 0, "C", 1);
						$reportePdf->SetFont("Arial", "B", 7);
						$reportePdf->Cell(25, 5, utf8_decode("Teléfono"), 1, 0, "C", 1);
						$reportePdf->SetFont("Arial", "", 7);
						$reportePdf->Cell(70, 5, $rows['chetelefono'], 1, 0, "L", 1);
						$reportePdf->SetFont("Arial", "B", 7);
						$reportePdf->Cell(50, 5, "Edad", 1, 0, "C", 1);
						$reportePdf->SetFont("Arial", "", 7);
						$reportePdf->Cell(50, 5, $rows['cheedad'], 1, 0, "C", 1);
						$reportePdf->Ln(5);
						$j++;
					}
					$reportePdf->Ln(1);
				}
			//fin HERMANOS
		//fin info familiar
		$reportePdf->Output("ConsolidadoDatosColaborador.pdf", "I");
?>