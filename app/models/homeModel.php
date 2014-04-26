<?php

class homeModel extends Model
{
	public function __construct($config)
	{
		parent::__construct($config);
	}

	public function index()
	{	
		return $this->db->query('SELECT * FROM system_users WHERE USER_ID = ?', 'i', array(1));
	}
}

