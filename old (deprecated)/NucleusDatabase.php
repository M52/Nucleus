<?php
// This class is responsible for creating a database or connecting to an existing one.
class NucleusDatabase {

	// The private members of this class.
	private $host = "localhost";
	private $database_name = "";
	private $username = "";
	private $password = "";
	private $connection;

	/*
	This constructor performs the following operations:
	1. Checks if there is an existing connection (should never happen, technically).
	2. Checks if the requested database exists. If it does not exist it is created.
	3. Creation sets up required tables and constraints but does not fill them.
	*/
	function __construct($_servername, $_username, $_password, $_dbname)
	{
		$this->servername = $_servername;
		$this->username = $_username;
		$this->password = $_password;
		$this->database_name = $_dbname;

		$sql = "CREATE DATABASE IF NOT EXISTS " . $this->database_name . ";";

		if (!isset($this->connection))
			$this->connection = new mysqli($this->servername, $this->username, $this->password) or die("Error: " . mysqli_error($this->connection));

		if ($this->connection->query($sql) === TRUE) {
			$this->connection->Close();
			$this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database_name);
		} else {
			NucleusUtility::Debug("Error creating database:", $this->connection->error);
		}
	}

	// Use this method to directly query the database.
	public function Query($query)
	{
		if (!isset($this->connection))
			die("No connection established");
		$result = mysqli_query($this->connection, $query);
		if ($result)
			return $result;
		else
			die("MySQL Error. Please check your SQL Query: ".$query."<br />ErrorNo: ". mysqli_error($this->connection));
		//return mysqli_query($this->connection, $query); //or die("MySQL Error. Please check your SQL Query: ".$query);
	}

	public function TableExists($_tablename_)
	{
		return !empty(mysqli_query($this->connection, "SELECT * FROM {$_tablename_} LIMIT 1"));
	}

	public function getDatabaseName()
	{
		return $this->database_name;
	}

	public function hasConnection()
	{
		return (isset($this->connection));
	}

	/*
	API Methods.
	*/

	// Will query the database for a specific user.
	public function getUsersByName($_username)
	{
		// TODO: Add prepared statements for safety reasons.
		/*$username = $_username;
		$statement = $this->connection->prepare("SELECT * FROM Users WHERE name=?;");
		$statement->bind_param("s", $username);
		$statement->execute();

		$statement->bind_result($result);

		print_r($result);
		*/
		
		$users = array();
		$result = $this->Query("SELECT * FROM Users WHERE name='{$_username}';");
		while($row = mysqli_fetch_assoc($result))
		{
			$user = new NucleusUser($row["id"], $row["name"], $row["password"]);
			$users[] = $user;
		}

		return $users;
	}


}
?>