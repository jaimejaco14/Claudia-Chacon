<?php 
	header( 'Content-Type: application/json' );
	include '../../cnx_data.php';
	require_once '../../lib/phpexcel/Classes/PHPExcel.php';

	$fechaGenerado           = date("d-m-Y");
	$horaGenerado            = date("h:i:s a");

	if ($_GET['tipo'] == '0' AND $_GET['sln'] == '0' AND $_GET['col'] == '0') 
    {
            $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_GET['fecha1']."' AND '".$_GET['fecha2']."' ORDER BY autcodigo";
    }
    elseif ($_GET['tipo'] != '0' AND $_GET['sln'] == '0' AND $_GET['col'] == '0') 
    {
            $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_GET['fecha1']."' AND '".$_GET['fecha2']."' AND a.auttipo_codigo = '".$_GET['tipo']."' ORDER BY autcodigo";
    }
    elseif ($_GET['tipo'] != '0' AND $_GET['sln'] != '0' AND $_GET['col'] == '0') 
    {
            $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_GET['fecha1']."' AND '".$_GET['fecha2']."' AND a.auttipo_codigo = '".$_GET['tipo']."' AND a.slncodigo = '".$_GET['sln']."' ORDER BY autcodigo";
    }
    elseif ($_GET['tipo'] != '0' AND $_GET['sln'] != '0' AND $_GET['col'] != '0') 
    {

    	if ($_GET['tipoU'] == 'M') 
        {

            $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_GET['fecha1']."' AND '".$_GET['fecha2']."' AND a.slncodigo = '".$_GET['sln']."' AND a.prmcodigo = '".$_GET['col']."' ORDER BY autcodigo";

        }
        elseif ($_GET['tipoU'] == 'P') 
        {
               $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_GET['fecha1']."' AND '".$_GET['fecha2']."' AND a.slncodigo = '".$_GET['sln']."' AND a.prvcodigo = '".$_GET['col']."' ORDER BY autcodigo";
        }
        elseif ($_GET['tipoU'] == '0' || $_GET['tipoU'] == '1') 
        {
               $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_GET['fecha1']."' AND '".$_GET['fecha2']."' AND a.slncodigo = '".$_GET['sln']."' AND a.clbcodigo = '".$_GET['col']."' ORDER BY autcodigo";

        }            
    }
    elseif ($_GET['tipo'] != '0' AND $_GET['sln'] == '0' AND $_GET['col'] != '0')
    {
    	if ($_GET['tipoU'] == 'M') 
        {

            $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_GET['fecha1']."' AND '".$_GET['fecha2']."' AND a.auttipo_codigo = '".$_GET['tipo']."' AND a.prmcodigo = '".$_GET['col']."' ORDER BY autcodigo";

        }
        elseif ($_GET['tipoU'] == 'P') 
        {
               $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_GET['fecha1']."' AND '".$_GET['fecha2']."' AND a.auttipo_codigo = '".$_GET['tipo']."' AND a.prvcodigo = '".$_GET['col']."' ORDER BY autcodigo";
        }
        elseif ($_GET['tipoU'] == '0' || $_GET['tipoU'] == '1') 
        {
               $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_GET['fecha1']."' AND '".$_GET['fecha2']."'AND a.auttipo_codigo = '".$_GET['tipo']."' AND a.clbcodigo = '".$_GET['col']."' ORDER BY autcodigo";

        }
    }



	$array = array();
	$query = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_object($query)) 
	{
		$array[] = array(
			'codigo' 		=>$row->autcodigo,
			'tipo'   		=>$row->nombre,
			'subtipo'   	=>$row->subtipo_nombre,
			'colaborador'	=>$row->colaborador,
			'autoriza'   	=>$row->autoriza,
			'valor'  		=>$row->autvalor,
			'porcentaje'      =>$row->autporcentaje,
			'observacion'  	=>$row->observacion,
			'fecha_aut'  	=>$row->autfecha_autorizacion,
			'cargo'  		=>$row->cargo,
			'salon'  		=>$row->slnnombre,
			'fecha_reg'  	=>$row->autfecha_registro,
			'estado'  		=>$row->autestado_tramite,
		);
	}

						

	function utf8_converter($array)
	{
		array_walk_recursive($array, function(&$item, $key){
		      if(!mb_detect_encoding($item, 'utf-8', true)){
		        $item = utf8_encode($item);
		      }
		});

		return $array;
		}

		$array = utf8_converter($array); 

  	

	$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q");
	$i        = 2;
	$reporteExcel = new PHPExcel();
	$reporteExcel->getProperties()
					->setCreator("Beauty Soft")
					->setLastModifiedBy("Beauty Soft")
					->setTitle("REPORTE DE AUTORIZACIONES")
					->setSubject("REPORTE DE PERMISOS")
					->setDescription("Reporte generado a través de Beauty Soft")
					->setCategory("reportes");

	//Creacion de imagen de cabecera
	$imagenCliente = new PHPExcel_Worksheet_Drawing();
	$imagenCliente->setHeight(45);
	$imagenCliente->setWorksheet($reporteExcel->getActiveSheet(0));

	$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);


		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A1", "Código")
						->setCellValue("B1", "Tipo")
						->setCellValue("C1", "Subtipo")
						->setCellValue("D1", "Beneficiario")
						->setCellValue("E1", "Cargo")
						->setCellValue("F1", "Valor")
						->setCellValue("G1", "Porcentaje")
						->setCellValue("H1", "Salón")
						->setCellValue("I1", "Observación")
						->setCellValue("J1", "Fecha Autorización")
						->setCellValue("K1", "Autorizado Por")
						->setCellValue("L1", "Estado");
	

		foreach($columnas as $columna)
		{

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A1:L1")->getFont()->setBold(true);

		foreach($array as $colaborador)
		{	

			$date  = date_create($colaborador["fecha_aut"]);
			$fecha = date_format($date, 'd/m/Y');
		
			$reporteExcel->setActiveSheetIndex(0)
					->setCellValue("A".$i, $colaborador["codigo"])
					->setCellValue("B".$i, $colaborador["tipo"])
					->setCellValue("C".$i, $colaborador["subtipo"])
					->setCellValue("D".$i, $colaborador["colaborador"])
					->setCellValue("E".$i, $colaborador["cargo"])
					->setCellValue("F".$i, $colaborador["valor"])
					->setCellValue("G".$i, $colaborador["porcentaje"])
					->setCellValue("H".$i, $colaborador["salon"])
					->setCellValue("I".$i, $colaborador["observacion"])
					->setCellValue("J".$i, $fecha)
					->setCellValue("K".$i, $colaborador["autoriza"])
					->setCellValue("L".$i, $colaborador["estado"]);
					$i++;
		}


		$reporteExcel->getActiveSheet(0)->setTitle("Estadísticas de Autorizaciones");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Autorizaciones) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de Autorizaciones - Beauty Soft.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		
		$exportarReporte->save("php://output");
	

?>