<?php
require_once('2048_fns.php');
session_start();
$nickname=$_SESSION['valid_user'];
try{
if(!$nickname)
		throw new Exception('Error! You must login first <a href="login.php">here</a>',1);
if(!filled_out($_POST))
	throw new Exception('Error! An error occured!1',2);
$rng=addslashes($_POST['rng']);
$number=addslashes($_POST['number']);
$db=db_conn();
@$result=$db->query("select rnd from savedgames where nickname='$nickname' and number='$number'");
if(!$result->num_rows)
			throw new Exception('Error! An error occured!2');
$row=$result->fetch_array();
if(substr($row['rnd'],0,20)!=$rng)
		throw new Exception('Error! An error occured!3');
echo '	cookie_name="'.md5($nickname.$number).'";
		rnd="'.$row['rnd'].'";
function saveToCookie()
{
	var cookie_date = new Date();
    cookie_date.setTime(cookie_date.getTime() + 30 * 24 * 3600 * 1000);
	var src_poss;
	var dst_poss;
	var dst_arr=new Array();
	save=new String;
	for(var i=0;i<40;i++)
		save=save+rnd.charAt(randomNumber(0,104));

			for(var i=0;i<8;i++)
			{
		for(var j=0;j<4;j++)
		{
			src_poss=(((rnd.charCodeAt((i+j)*4))%10)*10)+((rnd.charCodeAt((i+j)*4+1))%10);
			dst_poss=(((rnd.charCodeAt((i+j)*4+2))%10)*10)+((rnd.charCodeAt((i+j)*4+3))%10);
			dst_poss=dst_poss%40;
			for(var k=0;k<dst_arr.length;k++)
			{
				dst_poss=dst_poss%40;
				if(dst_poss==dst_arr[k])
				{
					dst_poss=dst_poss+1;
					k=-1;
				}
			}
			dst_arr.push(dst_poss);
			save=save.replaceAt(dst_poss,rnd.charAt((rnd.charCodeAt(src_poss)+(matrix[i%4][j]%50))%50+43));
		}
			}
    document.cookie = cookie_name + "=" + btoa(save)+"; expires=" + cookie_date.toGMTString();

}
function newGame()
{
    var cookie_date = new Date();
    cookie_date.setTime(cookie_date.getTime() - 1000*3600);
    document.cookie = "'.md5($nickname.$number).'=0; expires=" + cookie_date.toGMTString();

}
';
$result->free();
$db->close();
}
catch(Exception $e)
{
if($e->getCode()==1)
{
try{
if(!filled_out($_POST))
	throw new Exception('Error! An error occured!');
$rng=addslashes($_POST['rng']);
if(substr(md5('guest'),0,20)!=$rng)
		throw new Exception('Error! An error occured!');
echo '	cookie_name="'.md5('guest').'";
		rnd="'.$row['rnd'].'";
function saveToCookie()
{
	var cookie_date = new Date();
    cookie_date.setTime(cookie_date.getTime() + 30 * 24 * 3600 * 1000);
	var m=new Array();
	for(var i=0;i<4;i++)
		for(var j=0;j<4;j++)
			m.push(((matrix[i][j]+11)*(j+3)*3)+((i+7)*7));
    document.cookie = cookie_name + "=" + btoa(m.join("."))+"; expires=" + cookie_date.toGMTString();


}
function newGame()
{
    var cookie_date = new Date();
    cookie_date.setTime(cookie_date.getTime() - 1000*3600);
    document.cookie = "'.md5('guest').'=0; expires=" + cookie_date.toGMTString();

}
';
}
catch(Exception $e)
{
	echo '<html><head><link rel="stylesheet" href="form_style.css" type="text/css" media="all"/></head><body style="height:100%;margin:0;padding:0;">';
	show_header('Error');
	show_exception($e->getMessage());
	show_footer('Error');
	echo '</body></html>';
}
}
else
{
	echo '<html><head><link rel="stylesheet" href="form_style.css" type="text/css" media="all"/></head><body style="height:100%;margin:0;padding:0;">';
	show_header('Error');
	show_exception($e->getMessage());
	show_footer('Error');
	echo '</body></html>';
}
}
?>