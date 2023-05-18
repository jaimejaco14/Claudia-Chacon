<?php
class Database{
	
	private $host  = 'localhost';
   	 private $user  = 'appbeauty';
   	 private $password   = "bty_ERP@2017";
	   	 private $database  = "beauty_erp"; 
    private $charset = "utf8";
    private $collation = "utf8_unicode_ci";
	private $port = 3306;

    public function getConnection(){		
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);

		if($conn->connect_error){
			die("Error failed to connect to MySQL: " . $conn->connect_error);
		} else {
			return $conn;
		}
    }
}
?>
