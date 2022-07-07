<?php
/* The Xmas Gift 1.0
Author: Roberto Aleman
Website: ventics.com
*/
require_once("the_xmas_gift.php");

$gift = new the_xmas_gift();

session_start();
if (!isset($_SESSION['count'])) {  $_SESSION['count'] = 0;}
if (isset($_POST["reset"])) {	 $gift->reset();	}
	?>
<DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Should i buy this?</title>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<div style="text-align:center">
<form action="index.php" method="post" enctype="application/x-www-form-urlencoded" name="reset" target="_self">
<input name="Reset" type="submit" value="Reset App"></form>
<br/>
<i class="fa fa-gift fa-5x"></i><br/><h1 style="text-align:center">Should i buy this?</h1>
<div style="text-align:center">At Christmas we seek to give something to family or friends, but , do we really need to buy that gift?
According to this list of questions will help you decide whether to buy The Christmas Gift!</div>
<?php

if (isset($_GET["id"])) { 	$gift->get_answer($_GET["id"]);}
else {	$gift->get_answer($_SESSION['count']);}

?></div>
</body>
</html>