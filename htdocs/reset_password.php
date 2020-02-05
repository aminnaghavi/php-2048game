<?php
require_once('2048_fns.php');
session_start();
try{
$nickname=addslashes($_POST['nickname']);
$email=addslashes($_POST['email']);
$text=$_SESSION['captcha'];
$captcha=addslashes($_POST['captcha']);
if($captcha && strtolower($text)!=strtolower($captcha))
{
    throw new Exception('captcha is inccorect !<br/>',8);
}
	unset($_SESSION['captcha']);
$db=db_conn();
if(!filled_out($_POST))
	throw new Exception("input nickname and email!");
$result=$db->query("select * from users where nickname='$nickname' and email='$email'");
if(!$result->num_rows)
	throw new Exception('nickname doesn\'t match to email!');
$password= RandomPass(12);
$email_content="your new password is <span style=\"color:blue\">$password</span><br/>for log in click <a href=\"login.php\">here</a><br/>";
//echo $email_content;
if(!mail(stripslashes($email),"Activiton Code",$email_content));
	//throw new Exception('server couldn\'t send email!');
	
$db->query("update users set password=md5('$password') where nickname='$nickname' and email='$email'");
		if(!$db->affected_rows)
			throw new Exception("Database error!");
show_header('password changed successfully!');
//show_exception('An email will send to you');
show_exception('Our Email Server couldn\'t send email yet .<br/>Your new password is <span style="color:blue;">'.$password.'</span> .<br/>please take a screenshot from this page',999999);
show_footer('password changed successfully!');
exit();
}
catch(Exception $e)
{
?>
<html>
<head>
    <meta name="description" content="2048 game, you can save your score and your stage numbers in login mode!"/>
    <meta name="keywords" content="2048,4096,8192,mathemathic game,game,online,online game,android,ios,twenty fortyeight,game,2048.com,2048.net"/>

<link rel="stylesheet" href="form_style.css" type="text/css" media="all"/>
</head>
<body style="height:100%;padding:0;margin:0;">
<?php
	show_header('Forgot password');
?>
<form action="reset_password.php" method="post">
<table class="form_table" align="center" style="text-align:center;" cellpadding="20px" cellspacing="5px">
<tbody>
<tr>
<td>
nickname
</td>
<td>
<input name="nickname" type="text"/>
</td>
</tr>
<tr>
<td>
email
</td>
<td>
<input name="email" type="text"/>
</td>
</tr>
<tr>
                <td>
                <img src="create_image.php" alt="loading failed!"/>
                </td>
                <td>
                <input type="text" name="captcha" />
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
}
?>
</td>
</tr>
</tbody>
</table>
</form>
</span>
<?php
show_footer('Forgot password');
?>
</body>
</html>
