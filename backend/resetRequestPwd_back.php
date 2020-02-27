<?php
if(!isset($_SESSION))
{
    session_start();
}

if(isset($_POST["resetRequestSubmit"]))
{
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "http://localhost:8008/createNewPwd.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 3600;
    $valid = "";
    include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
    $userEmail = htmlspecialchars(trim($_POST["email"]));
    
    $sql = $db->prepare("DELETE FROM pwdReset WHERE pwdResetEmail= :pwdResetEmail");
    $sql->execute(array(
        ':pwdResetEmail'=>$userEmail
    ));
    
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    
    $sql = $db->prepare("INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (:pwdResetEmail, :pwdResetSelector, :pwdResetToken, :pwdResetExpires)");
    $sql->execute(array(
        ':pwdResetEmail'=>$userEmail,
        ':pwdResetSelector'=>$selector,
        ':pwdResetToken'=>$hashedToken,
        ':pwdResetExpires'=>$expires
    ));

    $db = NULL;
    if (!empty($userEmail))
    {
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $err_mail = "Adresse e-mail au mauvais format";
            header("Location:../resetPasswd.php?error=err_mail");
        }
        
        
        else {
            $message =
            "Une demande pour réinitialiser votre mot de passe Camagru à été faite. Cliquez sur le lien suivant:
            $url
            Si vous n'avez rien demandé, vous pouvez ignorer ce message.";
            $message = wordwrap($message, 70, "\r\n");
            mail($userEmail, "Mot de passe oublier Camagru", $message, "From: noReply@camagru.com");
            header("Location:../resetPasswd.php?reset=success");
            exit();
        }
    }
    else {
        $err_field = "Tous les champs ne sont pas renseignés";
        header("Location:../resetPasswd.php?error=err_field");
    }
}
else
    header("Location: ../index.php");
?>