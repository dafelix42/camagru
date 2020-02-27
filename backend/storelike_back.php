<?php
	if(!isset($_SESSION))
	{
    	session_start();
	}

	if (isset($_POST['click_like']))
	{
		include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
		$picPath = $_POST['picture'];
		$username = $_POST['username'];
		$pict_id = $_POST['pict_id'];

		$sql = $db->prepare("SELECT user FROM images WHERE dir = '".$picPath."'");
		$sql->execute();
		$resultOwnerImg = $sql->fetch();
		$ownerImg = $resultOwnerImg['user'];

		$sql = $db->prepare("SELECT email FROM utilisateurs WHERE username = '".$ownerImg."'");
    	$sql->execute();
    	$resultOwnerEmail = $sql->fetch();
    	$ownerEmail = $resultOwnerEmail['email'];

		$sql = $db->prepare("SELECT id FROM utilisateurs WHERE username = '".$_SESSION['user']."'");
		$sql->execute();
		$res_user_id = $sql->fetch();
		$user_id = $res_user_id['id'];


		$sql = $db->prepare("SELECT likes FROM likes WHERE username_like = '".$username."' AND id_image = $pict_id");
		$sql->execute();
		$resultLike = $sql->fetch();
		
		$boolean = $resultLike['likes'];
		// print_r(".$resultLike.");
		// exit;
	
		if ($boolean === NULL)
		{
			$sql = $db->prepare("INSERT INTO likes VALUE (NULL, :id_image, :username_like, :likes)");
			$sql->execute(array(
				':id_image' => $pict_id,
				':username_like' => $username,
				':likes' => 1
			));
	
// 				$destinataire = $email_user;
// 				$subject = "Notification";
// 				$message = "Vous venez de recevoir un like!
// 	---------------
// Ceci est un mail automatique, Merci de ne pas y répondre.'";
// 				mail($destinataire, $subject, $message);
		}
		else if ($boolean == 0)
		{
			$sql = $db->prepare("UPDATE likes SET likes = 1 WHERE id_image = $pict_id AND username_like = '".$username."'");
			$sql->execute();
	
// 			if ($validation == 1)
// 			{
// 				$destinataire = $email_user;
// 				$subject = "Notification";
// 				$message = "Vous venez de recevoir un like!
// 	---------------
// Ceci est un mail automatique, Merci de ne pas y répondre.'";
// 				mail($destinataire, $subject, $message);
// 			}
		}
		else if ($boolean == 1)
		{
			$sql = $db->prepare("UPDATE likes SET likes = 0 WHERE id_image = $pict_id AND username_like = '".$username."'");
			$sql->execute();
		}
		$sql = $db->prepare("SELECT COUNT(likes) FROM likes WHERE id_image = '".$pict_id."' AND likes = 1");
		$sql->execute();
		$resultCountLike = $sql->fetch();
		$countLike = $resultCountLike['COUNT(likes)'];
		$sql = $db->prepare("UPDATE images SET nb_like = :nb_like WHERE id_image = :id_image");
		$sql->execute(array(
			':nb_like' => $countLike,
			':id_image' => $pict_id
		));
	}

    header("Location: ../commentLike.php?id=$pict_id");
?>
