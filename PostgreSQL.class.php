<?php
class PostgreSQL
{	private $conn = null;

    //connect to PostgreSQL server, please type to variable $conn_string valid data for connect to DB
    function __construct()
    {		$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=1";
		$this->conn = pg_connect($conn_string);
		if($this->conn === false)
		{			throw new Exception("Unable to connect to DB.");		}    }

    //simple test
    function test()
    {    	$sql = "SELECT 1";
     	$query = pg_query($sql);
     	return pg_num_rows($query);    }
}
