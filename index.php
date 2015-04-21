<?php
	//automatic load classes
	include_once("autoload.php");
	try
	{
		//get Singleton object
		$app = Application::getInstance();
		//start application
		$app->start();
	}
	catch (Exception $e)	//something wrong
	{
	    echo $e->getMessage()."\n";
	}


