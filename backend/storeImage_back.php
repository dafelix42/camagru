<?php

if(!isset($_SESSION))
{
    session_start();
}

// print_r($_SESSION);
// echo $_SESSION['user'];
// echo " TEST SESSION STOREIMAGE_BACK ";
// exit;
if(isset($_POST['saveMontage'])){
	include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
	$owner = $_SESSION['user'];
	$path = "../";
	$filesname="upload";
	$img = $_POST['image'];
	if(!file_exists($path.$filesname))
	{ 
		mkdir($path.$filesname);
	}
	$folderPath = "upload/";

	$image_parts = explode(";base64,", $img);
	$image_type_aux = explode("image/", $image_parts[0]);
	$image_type = $image_type_aux[1];

	$name = $_SESSION['user'];
	$image_base64 = base64_decode($image_parts[1]);
	$fileName = $name.'-'.uniqid().".png";

	$file = $folderPath . $fileName;
	file_put_contents('../'.$file, $image_base64);
	$titrePhoto = $_POST["titrePhoto"];

	if (isset($_POST["filter"])){
		if($_POST["filter_screen"] == "davfelix")
		{
			$filtre = imagecreatefrompng("../filter/davfelix.png");
		}
		if($_POST["filter_screen"] == "chat")
		{
			$filtre = imagecreatefrompng("../filter/chat.png");
		}
		if($_POST["filter_screen"] == "moustache")
		{
			$filtre = imagecreatefrompng("../filter/moustache.png");
		}
		$photo  = imagecreatefrompng("../upload/".$fileName);
		imagecopy($photo, $filtre, 0, 0, 0, 0, 500, 375);
		imagepng($photo, '../'.$file);
		$sql = $db->prepare('INSERT INTO images VALUES (NULL,:dir, :user, :nb_like, :titleImage)');
				$sql->execute(array(
					':dir'=> $file,
					':user'=> $owner,
					':nb_like'=> NULL,
					':titleImage'=>$titrePhoto
				));
		header("Location:../ui.php?upload=success&path=$file");
	}
header("Location: ../ui.php");
}
else {
	header("Location: ../index.php");
}
?>