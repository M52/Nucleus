<?php
include("Nucleus/core.php");
// This class is responsible for creating a database or connecting to an existing one.
class NucleusDatabase {

	// The private members of this class.
	private $host = "localhost";
	private $database_name = "";
	private $username = "";
	private $password = "";

	// This member holds the connection.
	private $connection;

	// The constructor method for this class.
	function __construct($_servername, $_username, $_password)
	{
		$this->servername = $_servername;
		$this->username = $_username;
		$this->password = $_password;
	}

	public function Connect()
	{
		// If a connection was previously established, terminate it first then restart.
		if (isset($this->connection))
			$this->Close();

		// Establish a new connection
		$this->connection = new mysqli($this->servername, $this->username, $this->password);

		//Check if the connection was sucessfully established.
		if ($this->connection->connect_error)
		{
			die("Connection failed: " . $this->connection->connect_error);

		// REFACTOR. Temporary code.
		} else {
			NucleusUtility::Debug("Succes!", "Connection to DB succesfull");
		}
		// REFACTOR.
	}

	public function CreateDatabase($name)
	{
		// A local string to hold our sql query.
		$sql = "CREATE DATABASE IF NOT EXISTS " . $name . ";";

		// Make sure a connection exists.
		if (!isset($this->connection))
			$this->Connect();

		if ($this->connection->query($sql) === TRUE) {
			NucleusUtility::Debug("Succes!", "Database ".$name." created successfully");

			// Fill db with tables
			$this->QueryFromSQLFile("test.sql");

		} else {
			NucleusUtility::Debug("Error creating database:", $this->connection->error);
		}
	}

	public function QueryFromSQLFile($file)
	{
		$cmd = 'mysql' 
		.' --host='.$this->host
		.' --user='.$this->username
		.' --password='.""
		.' --database='.$this->database_name
		.' --execute="SOURCE '.getcwd().'//'.$file.'"';
		echo $cmd;
		$result = shell_exec($cmd);
		echo $result;
	}

	public function CreateUser($username, $password)
	{

	}

	public function Close()
	{
		$this->connection->close();
	}
}
?>