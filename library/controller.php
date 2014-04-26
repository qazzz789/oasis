<?php

class Controller
{
	protected $model;
	private $mysql;

	public function __construct($config = array())
	{
		$this->view = new View();
		$this->mysql = (empty($config['mysql']))? array() : $config['mysql'];
	}

	public function hasModel($mod = false)
	{
		$this->mod = $mod;
	}

	public function loadModel($name)
	{
		$path = __DiR__.'/../app/models/'.$name.'Model.php';

		if(file_exists($path) && $this->mod == true)
		{
			require_once $path;
			$modelName = $name.'Model';
			try {
				$this->model = new $modelName($this->mysql);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
			return true;
		}
		else if ($this->mod == false)
			return true;
		else
			return false;
	}
}