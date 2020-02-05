<?php
		require_once('2048_fns.php');
		session_start();
		$nickname=$_SESSION['valid_user'];
		try{
		if (!$nickname)
			throw new Exception('you are not logged in please log in <a href="login.php">here</a>');
        $db=db_conn();
        $result=$db->query("select max(bestscore),max(number) from savedgames where nickname='$nickname'");
		if(!$result->num_rows)
			throw new Exception('Cannot find user in database!');
        $row=$result->fetch_assoc();
        $number=$row['max(number)'];
        $bestscore=$row['max(bestscore)'];
		$save=addslashes($_COOKIE[md5($nickname.$number)]);
		if($save)
		{
		$result2=$db->query("select rnd from savedgames where nickname='$nickname' and number='$number'");
		if(!$result2->num_rows)
			throw new Exception('An error occured in database!');

		$row2=$result2->fetch_assoc();
		$matrix=load_cookie($nickname,$number,$row2['rnd'],$save);
		$score=calculate_score($matrix);

			if($score>$bestscore)
		{
			$db->query("update savedgames set BestScore='$score' where nickname='$nickname' and number='$number'");
					if(!$db->affected_rows)
			throw new Exception("Database error!");

		$bestscore=$score;
		}
		$result2->free();
		}
		$result->free();
        $db->close();
			
		?>
        <html>
<head>
    <title>login</title>
    <meta name="description" content="2048 game, you can save your score and your stage numbers in login mode!"/>
    <meta name="keywords" content="2048,4096,8192,mathemathic game,game,online,online game,android,ios,twenty fortyeight,game,2048.com,2048.net"/>
        <link rel="stylesheet" href="form_style.css" type="text/css" media="all"/>
	
    <style type="text/css">
        #stage {
			width:30%;
            height:100%;
        }

        #stage tr {
			width:100%;
            text-align: center;
        }

        #stage td {
			width:50%;
			height:100%;
            text-align: center;
        }
    </style>
</head>
<body style="height:100%;padding:0;margin:0;">
<?php
			show_header('Choose a game');
?>
    <form method="post" style="height:100%;width:100%;" action="game.php">
        <input type="hidden" name="number" />
        <table class="form_table" align="center" id="stage" >
            <tbody>
 <?php echo '<tr style="height:10%;"><td style="height:10%;">Welcome '.$nickname.'</td><td style="height:10%;"><a href="change_password.php">change password</a></td></tr><tr style="height:10%;"><td style="height:10%;">Best Score : '.$bestscore.' <a href="score_table.php">score table</a></td><td style="height:10%;"><a href="logout.php">log out</a></td></tr><tr style="height:40%;">';?>
                    <td style="height:40%;"><input name="2048" src="2048.png" type="image" onclick="this.form.number.value = '2048'"/></td>
                    <td style="height:40%;"><input name="4096" type="image" onclick="this.form.number.value = '4096'"
        <?php
        if ($number<4096) 
        {
            echo 'disabled="disabled" ';
            echo 'src="4096BW.png"';
        }
        else
            echo 'src="4096.png"';
			?>
        
                        /></td>
                </tr>
                <tr style="height:40%;">
                    <td style="height:40%;"><input name="8192" type="image" onclick="this.form.number.value = '8192'"
       <?php
        if ($number<8192) 
        {
            echo 'disabled="disabled" ';
            echo 'src="8192BW.png"';
        }
        else
        echo 'src="8192.png"';
		?>
                         /></td>
                    <td style="height:40%;"><input name="infinite" type="image" onclick="this.form.number.value = '16384'"
                    <?php
        if ($number<16384) 
        {
            echo 'disabled="disabled" ';
            echo 'src="16384BW.png"';
        }
        else
            echo 'src="16384.png"';                      
			?> 
        /></td>
                </tr>
            </tbody>
        </table>
    </form>
    <?php
	show_footer('Choose a game');
	?>
    </body>
</html>

<?php
		}
		catch(Exception $e)
			{
?>
	<html>
    <head>
    <link rel="stylesheet" href="form_style.css" type="text/css" media="all"/>
    </head>
    <body style="height:100%;padding:0;margin:0;">
 <?php
 	show_header('2048 Game');
	show_exception($e->getMessage());
	show_footer('2048 Game');
	?>
    </body>
    </html>
    <?php
}
?>