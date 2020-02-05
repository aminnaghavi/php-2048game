<?php
srand(time());
  function RandomPass($length)
 {
	    $all_num=array_merge(range('a','z'),range('A','Z'),range(0,9));
		$rnd=array();
        for($i=0;$i<$length;$i++)
        {
            array_push($rnd,$all_num[rand(0,count($all_num)-1)]);
        }
    return implode('',$rnd);
 }
function GetIP()
 {
     if(isset($_SERVER))
     {
 if(isset($_SERVER['HTTP_X_FOREWARDED_FOR']))
     return $_SERVER['HTTP_X_FOREWARDED_FOR'];
 if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];
        return $_SERVER["REMOTE_ADDR"];
     }
 }
 function CheckIP()
 {
	 $IP=GetIP();
    @$db=db_conn();
    $result=$db->query("select 1 from UpUsers where INET_NTOA(IP)='$IP';");
    $row=$result->fetch_assoc();
    if(count($row))
    {
        return true;
    }
    $result->free();
	return false;
 }
?>