<?php
abstract class Html
{
    private static $tags = array("html", "head", "meta", "style", "script", "body", "form", "table", "tbody", "tr", "th", "td", "input", "select", "option", "div");

    //magic method _call
    //$arguments may be args of html tag (see to w3c.org for help)
    function __call($methodName="", $arguments=array())
    {
    	{
    		if(strlen($args) < 1)
    		{
    		return "<".preg_replace("/Begin$/", "", $methodName)." ".$args.">\n";
    	}
    	{
    	else
    	{
}