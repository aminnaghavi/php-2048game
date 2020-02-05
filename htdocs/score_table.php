<html>
<head>
<link rel="stylesheet" href="form_style.css" type="text/css" media="all"/>
    <meta name="description" content="2048 game, you can save your score and your stage numbers in login mode!"/>
    <meta name="keywords" content="2048,4096,8192,mathemathic game,game,online,online game,android,ios,twenty fortyeight,game,2048.com,2048.net"/>
</head>
<body style="height:100%;margin:0;padding:0;">
<?php
require_once('2048_fns.php');
session_start();
$nickname=$_SESSION['valid_user'];
try{
if (!$nickname)
	throw new Exception('you are not logged in please log in <a href="login.php">here</a>');
$db=db_conn();
$result=$db->query("select nickname,bestscore from (select * from savedgames order by bestscore) as TS1 group by nickname order by bestscore desc,nickname desc");
if(!$result->num_rows)
	throw new Exception('An error occured in database!');
show_header('Score table.<a href="start_game.php">back</a>');
echo '<div id="scores" style="overflow-y:scroll;">';
echo '<table class="form_table" align="center" cellpadding="25px"><tbody>';
$num=0;
echo '<tr style="color:brown;"><td>Rank</td><td>Nickname</td><td>Score</td></tr>';
while($row=$result->fetch_assoc())
{
	$num++;
	if($nickname==$row['nickname'])
	{
		echo '<tr style="color:orange">';
		$mynum=$num;
	}
	else
		echo '<tr>';
	echo '<td>'.$num.'</td><td>'.$row['nickname'].'</td><td>'.$row['bestscore'].'</td></tr>';
}
?>
</tbody></table></div>
<script type="text/javascript">
	var ostl=document.createElement('style');
	ostl.type="text/css"
	var ot=document.createTextNode('#scores{height:'+window.innerHeight*0.7+'px;}');
	ostl.appendChild(ot);
	document.getElementsByTagName('head')[0].appendChild(ostl);
	var scr=document.getElementById('scores');
	scr.scrollTo(0,<?php echo ($mynum)/$num;?>*scr.clientHeight);
</script>
<?php
show_footer('Score table');
}
catch(Exception $e)
{
	show_header('Error');
	show_exception($e->getMessage());
	show_footer('Error');
}
?>
</body>
</html>
