<?php
class NucleusUser {
	private $id;
	private $name;
	private $password;

	function __construct($_id, $_name, $_password)
	{
		$this->id = $_id;
		$this->name = $_name;
		$this->password = $_password;
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getPassword()
	{
		return $this->password;
	}
}
?>