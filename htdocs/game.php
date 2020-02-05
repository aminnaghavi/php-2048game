<?php
require_once('2048_fns.php');

session_start();
$nickname=$_SESSION['valid_user'];
$number=$_POST['number'];
$save=addslashes($_COOKIE[md5($nickname.$number)]);
try{
if (!$nickname)
	throw new Exception('you are not logged in please log in <a href="login.php">here</a>');
if(!$number)
	throw new Exception('you didn\'t choose any Game!');
$matrix=array();
    $db=db_conn();
    $result=$db->query("select * from savedgames where nickname='$nickname' and number='$number';");
	if(!$result->num_rows)
		throw new Exception('Save doesn\'t exist.');
	$row=$result->fetch_array();
	$rnd=$row['rnd'];
    $bestscore=$row['BestScore'];
	if($save && $nickname)
	{

	$matrix=load_cookie($nickname,$number,$rnd,$save);
	$score=calculate_score($matrix);
	if($score>$row['BestScore'])
	{
			$db->query("update savedgames set BestScore='$score' where nickname='$nickname' and number='$number'");
					if(!$db->affected_rows)
			throw new Exception("Database error!");
		$bestscore=$score;
	}

	}
	else
	{
	    for($i=1;$i<5;$i++)
	    {
        	for($j=1;$j<5;$j++)
        	{
            $matrix[$i-1][$j-1]=$row["t$i$j"];
        	}
    	}
		$score=calculate_score($matrix);

    
	}
	
	$save=RandomPass(40);
	//$db->query("update savedgames set rnd='$rnd' where nickname='$nickname' and number='$number'");
			//if(!$db->affected_rows)
			//throw new Exception("Database error!");

	$db->close();

?>
<html>
    <head><title>Play Game</title>
     <meta name="description" content="2048 game, you can save your score and your stage numbers in login mode!"/>
    <meta name="keywords" content="2048,4096,8192,mathemathic game,game,online,online game,android,ios,twenty fortyeight,game,2048.com,2048.net"/>
        <style type="text/css">
			#page_table {
				height:100%;

			}
            #game_table {
				visibility:hidden;
                height: 100%;
				table-layout:fixed;
                float:left;
            }
			#game_table tr {
                height: 25%;
            }
            #game_table tr td{
                width:25%;
			
                text-align:center;
                background-color:rgb(226,226,226);
                border-radius:10%;
                background-origin:content-box;
                background-clip:content-box;

            }
            #game_table td img{
                top:0px;
                max-width:100%;
                max-height:100%;
                position:relative;
                border-radius:10%;

            }
            #score{
                float:left;
            }
            #addition_score {
                position: absolute;
                color:rgba(255,255,255,0);
            }
            .adding_score{
                                animation:adding_score .5s ease-out;
            }

            @keyframes adding_score{
                from {margin-top:0px;color:rgba(255, 106, 0,1);}
                to {margin-top:-20px;color:rgba(255, 106, 0,0);}
            }

            #score_table{
                width:100%;
                height:100%;
                
            }
			.comment{
				visibility:hidden;
			}
			.message_buttons{
				height:100%;
				width:100%;
				background-color:rgba(245,162,79,0.7);
				color:rgba(0,128,10,0.7);
				border-radius:10% 20% 30% 40%;
				align-self:center;
				align-content:center;
			}
			.comment_table{
				width:40%;
				height:30%;
				vertical-align:middle;
				font-size:xx-large;
				color:#ff6a00;
				text-align:center;
			}
                 </style>
             <script type="text/javascript" src="game.js">
            </script>
    </head>
            
    <body style="overflow:hidden;" onload="getReady('<?php echo substr($rnd,0,20);?>');setSource('<?php 
	for($i=1;$i<5;$i++)
		for($j=1;$j<5;$j++) 
			echo $row["t$i$j"].',';
			 echo '\','.$score?>);loadCookie('<?php 
	for($i=0;$i<4;$i++)
		for($j=0;$j<4;$j++) 
			echo $matrix[$i][$j].',';
			?>');keyChecker();Refresh();addKeyframes();">
    
        <script>
            setStage(<?php echo $number; ?>);
        </script>
        <table id="page_table" align="center" style="height:100%" >
            <tbody>
                <tr style="height:20%">
                    <td>
                        <table id="score_table">
                            <tbody>
                                <tr style="height:25%">
                                    <td>
                        
                        your best score is :
                        
                                        </td>
                                    <td>
                                       <span id="bestscore">

                                        <?php
    echo $bestscore;
                                        ?>
                                        </span>
                                        </td>
                                    </tr>
                                <tr style="height:25%">
                                    <td>
                                        your score :
                                    </td>
                                <td>
                                    <span id="score">
                                    <?php
    echo $score;
                                    ?>
                                        </span>
                        <span id="addition_score">
                            +0
                        </span>
                            </td>
                                    </tr>
                                    <tr style="height:50%">  
                                    <td >
                                    <button onClick="saveScore();"  style="width:50%;height:100%;border-radius:10%;" >save score</button>
                                    </td>
                                    <td>
                                    <button onClick="retry('');" style="width:50%;height:100%;border-radius:10%;" >New Game</button>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <tr style="height:80%">
                    <td>
<table id="game_table" >
        <tbody>
            <?php
    for($i=0;$i<4;$i++)
    {
        echo '<tr>';
        for($j=0;$j<4;$j++)
        {
            echo '<td><img name="numbers" src="'.((pow(2,$i*4+($j+1)))%32768).'.png" width="10px" height="10px"/></td>';
        }
        echo '</tr>';
    }
            ?>
            </tbody>
    </table>
        <div class="comment" id="loose">
           <table class="comment_table" align="center">
            <tbody>
            <tr>
            <td>game over!</td>
            </tr>
            <tr>
            <td><button onClick="retry('');" class="message_buttons">retry</button></td></tr>
            </tbody>
            </table>

        </div>
        <div class="comment" id="win">
            <table class="comment_table" align="center">
            <tbody>
            <tr>
            <td colspan="2">you did it!</td>
            </tr>
            <tr>
            <td><button onClick="retry('');" class="message_buttons">retry</button></td>
            <td><button onClick="nextStage('');" class="message_buttons" id="countinue">countinue</button></td>
            </tr>
            </tbody>
            </table>
            </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>
<?php
}
catch(Exception $e)
{
?>
	<html>
    <head>
    <meta name="description" content="2048 game, you can save your score and your stage numbers in login mode!"/>
    <meta name="keywords" content="2048,4096,8192,mathemathic game,game,online,online game,android,ios,twenty fortyeight,game,2048.com,2048.net"/>
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