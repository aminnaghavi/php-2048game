var matrix = new Array();
var movement = new Array();
var matrix_source = new Array();
var stage;
var score=0;
var bestscore=0;
var moving=0;
var time;
var rnd;
var img_size;
var score_src;
function getMobileOperatingSystem() {
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;

  if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) )
  {
    return 'iOS';

  }
  else if( userAgent.match( /Android/i ) )
  {

    return 'Android';
  }
  else
  {
    return 'unknown';
  }
}
function addKeyframes()
{
	var RL;
	var DU;
	var text=String();
    for(var i=1; i<4; i++)
        for(var j=-1;j<=1;j+=2)
        {
            
            if(j==1)RL='R';
            else RL='L';
            text=text+ '@-moz-keyframes move_numbers'+RL+i+'{';
            text=text+ 'from{left:0px;z-index:100;}';
            text=text+ 'to{left:'+(j*i*img_size)+'px;z-index:0;}}';
            text=text+ '@-webkit-keyframes move_numbers'+RL+i+'{';
            text=text+ 'from{left:0px;z-index:100;}';
            text=text+ 'to{left:'+(j*i*img_size)+'px;z-index:0;}}';
			text=text+ '@keyframes move_numbers'+RL+i+'{';
            text=text+ 'from{left:0px;z-index:100;}';
            text=text+ 'to{left:'+(j*i*img_size)+'px;z-index:0;}}';

            if(j==1)DU='D';
            else DU='U';
            text=text+ '@-moz-keyframes move_numbers'+DU+i+'{';
            text=text+ 'from{top:0px;z-index:100;}';
            text=text+ 'to{top:'+(j*i*img_size)+'px;z-index:0;}}';
			text=text+ '@-webkit-keyframes move_numbers'+DU+i+'{';
            text=text+ 'from{top:0px;z-index:100;}';
            text=text+ 'to{top:'+(j*i*img_size)+'px;z-index:0;}}';
			text=text+ '@keyframes move_numbers'+DU+i+'{';
            text=text+ 'from{top:0px;z-index:100;}';
            text=text+ 'to{top:'+(j*i*img_size)+'px;z-index:0;}}';

            text=text+ '.move_numbers'+RL+i+'{'+'animation:move_numbers'+RL+i+' '+(1 / 3)+"s ease-out;}";
            text=text+ '.move_numbers'+DU+i+'{'+'animation:move_numbers'+DU+i+' '+(1 / 3)+"s ease-out;}";
			if(j==1)RL='R';
            else RL='L';

            text=text+ '@-moz-keyframes move_numbers_fast'+RL+i+'{';
            text=text+ 'from{left:0px;z-index:100;}';
            text=text+ 'to{left:'+(j*i*img_size)+'px;z-index:0;}}';
            text=text+ '@-webkit-keyframes move_numbers_fast'+RL+i+'{';
            text=text+ 'from{left:0px;z-index:100;}';
            text=text+ 'to{left:'+(j*i*img_size)+'px;z-index:0;}}';
            text=text+ '@keyframes move_numbers_fast'+RL+i+'{';
            text=text+ 'from{left:0px;z-index:100;}';
            text=text+ 'to{left:'+(j*i*img_size)+'px;z-index:0;}}';


            if(j==1)DU='D';
            else DU='U';
            text=text+ '@-moz-keyframes move_numbers_fast'+DU+i+'{';
            text=text+ 'from{top:0px;z-index:100;}';
            text=text+ 'to{top:'+(j*i*img_size)+'px;z-index:0;}}';
			text=text+ '@-webkit-keyframes move_numbers_fast'+DU+i+'{';
            text=text+ 'from{top:0px;z-index:100;}';
            text=text+ 'to{top:'+(j*i*img_size)+'px;z-index:0;}}';
			text=text+ '@keyframes move_numbers_fast'+DU+i+'{';
            text=text+ 'from{top:0px;z-index:100;}';
            text=text+ 'to{top:'+(j*i*img_size)+'px;z-index:0;}}';

            text=text+ '.move_numbers_fast'+RL+i+'{'+'animation:move_numbers_fast'+RL+i+' '+(1 / 10)+"s ease-out;}";
            text=text+ '.move_numbers_fast'+DU+i+'{'+'animation:move_numbers_fast'+DU+i+' '+(1 / 10)+"s ease-out;}";

        }
	var ostl=document.createElement('style');
	ostl.type="text/css"
	var ot=document.createTextNode(text);
	ostl.appendChild(ot);
	document.getElementsByTagName('head')[0].appendChild(ostl);

}
function getReady(rand)
{
	var ogt=document.getElementById('game_table');
	ogt.width=ogt.clientHeight;
	img_size=ogt.clientHeight/4-5;
	var oimg=document.getElementsByName('numbers');
	for(var i=0;i<16;i++)
	{
				oimg[i].width=img_size;
				oimg[i].height=img_size;
	}
	
	var text=".comment{width:"+ogt.clientHeight+"px;height:"+ogt.clientHeight*0.7+"px;position:absolute;font-family:'Bradley Hand ITC';text-align:center;align-content:center;				vertical-align:middle;text-decoration:none;margin:auto;background-color:rgba(226,125,555,0.5);border-radius:10%;display:block;padding-top:"+ogt.clientHeight*0.3+"px;visibility:hidden;}";
	var ostl=document.getElementsByTagName('style');
	var ot=document.createTextNode(text);
	ostl[0].appendChild(ot);
sendAjaxRequest("get_data.php","rng="+rand+"&number="+stage,"appendScript(this.responseText.split('<!--')[0]);",false);
document.getElementById("game_table").style.visibility="visible";
}
function setSource(str,sco)
{
	for(var i=0;i<4;i++)
		matrix_source[i]=new Array();
	var arr=str.split(',');
	for(var i=0;i<4;i++)
		for(var j=0;j<4;j++)
			matrix_source[i][j]=arr[i*4+j];
	score_src=sco;
}
function ajaxRequest()
{
    try{

        var request = new XMLHttpRequest();//working for non IE browsers
        
    }
    catch(e1)
    {
        try{
            request = new ActiveXObject("Msxml2.XMLHTTP");//for IE v6 or upper
        }
        catch(e2)
        {
            try{
                request = new ActiveXObject("Microsoft.XMLHTTP");//for IE v5
            }
            catch(e3)
            {
                request = false;//not supporting ajax
            }
        }
    }
    return request;
}

function sendAjaxRequest(page,params,response,running)
{
	request=new ajaxRequest();
	request.open("POST",page,running);
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.setRequestHeader("Content-length",params.length);
	request.setRequestHeader("Connection","close");
	request.onreadystatechange=function()
	{
		if(this.readyState==4)
		{
			if(this.status==200)
			{
				if(this.responseText!=null)
				{
					if(this.responseText.substr(0,6)=='<html>')
						document.write(this.responseText);
					eval(response);

				}
				                else document.write('ajax error : no data received');
            }
            else document.write('ajax error : '+this.statusText)
        }
    }
request.send(params);
}
function setRND(rand)
{
	rnd=rand;
}
String.prototype.replaceAt=function(index, character) {
    return this.substr(0, index) + character + this.substr(index+character.length);
}
function randomNumber(firstvalue,lastvalue)
{
    var r = Math.floor(Math.random() * (lastvalue - firstvalue + 1) + firstvalue)
    return r;
}
function moveSlow(dir)
{
	    var oimg = document.body.getElementsByTagName("img");
		for (var i = 0; i < 4; i++)
            for (var j = 0; j < 4; j++)
                if (movement[i][j] ) {
                    for (var k = 0; k < oimg[i * 4 + j].classList.length; k++)
                        oimg[i * 4 + j].classList.remove(oimg[i * 4 + j].classList[k]);
                    oimg[i * 4 + j].offsetWidth = oimg[i * 4 + j].offsetWidth;
					oimg[i*4+j].classList.add('move_numbers'+dir+movement[i][j]);
				}
}
function moveFast(dir)
{
        var oimg = document.body.getElementsByTagName("img");
		for (var i = 0; i < 4; i++)
            for (var j = 0; j < 4; j++)
                if (movement[i][j] ) {
                    for (var k = 0; k < oimg[i * 4 + j].classList.length; k++)
                        oimg[i * 4 + j].classList.remove(oimg[i * 4 + j].classList[k]);
                    oimg[i * 4 + j].offsetWidth = oimg[i * 4 + j].offsetWidth;
					oimg[i*4+j].classList.add('move_numbers_fast'+dir+movement[i][j]);
                }
}
function move(dir)
{
	if(moving==0){
		addRandom();
		moveSlow(dir);
		moving=2;
		setTimeout('moving=1;Refresh();',300);
		time=setTimeout('moving=0;Refresh();',500);
		saveToCookie();

	}
	else if(moving==1){
		addRandom();
		moveFast(dir);
		moving=2;
		clearTimeout(time);
		setTimeout('moving=1;Refresh();',80);
		time=setTimeout('moving=0',500);
		saveToCookie();
	}
}
function addRandom()
{
	    var rrand = Math.floor(Math.random() * 4);
    var crand = Math.floor(Math.random() * 4);
    while (matrix[rrand][crand]) {
        rrand = Math.floor(Math.random() * 4);
        crand = Math.floor(Math.random() * 4);
    }
    matrix[rrand][crand] = 2;
}
function goLeft() {

    if (CanGoDir('l') == true && moving<2 ) {
        resetMovement();
        for (var i = 0; i < 4; i++)
            for (var j = 1; j < 4; j++) {
                if (matrix[i][j]) {
                    k = j;
                    while (CanGo(i, k, 'l') == 1) {
                        movement[i][j]++;
                        k--;
                    }
                    if (k > 0) {
                        movement[i][j] = movement[i][j] + movement[i][k - 1]
                        if (matrix[i][j] == matrix[i][k - 1]) {
                            movement[i][j]++;
                            matrix[i][j] = 'c';
                        }
                    }
                }
            }

        var addition_score = 0;
        for (var i = 0; i < 4; i++)
            for (var j = 1; j < 4; j++) {
                if (movement[i][j]) {
                    if (matrix[i][j] == 'c') {
                        addition_score += (matrix[i][j - movement[i][j]] * 2);
                        matrix[i][j - movement[i][j]] *= 2;
                    }
                    else
                        matrix[i][j - movement[i][j]] = matrix[i][j];
                    matrix[i][j] = 0;
                }
            }
        move('L');
		adding_score(addition_score);
    }

}
function goRight() {
    if (CanGoDir('r') == true && moving<2) {
        resetMovement();
        for (var i = 0; i < 4; i++)
            for (var j = 2; j >= 0; j--) {
                if (matrix[i][j]) {
                    k = j;
                    while (CanGo(i, k, 'r') == 1) {
                        movement[i][j]++;
                        k++;
                    }
                    if (k < 3) {
                        movement[i][j] = movement[i][j] + movement[i][k + 1];
                        if (matrix[i][j] == matrix[i][k + 1]) {
                            movement[i][j]++;
                            matrix[i][j] = 'c';
                        }
                    }
                }
            }

        var addition_score = 0;
        for (var i = 0; i < 4; i++)
            for (var j = 2; j >= 0; j--) {
                if (movement[i][j]) {
                    if (matrix[i][j] == 'c') {
                        addition_score += (matrix[i][j + movement[i][j]] * 2);
                        matrix[i][j + movement[i][j]] *= 2;
                    }
                    else
                        matrix[i][j + movement[i][j]] = matrix[i][j];
                    matrix[i][j] = 0;
                }
            
            }
		move('R');
        adding_score(addition_score);
    }


}
function goUp() {
    if (CanGoDir('u') == true && moving<2) {
        resetMovement();
        for (var i = 1; i < 4; i++)
            for (var j = 0; j < 4; j++) {
                if (matrix[i][j]) {
                    k = i;
                    while (CanGo(k, j, 'u') == 1) {
                        movement[i][j]++;
                        k--;
                    }
                    if (k > 0) {
                        movement[i][j] = movement[i][j] + movement[k - 1][j]
                        if (matrix[i][j] == matrix[k - 1][j]) {
                            movement[i][j]++;
                            matrix[i][j] = 'c';
                        }
                    }
                }
            }
        
		
        var addition_score=0;
        for (var i = 1; i < 4; i++)
            for (var j = 0; j < 4; j++) {
                if (movement[i][j]) {
                    if (matrix[i][j] == 'c') {
                        addition_score += (matrix[i - movement[i][j]][j] * 2);
                        matrix[i - movement[i][j]][j] *= 2;
                    }
                    else
                        matrix[i - movement[i][j]][j] = matrix[i][j];
                    matrix[i][j] = 0;
                }
            }
        move('U');
		adding_score(addition_score);
    }

}
function goDown() {
    if (CanGoDir('d') == true && moving<2) {
        resetMovement();
        for (var i = 2; i >= 0; i--)
            for (var j = 0; j < 4; j++) {
                if (matrix[i][j]) {
                    k = i;
                    while (CanGo(k, j, 'd') == 1) {
                        movement[i][j]++;
                        k++;
                    }
                    if (k < 3) {
                        movement[i][j] = movement[i][j] + movement[k + 1][j];
                        if (matrix[i][j] == matrix[k + 1][j]) {
                            movement[i][j]++;
                            matrix[i][j] = 'c';
                        }
                    }
                }
            }
        var addition_score = 0;
        for (var i = 2; i >= 0; i--)
            for (var j = 0; j < 4; j++) {
                if (movement[i][j]) {
                    if (matrix[i][j] == 'c') {
                        addition_score += (matrix[i + movement[i][j]][j] * 2);
                        matrix[i + movement[i][j]][j] *= 2;
                    }
                    else
                        matrix[i + movement[i][j]][j] = matrix[i][j];
                    matrix[i][j] = 0;
                }
            }
		move('D');
        adding_score(addition_score);
    }
}
function keyChecker() {
    document.body.onkeyup = function (oevent) {
        switch (oevent.keyCode) {
            case 37:
                goLeft();
                break;
            case 39:
                goRight();
                break;
            case 38:
                goUp();
                break;
            case 40:
                goDown();
                break;
        }
    }
	var x_cor;
	var y_cor;
	document.body.ontouchstart=document.body.onmousedown=function(oevent){
		if(oevent.changedTouches)
		{
			x_src=oevent.changedTouches[0].clientX;
			y_src=oevent.changedTouches[0].clientY;
		}
		else
		{
			x_src=oevent.clientX;
			y_src=oevent.clientY;
			}
	}
	document.body.ontouchend=document.body.onmouseup=function(oevent){
				if(oevent.changedTouches)
		{
			x_des=oevent.changedTouches[0].clientX
			y_des=oevent.changedTouches[0].clientY
		}
		else
		{
			x_des=oevent.clientX;
			y_des=oevent.clientY;
		}
		if(x_des-x_src>20 && Math.abs(y_des-y_src)<70)
			goRight();
		if(x_des-x_src<(-20) && Math.abs(y_des-y_src)<70)
			goLeft();
		if(y_des-y_src>20 && Math.abs(x_des-x_src)<70)
			goDown();
		if(y_des-y_src<(-20) && Math.abs(x_des-x_src)<70)
			goUp();
	}
}
function at(r, c) {
    var otable = document.getElementById("game_table");
    var otbody = otable.childNodes[1];
    return parseInt(otbody.rows[r].cells[c].firstChild.getAttribute('src'));
}
function set(r, c, value) {
		if(at(r,c)!=value)
		{
   		 var otable = document.getElementById("game_table");
   		 var otbody = otable.childNodes[1];
    	 return parseInt(otbody.rows[r].cells[c].firstChild.setAttribute('src', value + '.png'));
		}
}
function CanGo(r, c, dir) {
    var dx = 0;
    var dy = 0;
    switch (dir) {
        case 'u':
            dy = -1;
            break;
        case 'd':
            dy = 1;
            break;
        case 'l':
            dx = -1;
            break;
        case 'r':
            dx = 1;
            break;
    }
    if (r + dy < 0 || c + dx < 0 || r + dy > 3 || c + dx > 3)
        return 0;
    if (matrix[r][c] == matrix[r + dy][c + dx] && matrix[r][c])
        return 2;
    if (matrix[r + dy][c + dx] == 0)
        return 1;
    return 0;
}
function CanGoDir(dir)
{
    for(var i=0;i<4;i++)
        for(var j=0;j<4;j++)
            if (CanGo(i, j, dir) && matrix[i][j] )
                return true;
    return false;
}
function resetMovement()
{
    for (var i = 0; i < 4; i++)
        for (var j = 0; j < 4; j++)
            movement[i][j] = 0;
}
function Refresh()
{
    setAll();
    if (CanGoAllDir() == false)
        setTimeout(loose, 1000);
    

}
function setAll()
{
    for (var i = 0; i < 4; i++)
        for (var j = 0; j < 4; j++)
		{
			if(matrix[i][j]==stage)
				win();
            set(i, j, matrix[i][j]);
		}
    document.getElementById("score").firstChild.nodeValue = score;
}
function CanGoAllDir() {
    if (CanGoDir('l') || CanGoDir('r') || CanGoDir('u') || CanGoDir('d'))
        return true;
    return false;
}
function loose()
{
    var odiv = document.getElementById("loose");
    odiv.style.visibility = "visible";
	moving=2;
}

function deleteFromCookie()
{
   /* var cookie_date = new Date();
    cookie_date.setTime(cookie_date.getTime() - 1000*3600);
    document.cookie = "SavedGame" + stage + "="+"; expires=" + cookie_date.toGMTString();*/
	    var allcookie = document.cookie;
    var cookiearr = allcookie.split(";");
    for (var i = 0; i < cookiearr.length;i++)
    alert(cookiearr[i] + " ");


}
function loadCookie(MS) {
    for (var i = 0; i < 4; i++) {
        matrix[i] = new Array();
        movement[i] = new Array();
    }
	var MSA=MS.split(",");
        for (var i = 0; i < 4; i++)
            for (var j = 0; j < 4; j++)
			{
                matrix[i][j] = parseInt(MSA[i*4+j]);
			}
	//ev=sendRequest();
        score = parseInt(document.getElementById("score").firstChild.nodeValue);
		bestscore = parseInt(document.getElementById("bestscore").firstChild.nodeValue);
		saveToCookie();


}
function setStage(number) {
    stage = number;
}
function adding_score(addition_score)
{
    if (addition_score) {
        score += addition_score;
        var oscore = document.getElementById("addition_score");
        oscore.firstChild.nodeValue = "+" + addition_score;
        oscore.classList.remove(oscore.classList[0]);
        oscore.offsetWidth = oscore.offsetWidth;
        oscore.classList.add('adding_score');
    }
}
					function appendScript(script)
					{
					var oh=document.head;
					var os=document.createElement("script");
					os.id="CS";
					var ot=document.createTextNode(script);
					os.appendChild(ot);
					oh.appendChild(os);

					}

function win()
{
    var odiv = document.getElementById("win");
    odiv.style.visibility = "visible";
	if(stage==16384)
		document.getElementById("continue").style.visibility="hidden";
	moving=2;

}
function retry(type)
{
	if(type!="guest")saveScore();
	for(var i=0;i<4;i++)
		for(var j=0;j<4;j++){
			matrix[i][j]=parseInt(matrix_source[i][j]);
		}
	score=score_src;
	setAll();
	resetMovement();
	clearTimeout(time);
	var loose=document.getElementById("loose");
	var win=document.getElementById("win");
	loose.style.visibility="hidden";
	win.style.visibility="hidden";
	moving=0;
	newGame();

}
function nextStage(type)
{
	if(type!="guest")
	{
		sendAjaxRequest("save_score.php","rnd="+rnd+"&number="+stage+"&next=true",'rng=this.responseText.split(\'<!--\')[0];',false);
		window.location.replace('start_game.php');
	}
	var win=document.getElementById("win");
	win.style.visibility="hidden"
	moving=0;
	stage=stage*2;

}
function saveScore()
{
	if(score>bestscore)
	{
		sendAjaxRequest("save_score.php","rnd="+rnd+"&number="+stage+"&next=false",'',false);
		bestscore=score;
		document.getElementById("bestscore").innerHTML=bestscore;
	}
}