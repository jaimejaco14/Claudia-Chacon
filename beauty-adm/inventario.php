<?php 
	include '../cnx_data.php';

	$tipoReporte     = $_REQUEST["tipoReporte"];
	$fechaGenerado   =  date("d-m-Y");
	$horaGenerado    = date("H:i:s a");
	$query           = "SELECT DISTINCT(tponombre), tpocodigo FROM bty_vw_estructura_clasificacion ORDER BY tponombre";
	$resultQuery     = $conn->query($query);
	$categorias      = array();
	$tipos           = array();
	$grupos          = array();
	$subgrupos       = array();
	$lineas          = array();
	$sublineas       = array();
	$caracteristicas = array();

	while($registros = $resultQuery->fetch_array()){

		$resultQuery2 = $conn->query("SELECT DISTINCT(grunombre), grucodigo FROM bty_vw_estructura_clasificacion WHERE tpocodigo = ".$registros["tpocodigo"]." ORDER BY grunombre");

		while($registros2 = $resultQuery2->fetch_array()){

			$resultQuery3 = $conn->query("SELECT DISTINCT(sbgcodigo), sbgnombre FROM bty_vw_estructura_clasificacion WHERE grucodigo = ".$registros2["grucodigo"]." ORDER BY sbgnombre");

			while($registros3 = $resultQuery3->fetch_array()){

				$resultQuery4 = $conn->query("SELECT DISTINCT(lincodigo), linnombre FROM bty_vw_estructura_clasificacion WHERE sbgcodigo = ".$registros3["sbgcodigo"]." ORDER BY linnombre");

				while($registros4 = $resultQuery4->fetch_array()){

					$resultQuery5 = $conn->query("SELECT DISTINCT(sblcodigo), sblnombre FROM bty_vw_estructura_clasificacion WHERE lincodigo = ".$registros4["lincodigo"]." ORDER BY sblnombre");

					while($registros5 = $resultQuery5->fetch_array()){

						$resultQuery6 = $conn->query("SELECT DISTINCT(crscodigo), crsnombre FROM bty_vw_estructura_clasificacion WHERE sblcodigo = ".$registros5["sblcodigo"]." ORDER BY crsnombre");

						while($registros6 = $resultQuery6->fetch_array()){

							$caracteristicas[] = array("codCaracteristica" => $registros6["crscodigo"], "nomCaracteristica" => utf8_encode($registros6["crsnombre"]));
						}

						$sublineas[] = array("codSublinea" => $registros5["sblcodigo"], "nomSublinea" => utf8_encode($registros5["sblnombre"]), "caracteristicas" => $caracteristicas);
						$caracteristicas = array();
					}

					$lineas[] = array("codLinea" => $registros4["lincodigo"], "nomLinea" => utf8_encode($registros4["linnombre"]), "sublineas" => $sublineas);
					$sublineas = array();
				}

				$subgrupos[] = array("codSubgrupo" => $registros3["sbgcodigo"], "nomSubgrupo" => utf8_encode($registros3["sbgnombre"]), "lineas" => $lineas);
				$lineas = array();
			}

			$grupos[] = array("codGrupo" => $registros2["grucodigo"], "nomGrupo" => utf8_encode($registros2["grunombre"]), "subgrupos" => $subgrupos);
			$subgrupos = array();
		}

		$tipos[] = array("codTipo" => $registros["tpocodigo"], "nomTipo" => utf8_encode($registros["tponombre"]), "grupos" => $grupos);
		$grupos = array();
	}

	if($tipoReporte == "pdf"){

		require_once "lib/fpdf/fpdf.php";

		class PDF extends FPDF{

			function Header(){

				$this->Image('./imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 14);
				$this->Cell(0, 10, utf8_decode("REPORTE DE ESTRUCTURA - CLASIFICACIÓN"), 0, 2, 'R');
				$this->SetFont("Arial", "", 9);
				$this->Cell(0, 8, "Generado a las ".date("h:i:sA")." del ".date("d-m-Y"), 0, 2, 'R');
			}

			function Footer(){

				$this->SetY(-12);
				$this->SetFont('Arial','I',8);
				$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
				$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP", 0, 2,'C');
				//$this->Cell(0,5,"www.claudiachacon.com", 0, 2,'C');
			}
		}

		$reportePdf = new PDF();
		$reportePdf->AddPage();
		$reportePdf->Ln();

		for($i = 0; $i < count($tipos); $i++){
			
			$reportePdf->SetFont("Arial", "B", 10);
			$reportePdf->Cell(10, 8, "Tipo:", 0, 0);
			$reportePdf->SetFont("Arial", "", 10);
			$reportePdf->Cell(0, 8, utf8_decode($tipos[$i]["nomTipo"])." (".$tipos[$i]["codTipo"].")", 0, 1);

			for($j = 0; $j < count($tipos[$i]["grupos"]); $j++){
				
				$reportePdf->Cell(10, 8, "", 0, 0);
				$reportePdf->SetFont("Arial", "B", 10);
				$reportePdf->Cell(15, 8, "Grupo:", 0, 0);
				$reportePdf->SetFont("Arial", "", 10);
				$reportePdf->Cell(0, 8, utf8_decode($tipos[$i]["grupos"][$j]["nomGrupo"])." (".$tipos[$i]["grupos"][$j]["codGrupo"].")", 0, 1);

				for($k = 0; $k < count($tipos[$i]["grupos"][$j]["subgrupos"]); $k++){

					$reportePdf->Cell(25, 8, "", 0, 0);
					$reportePdf->SetFont("Arial", "B", 10);
					$reportePdf->Cell(20, 8, "Subgrupo:", 0, 0);
					$reportePdf->SetFont("Arial", "", 10);
					$reportePdf->Cell(0, 8, utf8_decode($tipos[$i]["grupos"][$j]["subgrupos"][$k]["nomSubgrupo"])." (".$tipos[$i]["grupos"][$j]["subgrupos"][$k]["codSubgrupo"].")", 0, 1);

					for($l = 0; $l < count($tipos[$i]["grupos"][$j]["subgrupos"][$k]["lineas"]); $l++){

						$reportePdf->Cell(45, 8, "", 0, 0);
						$reportePdf->SetFont("Arial", "B", 10);
						$reportePdf->Cell(12, 8, utf8_decode("Línea:"), 0, 0);
						$reportePdf->SetFont("Arial", "", 10);
						$reportePdf->Cell(0, 8, utf8_decode($tipos[$i]["grupos"][$j]["subgrupos"][$k]["lineas"][$l]["nomLinea"])." (".$tipos[$i]["grupos"][$j]["subgrupos"][$k]["lineas"][$l]["codLinea"].")", 0, 1);

						for($m = 0; $m < count($tipos[$i]["grupos"][$j]["subgrupos"][$k]["lineas"][$l]["sublineas"]); $m++){

							$reportePdf->Cell(60, 8, "", 0, 0);
							$reportePdf->SetFont("Arial", "B", 10);
							$reportePdf->Cell(20, 8, utf8_decode("Sublínea:"), 0, 0);
							$reportePdf->SetFont("Arial", "", 10);
							$reportePdf->Cell(0, 8, utf8_decode($tipos[$i]["grupos"][$j]["subgrupos"][$k]["lineas"][$l]["sublineas"][$m]["nomSublinea"])." (".$tipos[$i]["grupos"][$j]["subgrupos"][$k]["lineas"][$l]["sublineas"][$m]["codSublinea"].")", 0, 1);

							for($n = 0; $n < count($tipos[$i]["grupos"][$j]["subgrupos"][$k]["lineas"][$l]["sublineas"][$m]["caracteristicas"]); $n++){

								$reportePdf->Cell(80, 8, "", 0, 0);
								$reportePdf->SetFont("Arial", "B", 10);
								$reportePdf->Cell(27, 8, utf8_decode("Característica:"), 0, 0);
								$reportePdf->SetFont("Arial", "", 10);
								$reportePdf->Cell(0, 8, utf8_decode($tipos[$i]["grupos"][$j]["subgrupos"][$k]["lineas"][$l]["sublineas"][$m]["caracteristicas"][$n]["nomCaracteristica"])." (".$tipos[$i]["grupos"][$j]["subgrupos"][$k]["lineas"][$l]["sublineas"][$m]["caracteristicas"][$n]["codCaracteristica"].")", 0, 1);
							}
						}
					}
				}
			}
		}

		$reportePdf->Output("Reporte de estructura - clasificación.pdf", "I");

	}

	/*echo "<pre>";
	print_r($tipos);
	echo "</pre>";*/
	mysqli_close($conn);
?>