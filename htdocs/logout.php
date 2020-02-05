<?php
	require_once('2048_fns.php');
	session_start();
	$old_user=$_SESSION['valid_user'];
	unset($_SESSION['valid_user']);
	try{
	$result_dest=session_destroy();
	if(!empty($old_user))
		{
			if($result_dest)
				throw new Exception('you are logged out successfully');
			else
				throw new Exception('Could not log you out!');
		}
		else
		{
			throw new Exception('you are not logged in, please log in <a href="login.php">here</a>');
		}
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
		show_header('log out');
	show_exception($e->getMessage());
		show_footer('log out');

	?>
    </body>
    </html>
 <?php
	}
	?>
	