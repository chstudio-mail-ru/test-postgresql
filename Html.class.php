<?php
abstract class Html
{    //supported html tags
    private static $tags = array("html", "head", "meta", "style", "script", "body", "form", "table", "tbody", "tr", "th", "td", "input", "select", "option", "div");

    //magic method _call
    //$arguments may be args of html tag (see to w3c.org for help)
    function __call($methodName="", $arguments=array())
    {    	if(preg_match("/Begin$/", $methodName) && in_array(preg_replace("/Begin$/", "", $methodName), Html::$tags))
    	{    		$args = implode(" ", $arguments);
    		if(strlen($args) < 1)
    		{    			return "<".preg_replace("/Begin$/", "", $methodName).">\n";    		}
    		return "<".preg_replace("/Begin$/", "", $methodName)." ".$args.">\n";
    	}    	elseif(preg_match("/End$/", $methodName) && in_array(preg_replace("/End$/", "", $methodName), Html::$tags))
    	{    		return "</".preg_replace("/End$/", "", $methodName).">\n";    	}
    	else
    	{    		throw new Exception("Method ".$methodName." not supported.");    	}    }
}