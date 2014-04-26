<?php

/**
* 
*/
class Error extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
		parent::hasModel(false);
	}

	public function index($var = false)
	{
		if($var = false)
		{
			//$this->view->msg = 'This page does not exist';
		}

		//$this->view->render('error/index');
	}
}

?>