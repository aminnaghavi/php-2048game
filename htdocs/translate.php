<html>
<body>
<?php
echo "wow";
try{
$text="cat";
$from="en";
$to="fr";
$gt=file_get_contents("http://translate.google.com/translate_a/t?client=p&text=hello&sl=en&tl=ru");
//$gt=file_get_contents("http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".urlencode($text)."&langpair=".$from."|".$to);
echo $gt;
$json = json_decode($gt,true);
if($json['responseStatus']==200){
echo $json['responseData']['translatedText'];
}
else if($json['responseDetails'])
{
	echo "Error: ".$json['responseDetatils'];
}
else
{
	echo "Error";
}
}
catch(Exception $exc)
{
	echo "error";
}
?>
</body>
</html>