<?php
	//autoload classes (only from current directory)
	function __autoload($name)
	{
	    if(!preg_match("/\\|\//", $name) && is_file($name.".class.php"))
	    {	    	include_once($name.".class.php");	    }
	    else
	    {
	    	throw new Exception("Unable to load $name class.");
	    }
	}
