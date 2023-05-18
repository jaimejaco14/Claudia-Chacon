<?php
class Database{
	
	private $host  = 'localhost';
    private $user  = 'appbeauty';
    private $password   = "bty_ERP@2017";
    private $database  = "beauty_erp"; 
    
    public function getConnection(){		
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
/* change character set to utf8mb4 */
mysqli_set_charset($conn, "utf8mb4");
		if($conn->connect_error){
			die("Error failed to connect to MySQL: " . $conn->connect_error);
		} else {
			return $conn;
		}
    }
}
?>
