<?php
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

1.0.0, the class have this new options :

- Allow Delete files for each  ".zip" Archive

Next Version:

- RSS of files in each package, wow!! to monitorize the upload!!

*/

class upcom {


	function up($zip_name,$folder_name, $rand_number) {  // parametes ,


				$size = $_FILES["fileit"]['size'];  // file size
				$type = $_FILES["fileit"]['type']; // file tipe
				$file = $_FILES["fileit"]['name']; // file name
			if ($file != "")  //null validation
			{
				$extfile = $this->get_extension($file); // call get_extension function with original file name
				$namefile = $this->get_name_file($file); // call get_name_file function with original file name
				$final_file_name = $namefile."-".$rand_number.".".$extfile; //concat results with rand number to get the final file name, result with this format: Original Name-Rand Number.Original Ext
				chdir($folder_name);
				if (copy($_FILES['fileit']['tmp_name'],$file)) // upload this file
				{
					echo  "Action => File Attach to zip : ".$file." to ".$zip_name." <br/>"; // action message

							$zip = new ZipArchive;  //create new instance with ZipArchive library
							if ($zip->open($zip_name) === TRUE) { //open zip
								$zip->addFile($file, $final_file_name); // add file that is rising
								$zip->close(); //close zip file
								unlink ($file);  //delete the file that was uploaded
								echo 'Action =>Delete : '.$file.'<br/>'; //good message
								echo 'Zip Ready to share! <br/>'; // good message
 								echo '<meta http-equiv="refresh" content="2;URL=index.php" />';
								} else {
								echo 'Failed zip attach<br/>'; //error message
							}
					}
					else {
							echo  "Upload Error <br/>"; //error message
							}
			}
			else { echo   "Upload Error<br/>";  }//error message
			chdir('..'); //return to main folder

			//header('Location: index.php'); need refresh fast? uncomment this line

		}

	function form_send_file (){  //engine form to upload

		  echo '<strong>Upload and Compress</strong><form action="index.php" method="post" enctype="multipart/form-data">
			  	Select File to Upload and Compress : <input name="fileit" type="file"   size="50" /><br/>
				Package to Upload this file : <input name="package" type="text"   size="50" />
			 	<input name="submit" type="submit"  value="Upload and Compress" />
			  	<input name="action" type="hidden" value="upload" />
				</form>==============================<br/>'; //please , atention in name of form inputs
	}
		function form_create_zip (){  //engine form

		  echo '<strong>Create Zip package</strong><form action="index.php" method="post" enctype="multipart/form-data">
			  	Name of zip, with extension .zip please! : <input name="newzip" type="text"   size="50" />
			 	<input name="create_zip" type="submit"   value="Create New Zip" />
			  	<input name="action" type="hidden" value="create_zip" />
				</form>==============================<br/>'; //please , atention in name of form inputs
	}

	function form_delete_zip (){  //delete zip submit form

		  echo '<strong>Delete Zip package</strong><form action="index.php" method="post" enctype="multipart/form-data">
			  	Package to delete,with extension .zip please! : <input name="delzip" type="text"   size="50" />
			 	<input name="delete_zip" type="submit"   value="Delete This Zip" />
			  	<input name="action" type="hidden" value="delete_zip" />
				</form>==============================<br/>'; //please , atention in name of form inputs
	}


	function get_extension ($file) {

						$ext_of_file = explode(".",$file ); //
						$extfile = 	$ext_of_file[1];
						return $extfile;
		}

	function get_name_file ($file) {

						$name_of_file = explode(".",$file ); //
						$namefile = 	$name_of_file[0];
						return $namefile;

		}
	function delete_file ($package, $file) {
			echo "<h3>Package : ".$package;
			echo "<br/> File to delete : ".$file."</h3>";
			chdir('zips');
			$zip = new ZipArchive;
			if ($zip->open($package) === TRUE) {
				$zip->deleteName($file);

				echo "<h3>File ".$file." have been deleted in ".$package."</h3>";
				echo '<meta http-equiv="refresh" content="2;URL=index.php" />';
			}
			else
			{
				echo '<h3>Error in this operation!</h3>';
			}
		$zip->close();
		chdir('..');
		//header('Location: index.php');
		}
	function read_dir (){  //function to read dir for show zip link

if ($reader = opendir('zips')) {  //open dir

	   echo "<br>Listing Files .zip and their packed files:<br/>==============================<br/>Zips:<br/>";  //output
		while (false !== ($readit = readdir($reader))) { //validations
		   if ($readit != "." && $readit != "..") { //validations

			   echo "<br/>+<a href=\"zips/".$readit."\">".$readit."</a><br/>";  //output


			  chdir('zips');
				$zip = new ZipArchive;
				if ($zip->open($readit) === TRUE) {
					$i=0;
					while ($zip->getNameIndex($i) != NULL)
					{
						$nametodelete= $zip->getNameIndex($i);
						if($nametodelete != "upcom.txt")
						{
						 echo "|-- ".$zip->getNameIndex($i)." : <a href='index.php?del=true&package=".$readit."&filetodelete=".$nametodelete."' > (X) </a><br/> ";
						 $i++;
						}
					}
					$zip->close();
				} else {
					echo 'error in archive  ';
				}
				chdir('..');


		   }
	    }
	    closedir($reader); //close dir
	}

		}
	function rand_name($n){ // function to create rand name to store new file in current package

		$rand_name = substr(sha1(uniqid(rand())),0,$n); // create rand name base on sha1 and unidid, extract $n characters
		return $rand_name; //return value
		}


	function create_zip ($filename) //get parameters
		{
			echo $filename. "<br/>";
			chdir('zips');
					$zip = new ZipArchive;
					$res = $zip->open($filename, ZipArchive::CREATE);
					if ($res === TRUE)
					{
						$zip->addFromString('upcom.txt', 'Created by UpCom - Roberto Aleman, ventics.com'); //initial value for create a new zip fil
						$zip->close();
						echo 'Action => Create Zip File : '.$file.'<br/>'; //good message
					} else
					{
						echo 'fail, unable to create new zip!<br/>';
					}
			chdir('..');
			echo '<meta http-equiv="refresh" content="2;URL=index.php" />';
		}

		function zip_deleted ($filename) //get parameters
		{
				chdir('zips');//change to zips folder
				if(		unlink ($filename) ) // del command
				{
					echo 'Action =>Delete : '.$filename.'<br/>'; //good message
					}
				else
				{
					echo "Error problem with file : ".$filename." try again or check";//bad message
					}
				chdir('..'); //return to main folder
			echo '<meta http-equiv="refresh" content="2;URL=index.php" />';
		}

}
?>