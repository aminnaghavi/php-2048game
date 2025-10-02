<?php
function db_conn()
{
	@ $db = new mysqli('localhost','root','123456','users');
	if(mysqli_connect_errno())
		throw new Exception('Error! Cannot connect to database!',100);
	return $db;
}
?>
