<?php
if(!isset($_SESSION))
{
    session_start();
}

if (!isset($_SESSION['user']))
	{
		
		header("Location: ../index.php");
	}
if(isset($_FILES['photo'])){
	include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
	$owner = $_SESSION['user'];
	$file = $_FILES['photo'];
	$fileName = $_FILES['photo']['name'];
	$fileTmpName = $_FILES['photo']['tmp_name'];
	$fileSize = $_FILES['photo']['size'];
	$fileError = $_FILES['photo']['error'];
	$fileType = $_FILES['photo']['type'];
	$mime = mime_content_type($fileTmpName);
	
	$directory="../upload";
	if(!file_exists($directory))
	{
		mkdir($directory);
	}
	$folderPath = "upload/";
	$name = $_SESSION['user'];
	$fileName = $name.'-'.uniqid().".png";
	$file = $folderPath . $fileName;
	$new_width = 500;
	$new_height = 375;
	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg','jpeg','png');
	$titrePhoto = $_POST["titrePhoto"];

	if (in_array($fileActualExt,$allowed) && ($mime == 'image/png' || $mime == 'image/jpeg')) {
		if ($fileError === 0) {
			if ($fileSize < 2000000) {
				if ($_FILES['photo']['type'] == "image/png")
				{
					
					if (isset($_POST["filter"]))
					{
						if($_POST["filter"] == "davfelix")
						{
							$filtre = imagecreatefrompng("../filter/davfelix.png");
						}
						if($_POST["filter"] == "chat")
						{
							$filtre = imagecreatefrompng("../filter/chat.png");
						}
						if($_POST["filter"] == "moustache")
						{
							$filtre = imagecreatefrompng("../filter/moustache.png");
						}
						$img = imagecreatefrompng($_FILES['photo']['tmp_name']);
						imagepng($img, '../' . $folderPath.$fileName);
						$photo  = imagecreatefrompng("../upload/".$fileName);
						$photo = imagescale($photo, $new_width, $new_height);
						imagecopy($photo, $filtre, 0, 0, 0, 0, $new_width, $new_height);
						imagepng($photo, '../' . $file);
					}
				}
				else
				{
					if (isset($_POST["filter"]))
					{
						if($_POST["filter"] == "davfelix")
						{
							$filtre = imagecreatefrompng("../filter/davfelix.png");
						}
						if($_POST["filter"] == "chat")
						{
							$filtre = imagecreatefrompng("../filter/chat.png");
						}
						if($_POST["filter"] == "moustache")
						{
							$filtre = imagecreatefrompng("../filter/moustache.png");
						}
						$img = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
						imagejpeg($img, '../' . $folderPath.$fileName);
						$photo  = imagecreatefromjpeg("../upload/".$fileName);
						$photo = imagescale($photo, $new_width, $new_height);
						imagecopy($photo, $filtre, 0, 0, 0, 0, $new_width, $new_height);
						imagejpeg($photo, '../' . $file);
					}
				}
				$sql = $db->prepare('INSERT INTO images VALUES (NULL,:dir, :user, :nb_like, :titleImage)');
				$sql->execute(array(
					':dir'=> $file,
					':user'=> $owner,
					':nb_like'=> NULL,
					':titleImage'=>$titrePhoto
				));
				header("Location:../ui.php?upload=success&path=$file");
			}
			else {
				$err_size = "error";
				echo "Votre fichier est trop gros";
				header("Location:../ui.php?size=$err_size");
			}
		}
		else {
			$err_import = "error";
			echo "Il y a eu une erreur lors de  l'importation du fichier";
			header("Location:../ui.php?import=$err_simport");
		}
	}
	else {
		$err_type = "error";
		header("Location:../ui.php?type=$err_type");
		echo "Vous ne pouvez pas importer un fichier de ce type";
	}
}
else {
	header("Location: ../index.php");
}
?>