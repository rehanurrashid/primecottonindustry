<?php
class User{

	//database connection & tablename
	private $conn;
	private $table_name ="wp_users";

	// object properties
	public $ID;
	public $email;
	public $password;
	public $created;

	// constructor with $db as database conneciton
	public function __construct($db){
		$this->conn = $db;
	}

	//user signup function
	function signup(){
		if($this->isAlreadyExist()){
			return false;
		}
		else{

			$query = "INSERT INTO" . $this->table_name . "
		SET
			email=:email,
			password=:password,
			created=:created";

		//prepare query
		$statement =  $this->conn->prepare($query);

		//sanitize values
		$statement->email=htmlspecialchars(strip_tags($this->email));
		$statement->password=htmlspecialchars(strip_tags($this->password));
		$statement->created=htmlspecialchars(strip_tags($this->created));

		//bind parameters
		$statement->bindParam(":email", $this->email);
		$statement->bindParam(":password", $this->password);
		$statement->bindParam(":created", $this->created);

		//execute statement
		if($statement->execute()){
			$this->ID = $this->conn->lastInsertId();
			return true;
		}
			return false;
		}
	}
	function login(){
		//SELECT all query
		$query = "SELECT
				*
				FROM
				". $this->table_name."
				WHERE 
				user_email='".$this->email."'
				AND user_pass='".$this->password."'";
		//prepare query statement
		$statement = $this->conn->prepare($query);

		//excute query
		$statement->execute();
		return $statement;
				
	}
	function isAlreadyExist(){
		$query = "SELECT * 
		FROM
			" . $this->table_name . " 
		WHERE
			email ='" . $this->email."'";
	//prepare query statement
			$statement = $this->conn->prepare($query);
	//excute query
			$statement->execute();
		if($statement->rowCount() > 0){
			return true;
		}
		else {
			return false;
		}
	}
}