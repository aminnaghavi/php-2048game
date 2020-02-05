<?php
function show_exception($text,$time=3000)
{
	echo '<div class="form_table" align="center" style="color:orange;vertical-align:middle;background-clip:padding-box;width:50%;height:20%;padding-top:5%;">'.$text.'</div><br/>';
	?>
	<script type="text/javascript">
	function redirect()
	{
	window.location.replace('login.php');
	}
	setTimeout(redirect,<?php echo $time;?>);
	</script>
    <?php
}
function show_header($text)
{
	?>
    <table style="height:100%;width:100%;">
    <tbody>
    <tr style="height:10%">
    <td>
    <table style="width:100%;top:0px;left:0px;font-size:large;background-color:#093200;color:#F2FF93;border-radius:0% 0% 20% 20%;">
    <tbody>
	<tr>
    <td>
    2048Game.tk
    </td>
    <td align="right">
    powered by BW
    </td>
    </tr>
	<tr>
    <td colspan="2">
    <?php
    echo '<h3 align="center">'.$text.'</h3>';
	?>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr style="margin-top:0;height:80%">
    <td align="center">
    <?php
}
function show_footer($text)
{
	?>
    </td>
    </tr>
    <tr style="height:10%">
    <td>
	<table style="width:100%;margin-bottom:0px;left:0px;font-size:large;background-color:#5A0001;color:#F2FF93;border-radius:20% 20% 0% 0%;">
    <tbody>
	<tr>
    <td colspan="2">
    <?php
    echo '<h5 align="center">'.$text.'</h5>';
	?>
    </td>
    </tr>
    <tr>
    <td>
    2048Game.tk
    </td>
    <td align="right">
    powered by BW
    </td>
    </tr>

    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
<?php
}
?>
