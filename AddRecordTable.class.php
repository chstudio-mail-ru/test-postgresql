<?php
class AddRecordTable extends MainTable
{
	function __construct()
	{		parent::__construct();	}

	//returns table with add input fields (with combobox department list)
	function show($request = [])
	{		$content = "";

		$content .= $this->tableBegin("collspacing=\"0\"", "cellpadding=\"0\"");	//"border=\"1\"",
		$content .= $this->tbodyBegin();

		$content .= "	".$this->trBegin();

		//table header Название отдела
		$content .= "	".$this->thBegin("colspan=\"4\"", "style=\"width:500px\"");
		$content .= "		Добавление записи в раздел\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->tdBegin("colspan=\"3\"", "style=\"width:560px\"");
		$content .= "		".$this->showDepartmentsSelect();
		$content .= "	".$this->tdEnd();

		$content .= "	".$this->trEnd();
		//table captions
		$content .= "	".$this->trBegin();

		//Наименование Количество Цена за ед. Комментарий
		$content .= "	".$this->thBegin("style=\"width:40px\"");
		$content .= "";
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
		$content .= "";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->thBegin("style=\"width:300px\"");
		$content .= "		Комментарий\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->thBegin("style=\"width:120px\"");
		$content .= "";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->trEnd();
		//inputs
		$content .= "	".$this->trBegin();

		$content .= "		".$this->tdBegin();
		$content .= "&nbsp;&nbsp;&nbsp;&nbsp;";
		$content .= "		".$this->tdEnd();

		$content .= "		".$this->tdBegin();
		$content .= "			".$this->inputBegin("type=\"text\"", "value=\"\" ", "name=\"add_name\"", "style=\"width:300px;\"")."			".$this->inputEnd();
		$content .= "		".$this->tdEnd();

		$content .= "		".$this->tdBegin();
		$content .= "			".$this->inputBegin("type=\"text\"", "value=\"\" ", "name=\"add_num\"", "style=\"width:100px;\"")."			".$this->inputEnd();
		$content .= "		".$this->tdEnd();

		$content .= "		".$this->tdBegin();
		$content .= "			".$this->inputBegin("type=\"text\"", "value=\"\" ", "name=\"add_price\"", "style=\"width:100px;\"")."			".$this->inputEnd();
		$content .= "		".$this->tdEnd();

		$content .= "		".$this->tdBegin();
		$content .= "";
		$content .= "		".$this->tdEnd();

		$content .= "		".$this->tdBegin();
		$content .= "			".$this->inputBegin("type=\"text\"", "value=\"\" ", "name=\"add_comment\"", "style=\"width:300px;\"")."			".$this->inputEnd();
		$content .= "		".$this->tdEnd();

		//add record button
		$content .= "		".$this->tdBegin();
		$content .= "			".$this->inputBegin("type=\"submit\"", "value=\"Добавить\" ", "name=\"add_record\"", "style=\"width:120px;\"")."			".$this->inputEnd();
		$content .= "		".$this->tdEnd();

		$content .= "	".$this->trEnd();

		$content .= $this->tbodyEnd();
		$content .= $this->tableEnd();

		return $content;
	}

	//returns html of combobox with departments list
	private function showDepartmentsSelect()
	{		$content = $this->selectBegin("name=\"add_to_department_id\"", "style=\"width:580px;\"");
		foreach($this->departments as $key=>$value)
		{			$content .= "			".$this->optionBegin("value=\"".$key."\"").$value."\n			".$this->optionEnd();		}
		$content .= "		".$this->selectEnd();

		return $content;	}}