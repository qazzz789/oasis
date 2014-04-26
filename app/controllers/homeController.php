<?php

class home extends Controller
{
	public function __construct($config)
	{
		parent::__construct($config);
		parent::hasModel(true);
	}

	public function index()
	{
		echo 'index</br>';

		print_r($this->model->index());
	}

}