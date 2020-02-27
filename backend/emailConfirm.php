<?php
if(!isset($_SESSION))
{
    session_start();
}
if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['token']) && !empty($_GET['token'])){
    include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
    $email = $_GET['email'];
    $code = $_GET['token'];
    $sql = $db->prepare("SELECT confirmation_code FROM utilisateurs WHERE email = :email");
    $sql->execute(array(
        ':email'=>$email
    ));
    $user_infos = $sql->fetchall();
    if($_GET['token'] == $user_infos['0']['confirmation_code']) {
        $sql = "UPDATE `utilisateurs`
        SET `confirmation` = 1
        WHERE `email` = '$email'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        header('Location:../connexion.php');
        exit;
    }
    else {
        header('Location:../index.php');
    }
}
else {
    header('Location:../index.php');
}


?>