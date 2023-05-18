<?php
class Items{ 

public $sercodigo;
    public $slncodigo;
    public $citfecha;
    public $cithora;
    public $documento;
    public $clbcodigo;
    public $clicodigo;
    public $nota;
    public $citobservaciones;
    public $trcdocumento;
	public $trcnombres;
	public $trcapellidos;
	public $trcemail;
	public $trctelefono;
	public $dia_nacimiento;
	public $mes_nacimiento;
	public $tdicodigo;
    private $conn;
	
    public function __construct($db){
        $this->conn = $db;
    }	
	
    
	function disponibilidad(){	
		try{

            $servicio = $this->sercodigo;
            $salon = $this->slncodigo;
            $fecha = $this->citfecha;
            $hora = $this->cithora;


$stmt = $this->conn->prepare("SELECT * 
				FROM btyestado_colaborador est 
				INNER JOIN (
					SELECT DISTINCT c.clbcodigo, svc.sercodigo, svc.sernombre, svc.trcrazonsocial, slncodigo 
					FROM btycolaborador c 
					INNER JOIN bty_vw_servicios_colaborador svc ON c.clbcodigo = svc.clbcodigo 
					INNER JOIN btyservicio s ON svc.sercodigo = s.sercodigo 
					LEFT JOIN btysalon_base_colaborador sbc ON c.clbcodigo = sbc.clbcodigo 
					WHERE svc.sercodigo = $servicio AND slncodigo = $salon
					AND c.clbcodigo NOT IN (
						SELECT DISTINCT clbcodigo FROM btycita WHERE citfecha = $fecha AND cithora = $hora AND c.clbcodigo = clbcodigo
					)
				) AS tblRandom 
				ON est.clbcodigo = tblRandom.clbcodigo 
				INNER JOIN btyprogramacion_colaboradores pc ON pc.clbcodigo = tblRandom.clbcodigo
				WHERE est.cletipo = 'VINCULADO'
				AND pc.slncodigo = $salon
				AND pc.clbcodigo IS NOT NULL
				AND pc.slncodigo = $salon
				AND pc.prgfecha = $fecha
				AND pc.tprcodigo IN (1,9,10)
				ORDER BY RAND()
				LIMIT 0,1;
            ");

            $stmt->execute();			
            $result = $stmt->get_result();		
            return $result;	
		}catch(Exception $e){
            http_response_code(400);     
            echo json_encode('not found');
        }
	}

    function cliente(){	
        try{
            $documento = $this->documento;
            $stmt = $this->conn->prepare("SELECT * FROM btycliente INNER JOIN btytercero ON btycliente.trcdocumento = btytercero.trcdocumento WHERE btycliente.trcdocumento = ".strval($documento)."");
            $stmt->execute();			
            $result = $stmt->get_result();		
            return $result;
        }catch(Exception $e){
            http_response_code(400);     
            echo json_encode('not found');
        }

	}

    function turno_salon(){	
		if($this->slncodigo) {

			$id_salon = $this->slncodigo;

			$stmt = $this->conn->prepare("SELECT * FROM btyhorario_salon INNER JOIN btyhorario ON btyhorario_salon.horcodigo =btyhorario.horcodigo WHERE btyhorario_salon.slncodigo = ".strval($id_salon)."");

		} else {
			http_response_code(400);     
			echo json_encode('not found');
		}		
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
    function salones(){	
		try {
			$stmt = $this->conn->prepare("SELECT * FROM btysalon");
			$stmt->execute();			
			$result = $stmt->get_result();		
			return $result;	
		} catch (Exception $e) {
			echo 'Error: ',  $e->getMessage(), "\n";
		}			
		return $result;	
	}

    function servicios_colaborador(){	
		if($this->slncodigo) {

            $salon = $this->slncodigo;
			$stmt = $this->conn->prepare("SELECT DISTINCT co.sernombre, co.sercodigo
                FROM btysalon_base_colaborador sl
                INNER JOIN bty_vw_servicios_colaborador co ON sl.clbcodigo = co.clbcodigo
                WHERE sl.slncodigo = $salon AND sl.slncodigo = $salon ORDER BY co.sernombre ASC"); 

				if($stmt){
					$stmt->execute();			
					$result = $stmt->get_result();	
					return $result;
				}else{
					http_response_code(400);     
					echo json_encode('not found');
				}
	}
	}

 public function crearCita(){
        try{
			$clbcodigo = $this->clbcodigo;
			$slncodigo = $this->slncodigo;
			$sercodigo = $this->sercodigo;
			$clicodigo = $this->clicodigo;
			$citfecha = $this->citfecha;
			$cithora = $this->cithora;
			$citobservaciones = $this->citobservaciones;
			
			$id_table_cita = $this->conn->prepare("SELECT citcodigo FROM btycita ORDER BY citcodigo DESC LIMIT 1;");

			$id_table_cita->execute();
			$result = $id_table_cita->get_result();
			$row = $result->fetch_assoc();			

			$sumarID = $row['citcodigo'] + 1;

			$stmt = $this->conn->prepare("INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES($sumarID , 1, $clbcodigo, $slncodigo, $sercodigo, $clicodigo, 111 ,'".$citfecha."', '".$cithora."', CURDATE(), CURTIME(), 'Sin Nota')");
			$result =mysqli_stmt_execute($stmt);
			if($result == 1){
				$stmt = $this->conn->prepare("INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (1, $sumarID, CURDATE(), CURTIME(), 111, '')");
				$result =mysqli_stmt_execute($stmt);
				return $result;

			}


		}catch(Exception $e){
            http_response_code(400);     
            echo json_encode($e);
        }
    }
 public function crearDomicilio(){
        try{
			$clbcodigo = $this->clbcodigo;
			$slncodigo = $this->slncodigo;
			$sercodigo = $this->sercodigo;
			$clicodigo = $this->clicodigo;
			$citfecha = $this->citfecha;
			$cithora = $this->cithora;
			$citobservaciones = $this->citobservaciones;

			//SUMAR EL ID DE LA TABLA DE CITAS PORQUE NO SE PUEDE HACER AUTOINCREMENT
			
			$id_table_cita = $this->conn->prepare("SELECT citcodigo FROM btycita ORDER BY citcodigo DESC LIMIT 1;");

			$id_table_cita->execute();
			$result = $id_table_cita->get_result();
			$row = $result->fetch_assoc();			

			$sumarID = $row['citcodigo'] + 1;

			$stmt = $this->conn->prepare("INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES($sumarID , 1, $clbcodigo, $slncodigo, $sercodigo, $clicodigo, 111 ,'".$citfecha."', '".$cithora."', CURDATE(), CURTIME(), 'Sin Nota')");
			$result =mysqli_stmt_execute($stmt);

			if($result == 1){
				$stmt = $this->conn->prepare("INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (10, $sumarID, CURDATE(), CURTIME(), 111, '')");
				$result_insert_cita =mysqli_stmt_execute($stmt);


				if($result_insert_cita == 1){
					// $stmt = $this->conn->prepare("INSERT INTO btydomicilio (dmcodigo, citcodigo, dmvalser, dmvalrec, dmvaltrai, dmvaltrar, dmtotal, dmestado) VALUES ($sumarID_domicilio, $sumarID, 0, 0, 0, 0, 0, 1)");
					$stmt = $this->conn->prepare("INSERT INTO btydomicilio (citcodigo, dmvalser, dmvalrec, dmvaltrai, dmvaltrar, dmtotal) VALUES ($sumarID, 1, 1, 1, 1, 1)");
					$result_insert_domicilio =mysqli_stmt_execute($stmt);

					return $result_insert_domicilio;
				}
			}


		}catch(Exception $e){
            http_response_code(400);     
            echo json_encode('not found');
        }
    }
public function crearCliente(){
		try{
		$trcdocumento = $this->trcdocumento;
		$trcnombres = $this->trcnombres;
		$trcapellidos = $this->trcapellidos;
		$trcemail = $this->trcemail;
		$trctelefono = $this->trctelefono;
		$dia_nacimiento = $this->dia_nacimiento;
		$mes_nacimiento = $this->mes_nacimiento;
		$tdicodigo = $this->tdicodigo;

		$razonsocial = $trcnombres . ' ' . $trcapellidos;

		$fecha_nacimiento = '2023' . '-' . $mes_nacimiento .'-' .$dia_nacimiento;

		$addUser = $this->conn->prepare("INSERT INTO btytercero (tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, brrcodigo, trcestado) VALUES ($tdicodigo, $trcdocumento, 0, '".$trcnombres."', '".$trcapellidos."', '".$razonsocial."', '', '', $trctelefono, 0, 1)");

		$result =mysqli_stmt_execute($addUser);
		if($result == 1){
			$id_tabla_cliente = $this->conn->prepare("SELECT clicodigo FROM btycliente ORDER BY clicodigo DESC LIMIT 1;");

			$id_tabla_cliente->execute();
			$result = $id_tabla_cliente->get_result();
			$id = $result->fetch_assoc();	

			$sumarID_cliente = $id['clicodigo'] + 1;
	
			$stmt = $this->conn->prepare("INSERT INTO btycliente (clicodigo, trcdocumento, tdicodigo, slncodigo, clisexo, ocucodigo, cliextranjero, cliemail, clifechanacimiento, clinotificacionemail, clinotificacionmovil, cliempresa, clifecharegistro, cliimagen, clitiporegistro, cliclave, cliacceso, clitiposangre, cliestado, usucodigo, clifechaupdate) VALUES ($sumarID_cliente, '".$trcdocumento."', $tdicodigo, 18, '', 0, '', '".$trcemail."', '".$fecha_nacimiento."', 'S', 'S', 'N', CURDATE(), 'default.jpg', 'INTERNO', 'NULL', 0, '', 1, 111, CURDATE())");
			
			$result =mysqli_stmt_execute($stmt);
			return $result;
		}

		}catch(Exception $e){
			http_response_code(400);     
			echo json_encode('not found');
		}
	}		
}

