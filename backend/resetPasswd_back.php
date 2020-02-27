<?php
if(!isset($_SESSION))
{
    session_start();
}
    // $username = $_GET['login'];
    // $code = $_GET['code'];
    // $valid = "";
    // $username = "";
    // $email = "";
    // $password = "";
    // $conf_pass = "";
    // $err_log_dispo = "";
    // $err_email_dispo = "";
    if(isset($_POST["resetPasswdSubmit"]))
	{
        $selector = $_POST["selector"];
        $validator = $_POST["validator"];
        $password = trim(htmlspecialchars(addslashes($_POST["pwd"])));
        $confPassword = trim(htmlspecialchars(addslashes($_POST["confirmPwd"])));

        if(empty($password) || empty($confPassword)) {
            header("Location: ../createNewPwd.php?selector=$selector&validator=$validator&error=err_empty");
            exit();
        }
        if ($password != $confPassword) {
            header("Location: ../createNewPwd.php?selector=$selector&validator=$validator&error=err_confirm");
            exit();
        }
        if (strlen($password) < 8 || strlen($password) > 32) {
            header("Location: ../createNewPwd.php?selector=$selector&validator=$validator&error=err_length");
            exit();
        }

        $currentDate = date("U");
        include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");


        $sql = $db->prepare("SELECT * FROM pwdReset WHERE pwdResetSelector = :pwdResetSelector AND pwdResetExpires >= :pwdResetExpires");
        $sql->execute(array(
            ':pwdResetSelector'=>$selector,
            ':pwdResetExpires'=>$currentDate
        ));
        $row=$sql->fetch();
        if(!$sql->rowCount()>0) {
            header("Location: ../createNewPwd.php?selector=$selector&validator=$validator&error=err_token");
            exit();
        }
        else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);
            if ($tokenCheck === FALSE) {
                header("Location: ../createNewPwd.php?selector=$selector&validator=$validator&error=err_token");
                exit();
            }
            elseif ($tokenCheck === TRUE) {
                $tokenEmail = $row['pwdResetEmail'];
                $sql = $db->prepare("SELECT * FROM utilisateurs WHERE email= :email");
                $sql->execute(array(
                    ':email'=> $tokenEmail
                ));
                $row=$sql->fetch();
                if(!$sql->rowCount()>0) {
                    echo "Il y a eu une erreur";
                    exit();
                } else {
                    $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = $db->prepare("UPDATE utilisateurs SET passwd= :passwd WHERE email= :email");
                    $sql->execute(array(
                        ':passwd'=>$newPwdHash,
                        ':email'=>$tokenEmail
                    ));
                    $sql = $db->prepare("DELETE FROM pwdReset WHERE pwdResetEmail= :pwdResetEmail");
                    $sql->execute(array(
                        ':pwdResetEmail'=>$userEmail
                    ));
                    header("Location: ../connexion.php?newpwd=passwordUpdated");
                }
            }
        
        }
    }
    else
        header("Location:../index.php");
?>