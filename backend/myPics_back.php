<?php
if(!isset($_SESSION))
  session_start();
if($_SESSION["logged_in"] == FALSE) {
  header("Location:connexion.php");
}

if(isset($_GET['src'])) {
    include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
    $dir = $_GET['src'];
    $sql = $db->prepare("SELECT user FROM images WHERE dir = :dir");
    $sql->execute(array(
        ':dir' => $dir
    ));
    $user_image = $sql->fetchColumn();
	if ($_SESSION['user'] == $user_image) {
        $sql = $db->prepare("DELETE FROM images WHERE dir= :dir");
        $sql->execute(array(
            ':dir' => $dir
        ));
        header("Location:../ui.php?delete=success");
    }
    else {
        $error = "Erreur, la photo n'as pas été supprimée.";
        header("Location:../ui.php?delete=$error");
    }
}
?>
