<html>
    <head><title>activition</title><link rel="stylesheet" href="form_style.css" type="text/css" media="all"/>
    <meta name="description" content="2048 game, you can save your score and your stage numbers in login mode!"/>
    <meta name="keywords" content="2048,4096,8192,mathemathic game,game,online,online game,android,ios,twenty fortyeight,game,2048.com,2048.net"/>
    </head>
    <body style="height:100%;padding:0;margin:0;">
<?php
	require_once('2048_fns.php');
	show_header('activition');
	session_start();
    $nickname=addslashes(urldecode($_GET['nickname']));
    $activition_code=addslashes($_GET['Activition_Code']);
	try{
    $db=db_conn();
    $result=$db->query("select nickname,email,password from new_users where nickname='$nickname' and activition_code='$activition_code'");
    if($result->num_rows)
    {
		$_SESSION['valid_user']=$nickname;
		//check_session($nickname);
        $row=$result->fetch_assoc();
        $password=$row['password'];
        $email=$row['email'];
        $date=date("Y-m-d");
        $db->query("delete from new_users where nickname='$nickname'");
			if(!$db->affected_rows)
		throw new Exception("Database error!");
        $db->query("insert into users (nickname,email,password,date) values ('$nickname','$email','$password','$date')");
		if(!$db->affected_rows)
			throw new Exception("Database error!");
		$r1=rand(1,4);
        $c1=rand(1,4);
        $r2=rand(1,4);
        $c2=rand(1,4);
        while($r1==$r2 && $c1==$c2)
        {
        $r2=rand(1,4);
        $c2=rand(1,4);
        }
		$rnd=create_rnd();
        $db->query("insert into savedgames (nickname,number,rnd,t$r1$c1,t$r2$c2) values ('$nickname',2048,'$rnd',2,2);");
			if(!$db->affected_rows)
		throw new Exception("Database error!");

        $db->close();
	show_exception('your registration complited waiting for directing to Game !');
    }
    else{
        throw new Exception('an error occured !');
    }
	}
	catch(Exception $e)
	{
		show_exception($e->getMessage());
	}
	show_footer('activition');
?>
       </body>
</html>