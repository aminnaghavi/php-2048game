<?php
require_once('auth_fns.php');
function cookie_name($nickname,$password)
{
	$sh1_n=sha1($nickname);
	$sh1_p=sha1($password);
	$all_num=array_merge(range('a','z'),range('A','Z'),range(0,9));
	for($i=0;$i<40;$i++)
	 	$snp[$i]=$all_num[(ord($sh1_n[$i])+ord($sh1_p[$i]))%52];//ord gives ascii code and chr convert ascii code to character
	$snp=implode('',$snp);
	return $snp;
}
function save_cookie($nickname,$number,$matrix)
{
	for($i=0;$i<4;$i++)
		$matrix[$i]=array();
	$matrix[0][0]=2;
	$matrix[0][1]=0;
	$matrix[0][2]=0;
	$matrix[0][3]=0;
	$matrix[1][0]=4;
	$matrix[1][1]=128;
	$matrix[1][2]=256;
	$matrix[1][3]=8;
	$matrix[2][0]=16;
	$matrix[2][1]=512;
	$matrix[2][2]=2;
	$matrix[2][3]=0;
	$matrix[3][0]=0;
	$matrix[3][1]=0;
	$matrix[3][2]=2048;
	$matrix[3][3]=2;
	$rnd=RandomPass(100);
	$save=RandomPass(40);

}
function delete_cookie($cookie_name)
{

    setcookie($cookie_name, '', time() - 3600);
}
function load_cookie($nickname,$number,$rnd,$save)
{
	$save=base64_decode($save);
	$matrix=array();
	for($i=0;$i<4;$i++)
		$matrix[$i]=array();
	$dst_arr=array();
	$arr_num=0;
	for($i=0;$i<8;$i++)
		for($j=0;$j<4;$j++)
		{
			$src_poss=
			((ord($rnd[($i+$j)*4]))%10)*10+
			((ord($rnd[($i+$j)*4+1]))%10);
			$dst_poss=
			((ord($rnd[($i+$j)*4+2]))%10)*10+
			((ord($rnd[($i+$j)*4+3]))%10);
			$dst_poss=$dst_poss%40;
			for($k=0;$k<$arr_num;$k++)
				{
				$dst_poss=$dst_poss%40;
				if($dst_poss==$dst_arr[$k])
				{
					$dst_poss=$dst_poss+1;
					$k=-1;
				}
			}
			$arr_num++;
			array_push($dst_arr,$dst_poss);
			$t=strpos(substr($rnd,43,50),$save[$dst_poss]);
			$t=$t-ord($rnd[$src_poss]);
			while($t<0)
			{
				$t+=50;
			}
			
			switch ($t)
			{
			case 14:
			$t=64;
			break;
			case 28:
			$t=128;
			break;
			case 6:
			$t=256;
			break;
			case 12:
			$t=512;
			break;
			case 24:
			$t=1024;
			break;
			case 48:
			$t=2048;
			break;
			case 46:
			$t=4096;
			break;
			case 42:
			$t=8192;
			break;
			case 34:
			$t=16384;
			break;
			case 0;
			case 2:
			case 4:
			case 8:
			case 16:
			case 32:
			break;
			default:
				delete_cookie(md5($nickname.$number));
				throw new Exception('Coulden\'t load Game!<br/>please try again!');
				break;
			}
			if($t>$number)
					throw new Exception('Coulden\'t load Game!<br/>please try again!');
			if($i<4)
				$matrix[$i][$j]=$t;
			else
			{
				if($matrix[$i%4][$j]!=$t)
					throw new Exception('Coulden\'t load Game!<br/>please try again!!!');
			}
			
				
					

		}
		return $matrix;

}
function load_cookie_guest($save)
{
	$save=base64_decode($save);
	$matrix=array();
	$m=explode('.',$save);
		for($i=0;$i<4;$i++)
		{
			$matrix[$i]=array();
			for($j=0;$j<4;$j++)
			{
				$matrix[$i][$j]=(($m[$i*4+$j]-(($i+7)*7))/(($j+3)*3))-11;
			switch ($matrix[$i][$j])
			{
				case 0:
				case 2:
				case 4:
				case 8:
				case 16:
				case 32:
				case 64:
				case 128:
				case 256:
				case 512:
				case 1024:
				case 2048:
				case 4096:
				case 8192:
				case 16384:
				break;
				default:
				delete_cookie(md5('guest'));
				throw new Exception('Coulden\'t load Game!<br/>please try again!');
				break;
			}
			
		}
		}
		return $matrix;

}
	function calculate_each_score($num)
	{
		if($num<=2)
			return 0;
		return calculate_each_score($num/2)+calculate_each_score($num/2)+$num;
	}
	function calculate_score($matrix)
	{
		for($i=0;$i<4;$i++)
	    	{
        	for($j=0;$j<4;$j++)
        	{
			$score=$score+calculate_each_score($matrix[$i][$j]);
        	}
    		}
			return $score;

	}
	function create_rnd()
	{
	$rng=array_merge(range('a','z'),range('A','Z'),range(0,9));
	shuffle($rng);
	$rng=implode('',$rng);
	$rng=substr($rng,0,50);
	$rnd1=RandomPass(43);
	$rnd2=RandomPass(12);
	$rnd=$rnd1.$rng.$rnd2;
	return $rnd;
	}
?>