<?php
class PostgreSQL
{

    //connect to PostgreSQL server, please type to variable $conn_string valid data for connect to DB
    function __construct()
    {
		$this->conn = pg_connect($conn_string);
		if($this->conn === false)
		{

    //simple test
    function test()
    {
     	$query = pg_query($sql);
     	return pg_num_rows($query);
}