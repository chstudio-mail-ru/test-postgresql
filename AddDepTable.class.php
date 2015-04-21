<?php
class AddDepTable extends Html //in Html class there is magic method __call with suffix Begin or suffix End for return valid html tag,
						       //application works without Smarty or Twig templates
{
	//returns table with add department field
	function show()
	{		$content = "";

		$content .= $this->tableBegin("collspacing=\"0\"", "cellpadding=\"0\"");
		$content .= $this->tbodyBegin();

		$content .= "	".$this->trBegin();

		//table header Название отдела
		$content .= "	".$this->thBegin("style=\"width:990px\"");
		$content .= "		Название раздела\n";
		$content .= "	".$this->thEnd();

		$content .= "	".$this->tdBegin("style=\"width:120px\"");
		$content .= "		&nbsp;\n";
		$content .= "	".$this->tdEnd();

		$content .= "	".$this->trEnd();
		$content .= "	".$this->trBegin();

		$content .= "	".$this->tdBegin();
		$content .= "		".$this->inputBegin("type=\"text\"", "value=\"\"", "name=\"add_department_name\"", "style=\"width:990px;\"")."			".$this->inputEnd();
		$content .= "	".$this->tdEnd();

		$content .= "	".$this->tdBegin();
		$content .= "		".$this->inputBegin("type=\"submit\"", "value=\"Добавить\"", "name=\"add_department\"", "style=\"width:120px;\"")."			".$this->inputEnd();
		$content .= "	".$this->tdEnd();

		$content .= "	".$this->trEnd();

		$content .= $this->tbodyEnd();
		$content .= $this->tableEnd();

		return $content;
	}
	function parseRequest($request)
	{		echo "AddDepTable";
		print_r($request);
	}
}