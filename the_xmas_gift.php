<?php

/* The Xmas Gift 1.0
Author: Roberto Aleman
Website: ventics.com
*/

class the_xmas_gift{

function reset ()
	{
		unset($_SESSION['count']);
		echo '<meta http-equiv="refresh" content="1;URL=index.php">';
		}
function get_answer ($id)
	{
					require("data.php");
					$checkA = explode (",",$DATA);
					$checkAn = explode ("|",trim($checkA[$id]));
					echo "<h2>".trim($checkAn[1])."</h2>";

if ($checkAn[2]  == null){ $checkAn[2] ="";}
if ($checkAn[3]  == null){ $checkAn[3] ="";}
if ($checkAn[4]  == null){ $checkAn[4] ="";}
if ($checkAn[5]  == null){ $checkAn[5] ="";}


echo "<h2><a href='index.php?id=".trim($checkAn[3])."'>".trim($checkAn[2])."</a>  <a href='index.php?id=".trim($checkAn[5])."'>".trim($checkAn[4])."</a></h2>";
		}
	}
?>