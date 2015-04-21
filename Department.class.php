<?php
class Department extends Html //in Html class there is magic method __call with suffix Begin or suffix End for return valid html tag,
						      //application works without Smarty or Twig templates
{	private $data_rows = array();
	private $department_id;
	private $department_name;
	//width of input elements
	private $input_width = array("name" => 310, "num" => 100, "price" => 100, "sum" => 100, "comment" => 310);

	function __construct($department_id=0, $name="test")
	{		if($department_id < 1)
		{			throw new Exception("\$department_id is undefined.");
		}
		$this->department_id = $department_id;

		//determination name of current department
		if(strlen($name) < 1)
		{
			$sql = "SELECT * FROM departments WHERE id='".$department_id."' AND deleted=false";
	       	$query = pg_query($sql) or die('Query failed: ' . pg_last_error());
	       	if(pg_num_rows($query) < 1)
	       	{	       		throw new Exception("id = $department_id not found in table `departments`.");	       	}
      		$row = pg_fetch_assoc($query);
        	$this->department_name = $row['name'];
        }
        else
        {
        	$this->department_name = $name;
        }

		$sql = "SELECT * FROM data_rows WHERE department_id='".$department_id."' AND deleted=false ORDER BY id ASC";
       	$query = pg_query($sql) or die('Query failed: ' . pg_last_error());
       	while($row = pg_fetch_assoc($query))
       	{
       		$this->data_rows[$row['id']] = array('name' => $row['name'], 'num' => $row['num'], 'price' => $row['price'], 'sum' => $row['sum'], 'comment' => $row['comment']);
       	}
	}

	//output editable department name with delete button
	function headerName()
	{		$content = "";

		$content .= "	".$this->trBegin();

		$content .= "		".$this->tdBegin("colspan=\"6\"");
		$content .= "			".$this->inputBegin("type=\"text\"", "value=\"".$this->department_name."\"", "name=\"department_name[".$this->department_id."]\"", "style=\"width:990px;\"")."			".$this->inputEnd();
		$content .= "		".$this->tdEnd();

		//delete button
		$content .= "		".$this->tdBegin();
		$content .= "			".$this->inputBegin("type=\"submit\"", "value=\"Удалить раздел\"", "name=\"delete_department[".$this->department_id."]\"", "style=\"width:120px;\"")."			".$this->inputEnd();
		$content .= "		".$this->tdEnd();

		$content .= "	".$this->trEnd();

		return $content;	}

	//output editable data cells with delete button
	function listRows()
	{		$content = "";

		$i=1;

		foreach($this->data_rows as $key=>$value)
		{			$content .= "	".$this->trBegin();
			$content .= "		".$this->tdBegin();
			$content .= "			".$i++."\n";
			$content .= "		".$this->tdEnd();

			foreach($value as $col_name=>$col_value)
			{				if(in_array($col_name, array("id", "department_id", "deleted")))
				{					continue;				}

				$width = ($this->input_width[$col_name])? $this->input_width[$col_name] : 100;
				//in php >= 5.3 can type easier: $this->input_width[$col_name] ?: 100

				$readonly = ($col_name == "sum")? " readonly=\"readonly\"" : null;

				$content .= "		".$this->tdBegin();
				$content .= "			".$this->inputBegin("type=\"text\"", "value=\"".$col_value."\"", "name=\"".$col_name."[".$this->department_id."][".$key."]\"", "style=\"width:".$width."px;\"", $readonly)."			".$this->inputEnd();
				$content .= "		".$this->tdEnd();
			}

			//delete record button
			$content .= "		".$this->tdBegin();
			$content .= "			".$this->inputBegin("type=\"submit\"", "value=\"Удалить\"", "name=\"delete_record[".$this->department_id."][".$key."]\"", "style=\"width:120px;\"")."			".$this->inputEnd();
			$content .= "		".$this->tdEnd();

			$content .= "	".$this->trEnd();
		}

		return $content;
	}
	//add new record to the department, delete record, save records in DB
	function parseRequest($request)
	{
		if(isset($request['add_to_department_id']) && $this->department_id == intval($request['add_to_department_id']) && array_key_exists("add_record", $request) && strlen($request["add_name"]) > 0)
		{
			$sql = "INSERT INTO data_rows (department_id, name, num, price, sum, comment)
					VALUES ('".intval($request['add_to_department_id'])."', '".pg_escape_string($request["add_name"])."', '".intval($request["add_num"])."',
							'".floatval($request["add_price"])."', '".floatval($request["add_price"])*intval($request["add_num"])."', '".pg_escape_string($request["add_comment"])."');";
            $query = pg_query($sql) or die('Query failed: ' . pg_last_error());
		}
		elseif(array_key_exists("delete_record", $request) && is_array($request["delete_record"]) && count($request["delete_record"]) > 0)
		{
			foreach($request["delete_record"] as $department_id=>$record)
			{
				foreach($record as $record_id=>$button_value)
				{
					$sql = "UPDATE data_rows SET deleted=true WHERE id='".intval($record_id)."';";
            		$query = pg_query($sql) or die('Query failed: ' . pg_last_error());
            	}
            }
		}
		elseif(array_key_exists("save_changes", $request))
		{
			$update_num = array();
			foreach($request["name"][$this->department_id] as $record_id=>$value)
			{
				if($this->data_rows[$record_id]['name'] != pg_escape_string($value))
				{
					$sql = "UPDATE data_rows SET name='".pg_escape_string($value)."' WHERE id='".intval($record_id)."';";
	            	$query = pg_query($sql) or die('Query failed: ' . pg_last_error());
            	}
            }
			foreach($request["num"][$this->department_id] as $record_id=>$value)
			{
				if($this->data_rows[$record_id]['num'] != intval($value))
				{
					$sql = "UPDATE data_rows SET num='".intval($value)."', price='".floatval($request["price"][$this->department_id][$record_id])."',
							sum='".floatval($request["price"][$this->department_id][$record_id])*intval($request["num"][$this->department_id][$record_id])."' WHERE id='".intval($record_id)."';";
	            	$query = pg_query($sql) or die('Query failed: ' . pg_last_error());
	            	$update_num[] = $record_id;
            	}
            }
			foreach($request["price"][$this->department_id] as $record_id=>$value)
			{
				if(!in_array($record_id, $update_num) && $this->data_rows[$record_id]['price'] != floatval($value))
				{
					$sql = "UPDATE data_rows SET price='".floatval($value)."', num='".intval($request["num"][$this->department_id][$record_id])."',
							sum='".floatval($request["price"][$this->department_id][$record_id])*intval($request["num"][$this->department_id][$record_id])."' WHERE id='".intval($record_id)."';";
	            	$query = pg_query($sql) or die('Query failed: ' . pg_last_error());
            	}
            }
		}
	}
}
