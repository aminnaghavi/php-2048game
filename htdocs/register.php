<?php
require_once('2048_fns.php');
session_start();
try{
$text=$_SESSION['captcha'];
if(!filled_out($_POST))
{
    throw new Exception('nothing inputed !<br/>',0);
}
$input=add_slash($_POST);
$nickname=$input['nickname'];
$password=$input['password'];
$email=$input['email'];
$confirm_email=$input['confirm_email'];
$captcha=$input['captcha'];
if($captcha && strtolower($text)!=strtolower($captcha))
{
    throw new Exception('captcha is inccorect !<br/>',8);
}
	unset($_SESSION['captcha']);
	$result_dest=session_destroy();
if(strlen(stripslashes($nickname))<3)
{
    throw new Exception('nickname must contain 3 characters !<br/>',1);
}
if(!ereg('^[a-zA-Z0-9.\-\&_]+$',stripslashes($nickname)))
{
    throw new Exception('nickname can only contain alphabet and digits and limited symbols !',2);
}
$db = db_conn();
$query="select * from new_users left join users on 1=1 where users.nickname='$nickname' or new_users.nickname='$nickname'";//we didn't use cross join because when one of tables is empty it makes error;
$result=$db->query($query);
if($result->num_rows)
{
    throw new Exception('this nickname is exist please try other nickname !<br/>',3);
}
if(!ereg('^[a-zA-Z0-9._\-]+@[a-zA-Z]+\.[a-zA-Z]+$',stripslashes($email)))
{
    throw new Exception('please input a valid email !<br/>',4);
}
$query="select 1 from new_users left join users on 1=1 where users.email='$email' or new_users.email='$email'";
$result=$db->query($query);
if($result->num_rows)
{
    throw new Exception('this email is exist !<br/>',5);
}

if($email!=$confirm_email)
{
    throw new Exception('email is\'nt equal with confirm email !<br/>',6);
}
if(!check_password($password))
{
    throw new Exception('password must be at least 6 character !',7);
}
srand(time());
$random_number=rand(10000,99999);
$date=date("Y-m-d");
$url_nickname=urlencode("$nickname");
$link='http://' . $_SERVER['HTTP_HOST'] . "/activition.php?nickname=$url_nickname"."&Activition_Code=$random_number";
$email_content="tanck you for registering<br/>for login please <a href=\"$link\">click here</a><br/>";
if(!mail(stripslashes($email),"Activiton Code",$email_content))
{
	//throw new Exception('server couldn\'t send email!',11);
	 //echo "for login please <a href=\"$link\">click here</a> !<br/>";	
}
$db->query("insert into new_users (nickname,email,password,date,Activition_Code) values('$nickname','$email',md5('$password'),'$date','$random_number')");
if(!$db->affected_rows)
	    throw new Exception("database couldn't rensponse ,please try later !",10);
$db->close();
show_header('you are registered successfully!');
show_exception($email_content.' or wait for redirect.<br/>'.'Our Email Server couldn\'t send email yet .',999999);
?>
	<script type="text/javascript">
	function redirect()
	{
	window.location.replace('<?php echo $link;?>');
	}
	setTimeout(redirect,3000);
	</script>
    <?php
show_footer('you are registered successfully!');
exit();

}
catch(Exception $e){
if($e->getCode()==100)
{
echo $e->getMessage().'please try later';
exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="description" content="2048 game, you can save your score and your stage numbers in login mode!"/>
    <meta name="keywords" content="2048,4096,8192,mathemathic game,game,online,online game,android,ios,twenty fortyeight,game,2048.com,2048.net"/>

<link rel="stylesheet" href="form_style.css" type="text/css" media="all"/>
    <title>register</title>
    <style type="text/css">
        td input{
            width:100%;
        }
    </style>
</head>
<body style="height:100%;padding:0;margin:0;">
<?php
show_header('Register');
?>
    <form method="post"  action="register.php" style="width:100%;">
        <table align="center" class="form_table" cellpadding="5px" cellspacing="25px" style="width:50%;">
            <tbody>
                <tr>
                    <td>nickname :</td>
                    <td><input type="text" name="nickname"
                        <?php
    echo "value=\"$nickname\"";
                        ?>
                        /></td>
                </tr>
         <?php
    if($e->getCode()==1)
        echo '<tr><td></td><td  style="color:red;font-size:small;">'.$e->getMessage().'</td></tr>';
    if($e->getCode()==2)
        echo '<tr><td></td><td  style="color:red;font-size:small">'.$e->getMessage().'</td></tr>';
    if($e->getCode()==3)
        echo '<tr><td></td><td  style="color:red;font-size:small">'.$e->getMessage().'</td></tr>';
         ?>          
                <tr>
                    <td>email :</td>
                    <td><input type="text" name="email" 
                        <?php
    echo "value=\"$email\"";
                        ?>
                         /></td>
                </tr>
                <?php
    if($e->getCode()==4)
        echo '<tr><td></td><td  style="color:red;font-size:small">'.$e->getMessage().'</td></tr>';
    if($e->getCode()==5)
        echo '<tr><td></td><td  style="color:red;font-size:small">'.$e->getMessage().'</td></tr>';
                ?>
                <tr>
                    <td>confirm email :</td>
                    <td><input type="text" name="confirm_email" 
                        <?php
    echo "value=\"$confirm_email\"";
                        ?>
                         /></td>
                </tr>
                <?php
    if($e->getCode()==6)
        echo '<tr><td></td><td  style="color:red;font-size:small">'.$e->getMessage().'</td></tr>';
                ?>
                <tr>
                    <td>password :</td>
                    <td><input type="password" name="password" /></td>
                </tr>
                <?php
    if($e->getCode()==7)
        echo '<tr><td></td><td  style="color:red;font-size:small">'.$e->getMessage().'</td></tr>';
                ?>
                <tr>
                <td>
                <img src="create_image.php" alt="loading failed!"/>
                </td>
                <td>
                <input type="text" name="captcha" />
                </td>
                </tr>
                     <?php
    if($e->getCode()==8)
        echo '<tr><td></td><td  style="color:red;font-size:small">'.$e->getMessage().'</td></tr>';
                ?>

                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="register" /></td>
                </tr>
                <?php
    if($e->getCode()==10 ||$e->getCode()==11)
        echo '<tr><td colspan="2" style="color:red;text-align:center;">'.$e->getMessage().'</td></tr>';
}
         ?>
            </tbody>
        </table>
    </form>
    <?php
	show_footer('Register');
	?>
</body>
</html>
