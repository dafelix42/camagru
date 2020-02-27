<?php
if(!isset($_SESSION))
{
    session_start();
}
    if(isset($_POST['inscription_submit']))
	{
        include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
        $username = htmlspecialchars(trim($_POST["login"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $password = htmlspecialchars($_POST["passwd"]);
        $conf_pass = htmlspecialchars($_POST["confirmPasswd"]);
        $valid = NULL;

        if (!empty(($username)) && !empty(($email)) && !empty(($_POST["passwd"])) && !empty(($_POST["confirmPasswd"])) && $_POST['inscription_submit'] == "Valider")
        {
            var_dump($password);
            if (strlen($username) < 3 || strlen($username) > 20) {
                $err_nameLength = "error";
                $valid = "error";
            }
            if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
                $err_name = "error";
                $valid = "error";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $err_mail = "error";
                $valid = "error";
            }
            if (!preg_match("/^\S*(?=\S{8,512})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/",$password)) {
                $err_pass = "error";
                $valid = "error";
                var_dump($valid);
            }
            if(strcmp(($password), ($conf_pass))){
        		$err_conf = "error";
                $valid = "error";
            }
            $sql = $db->prepare('SELECT username, email FROM utilisateurs');
            $sql->execute();
            $user_infos = $sql->fetchall();
            foreach($user_infos as $user) {
                if ($user['username'] == $username) {
                    $err_log_dispo = "error"; 
                    $valid = "error";
                }
                if ($user['email'] == $email) {
                    $err_email_dispo = "error"; 
                    $valid = "error";
                }
            };
            if ($valid !== "error") {
                $valid = "success";
                $confirm_code = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789!()/qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789!()/!()/!()/';
                $confirm_code = str_shuffle($confirm_code);
                $confirm_code = substr($confirm_code, 0, 20);
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = $db->prepare('INSERT INTO utilisateurs VALUES (NULL,:username, :email, :passwd, :confirmation, :confirmation_code, :notifications)');
            $sql->execute(array(
                ':username'=> $username,
                ':email'=> $email,
                ':passwd'=> $passwordHash,
                ':confirmation'=> FALSE,
                ':confirmation_code'=> $confirm_code,
                ':notifications'=> 1
            ));
        
            $message =
            "
            Confirmez votre email pour valider votre compte Camagru en cliquant sur le lien suivant
            http://localhost:8008/backend/emailConfirm.php?email=$email&token=$confirm_code
            ";
            $message = wordwrap($message, 70, "\r\n");
            mail($email, "Confirmation Camagru", $message, "From: noReply@camagru.com");
            }
            header("Location:../inscription.php?autor=$valid&login=$username&email=$email&nameLen=$err_nameLength&name=$err_name&mail=$err_mail&pass=$err_pass&conf=$err_conf&logDispo=$err_log_dispo&mailDispo=$err_email_dispo");
            exit();
        }
        else {
            $err_field = "error";
            header("Location:../inscription.php?autor=$valid&login=$username&email=$email&field=$err_field");
            exit();
        }
        $db = NULL;
    }
    else {
        header("Location:../index.php");
        exit();
    }
?>