<?php
function filled_out($arr)
{
	$flag=false;
	foreach($arr as $key => $value)
	{
		$flag=true;
		if((!isset($key)) || ($value==''))
			return false;
	}
	return $flag;
}
function add_slash($arr)
{
	if(!get_magic_quotes_gpc())
	foreach($arr as $key => $value)
		$value=addslashes($value);
	return $arr;
}
function check_mail($email)
{
	if(!ereg('^[a-zA-Z0-9._\-]+@[a-zA-Z]+\.[a-zA-Z]+$',stripslashes($email)))
		return false;
	return true;
}
function check_nickname($nickname)
{
	
	if(!ereg('^[a-zA-Z0-9.\-\&_]+$',stripslashes($nickname)))
    	return false;
	return true;
}
function check_password($password)
{
	if(strlen(stripcslashes($password))<6 || strlen(stripslashes($password))>16)
		return false;
	return true;	
}
?>