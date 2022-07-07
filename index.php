<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000;
}
a:link {
	color: #F00;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #F00;
}
a:hover {
	text-decoration: none;
	color:#FFF;
	background:#000;
}
a:active {
	text-decoration: none;
	color: #F00;
}
a {
	font-size: 12px;
	font-weight: bold;
}
-->
</style><?php
/*
Class Name : Upload and Compress
Author: Roberto C. Aleman
Web : ventics.com

Description:
UpCom class lets you upload a file with declared due to a folder, and add the file to upload a
compressed file that exists in that folder, just shows a link to the archive so that it can be shared,
as security for overwrite no uploads are renamed and packaged using SHA1 and select 10
characters with a unique ID, likewise, the uploaded file to the temporary directory is deleted after
being packed ...

Requeriments:  PHP5

Install: upload this package to favorite folder on your hosting and create de "zips" folder to start

Change log:

0.2.1, the class can it upload and compress file in zip file with this command

$new_upload -> up('package.zip','/zips/package.zip',$new_upload ->rand_name('jpg'));

0.4.1, the class can :

-Create New Zip
-Delete Zip package
-UpLoad file to favorite package, you can select the package to upload


0.6.0, the class have this new options :

- Detect the file extension
- Keeps the original name of the file and generates a final name to be compressed in the format: Original File Name + "-" + Random Number + "." +Original File Extension
- Allow choice the numbers for the  random generation


0.8.0, the class have this new options :

- Show a list of all files in each .ZIP package.. wow! to monitorize the upload!!
- use CSS styles

1.0.0, the class have this new options :

- Allow Delete files for each  ".zip" Archive

Next Version:

- RSS of files in each package, wow!! to monitorize the upload!!

*/
?>
Refresh this page: <a href="index.php" target="_self">click here</a><br/><br/>
<?php


require_once("upcom.php"); //call class

$new_upload = new upcom(); //create object
$new_upload -> form_send_file(); //call form to upload and compress
$new_upload -> form_create_zip(); //call form to create
$new_upload -> form_delete_zip(); //call form to delete
$new_upload -> read_dir(); // show result zip to share

if(isset($_GET['del']) == "true") //check a submit
{

		$new_upload -> delete_file($_GET['package'],$_GET['filetodelete']); //send parameters, for now allow alll extensions !!!


 }


if(isset($_POST['submit'])) //check a submit
{
	if ($_POST["action"] == "upload")  //form action
	{
		$new_upload -> up($_POST["package"],'zips',$new_upload ->rand_name(5)); //send parameters, for now allow alll extensions !!!
	}

 }
if(isset($_POST['create_zip'])) //check a submit
{
		if ($_POST["action"] == "create_zip")  //form action
	{
						$new_upload -> create_zip($_POST['newzip']); //send parameters
	}
}

if(isset($_POST['delzip'])) //check a submit
{
		if ($_POST["action"] == "delete_zip")  //form action
	{
						$new_upload -> zip_deleted($_POST['delzip']); //send parameters
	}
}


?>