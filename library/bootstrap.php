<?php

class bootstrap
{
	
	function __construct()
	{
		$config = include __DiR__.'/../app/config/config.php';


		$method = $_SERVER['REQUEST_METHOD'];
		$requestUri = $_SERVER['REQUEST_URI'];

		$scriptName = $_SERVER['SCRIPT_NAME'];

		if (strpos($requestUri, $scriptName) !== false) {
		    $physicalPath = $scriptName; // <-- Without rewriting
		} else {
			$physicalPath = str_replace('\\', '', dirname($scriptName)); // <-- With rewriting
		}

		$request = substr_replace($requestUri, '', 0, strlen($physicalPath));

		$url = (urldecode($request));
		$url = explode('/',ltrim(rtrim($url,'/'),'/'));

		$config['controller'] = (!empty($config['controller']))? $config['controller']:'home';

		if(empty($url[0]))
		{
			require_once CONTPATH.$config['controller'].'Controller.php';
			$controller = new $config['controllerClass']($config);
			try {
				$controller->loadModel('home');
			} catch (Exception $e) {
				$this->error($e->getMessage());
				return false;
			} 
			$controller->index();
			return false;
		}

		$file = CONTPATH.$url[0].'Controller.php';

		if(file_exists($file))
		{
			require_once $file;
		}
		else
		{
			$this->error('could not load controller');
			return false;
		}

		$controller = new $url[0]($config);
		
		if(!$controller->loadModel($url[0]))
		{
			$this->error('could not load model');
		}

		if (isset($url[2])) 
		{
			if (method_exists($controller, $url[1])) 
			{
				$controller->{$url[1]}($url);
			} 
			else 
			{
				$this->error('method does not exist');
			}
		}
		else
		{
			if (isset($url[1]))
			{
				if (method_exists($controller, $url[1])) 
				{
					$controller->{$url[1]}();
				} 
				else 
				{
					$this->error('method does not exist');
				}
			} 
			else 
			{
				$controller->index();
			}
		}
	}

	public function error($err = 'error') 
	{
		if(file_exists(CONTPATH.'errorController.php'))
		{
			require_once CONTPATH.'errorController.php';
			echo $err.'</br>';
			$controller = new Error();
			$controller->loadModel('error');
			$controller->index();
			return false;
		}
		else
		{
			echo 'error proccesing request';
			return false;
		}
	}
}
