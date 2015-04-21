<?php
class MainTable extends Html //in Html class there is magic method __call with suffix Begin or suffix End for return valid html tag,
						     //application works without Smarty or Twig templates
{
	protected $departments = array();

	function __construct()
	{		//load all active (not deleted) departments to array $this->departments from DB
		$sql = "SELECT * FROM departments WHERE deleted=false ORDER BY id ASC";
       	$query = pg_query($sql) or die('Query failed: ' . pg_last_error());
       	while($row = pg_fetch_assoc($query))
       	{       		$this->departments[$row['id']] = $row['name'];       	}
	}

	//returns main table html with content
	function show($request=array())
	{		$content = "";

		$content .= $this->tableBegin("collspacing=\"0\"", "cellpadding=\"0\"");
		$content .= $this->tbodyBegin();

		$content .= "	".$this->trBegin();

		//table header №   Наименование Количество Цена за ед. Итого Комментарий
		$content .= "	".$this->thBegin("style=\"width:40px\"");
		$content .= "		№ пп\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->thBegin("style=\"width:300px\"");
		$content .= "		Наименование\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->thBegin("style=\"width:100px\"");
		$content .= "		Количество\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->thBegin("style=\"width:100px\"");
		$content .= "		Цена за ед.\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->thBegin("style=\"width:100px\"");
		$content .= "		Итого\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->thBegin("style=\"width:300px\"");
		$content .= "		Комментарий\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->thBegin("style=\"width:120px\"");
		$content .= "		X\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->trEnd();

		foreach($this->departments as $key=>$value)
		{			$department = new Department($key, $value);

			$department->parseRequest($request);
			//<hr><th> tags
			$content .= $department->headerName();

			//list of data rows (<tr><td> tags) with control buttons
			$content .= $department->listRows();
		}		$content .= $this->tbodyEnd();
		$content .= $this->tableEnd();

		return $content;
	}

	//add new department, delete department, save department names in DB
	function parseRequest($request)
	{		if(array_key_exists("add_department", $request) && strlen($request["add_department_name"]) > 0)
		{			$sql = "INSERT INTO departments (name) VALUES ('".pg_escape_string($request["add_department_name"])."');";
            $query = pg_query($sql) or die('Query failed: ' . pg_last_error());
		}
		elseif(array_key_exists("delete_department", $request) && is_array($request["delete_department"]) && count($request["delete_department"]) > 0)
		{
			foreach($request["delete_department"] as $key=>$value)
			{
				$sql = "UPDATE departments SET deleted=true WHERE id='".intval($key)."';";
            	$query = pg_query($sql) or die('Query failed: ' . pg_last_error());
            }
		}
		elseif(array_key_exists("save_changes", $request))
		{			foreach($request["department_name"] as $key=>$value)
			{
				if(array_key_exists($key, $this->departments) && pg_escape_string($value) != $this->departments[$key])
				{
					$sql = "UPDATE departments SET name='".pg_escape_string($value)."' WHERE id='".intval($key)."';";
	            	$query = pg_query($sql) or die('Query failed: ' . pg_last_error());
            	}
            }
		}
	}}