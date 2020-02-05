<?php
require_once('2048_fns.php');
session_start();
$rnd=addslashes($_POST['rnd']);
$number=addslashes($_POST['number']);
$next=addslashes($_POST['next']);
$nickname=$_SESSION['valid_user'];
$save=addslashes($_COOKIE[md5($nickname.$number)]);
try{
	if(!$nickname)
		throw new Exception('Error! You must login first <a href="http://localhost/login.php">here</a>',1);
	if(!filled_out($_POST))
		throw new Exception('Error! An error occured!',2);
	$db=db_conn();
	@$result=$db->query("select * from savedgames where nickname='$nickname' and number='$number'");
	if(!$result->num_rows)
			throw new Exception('Error! An error occured!');
	$row=$result->fetch_array();
	if($row['rnd']!=$rnd)
		throw new Exception('Error! An error occured!');
	$matrix=load_cookie($nickname,$number,$rnd,$save);
	$score=calculate_score($matrix);
	if($score>$row['BestScore']){
			$db->query("update savedgames set BestScore='$score' where nickname='$nickname' and number='$number'");
					if(!$db->affected_rows)
			throw new Exception("Database error!");
	}
if($next=='true')
	for($i=0;$i<4;$i++)
		for($j=0;$j<4;$j++)
			if($number==$matrix[$i][$j])
			{
				$rnd=create_rnd();
				$m='';
				for($k=0;$k<4;$k++)
				{
					$m=$m.','.implode(',',$matrix[$k]);
				}
				$number=$number*2;
					$db->query("delete from savedgames where nickname='$nickname' and number='$number'");
							if(!$db->affected_rows)
			throw new Exception("Database error!");

					//$db->query("insert into savedgames values ('$nickname',$number,$score,'$rnd'".$m.")");
					//if(!$db->affected_rows)
						//throw new Exception("Database error!");

				break;
}
$result->free();
$db->close();
}
catch(Exception $e)
{
	echo '<html><head><link rel="stylesheet" href="form_style.css" type="text/css" media="all"/></head><body style="height:100%;margin:0;padding:0;">';
	show_header('Error');
	show_exception($e->getMessage());
	show_footer('Error');
	echo '</body></html>';
}
?>