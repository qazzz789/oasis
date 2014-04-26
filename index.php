<?php

defined('BASEPATH')	or	define('BASEPATH', 'http://localhost/oasis');
defined('CONTPATH')	or	define('CONTPATH', __DIR__.'\library/../app/controllers/');
defined('SITENAME')	or	define('SITENAME', 'Oasis');

date_default_timezone_set('America/New_York');

spl_autoload_register(function ($class)
{
	$class = strtolower($class);

	if(file_exists('library/'.$class.'.php'))
		require_once 'library/'.$class.'.php';
	else
		throw new Exception("Unable to load $class.");
});

try {

	$app = new bootstrap();

} catch (Exception $e) {
	echo $e->getMessage(), "\n";
}