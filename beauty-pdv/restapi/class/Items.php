<?php
class Items{   
    
	
	//TABLE CLIENT
	private $itemsTable = "btycliente"; 
	private $tableNameClients = "btytercero";

	//TABLE SALONES
	private $tableSalones = "btysalon"; 
	private $tableSalonYcolaboradores = "btysalon_base_colaborador";

	//TABLE COLABORADORES
	private $tableColaboradores = "bty_vw_servicios_colaborador";

	//TABLE HORARIOS
	private $tableHorariosSalon = "btyhorario_salon";
	private $tableHorarios = "btyhorario";

	//TABLE CITAS
	private $tableCitas = "btycita";

	public $documento;
	public $salon_id;
	public $colaborador_id;
    private $conn;
	
    public function __construct($db){
        $this->conn = $db;
    }	
	
	function cliente(){	
		if($this->documento) {
			//$stmt = $this->conn->prepare("SELECT * FROM ".$this->itemsTable ." INNER JOIN ".$this->tableNameClients." ON ".$this->itemsTable.".trcdocumento = ".$this->tableNameClients.".trcdocumento WHERE ".$this->itemsTable.".trcdocumento = ?");

		$stmt = $this->conn->prepare("SELECT * FROM ".$this->itemsTable ." INNER JOIN ".$this->tableNameClients." ON ".$this->itemsTable.".trcdocumento = ".$this->tableNameClients.".trcdocumento WHERE ".$this->itemsTable.".trcdocumento LIKE '%".$this->documento."%'");

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
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->tableSalones."");
			$stmt->execute();			
			$result = $stmt->get_result();		
			return $result;	
		} catch (Exception $e) {
			echo 'Error: ',  $e->getMessage(), "\n";
		}			
		return $result;	
	}
	public function colaboradores(){	
		if($this->salon_id) {
			$id_salon = $this->salon_id;
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->tableSalonYcolaboradores." INNER JOIN ".$this->tableSalones." ON ".$this->tableSalonYcolaboradores.".slncodigo = ".$this->tableSalones.".slncodigo WHERE ".$this->tableSalonYcolaboradores.".slncodigo = ".strval((int)$id_salon)."");
		} else {
			http_response_code(400);     
			echo json_encode('not found');
		}		
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}

	public function nombreColaboradores(){
		$colaboradores = $this->colaboradores();

		$all_id_colaboradores = array();

		foreach($colaboradores as $colaborador) {
			$result = $colaborador['clbcodigo'] . ' ';

			array_push($all_id_colaboradores, $result);
			
		}
	$num = array_map('intval', $all_id_colaboradores);
	$numbers_string = implode(",", $num);
	$stmt = $this->conn->prepare("SELECT * FROM ".$this->tableColaboradores." WHERE clbcodigo IN (".$numbers_string.")");

	

	$stmt->execute();			
	$result = $stmt->get_result();		
	return $result;

	}

	function servicios_colaboradores(){	
		if($this->colaborador_id) {
			

			$clb_codigo = $this->colaborador_id;
			//$stmt = $this->conn->prepare("SELECT DISTINCT * FROM ".$this->tableColaboradores." WHERE clbcodigo IN (".strval($clb_codigo).")");
			$stmt = $this->conn->prepare("SELECT DISTINCT sernombre, sercodigo, clbcodigo FROM ".$this->tableColaboradores." WHERE clbcodigo = ".strval((int)$clb_codigo)."");


		} else {
			http_response_code(400);     
			echo json_encode('not found');
		}		
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
		
	}

	function turno_salon(){	
		if($this->salon_id) {

			$id_salon = $this->salon_id;

			$stmt = $this->conn->prepare("SELECT * FROM ".$this->tableHorariosSalon." INNER JOIN ".$this->tableHorarios." ON ".$this->tableHorariosSalon.".horcodigo = ".$this->tableHorarios.".horcodigo WHERE ".$this->tableHorariosSalon.".slncodigo = ".strval($id_salon)."");

		} else {
			http_response_code(400);     
			echo json_encode('not found');
		}		
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}

	public function disponibilidad(){
		if($this->salon_id) {

			//$slncodigo = $data['salon_id'];
			//$citfecha = $data['fecha_cita'];
			//$fechaString = date('Y-m-d', strtotime($citfecha));
	                
			$slncodigo = $this->salon_id;
			$fechaString = $this->fecha_id;
			
			//$stmt = $this->conn->prepare("SELECT * FROM btycita WHERE btycita.slncodigo = ".$slncodigo." AND btycita.citfecha = $fechaString");
			$stmt = $this->conn->prepare("SELECT  * FROM btycita INNER JOIN btyservicio ON btycita.sercodigo = btyservicio.sercodigo WHERE btycita.slncodigo = $slncodigo AND btycita.citfecha = $fechaString");

		} else {
			http_response_code(400);     
			echo json_encode('not found');
		}		
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	public function crearCita(){
 		if($this->salon_id){
	
			$clbcodigo = $this->colaborador_id;
			$slncodigo = $this->salon_id;
			$sercodigo = $this->servicio_id;
			$clicodigo = $this->cliente_id;
			$citfecha = $this->fecha_cita;
			$cithora = $this->hora_cita;
			$citobservaciones = $this->asunto;
					

			$id_table_cita = $this->conn->prepare("SELECT citcodigo FROM ".$this->tableCitas." ORDER BY citcodigo DESC LIMIT 1;");

			$id_table_cita->execute();
			$result = $id_table_cita->get_result();
			$row = $result->fetch_assoc();			

			$sumarID = $row['citcodigo'] + 1;

			$stmt = $this->conn->prepare("INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES($sumarID , 1, $clbcodigo, $slncodigo, $sercodigo, $clicodigo, 111 , $citfecha , $cithora, CURDATE(), CURTIME(), $citobservaciones)");
			$result =mysqli_stmt_execute($stmt);

			if($result == 1){
				$stmt = $this->conn->prepare("INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (1, $sumarID, CURDATE(), CURTIME(), 111, '')");
				$result =mysqli_stmt_execute($stmt);
				return $result;

			}


		}else{
			http_response_code(400);     
			echo json_encode('not found');
		}
			
	}

	
}
?>
