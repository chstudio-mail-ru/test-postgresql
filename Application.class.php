<?php
//Singleton pattern (for example)
class Application extends Html //in Html class there is magic method __call with suffix Begin or suffix End for return valid html tag,
							   //application works without Smarty or Twig templates
{	private static $instance = null;

	private function __construct()
	{	}

	private function __clone()
	{	}

	static function getInstance()
	{		if(self::$instance == null)
		{			self::$instance = new Application();		}
		return self::$instance;	}

	//main application method
	function start()
	{		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		echo $this->htmlBegin("xmlns=\"http://www.w3.org/1999/xhtml\"", "xml:lang=\"en\"", "lang=\"en\"");
		echo $this->headBegin();
		echo $this->metaBegin("http-equiv=\"Content-Type\"", "content=\"text/html; charset=utf-8\"").$this->metaEnd();
		echo $this->styleBegin("type=\"text/css\"");
		echo "table {margin: 10px 0 10px 0; width:1060px; border: 2px solid black;}\n";
		//echo "th {border: 1px solid black;}\n";
		//echo "td {border: 1px solid black;}\n";
		echo $this->styleEnd();
		echo $this->headEnd();
		echo $this->bodyBegin();

		//conect to Postgre server
		$pg = new PostgreSQL();
  		//echo $pg->test();

  		echo $this->formBegin("method=\"post\" action=\"\"");

  		//class MainTable (glue all departments to one table)
  		$mt = new MainTable();
  		$mt->parseRequest($_REQUEST);
  		if(array_key_exists('updated', $_REQUEST))
  		{
	  		$mt->show($_REQUEST);
	  	}
	  	else
  		{
	  		echo $mt->show($_REQUEST);
	  	}

  		if(array_key_exists('updated', $_REQUEST))
  		{
	  		//show changes after update
	  		$mt = new MainTable();
	  		echo $mt->show();
  		}

		$ad = new AddDepTable();
		echo $ad->show();

		$ar = new AddRecordTable();
		echo $ar->show();

		echo $this->inputBegin("type=\"hidden\"", "name=\"updated\"", "value=\"1\"").$this->inputEnd();
		echo $this->inputBegin("type=\"submit\"", "name=\"save_changes\"", "value=\"Сохранить изменения\"").$this->inputEnd();

  		echo $this->formEnd();

  		echo $this->bodyEnd();
  		echo $this->htmlEnd();
	}
}