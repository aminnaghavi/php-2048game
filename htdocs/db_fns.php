<?php
function db_conn()
{
	@ $db = new mysqli('localhost','root','113733','users');
	if(mysqli_connect_errno())
		throw new Exception('Error! Cannot connect to database!',100);
	return $db;
}
?>