<?php
include("Nucleus/core.php");
// This class is responsible for creating a database or connecting to an existing one.
class NucleusDatabase {

	// The private members of this class.
	private $host = "localhost";
	private $database_name = "";
	private $username = "";
	private $password = "";
	private $connection;

	// The constructor method for this class.
	function __construct($_servername, $_username, $_password, $_dbname)
	{
		$this->servername = $_servername;
		$this->username = $_username;
		$this->password = $_password;
		$this->database_name = $_dbname;

		//$this->CreateDatabase();
		$sql = "CREATE DATABASE IF NOT EXISTS " . $this->database_name . ";";
		if (!isset($this->connection))
			$this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database_name) or die("Error: " . mysqli_error($this->connection));
		if ($this->connection->query($sql) === TRUE) {

			/*
			// Fill db with tables, if empty. We do not use this->Query here because we don't want to die on failure
			$check_table = mysqli_query($this->connection, "SELECT id FROM Users;");

			if (empty($check_table))
			{
				$this->Query("CREATE TABLE Users(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(60) NOT NULL, password VARCHAR(60) NOT NULL);");
			}
			*/
			$this->QueryFromFile("/test.sql");

		} else {
			NucleusUtility::Debug("Error creating database:", $this->connection->error);
		}
	}

	public function Query($query)
	{
		if (isset($this->connection))
		{
			mysqli_query($this->connection, $query) or die("A MySQL error has occurred.<br />Error:" . mysqli_error($this->connection));
		}
	}

	public function QueryFromFile($file)
	{
		$command = "mysql -u{$this->username} -p{$this->password} -h {$this->host} -D {$this->database_name} < {$file}";
		$output = shell_exec($command);
		echo $output;
		echo $command;
	}
}
?>