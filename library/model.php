<?php

class Model
{
	
	public function __construct($config)
	{
		$this->db = new Database($config['host'], $config['user'], $config['pass'], $config['db']);

		try {
			$this->db->open();
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	public function __destruct()
	{
		try {
			if(isset($this->db))
				$this->db->close();
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}