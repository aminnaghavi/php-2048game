<html>
<head> 
    <title>2048</title>
    <meta name="google-site-verification" content="2Wedh4HUNau1gEVP5Uas7BRM2K0JAOI1jg0QdLCpLd8" />
    <meta name="description" content="2048 game, you can save your score and your stage numbers in login mode!"/>
    <meta name="keywords" content="2048,4096,8192,mathemathic game,game,online,online game,android,ios,twenty fortyeight,game,2048.com,2048.net"/>

    <style type="text/css">
        .form_table tr{
            text-align:center;
        }
        .form_table td{
           text-align:center;
        }
    </style>
    <link rel="stylesheet" href="form_style.css" type="text/css" media="all"/>
</head>
<body onload="keyChecker()">
 <?php
 require_once('2048_fns.php');
 show_header('login');
 session_start();		
 $nickname=$_SESSION['valid_user'];
 if($nickname)
 {
	 ?>
	<script type="text/javascript">
	window.location.replace('start_game.php');
	</script>
 <?php
 }
  try{
	if(!filled_out($_POST))
	{
		throw new Exception('please enter username and password');
	}
	$nickname=addslashes($_POST['nickname']);
	$password=addslashes($_POST['password']);
	$db=db_conn();
    $result=$db->query("select nickname,password from users where nickname='$nickname' and password=md5('$password');");
	if(!$result->num_rows)
		throw new Exception('username or password is incorrect!did you <a href="reset_password.php">forgot password</a>');
    $_SESSION['valid_user']=$nickname;
        //$stmt=$db->prepare('insert into UpUsers values (?,INET_ATON(?),?);');
        //$stmt->bindparams('sds',$nickname,$IP,$)

        //setcookie('nickname',$nickname,)
        $result->free();
        $db->close();
			 ?>
	<script type="text/javascript">
	window.location.replace('start_game.php');
	</script>
 <?php

        }
        catch(Exception $e)
		{
?>
    <form method="post" action="login.php">
        <table class="form_table" align="center" cellpadding="5px" cellspacing="25px" >
        <tr>
        <td colspan="2" style="color:red;font-size:large;font-weight:bold;">
        <noscript>
        	This game using javascript so you should turn it on.
        </noscript>
        <script>
			if(!navigator.cookieEnabled)
				document.write('This game using cookie For saving your game so you should turn it on.');
		</script>
        </td>
        </tr>
            <tr>
                <td>nickname :</td>
                <td ><input type="text" name="nickname"
                    <?php echo "value=\"$nickname\""; ?> /></td>
            </tr>
            <tr>
                <td>password :</td>
                <td ><input type="password" name="password" /></td>
            </tr>
            <?php
                echo '<tr><td></td><td style="color:red;font-size:small;">'.$e->getMessage().'</td></tr>';
            ?>
            
 
			<tr>
                <td><a href="register.php">register</a></td>
                <td><input type="submit" name="submit" value="login" /></td>
			<tr>
            <td colspan="2">you can play as <a href="game_guest.php">guest</a></td>
            </tr>
        </table>
    </form>
    <?php
}
show_footer('login');
?>
</body>
</html>
