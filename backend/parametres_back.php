<?php
if(!isset($_SESSION))
{
    session_start();
}
if (isset($_POST["parametres_submit"])) {
    $valid= "";
        $newUsername = htmlspecialchars(trim($_POST["login"]));
        $newEmail = htmlspecialchars(trim($_POST["email"]));
        $confNewEmail = htmlspecialchars($_POST["confEmail"]);
        $newPassword = htmlspecialchars($_POST["newPasswd"]);
        $conf_pass = htmlspecialchars($_POST["confirmPasswd"]);
        $password = htmlspecialchars($_POST["passwd"]);
        $notification = htmlspecialchars($_POST["notif"]);

        if (!empty($_POST["passwd"]) && $_POST["parametres_submit"] == "Valider")
        {
            include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");

            if (!empty($newUsername) && (strlen($newUsername) < 3 || strlen($newUsername) > 20)) {
                $err_nameLength = "error";
                $valid = "error";
            }
            if (!empty($newUsername) && !preg_match("/^[a-zA-Z0-9]*$/",$newUsername)) {
                $err_name = "error";
                $valid = "error";
            }
            if (!empty($newEmail) && !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $err_mail = "error";
                $valid = "error";
            }
            if(!empty($newEmail) && strcmp(($newEmail), ($confNewEmail))){
        		$err_mailConf = "error";
                $valid = "error";
            }
            if (!empty($newPassword) && !preg_match("/^\S*(?=\S{8,512})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/",$newPassword)) {
                $err_newPass = "error";
                $valid = "error";
            }
            if(!empty($newPassword) && strcmp(($newPassword), ($conf_pass))){
        		$err_conf = "error";
                $valid = "error";
            }
            if ($valid == "error") {
                header("Location:../parametres.php?newLogin=$newUsername&newMail=$newEmail&nameLen=$err_nameLength&name=$err_name&mail=$err_mail&mailConf=$err_mailConf&newPass=$err_newPass&confPass=$err_conf");
                exit();
            }
            $sql = $db->prepare('SELECT username, passwd FROM utilisateurs');
            $sql->execute();
            $user_infos = $sql->fetchall();
            foreach($user_infos as $user) {
                if ($user['username'] == $_SESSION["user"] && !password_verify($password, $user['passwd'])) {
                    $err_pass = "error";
                    header("Location:../parametres.php?login=$newUsername&mail=$newEmail&pass=$err_pass");
                    exit();
                }
            }
            $sql = $db->prepare('SELECT username, email FROM utilisateurs');
            $sql->execute();
            $user_infos = $sql->fetchall();
            foreach($user_infos as $user) {
                if (!empty($newUsername) && $user['username'] == $newUsername) {
                $err_log_dispo = "error"; 
                $valid = "error";
                }
                if (!empty($newEmail) && $user['email'] == $newEmail) {
                $err_email_dispo = "error"; 
                $valid = "error";
                }
            };
            if ($valid == "error") {
                header("Location:../parametres.php?login=$newUsername&mail=$newEmail&logDispo=$err_log_dispo&mailDispo=$err_email_dispo");
                exit();
            }
            else {
                    $valid = "success";
                    $sql = $db->prepare('SELECT id, username FROM utilisateurs');
                    $sql->execute();
                    $user_infos = $sql->fetchall();
                    foreach($user_infos as $user) {
                        if ($user['username'] == $_SESSION["user"]) {
                            $uid = $user['id'];
                        }
                    }       
                    if (!empty($newUsername)) {
                        $currentUser = $_SESSION['user'];
                        $sql = $db->prepare("UPDATE utilisateurs SET username= :username WHERE id= :id");
                        $sql->execute(array(
                        ':username'=>$newUsername,
                        ':id'=>$uid
                        ));
					    $sql = $db->prepare("UPDATE images SET user = '".$newUsername."' WHERE user = ?");
                        $sql->execute(array($currentUser));
                        $sql = $db->prepare("UPDATE likes SET username_like = '".$newUsername."' WHERE username_like = ?");
                        $sql->execute(array($currentUser));
                        $sql = $db->prepare("UPDATE commentaires SET username = '".$newUsername."' WHERE username = ?");
					    $sql->execute(array($currentUser));
                 
                    $_SESSION["user"] = $newUsername;
                    }
                    if (!empty($newEmail)) {
                        echo $newEmail;
                        echo $uid;
                        $sql = $db->prepare("UPDATE utilisateurs SET email= :email WHERE id= :id");
                        $sql->execute(array(
                        ':email'=>$newEmail,
                        ':id'=>$uid
                        ));
                    }
                    if (!empty($newPassword)) {
                        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                        $sql = $db->prepare("UPDATE utilisateurs SET passwd= :passwd WHERE id= :id");
                        $sql->execute(array(
                        ':passwd'=>$newPasswordHash,
                        ':id'=>$uid
                        ));
                    }

                    $sql = $db->prepare("UPDATE utilisateurs SET notifications= :notifications WHERE id= :id");
                    $sql->execute(array(
                        ':notifications'=>$notification,
                        ':id'=>$uid
                    ));
                header("Location:../parametres.php?autor=$valid&login=$newUsername&email=$newEmail&nameLen=$err_nameLength&name=$err_name&mail=$err_mail&newPass=$err_pass&confPass=$err_conf&logDispo=$err_log_dispo&mailDispo=$err_email_dispo");
                exit();
            }
        }
        else {
            $err_field = "error";
            header("Location:../parametres.php?&login=$newUsername&email=$newEmail&field=$err_field");
            $db = NULL;
            exit();
        }
        $db = NULL;
    }
else {
    header("Location:../index.php");
    exit();
}