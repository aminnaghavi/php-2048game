<html>
<head>
<link rel="stylesheet" href="form_style.css" type="text/css" media="all"/>
    <meta name="description" content="2048 game, you can save your score and your stage numbers in login mode!"/>
    <meta name="keywords" content="2048,4096,8192,mathemathic game,game,online,online game,android,ios,twenty fortyeight,game,2048.com,2048.net"/>
</head>
<body style="height:100%;padding:0;margin:0;">
<?php
require_once('2048_fns.php');
session_start();
show_header('Change password');
$nickname=$_SESSION['valid_user'];
$old_password=addslashes($_POST['old_password']);
$new_password=addslashes($_POST['new_password']);
try{
if(!$nickname){
	show_exception('you are not logged in please log in <a href="login.php">here</a>');
	show_footer('Change password');
	exit;
}
if(!filled_out($_POST))
	throw new Exception('please enter username and password and new password');
$db=db_conn();
$result=$db->query("select 1 from users where nickname='$nickname' and password=md5('$old_password')");
if(!$result->num_rows)
    throw new Exception('username or password is incorrect !');	
if(!check_password($new_password))
    throw new Exception('password must be at least 6 character !');
$db->query("update users set password=md5('$new_password') where nickname='$nickname'");
if(!$db->affected_rows)
	    throw new Exception('password is not changed !');
show_exception('password change successfuly.wait for redirect or click <a href="start_game.php">here</a>');
}
catch(Exception $e)
{
?>
<form action="change_password.php" method="post">
<table class="form_table" align="center" style="text-align:center;" cellpadding="20px" cellspacing="5px">
<tbody>
<tr>
<td>
old password
</td>
<td>
<input name="old_password" type="password"/>
</td>
</tr>
<tr>
<td>
new password
</td>
<td>
<input name="new_password" type="password"/>
</td>
</tr>
<tr>
<td>
</td>
<td>
<input name="submit" type="submit" value="Send new password"/>
</td>
</tr>
<tr>
<td colspan="2" style="color:red;font-size:small;">
<?php
	echo $e->getMessage();
?>
</td>
</tr>
</tbody>
</table>
</form>
<?php
}
show_footer('Change password');
?>
</body>
</html>