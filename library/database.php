<?php

class Database
{

	private $connection;
	private $lastQuery;
	private $host, $user, $pw, $db;

	public function __construct($host, $user, $pw, $db)
	{
		$this->host = $host;
		$this->user = $user;
		$this->pw = $pw;
		$this->db = $db;
	}

	public function open()
	{
		try {
			$this->connection = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pw);
		} catch (PDOException $e) {
			throw new Exception('Connection failed: ' . $e->getMessage());
		}
	}

	public function close()
	{
		try {
			if(isset($this->connection))
			{
				unset($this->connection);
			}
		} catch (PDOException $e) {
			throw new Exception('Closing failed: ' . $e->getMessage());
		}
	}

	public function query($sql,$typeDef = FALSE,$params = FALSE)
	{
		if($stmt = $this->connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL)))
		{
			if($typeDef)
			{
				$nums = array();
				$nums = array_pad($nums, count($params), "");
				$bindParams = array();
				$bindParamsReferences = array();
				$typeDef = str_split($typeDef);
				$bindParams = array_pad($bindParams, count($params), "");
				foreach($typeDef as $key => $value)
				{
					if($typeDef[$key] == 'i')
						$typeDef[$key] = PDO::PARAM_INT;
					elseif ($typeDef[$key] == 's') 
						$typeDef[$key] = PDO::PARAM_STR;
					$nums[$key] = $key + 1;

					$stmt->bindParam($key+1, $params[$key], $typeDef[$key]);
			  	}
				foreach($bindParams as $key => $value)
				{
					$bindParamsReferences[$key] = &$params[$key]; 
			  	}
			}

			$result = array();

			if($stmt->execute())
			{
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
					$result[] = $row;
				}
			}
		}
		return $result;
	}

}