<?php 

define('E_FATAL',  E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR | 
        E_COMPILE_ERROR | E_RECOVERABLE_ERROR);
define('ENV', 'dev');
//Custom error handling vars
define('DISPLAY_ERRORS', TRUE);
define('ERROR_REPORTING', E_ALL | E_STRICT);
define('LOG_ERRORS', TRUE);
register_shutdown_function('shut');
set_error_handler('handler');
//Function to catch no user error handler function errors...
function shut(){
    $error = error_get_last();
    if($error && ($error['type'] & E_FATAL)){
        handler($error['type'], $error['message'], $error['file'], $error['line']);
    }
}
function handler( $errno, $errstr, $errfile, $errline ) {
    switch ($errno){
        case E_ERROR: // 1 //
            $typestr = 'E_ERROR'; break;
        case E_WARNING: // 2 //
            $typestr = 'E_WARNING'; break;
        case E_PARSE: // 4 //
            $typestr = 'E_PARSE'; break;
        case E_NOTICE: // 8 //
            $typestr = 'E_NOTICE'; break;
        case E_CORE_ERROR: // 16 //
            $typestr = 'E_CORE_ERROR'; break;
        case E_CORE_WARNING: // 32 //
            $typestr = 'E_CORE_WARNING'; break;
        case E_COMPILE_ERROR: // 64 //
            $typestr = 'E_COMPILE_ERROR'; break;
        case E_CORE_WARNING: // 128 //
            $typestr = 'E_COMPILE_WARNING'; break;
        case E_USER_ERROR: // 256 //
            $typestr = 'E_USER_ERROR'; break;
        case E_USER_WARNING: // 512 //
            $typestr = 'E_USER_WARNING'; break;
        case E_USER_NOTICE: // 1024 //
            $typestr = 'E_USER_NOTICE'; break;
        case E_STRICT: // 2048 //
            $typestr = 'E_STRICT'; break;
        case E_RECOVERABLE_ERROR: // 4096 //
            $typestr = 'E_RECOVERABLE_ERROR'; break;
        case E_DEPRECATED: // 8192 //
            $typestr = 'E_DEPRECATED'; break;
        case E_USER_DEPRECATED: // 16384 //
            $typestr = 'E_USER_DEPRECATED'; break;
    }
    $message = '<b>'.$typestr.': </b>'.$errstr.' in <b>'.$errfile.'</b> on line <b>'.$errline.'</b><br/>';
    if(($errno & E_FATAL) && ENV === 'production'){
        header('Location: 500.html');
        header('Status: 500 Internal Server Error');
    }
    if(!($errno & ERROR_REPORTING))
        return;
    if(DISPLAY_ERRORS)
        printf('%s', $message);
    //Logging error on php file error log...
    if(LOG_ERRORS)
        error_log(strip_tags($message), 0);
}
ob_start();


	/*session_start();
	require_once '../lib/fpdf/fpdf.php';
	include("conexion.php");
    */
	$idpermiso 			= $_GET["idpermiso"];
	$cod_colaborador	= $_GET['idcolaborador'];
	$fechaGenerado      = date("d-m-Y");
	$horaGenerado       = date("h:i:s a");

	

		class ReportPdf extends FPDF
		{

				function Header()
				{

					$this->Image('../contenidos/imagenes/logo_empresa.jpg', 10, 10, 60);
					$this->SetFont("Arial", "B", 8);
					$this->Cell(0, 5, "REPORTE DE PERMISOS", 0, 2, 'R');
					$this->Ln(0);
					$this->Cell(0, 5, "COLABORADOR: ".$_GET['colaborador']." ", 0, 2, 'R');
					//$this->Cell(0, 8, "Generado a las ".date("h:i:s A")." del ".$_SESSION['fechaactual'], 0, 2, 'R');
				}

				function Footer()
				{

					$this->SetY(-12);
					$this->SetFont('Arial','',8);
					$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
					$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP a las ".date("H:i:s"), 0, 2,'C');
				}

				function Tabla($header,$datos,$w,$al)
				{

					$this->SetFillColor(151, 130, 45);
					$this->SetTextColor(255);
					$this->SetDrawColor(0,0,0);
					$this->SetLineWidth(.1);
					$this->SetFont('','',7);

					
					for($i=0;$i<count($header);$i++){
						$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
					}
					$this->Ln();

					$this->SetFillColor(255, 246, 210);
					$this->SetTextColor(0);

					$Relleno=0;
					$j=0;
					$k=36;
					$l=0;
					    while($row=mysqli_fetch_array($datos))
					    {
					    	
						  
						  for($i=0;$i<count($header);$i++){
						  
						    
						    $this->Cell($w[$i],6,utf8_decode($row[$i]),'LR',0,$al[$i],$Relleno);
								
						   }
						   $this->Ln();
						   $Relleno=!$Relleno;
						   	$j++;
							
							if($j==$k){	
								$l++;
								if($l==1){$k=36;}
								$j=-1;
								$this->Cell(array_sum($w),0,'','T');
								$this->AddPage();
								$this->SetY(25);
								$this->SetFillColor(40,22,111);
								$this->SetTextColor(255);
								//$this->SetDrawColor(0,0,0);
								$this->SetLineWidth(.3);
								$this->SetFont('','I');

							
								for($i=0;$i<count($header);$i++){
									$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
								}
								$this->Ln();

								$this->SetFillColor(224,235,255);
								$this->SetTextColor(0);
								$this->SetFont('');
								$Relleno=0;
							}	
						}
						
						$this->Cell(array_sum($w),0,'','T');
					}
		}


$reportePdf = new ReportPdf();
$reportePdf->AddPage("L", "legal");


	mysqli_query( $conn, "SET lc_time_names = 'es_CO'" );
	mysqli_set_charset($conn, "utf8");

	$sql = mysqli_query($conn, "SELECT p.percodigo, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, p.perobservacion_autorizacion,  CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND  p.clbcodigo = $cod_colaborador ORDER BY p.perestado_tramite DESC");



			$reportePdf->SetFont('helvetica','B',11);
			$reportePdf->Ln(9);

		   
		    $EncabezadoColumnas=array(utf8_decode('Código'), 'Permiso Desde', 'Permiso Hasta','Usuario Registro','Usuario Autoriza', 'Observaciones Registro', 'Observaciones Finales', 'Fecha Autoriza', 'Estado');

		  	$AnchoColumnas = array(10,28,28,45,45,70,70,25,20);
			 
		    $AlineacionColumnas=array('R','L','L','L','L','L','L', 'L', 'C');
		    $reportePdf->Tabla($EncabezadoColumnas,$sql,$AnchoColumnas,$AlineacionColumnas);
		    $reportePdf->SetFont('helvetica','B',11);
		    $reportePdf->Ln();
	    

$reportePdf->Output("".utf8_decode('REPORTE DE PERMISOS '). $_GET['colaborador'].".pdf", "I");


mysqli_close($conn);
ob_end_flush();
?>