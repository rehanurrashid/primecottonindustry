<?php
class DB {

	//database credentials
	private $host		= "localhost";
	private $db_name	= "cotton";
	private $username	= "root";
	private $password	= "";
	public $conn;

	//get database connection
	public function getConnection(){
		$this->conn = null;
		try {
			$test = $this->conn = new PDO("mysql:host=" .$this->host.";dbname=". $this->db_name, $this->username, $this->password);
			} 

		catch (PDOException $e) {
			echo "Connection Error " . $e->getMessage();
		}
		return $this->conn;
		
	}

}