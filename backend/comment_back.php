<?php
if(!isset($_SESSION))
{
    session_start();
}
if(isset($_POST['idImage']) && !empty($_POST['idImage'])){
    $idImage = $_POST['idImage'];
}

if(isset($_SESSION['user']) && isset($_POST['commentaire']) && !empty($_POST['commentaire'])){
    include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
    $owner = $_SESSION['user'];
    $comment = trim(htmlspecialchars($_POST['commentaire']));
    
    $sql = $db->prepare("INSERT INTO commentaires VALUES (NULL,:comment, :idImage, :username)");
	$sql->execute(array(
		':comment'=> $comment,
		':idImage'=> $idImage,
		':username'=> $owner
    ));
    
    $sql = $db->prepare("SELECT user FROM images WHERE id_image = $idImage");
    $sql->execute();
    $resultOwnerImg = $sql->fetch();
    $ownerImg = $resultOwnerImg['user'];
    
    $sql = $db->prepare("SELECT notifications FROM utilisateurs WHERE username = '".$ownerImg."'");
    $sql->execute();
    $resultNotif = $sql->fetch();
    $notif = $resultNotif['notifications'];

    if ($notif == 1) {
        $sql = $db->prepare("SELECT email FROM utilisateurs WHERE username = '".$ownerImg."'");
        $sql->execute();
        $resultOwnerEmail = $sql->fetch();
        $ownerEmail = $resultOwnerEmail['email'];
        
        $destinataire = $ownerEmail;
	    $subject = "Notification";
	    $message = "Vous venez de recevoir un commentaire!
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.'";
        mail($destinataire, $subject, $message);
    }
    header("Location: $_SERVER[HTTP_REFERER]");
}

else {
    header("Location: $_SERVER[HTTP_REFERER]");
}


?>