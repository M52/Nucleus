<?php
// This class is responsible for creating a database or connecting to an existing one.
class NucleusDatabase {

	// The private members of this class.
	private $servername = "localhost";
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


		// Connection can't be made so the object becomes null
		$connection = new mysqli($this->servername, $this->username, $this->password);

		//Check if the connection was sucessfully established.
		if ($this->connection->connect_error)
		{
			die("Connection failed: " . $this->connection->connect_error);
		}


	}

	public function CreateDatabase($name)
	{
		// A local string to hold our sql query.
		$sql = "CREATE DATABASE " . $name . ";";
		if ($this->connection->query($sql) === TRUE) {
			echo "Database created successfully";
		} else {
			echo "Error creating database: " . $conn->error;
}
	}

	public function Close()
	{
		$this->connection->close();
	}
}
?>